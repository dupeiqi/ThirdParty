<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'api\controllers',
    'modules' => [
        /**
         * 用Module实现版本v1和v2
         */
        'v1' => [
            'class' => 'api\modules\v1\Module',
            'defaultRoute' => 'index',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-api',
        ],
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'api\models\User',
            'enableAutoLogin' => true, //开启自动登录   关闭session时自动失效
            'enableSession' => false, //关闭session  暂时...
            'loginUrl' => null, //登录跳转地址为空
            'idParam' => '__api_user',
        ],
        'session' => [
            // this is the name of the session cookie used for login on the api
            'name' => 'advanced-api',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false, // 是否启用严格解析，只有在rules中存在的才解析，开启容易出错
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/default'],
                    'pluralize' => false, //是否启用复数形式，注意index的复数indices，我认为开启后不直观
                ],
            ],
//            'rules' => require(__DIR__ . '/route.php'),
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];
