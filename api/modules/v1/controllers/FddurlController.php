<?php
namespace api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\web\Response;
use common\models\JsonYll;
use yii\helpers\ArrayHelper;
use common\models\FddSignature;

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
            return JsonYll::encode('40012',$fdd_data['result_desc'], ['transaction_id'=>$fdd_data['transaction_id']], '200');
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
            $model->download_url=$fdd_data['download_url'];
            $model->viewpdf_url=$fdd_data['viewpdf_url'];
            $model->timestamp=$timestamp;
            $model->status=1;
            $ret=$model->save();
            
            return JsonYll::encode(JsonYll::SUCCESS, '签署成功！', ['transaction_id'=>$fdd_data['transaction_id'],'download_url'=>$fdd_data['download_url'],'viewpdf_url'=>$fdd_data['viewpdf_url']], '200');
           
        }else{
           
             return JsonYll::encode('40010','数据验证错误，请联系管理员', ['transaction_id'=>$fdd_data['transaction_id']], '200');
        }

        exit;
    }
    
    /**
     * 法大大异步返回
     */
    public function actionNotifyUrl() {
       
    }
    
}
