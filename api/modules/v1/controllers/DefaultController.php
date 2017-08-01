<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use common\models\JsonYll;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use api\components\QueryParamAuth;

/**
 * Default controller for the `module` module
 */
class DefaultController extends ActiveController
{
    public $modelClass = 'common\models\QianZhangModel';
    public function behaviors()
    {
        $parent = parent::behaviors();
        $son = [
            'authenticator' => [
                'class' => QueryParamAuth::className()
            ],
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
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionTest() {
        $file = fopen("index.txt","a+");
        echo fwrite($file,$_GET["name"].PHP_EOL);
        fclose($file);
        return JsonYll::encode(JsonYll::SUCCESS, '查询完成.', [\Yii::$app->user->id], '200');
    }
}
