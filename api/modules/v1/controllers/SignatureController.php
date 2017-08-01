<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use common\models\JsonYll;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use api\components\QueryParamAuth;
use common\models\Signature;

/**
 * Default controller for the `module` module
 */
class SignatureController extends ActiveController
{
    public $modelClass = 'common\models\Signature';
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
        var_dump(\Yii::$app->user->identity->certificate);
        echo \Yii::$app->user->identity->certificate->pfx_url;exit;
        //return JsonYll::encode(JsonYll::SUCCESS, '查询完成.', [\Yii::$app->user->certificate], '200');
    }
    public function actionSignature() {
        //var_dump(json_decode($_GET["signature"]));exit;
        //$key=isset($_GET["key"])?$_GET["key"]:0;
        //$offsetX=isset($_GET["offsetX"])?$_GET["offsetX"]:100;
        //$offsetY=isset($_GET["offsetY"])?$_GET["offsetY"]:100;
        var_export($_FILES,true);
        file_get_contents($_FILES['srcpdf']['tmp_name']);
        $date=$this->getRand();//date("Ymd-H-i-m");
        copy($_FILES['srcpdf']['tmp_name'], "D:/iSign_Files/src/$date.pdf");

        $signature=json_decode($_GET["signature"]);
        if($signature==null||$signature.count()==0){
            return JsonYll::encode(JsonYll::FAIL, '签章失败.', [], '100');
        }
        $ch = curl_init();
        foreach($signature as $item){
            $key=isset($item["key"])?$item["key"]:0;
            $offsetX=isset($item["offsetX"])?$item["offsetX"]:100;
            $offsetY=isset($item["offsetY"])?$item["offsetY"]:100;
            $signUrl= "http://106.14.80.183:8080/WebRoot/index.jsp?pfxFilePath=D:/iSign_Files/".\Yii::$app->user->identity->certificate->pfx_url.
                "&keyFilePath=D:/iSign_Files/".\Yii::$app->user->identity->certificate->key_url.
                "&srcPDFFilePath=D:/iSign_Files/src/$date.pdf&destPDFFilePath=D:/iSign_Files/dest/$date.pdf&key=$key&offsetX=$offsetX&offsetY=$offsetY";

            curl_setopt($ch, CURLOPT_URL, $signUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            $result = curl_exec($ch);
        }

        curl_close($ch);

        $result = intval( $result );
        $model = new Signature();
        $model->company_id=Yii::$app->user->id;
        $model->src_url="D:/iSign_Files/src/$date.pdf";
        $model->dest_url="D:/iSign_Files/dest/$date.pdf";
        $model->count=$key;
        $model->status=$result;
        $model->save();
        if($result==200){
            return JsonYll::encode(JsonYll::SUCCESS, '签章成功.', ["filename"=>$date], '200');
        }
        else
            return JsonYll::encode(JsonYll::FAIL, '签章失败.', [], '100');
    }
    public function actionSignatureNew() {
        var_dump(json_decode($_GET["signature"]));exit;
        //var_dump(json_decode($_GET["signature"]));exit;
        //$key=isset($_GET["key"])?$_GET["key"]:0;
        //$offsetX=isset($_GET["offsetX"])?$_GET["offsetX"]:100;
        //$offsetY=isset($_GET["offsetY"])?$_GET["offsetY"]:100;
        var_export($_FILES,true);
        file_get_contents($_FILES['srcpdf']['tmp_name']);
        $date=$this->getRand();//date("Ymd-H-i-m");
        copy($_FILES['srcpdf']['tmp_name'], "D:/iSign_Files/src/$date.pdf");

        $signature=json_decode($_GET["signature"]);
        if($signature==null||$signature.count()==0){
            return JsonYll::encode(JsonYll::FAIL, '签章失败.', [], '100');
        }
        $ch = curl_init();
        foreach($signature as $item){
            $key=isset($item->key)?$item->key:0;
            $offsetX=isset($item->offsetX)?$item->offsetX:100;
            $offsetY=isset($item->offsetY)?$item->offsetY:100;

            $signUrl= "http://106.14.80.183:8080/WebRoot/index.jsp?pfxFilePath=D:/iSign_Files/".\Yii::$app->user->identity->certificate->pfx_url.
                "&keyFilePath=D:/iSign_Files/".\Yii::$app->user->identity->certificate->key_url.
                "&srcPDFFilePath=D:/iSign_Files/src/$date.pdf&destPDFFilePath=D:/iSign_Files/dest/$date.pdf&key=$key&offsetX=$offsetX&offsetY=$offsetY";
            curl_setopt($ch, CURLOPT_URL, $signUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            $result = curl_exec($ch);
            copy("D:/iSign_Files/dest/$date.pdf", "D:/iSign_Files/src/$date.pdf");
        }

        curl_close($ch);

        $result = intval( $result );
        $model = new Signature();
        $model->company_id=Yii::$app->user->id;
        $model->src_url="D:/iSign_Files/src/$date.pdf";
        $model->dest_url="D:/iSign_Files/dest/$date.pdf";
        $model->count=$key;
        $model->status=$result;
        $model->save();
        if($result==200){
            return JsonYll::encode(JsonYll::SUCCESS, '签章成功.', ["filename"=>$date], '200');
        }
        else{
            return JsonYll::encode(JsonYll::FAIL, '签章失败.', [], '100');
        }

    }
    public function actionDownPdf() {
        $filename=isset($_GET["filename"])?$_GET["filename"]:0;
        $filepath=realpath("D:/iSign_Files/dest/$filename.pdf"); //文件名
        //$date=date("Ymd-H:i:m");
        Header( "Content-type:  application/octet-stream ");
        Header( "Accept-Ranges:  bytes ");
        Header( "Accept-Length: " .filesize($filepath));
        header( "Content-Disposition:  attachment;  filename= {$filename}.pdf");
        echo file_get_contents($filepath);
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
