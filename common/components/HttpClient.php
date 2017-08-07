<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\components;

class HttpClient {

    /**
     * @wxq curl post data
     * return string of data
     */
    public static function request($url, $data = null) {

        $curl = curl_init();
        $this_header = array(
            "content-type: application/x-www-form-urlencoded;
      charset=UTF-8"
        );

        curl_setopt($curl, CURLOPT_HTTPHEADER, $this_header);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

    public static function post($url, $data = null) {
        $data = http_build_query($data);
        $data = json_encode($data);
        $curlobj = curl_init();   // 初始化
        curl_setopt($curlobj, CURLOPT_URL, $url);  // 设置访问网页的URL
        curl_setopt($curlobj, CURLOPT_RETURNTRANSFER, true);   // 执行之后不直接打印出来
// Cookie相关设置，这部分设置需要在所有会话开始之前设置
        date_default_timezone_set('PRC'); // 使用Cookie时，必须先设置时区
        curl_setopt($curlobj, CURLOPT_COOKIESESSION, TRUE);
        curl_setopt($curlobj, CURLOPT_COOKIEFILE, "cookiefile");
        curl_setopt($curlobj, CURLOPT_COOKIEJAR, "cookiefile");
//curl_setopt($curlobj, CURLOPT_COOKI, session_name().'='.session_id());
        curl_setopt($curlobj, CURLOPT_HEADER, 0);
        curl_setopt($curlobj, CURLOPT_FOLLOWLOCATION, 1); // 这样能够让cURL支持页面链接跳转
        curl_setopt($curlobj, CURLOPT_POST, 1);
        curl_setopt($curlobj, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curlobj, CURLOPT_HTTPHEADER, array("application/x-www-form-urlencoded; charset=utf-8",
            "Content-length: " . strlen($data)
        ));
        $a = curl_exec($curlobj); // 执行
        return $a;
    }

    public static function curl($url, $data = null) {
        $curlobj = curl_init();
        curl_setopt($curlobj, CURLOPT_URL, $url);  // 设置访问网页的URL
        curl_setopt($curlobj, CURLOPT_RETURNTRANSFER, true);   // 执行之后不直接打印出来
        date_default_timezone_set('PRC'); // 使用Cookie时，必须先设置时区
        curl_setopt($curlobj, CURLOPT_COOKIESESSION, TRUE);
        curl_setopt($curlobj, CURLOPT_COOKIEFILE, "cookiefile");
        curl_setopt($curlobj, CURLOPT_COOKIEJAR, "cookiefile");
        curl_setopt($curlobj, CURLOPT_HEADER, 0);
        curl_setopt ($curlobj,CURLOPT_REFERER,'HTTP://credit.qianbitou.cn');
        curl_setopt($curlobj, CURLOPT_FOLLOWLOCATION, 1); // 这样能够让cURL支持页面链接跳转
        curl_setopt($curlobj, CURLOPT_RETURNTRANSFER, 1); //不直接输出，返回到变量,获取的信息以文件流的形式返回
        if (!empty($data)) {
            $data = http_build_query($data);
            curl_setopt($curlobj, CURLOPT_POST, 1);
            curl_setopt($curlobj, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curlobj, CURLOPT_HTTPHEADER, array("application/x-www-form-urlencoded; charset=utf-8",
                "Content-length: " . strlen($data)
            ));
        }
        $output = curl_exec($curlobj);
        curl_close($curlobj);
        return $output;
    }

    //curl转义url 中文
    public static function urlConvert($url){
        $pathArr = array();
        $modules = parse_url($url);
        $path = $modules['path'];
        $pathSplit = explode('/', $path);
        foreach ($pathSplit as $row){
            $pathArr[] = rawurlencode($row);
        }
        $urlNew = $modules['scheme']."://".$modules['host'].implode('/', $pathArr);
        return $urlNew;
    }

    /**
     * 发送http的post请求(json)
     * @param type $url
     * @param type $data
     * @return type
     */
    public static function jsonPost($url,$data = null)
    {
        $curl = curl_init();
        $this_header = array(
            "content-type: application/json; charset=UTF-8"
        );

        curl_setopt($curl, CURLOPT_HTTPHEADER, $this_header);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS,$data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

     public static function https($url, $data = null) {
        $curl = curl_init(); // 启动一个CURL会话
        //curl_setopt($curl, CURLOPT_SSL_CIPHER_LIST, 'SSLv3'); // SSL 版本设置成 SSLv3
////curl_setopt($curl, CURLOPT_SSL_VERSION, 3); // SSL 版本设置成 SSLv3 //CURLOPT_SSLVERSION
        //curl_setopt($curl, CURLOPT_SSLVERSION, 3); // SSL 版本设置成 SSLv3 //
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
        $userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? strtolower($_SERVER['HTTP_USER_AGENT']) : ''; //服务器上会因为某些原因丢失useragent信息，出现错误undefined index HTTP_USER_AGENT
        curl_setopt($curl, CURLOPT_USERAGENT, $userAgent); // 模拟用户使用的浏览器
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        if(!empty($data)){
           // $str = http_build_query($data);
          //  echo $str;
            $headerArr = array(
                'Content-Type:application/x-www-form-urlencoded; charset=utf-8',
                'Accept:application/json',
                'Content-Length:' . strlen($str),
            );
            curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headerArr);
        }
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        $tmpInfo = curl_exec($curl); // 执行操作
      
        if (curl_errno($curl)) {
            echo 'Errno' . curl_error($curl); //捕抓异常
        }
        curl_close($curl); // 关闭CURL会话
        return $tmpInfo; // 返回数据
    }

    public static function soap($url, $func,$param)
    {
        $client=new \SoapClient($url);
        $ret = $client->$func($param);
        //$ret = $client->__soapCall($func,array('parameters' => $param));
        return $ret;
    }

    public static function postFile($url, $data = null)
    {
        $header = array('Content-Type: multipart/form-data;charset=UTF-8');
        $resource = curl_init();
        curl_setopt($resource, CURLOPT_URL, $url);
        curl_setopt($resource, CURLOPT_HTTPHEADER, $header);
        curl_setopt($resource, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($resource, CURLOPT_POST, 1);
        curl_setopt($resource, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($resource);
        curl_close($resource);
        return $result;
    }
    
    public static function postFdd($url, $curlPost) {

        $resource = curl_init();
        curl_setopt($resource, CURLOPT_URL, $url);
        curl_setopt($resource, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        curl_setopt($resource, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
        curl_setopt($resource, CURLOPT_HEADER, 0);
        curl_setopt($resource, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($resource, CURLOPT_POST, 1);
        curl_setopt($resource, CURLOPT_POSTFIELDS, $curlPost);
        $result = curl_exec($resource);
        if (curl_errno($resource)) {
            $result['error'] = curl_error($resource);                    //捕抓异常  
        }

        curl_close($resource);
        return $result;
    }

}
