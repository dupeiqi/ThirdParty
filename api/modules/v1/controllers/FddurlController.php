<?php
namespace api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\web\Response;
use common\models\JsonYll;
use yii\helpers\ArrayHelper;
use common\models\FddSignature;
use common\models\FddApi;
use yii\log\FileTarget;
class FddurlController extends ActiveController {
    
    public $modelClass = 'common\models\FddSignature';
    
    public function behaviors()
    {
        
        $parent = parent::behaviors();
        $son = [
           
            'contentNegotiator' => [
                'formats' => [
                    'text/html' => Response::FORMAT_JSON,
                ]
            ]
        ];
        return ArrayHelper::merge($parent, $son);
    }
    
    /**
     * 法大大返回
     */
    public function actionReturnUrl() {
       //获取法大大推送信息
        
        $fdd_data=$_GET;
        $appId=Yii::$app->params['fddConfig']['app_id'];
        $secret=Yii::$app->params['fddConfig']['app_secret'];
        
        if ($fdd_data['result_code']!='3000'){
           // return JsonYll::encode(JsonYll::FAIL,$fdd_data['result_desc'], ['transaction_id'=>$fdd_data['transaction_id']], '40012');
            echo "数据验证错误，请联系管理员";
            exit;
        }
        //验证是否正确
       
        $timestamp = $fdd_data['timestamp'];
        $sha1 = strtoupper(sha1($secret . $fdd_data['transaction_id']));
        $md5 = strtoupper(md5($timestamp));
        $sha2 = strtoupper(sha1($appId . $md5 . $sha1));
        $msgDigest = base64_encode($sha2);
        if ($msgDigest==$fdd_data['msg_digest']){
            //更改签署状态和合同地址
            $model=FddSignature::findOne(['transaction_id'=>$fdd_data['transaction_id']]);
            $model->download_url=urldecode($fdd_data['download_url']);
            $model->viewpdf_url=urldecode($fdd_data['viewpdf_url']);
            $model->timestamp=$timestamp;
            $model->status=1;
            $ret=$model->save();
            
            //获取企业用户
            $user_rec = \common\models\base\User::findOne(['id' => $model->user_id]);
            if (empty($user_rec)) {
              //  return JsonYll::encode(JsonYll::FAIL, '用户ID有误.', [], '40010');
                echo '数据验证错误，请联系管理员.';
                exit;
            }
            $user_id = $model->user_id;
            $customer_id = $user_rec->fdd_ca;
            
            //获取合同数据
            $rsContract = \common\models\FddContract::findOne(['contract_id' => $model->contract_id, "status" => 1]);           
            if (empty($rsContract)) {
              //  return JsonYll::encode(JsonYll::FAIL, '合同已签署或没有生成.', [], '40010');
                echo '合同已签署或没有生成，请联系管理员.';
                exit;
            }
            
            //修改合同编号状态（个人签署成功）
            $rsContract->status=3;
            $rsContract->save();
            
            $doc_title = $rsContract->doc_title;
            $sign_keyword = $rsContract->sign_keyword;
            $contract_id=$rsContract->contract_id;
            
            //企业自动签署
          //  return $this->actionAutoSign($user_id, $doc_title, $contract_id, $customer_id, $sign_keyword);
            if ($rsContract->callback){            
                return  $this->redirect($rsContract->callback);
            }else{
                echo "签署成功！";
            }
          //  return JsonYll::encode(JsonYll::SUCCESS, '签署成功！', ['transaction_id'=>$fdd_data['transaction_id'],'download_url'=>$fdd_data['download_url'],'viewpdf_url'=>$fdd_data['viewpdf_url']], '200');
           
        }else{
            echo '数据验证错误，请联系管理员';
            // return JsonYll::encode(JsonYll::FAIL,'数据验证错误，请联系管理员', ['transaction_id'=>$fdd_data['transaction_id']], '40010');
        }

        exit;
    }
    
    

    /**
     * 法大大异步返回
     */
    public function actionNotifyUrl() {

    }
    
     /**
     * 企业签署跑对列
     */
    public function actionFddList() {
        $time = microtime(true);
	$log = new FileTarget();
	$log->logFile = Yii::$app->getRuntimePath() . '/logs/fdd_log.log';	
	
 
        //获取个人签署合同数据
        $rsContract = \common\models\FddContract::find()->where(["status" => 3])->all();
      //  print_r($rsContract);
        foreach ($rsContract as $key => $value) {
            //获取企业用户
            $user_rec = \common\models\base\User::findOne(['id' => $value->user_id]);
            if (empty($user_rec)) {
               $log->messages[] = [$value->user_id."合同编号：".$value->contract_id.'用户ID有误',1,'fdd',$time];
               continue;
            }
           
            if ($user_rec->is_auto==2){  //手动签署
                 $log->messages[] = [$value->user_id."合同编号：".$value->contract_id.'手动签署',1,'fdd',$time];
                 continue;
            }
            
          
            $user_id = $value->user_id;
            $customer_id = $user_rec->fdd_ca;
            $doc_title = $value->doc_title;
            $sign_keyword = $value->sign_keyword;
            $contract_id = $value->contract_id;
            $ret= ($this->actionAutoSign($user_id,$doc_title,$contract_id,$customer_id,$sign_keyword));
            if ($ret['code']==0){
               $log->messages[] = ["合同编号：".$value->contract_id."---错误信息：".json_encode($ret),1,'fdd',$time];
            }
        }
        //写入日志
        $log->export();
        return "执行完成";
    }

    /**
     * 文档签署接口（自动签）
   
     */
     
    private function actionAutoSign($user_id,$doc_title,$contract_id,$customer_id,$sign_keyword){
       
       
       
        if (empty($doc_title)) {
            return JsonYll::encode(JsonYll::FAIL, '签署标题不能为空.', [], '40010');
        }
     
        if (empty($contract_id)) {
            return JsonYll::encode(JsonYll::FAIL, '签署合同编号不能为空.', [], '40010');
        }     
       

        if (empty($customer_id)) {
            return JsonYll::encode(JsonYll::FAIL, '签署客户编号CA不能为空.', [], '40010');
        }

        if (empty($sign_keyword)) {
            return JsonYll::encode(JsonYll::FAIL, '定位关键字不能为空.', [], '40010');
        }
        
        $client_role =1;// Yii::$app->request->post('client_role');
        $client_role = $client_role?$client_role:1;
        $transaction_id = "SG" . $this->getRand();
        
        $model = FddSignature::findOne(['contract_id' => $contract_id, 'customer_id' => $customer_id]);
        if (empty($model->id)){
            //保存签署合同
            $model=new FddSignature();
            $model->user_id = $user_id;       //操作者或企业用户ID
            $model->sign_user_id=$user_id;   //签署用户ID
            $model->transaction_id = $transaction_id;
            $model->contract_id = $contract_id;
            $model->customer_id = $customer_id;
            $model->doc_title = $doc_title;
            $model->client_role = $client_role;
            $model->sign_keyword = $sign_keyword ? $sign_keyword : '';
            $model->timestamp = date("YmdHis");
            $signStatus = $model->save();
        } else {
            $signStatus = true;
        }
        if ($signStatus) {

            if ($model->status == 1) {  //是否请求法大大成功
              
                //合同归档
               return $this->actionFiling($user_id, $contract_id, $model->download_url, $model->viewpdf_url);
            } else {
                $fdd = new FddApi();
                $notify_url = '';

                $ret = json_decode($fdd->invokeExtSignAuto($transaction_id, $customer_id, $client_role, $contract_id, $doc_title, $sign_keyword, $notify_url), true);
                if ($ret['code'] == '1000') {
                    $model->download_url = $ret['download_url'];
                    $model->viewpdf_url = $ret['viewpdf_url'];
                    $model->status = 1;
                    $model->save();
                    //合同归档
                   return $this->actionFiling($user_id, $contract_id, $ret['download_url'], $ret['viewpdf_url']);
                } else {
                    return JsonYll::encode(JsonYll::FAIL, $ret['msg'], ['transaction_id' => $transaction_id], '40010');
                }
            }
        } else {
            return JsonYll::encode(JsonYll::FAIL, '数据保存失败，请联系管理员.', [], '200');
        }
    }

    /**
     * 合同归档接口

     */
     public function actionFiling($user_id,$contract_id,$download_url,$viewpdf_url) {

        if (empty($contract_id)) {
            return JsonYll::encode(JsonYll::FAIL, '签署合同编号不能为空.', [], '40010');
        }

        $model = \common\models\FddContract::findOne(['contract_id' => $contract_id, 'user_id' => $user_id]);

        if (empty($model->id)) {
            return JsonYll::encode(JsonYll::FAIL, '结案合同不是您发起的!', [], '40010');
        }

        $fdd = new FddApi();
        $ret = json_decode($fdd->invokeContractFilling($contract_id), true);
    
        if ($ret['code'] == '1000') {
            //更改合同状态
            $model->status = 2;
            $model->save();
           
            return JsonYll::encode(JsonYll::SUCCESS, '合同归档成功！', ['contract_id' => $contract_id,'download_url'=>$download_url,'viewpdf_url'=>$viewpdf_url], '200');
           
        } else {
            return JsonYll::encode(JsonYll::FAIL, $ret['msg'], ['contract_id' => $contract_id,'download_url'=>$download_url,'viewpdf_url'=>$viewpdf_url], '40010');
        }
    }
    
    public function getRand()
    {
        $time = explode (" ", microtime () );
        $time = $time [1] . str_pad(round($time [0] * 1000),3,'0',STR_PAD_RIGHT);
        $time2 = explode ( ".", $time );
        $time = $time2 [0];
        $time.=rand(100,999);
        return $time;
    }
}
