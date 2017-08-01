<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use common\models\JsonYll;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use api\components\QueryParamAuth;
use api\components\Zhima;
/**
 * Default controller for the `module` module
 */
class ZhimaController extends ActiveController
{
    public $modelClass = 'common\models\QianZhangModel';
    public function behaviors()
    {
        $parent = parent::behaviors();
        $son = [
            //'authenticator' => [
            //    'class' => QueryParamAuth::className()
            //],
//            'rateLimiter' => [
//                'class' => RateLimiter::className(),
//                'enableRateLimitHeaders' => true,
//            ],
            'contentNegotiator' => [
                'formats' => [
                    'text/html' => Response::FORMAT_JSON,
                ]
            ]
        ];
        return ArrayHelper::merge($parent, $son);
    }
    public function actionAuthorize() {
        $file = fopen("authorize.txt","a+");
        $str='';
        foreach($_GET as $k=>$v){
            $str=$str.$k.'='.$v.'&';
        }
        $str=rtrim($str,'&');
        fwrite($file,$str.PHP_EOL);
        fclose($file);
        var_dump($_GET); exit;
        //return JsonYll::encode(JsonYll::SUCCESS, '查询完成.', [\Yii::$app->user->id], '200');
    }

    public function actionTest() {
        $zhima=new Zhima();
        $zhima->getResult();
        //$zhima->testZhimaAuthInfoAuthquery();
        //var_dump($zhima->testZhimaAuthInfoAuthorize());
        exit;
    }
}
