<?php
namespace api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\web\Response;
use common\models\JsonYll;
use yii\helpers\ArrayHelper;
use common\models\FddSignature;
use common\models\FddApi;

class TestController extends ActiveController {
    
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
    
    public function actionTest(){
        
        $model = \common\models\FddContract::findOne(['contract_id' =>'HT1503367035250318', 'user_id' =>8]);
        if (empty($model->id)){
         return JsonYll::encode('40010', '结案合同不是您发起的!', [], '200');
            
        }else{
            echo "222222";
        }
         return JsonYll::encode('40010','dfsfsdfa', $model, '200');
         exit;
         $fdd=new FddApi();
            
//获取法大大CA
            $aaa=$fdd->invokeSyncPersonAuto('朱明军2', '13799270903', '511102197607014013');
            print_r($aaa);
          
            $ret= json_decode($aaa,true);
            print_r($ret);
            if ($ret['code']=='1000'){
               // $this->fdd_ca=$ret['customer_id'];
            }else{
                return false;
            }
    }
    
}