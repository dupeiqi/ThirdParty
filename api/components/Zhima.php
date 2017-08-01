<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace api\components;

include('zmxy\ZmopSdk.php');
use yii;
use common\models\JsonYll;
/**
 * Description of newPHPClass
 *
 * @author u
 */
class Zhima {
//芝麻信用网关地址
    public $gatewayUrl = "https://zmopenapi.zmxy.com.cn/openapi.do";
    //商户私钥文件
    public $privateKeyFile ='../modules/v1/pem/rsa_private_key.pem';// "d:\\keys\\private_key.pem";
    //芝麻公钥文件
    public $zmPublicKeyFile = '../modules/v1/pem/rsa_public_key.pem';// "d:\\keys\\public_key.pem";
    //数据编码格式
    public $charset = "UTF-8";
    //芝麻分配给商户的 appId
    public $appId = "1003025";

    public function testZhimaAuthInfoAuthorize(){
        $client = new \ZmopClient($this->gatewayUrl,$this->appId,$this->charset,$this->privateKeyFile,$this->zmPublicKeyFile);
        $request = new \ZhimaAuthInfoAuthorizeRequest();
        $request->setChannel("apppc");
        $request->setPlatform("zmop");
        $request->setIdentityType("2");// 必要参数
        $request->setIdentityParam("{\"name\":\"林连法\",\"certType\":\"IDENTITY_CARD\",\"certNo\":\"350524198908094014\"}");// 必要参数
        //$request->setIdentityType("1");// 必要参数
        //$request->setIdentityParam("{\"mobileNo\":\"15959240227\"}");// 必要参数
        //return $client->execute($request);
        $request->setBizParams("{\"auth_code\":\"M_APPPC_CERT\",\"channelType\":\"app\",\"state\":\"0\"}");//
        $url = $client->generatePageRedirectInvokeUrl($request);
        return $url;
    }
    public function testZhimaAuthInfoAuthquery(){
        $client = new \ZmopClient($this->gatewayUrl,$this->appId,$this->charset,$this->privateKeyFile,$this->zmPublicKeyFile);
        $request = new \ZhimaAuthInfoAuthqueryRequest();
        $request->setChannel("apppc");
        $request->setPlatform("zmop");
        $request->setIdentityType("2");// 必要参数
        $request->setIdentityParam("{\"name\":\"林连法\",\"certType\":\"IDENTITY_CARD\",\"certNo\":\"350524198908094014\"}");// 必要参数
        $request->setAuthCategory("C2B");// 必要参数
        $response = $client->execute($request);
        echo json_encode($response,JSON_UNESCAPED_UNICODE);
    }

    public function getResult() {
        $params = 'NoybwOw+ljGPVcvyWDexr1h4TstABY/W2f3KoOuuN5/wPgun3PtB0hA7eODB4g5lOz5blACyXijNlmdP6uMCtQ0X4zwNtij8eJ/9ZWphhcwJuaDX0lffCelwByNW8u1sIdvYrrtF0SxfI6DJY8RONpO2H5XEIkA7WN0E52snX6Kzp5vGHQYK17j/s9kkSS5K80uDxuB0aPhjQvNL1vLWmeSDNzLcGQGbuuveg2xXSCVeCJEaT4qs65cjMbq70pMLnnAhl84dOfQENnJxpKVBEpe4/uQMkUzgbK12UUquwJzfQdaVAv58Vao+n68shuAJ5jw71PZbmqIAc7HxzOQPPQ==';
        //从回调URL中获取params参数，此处为示例值
        $sign = 'mVp+936bFk7U9RHoFJwiTx2cukwCfELBECvhrSYrVywFoCdVhbaZ/OufYZ8MCgmcTZil4EYgS6ho6d/QoXqIJET2pZSAU2bl8xOrsNcr14gX1iFppZ2Ck9MgID7/CmadM9jbPE2xdcbrEcKdXR1ESIZqbp2dNaQ39fkuo5rMoWc=';
        //从回调URL中获取sign参数，此处为示例值
        // 判断串中是否有%，有则需要decode
        $params = strstr ( $params, '%' ) ? urldecode ( $params ) : $params;
        $sign = strstr ( $sign, '%' ) ? urldecode ( $sign ) : $sign;

        $client = new \ZmopClient ( $this->gatewayUrl, $this->appId, $this->charset, $this->privateKeyFile, $this->zmPublicKeyFile );
        $result = $client->decryptAndVerifySign ( $params, $sign );
        echo urldecode($result);
    }
}
