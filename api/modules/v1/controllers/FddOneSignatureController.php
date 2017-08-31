<?php
namespace api\modules\v1\controllers;
use Yii;
use yii\rest\ActiveController;
use common\models\JsonYll;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use api\components\QueryParamAuth;
use common\models\FddApi;
use common\models\FddContract;
use common\models\FddSignature;
use common\models\GrUser;
class FddOneSignatureController extends ActiveController{
    
    public $modelClass = 'common\models\FddSignature';
    //文件路途
    public $pathfile;
    //页面跳转
    public  $return_url='http://api.signature.com/v1/fddurl/return-url';
    
    public function behaviors()
    {
        $parent = parent::behaviors();
        $son = [
            'authenticator' => [
                'class' => QueryParamAuth::className()
            ],

            'contentNegotiator' => [
                'formats' => [
                    'text/html' => Response::FORMAT_JSON,
                ]
            ]
        ];
        $this->pathfile=\Yii::$app->params['fddConfig']['file_path'];
        return ArrayHelper::merge($parent, $son);
    }
    
   
    /**
     * 文档签署接口（手动签）

     */
    public function actionSign($user_id,$doc_title,$contract_id,$customer_id,$sign_keyword='') {

    
        if (empty($user_id)) {
            return JsonYll::encode('40010', '用户ID不能为空.', [], '200');
        }
        
        if (empty($doc_title)) {
            return JsonYll::encode('40010', '签署标题不能为空.', [], '200');
        }

        if (empty($contract_id)) {
            return JsonYll::encode('40010', '签署合同编号不能为空.', [], '200');
        }
        $rsContract = FddContract::findOne(['contract_id' => $contract_id, "status" => 1]);
        $return_url = trim($this->return_url);
       
        if (empty($customer_id)) {
            return JsonYll::encode('40010', '签署客户编号CA不能为空.', [], '200');
        }
     
        $transaction_id = "SG" . $this->getRand();

        //保存签署合同
        $model = FddSignature::findOne(['contract_id' => $contract_id, 'customer_id' => $customer_id]);             
        if (!empty($model->id)){
            if ($model->status==1){
                return JsonYll::encode(JsonYll::FAIL, '些合同您已经签署过了.', [], '200');
            }
        }else{
            $model=new FddSignature();
        }
        
        $model->user_id =Yii::$app->user->id;
        $model->sign_user_id=$user_id;
        $model->transaction_id = $transaction_id;
        $model->contract_id = $contract_id;
        $model->customer_id = $customer_id;
        $model->doc_title = $doc_title;
        $model->client_role = 1;
        $model->sign_keyword = $sign_keyword?$sign_keyword:'';
        $signStatus = $model->save();
        if ($signStatus) {
            $fdd = new FddApi();
            $get_url = $fdd->invokeExtSign($transaction_id, $customer_id, $contract_id, $doc_title, $return_url, $sign_keyword);
            return JsonYll::encode(JsonYll::SUCCESS, '成功！', ['url' => $get_url], '200');
          
        } else {
            return JsonYll::encode(JsonYll::FAIL, '数据保存失败，请联系管理员.', [], '200');
        }
    }

  
    
      
     /**
     * 合并签章接口
     */
     public function actionOnekeySign(){
          $user_id=Yii::$app->user->id;
        
        if (empty($user_id)) {
            return JsonYll::encode('40010', '用户ID不能为空.', [], '200');
        }
     
        $template_id=Yii::$app->request->post("template_id");

//        if (empty($template_id)) {
//            return JsonYll::encode('40010', '模版ID不能为空.', [], '200');
//        }
        $user_name=Yii::$app->request->post("user_name");

        if (empty($user_name)) {
            return JsonYll::encode('40010', '签约用户名称不能为空.', [], '200');
        }
        $id_card=Yii::$app->request->post("id_card");

        if (empty($id_card)) {
            return JsonYll::encode('40010', '签约用户身份证不能为空.', [], '200');
        }
        $user_mobile=Yii::$app->request->post("user_mobile");

        if (empty($user_mobile)) {
            return JsonYll::encode('40010', '签约用户手机不能为空.', [], '200');
        }

        if (empty($template_id)) {
            $count_rec = \common\models\FddTemplate::find()->where(['user_id' => $user_id, 'visible' => 1])->count();
            if ($count_rec == 1) {  //是为公司唯一一个模版
                $tp_rec = \common\models\FddTemplate::find()->where(['user_id' => $user_id, 'visible' => 1])->select(array('id', 'template_id', 'template_name', 'template_file','sign_keyword'))->one();
                if (empty($tp_rec->id)) {
                    return JsonYll::encode('40010', '您传的模版ID不误！.', [], '200');
                }
            } else {
                return JsonYll::encode('40010', '您传的模版ID不误！.', [], '200');
            }
        } else {
            //判断用户模版是否存在
            $tp_rec = \common\models\FddTemplate::find()->where(['user_id' => $user_id, 'template_id' => $template_id, 'visible' => 1])->select(array('id', 'template_id', 'template_name', 'template_file','sign_keyword'))->one();

            if (empty($tp_rec->id)) {
                return JsonYll::encode('40010', '您传的模版ID不误！.', [], '200');
            }
        }

        $sign_keyword=$tp_rec->sign_keyword;

        if (empty($sign_keyword)) {
            return JsonYll::encode('40010', '企业定位关键字不能为空.', [], '200');
        }
        //模版字典
        
        $dic_rec= \common\models\DataDict::find()->where(['user_id'=>$user_id,'template_id'=>$template_id,'visible'=>1])->select(array('id', 'dict_name', 'dict_value'))->all();
        if (empty($dic_rec)){
             return JsonYll::encode('40010', '模版数据字典不能为空.', [], '200');
        }
        $parameter_map=array();  //填充内容
        foreach ($dic_rec as $value){
            $dic_value=Yii::$app->request->post($value->dict_name);
           
            if (empty($dic_value)) {
                return JsonYll::encode('40010', $value->dict_value.'不能为空.', [], '200');
            }
            $parameter_map[$value->dict_name]=$dic_value;
        }
        
        //个人用户是否存在（添加法大大的CA）
        $user_model=new GrUser;
        $user_rec= $user_model->find()->where(['id_card'=>$id_card,'company_name'=>$user_name,'mobile'=>$user_mobile])->one();
   
        if (empty($user_rec->id)){
            $fdd=new FddApi();
            //获取法大大CA           
            $ret= json_decode($fdd->invokeSyncPersonAuto($user_name, $user_mobile, $id_card),true);
            if ($ret['code']=='1000'){
                
                $customer_id=$ret['customer_id'];  //法大大个人CA
                //保存用户资料         
                $user_model->fdd_ca=$customer_id;
                $user_model->company_name=$user_name;
                $user_model->id_card=$id_card;
                $user_model->mobile=$user_mobile;
                $user_model->created_at=$user_model->updated_at=time();
                $user_model->token=md5($user_name.$id_card.$user_model->created_at);
                $user_model->save();
                
                $ge_user_id=$user_model->id;
            }else{
               return JsonYll::encode('40010', $ret['msg'], [], '200');
            }
            
            
            
        }else{
            $customer_id=$user_rec->fdd_ca;  //法大大个人CA 
            $ge_user_id=$user_rec->id;
        }
        
        if (empty($customer_id)) {
            return JsonYll::encode('40010', '个人法大大CA不能为空,请联系管理员.', [], '200');
        }
        
        $cp_customer_id=Yii::$app->user->identity->fdd_ca;;  //企业法大大CA 
         if (empty($cp_customer_id)) {
            return JsonYll::encode('40010', '企业法大大CA不能为空,请联系管理员.', [], '200');
        }
        
        $model = FddContract::findOne(['user_id' => $user_id,'sign_user_id'=>$ge_user_id, 'template_id' => $template_id]);
        if (empty($model->id)) {
            //合同编号
            $contract_id = "HT" . $this->getRand();
            $doc_title = $tp_rec->template_name;

            //保存文件合同
            $model = new FddContract();
            $model->user_id = Yii::$app->user->id;
            $model->sign_user_id = $ge_user_id;
            $model->contract_id = $contract_id;
            $model->template_id = $template_id;
            $model->parameter = json_encode($parameter_map);
            $model->sign_keyword = $sign_keyword;
            $model->doc_title = $doc_title;
            $model->file = $this->pathfile . "/" . $tp_rec->template_file;
            $model->timestamp = date("YmdHis");
            $contractStatus = $model->save();
        } else {
            //合同编号
            $contract_id = $model->contract_id;
            $doc_title = $model->doc_title;
            $contractStatus=true;
        }



        if ($contractStatus) {

            if (empty($model->status)) {  //是否请求法大大成功
                //请求法大大接口
                $fdd = new FddApi();
                $jsondata = json_decode($fdd->invokeGenerateContract($template_id, $contract_id, $doc_title, json_encode($parameter_map), 14, 4, ''), true);
                if ($jsondata['code'] == '1000') {

                    $model->status = 1;
                    $model->save();
                    //获取手动签章网址
                    $sign_ret = $this->actionSign($ge_user_id, $doc_title, $contract_id, $customer_id, '');
                    if ($sign_ret['code'] == 1) {
                        //  $this->redirect($sign_ret['url']);
                        return $sign_ret;
                    } else {
                        return $sign_ret;
                    }
                } else {
                    return JsonYll::encode('40011', $jsondata['msg'], ['contract_id' => $contract_id, 'doc_title' => $tp_rec->template_name], '200');
                }
            } else {
                //获取手动签章网址
                $sign_ret = $this->actionSign($ge_user_id, $doc_title, $contract_id, $customer_id, '');

                if ($sign_ret['code'] == 1) {
                    //  $this->redirect($sign_ret['url']);
                    return $sign_ret;
                } else {
                    return $sign_ret;
                }
            }
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