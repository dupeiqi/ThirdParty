<?php

namespace common\models;
use Yii;
use common\models\FddBase;
use common\components\HttpClient;
use common\components\Crypt3Des;

class FddApi extends FddBase {

    /**
     * 调用个人ca注册
     * @author: yaoshuifu
     * @param customer_name 名称
     * @param email 邮箱
     * @param id_card 证件号码
     * @param ident_type 证件类型
     * @param mobile 手机号
     * @return
     */
    public function invokeSyncPersonAuto($customer_name, $mobile, $id_card, $email='', $ident_type='') {
        if (empty($customer_name)||empty($mobile)||empty($id_card)){
            return ['code'=>'4004','msg'=>'必填字段为空值！'];
        }
        $params = array();
        $timpstamp = date("YmdHis");
        $sha2 = strtoupper(sha1($this->appId . strtoupper(md5($timpstamp)) . strtoupper(sha1($this->secret))));
        $msgDigest = base64_encode($sha2);

        $params['app_id'] = $this->appId;
        $params['v'] = $this->version;
        $params['timestamp'] = $timpstamp;
        $params['customer_name'] = $customer_name;
        $params['email'] = $email;
        $params['ident_type'] = $ident_type;
        $params['id_mobile'] = Crypt3Des::encrypt($id_card . "|" . $mobile, $this->secret);
        $params['msg_digest'] = $msgDigest;
        //获取请求地址
        $url = $this->getURLOfSyncPersonAuto();
        //发起https的post请求
        $result = HttpClient::postFdd($url, $params);
        return $result;
    }

    /**
     * 调用文档传输接口
     * @author: yaoshuifu
     * @param contract_id 合同编号
     * @param doc_title 合同标题
     * @param file 合同文件,与doc_url两个只传一个
     * @param doc_url 合同文件URL（公网）地址
     * @param doc_type 合同类型（.pdf）
     * @return
     */
    public function invokeUploadDocs($contract_id, $doc_title, $doc_type, $file, $doc_url) {

        if (empty($contract_id) || empty($doc_title) || empty($doc_type)) {
            return ['code'=>'4004','msg'=>'必填字段为空值！'];
        }
        //合同文件,与doc_url两个只传一个
        if (empty($file) && empty($doc_url))
            return ['code'=>'4004','msg'=>'必填字段为空值！'];

        $params = array();
        $timpstamp = date("YmdHis");

        //加密
        $sha2 = strtoupper(sha1($this->appId . strtoupper(md5($timpstamp)) . strtoupper(sha1($this->secret . $contract_id))));
        $msgDigest = base64_encode($sha2);

        $params['app_id'] = $this->appId;
        $params['timestamp'] = $timpstamp;
        $params['contract_id'] = $contract_id;
        $params['doc_title'] = $doc_title;
        $params['doc_type'] = $doc_type;

        if ($file) {
            $params['file'] = new \CURLFile(realpath($file));
        } else {
            $params['doc_url'] = $doc_url;
        }
        $params['msg_digest'] = $msgDigest;
        $params['v'] = $this->version;
        //获取URL
        $url = $this->getURLOfUploadDocs();

        //发起https的post请求
        $result = HttpClient::postFdd($url, $params);

        return $result;
    }

    /**
     * 调用上传合同模板接口
     * @author: yaoshuifu
     * @param template_id 模板ID
     * @param file 模板文件
     * @param doc_url 模板URL
     * @return
     */
    public function invokeUploadTemplate($template_id, $file, $doc_url) {

        if (empty($template_id))
            return ['code'=>'4004','msg'=>'必填字段为空值！'];

        if (empty($file) && empty($doc_url))
            return ['code'=>'4004','msg'=>'必填字段为空值！'];

        $timpstamp = date("YmdHis");

        $md5 = strtoupper(md5($timpstamp));
        $sha1 = strtoupper(sha1($this->secret . $template_id));
        $sha2 = strtoupper(sha1($this->appId . $md5 . $sha1));
        $msgDigest = base64_encode($sha2);

        $params['app_id'] = $this->appId;
        $params['v'] = $this->version;
        $params['timestamp'] = $timpstamp;
        $params['template_id'] = $template_id;

        if ($file) {
            $params['file'] = new \CURLFile(realpath($file));
        } else {
            $params['doc_url'] = $doc_url;
        }

        $params['msg_digest'] = $msgDigest;

        //获取URL
        $url = $this->getURLOfUploadTemplate();

        //发起https的post请求
        $result = HttpClient::postFdd($url, $params);
        return $result;
    }

    /**
     * 调用生成合同接口
     * @author: yaoshuifu
     * @param template_id 合同模板编号
     * @param contract_id 合同编号
     * @param doc_title 签署文档标题
     * @param font_size 字体大小 不传则为默认值9
     * @param font_type 字体类型 0-宋体；1-仿宋；2-黑体；3-楷体；4-微软雅黑
     * @param parameter_map 填充内容
     * @param dynamic_tables 动态表单
     * @return
     */
    public function invokeGenerateContract($template_id, $contract_id, $doc_title, $parameter_map, $font_size = '', $font_type = '', $dynamic_tables = '') {

        if (empty($contract_id) || empty($template_id) || empty($doc_title)||empty($parameter_map)) {
           return ['code'=>'4004','msg'=>'必填字段为空值！'];
        }

        $timpstamp = date("YmdHis");

        $md5 = strtoupper(md5($timpstamp));
        $sha1 = strtoupper(sha1($this->secret . $template_id . $contract_id));
        $sha2 = strtoupper(sha1($this->appId . $md5 . $sha1 . $parameter_map));
        $msgDigest = base64_encode($sha2);

        $params['app_id'] = $this->appId;
        $params['v'] = $this->version;
        $params['timestamp'] = $timpstamp;
        $params['doc_title'] = $doc_title;
        $params['template_id'] = $template_id;
        $params['contract_id'] = $contract_id;
        $params['parameter_map'] = $parameter_map;
        $params['font_size'] = $font_size;
        $params['font_type'] = $font_type;
        $params['dynamic_tables'] = $dynamic_tables;
        $params['msg_digest'] = $msgDigest;

        //获取URL
        $url = $this->getURLOfGenerateContract();
       
        //发起https的post请求
        $result = HttpClient::postFdd($url, $params);

        return $result;
    }

    /**
     * 调用签署接口（手动签模式）
     * @author: yaoshuifu 
     * @param transaction_id 交易号，长度小于等于32位
     * @param customer_id 客户编号
     * @param contract_id 合同编号
     * @param doc_title 文档标题
     * @param sign_keyword 定位关键字
     * @param return_url 跳转地址
     * @param notify_url 异步通知地址
     * @return 返回拼接好的地址，请跳转页面到该地址
     */
    public function invokeExtSign($transaction_id, $customer_id, $contract_id, $doc_title, $return_url, $sign_keyword = '', $notify_url = '') {

        if (empty($contract_id) || empty($customer_id) || empty($doc_title) || empty($transaction_id) || empty($return_url)) {
           return ['code'=>'4004','msg'=>'必填字段为空值！'];
        }

        $timpstamp = date("YmdHis");
        $sha1 = strtoupper(sha1($this->secret . $customer_id));
        $md5 = strtoupper(md5($transaction_id . $timpstamp));
        $sha2 = strtoupper(sha1($this->appId . $md5 . $sha1));
        $msgDigest = base64_encode($sha2);

        $params['app_id'] = $this->appId;
        $params['v'] = $this->version;
        $params['timestamp'] = $timpstamp;
        $params['contract_id'] = $contract_id;
        $params['customer_id'] = $customer_id;
        $params['transaction_id'] = $transaction_id;
        $params['doc_title'] = $doc_title;
        $params['sign_keyword'] = $sign_keyword;
        $params['return_url'] = trim($return_url);
        $params['notify_url'] = trim($notify_url);
        $params['msg_digest'] = $msgDigest;

        //获取URL
        $url = $this->getURLOfExtSign();
        //组合访问网址
        $get_url = $url . "?timestamp=" . $timpstamp . "&transaction_id=" . $params['transaction_id'] . "&contract_id=" . $params['contract_id'] . "" . "&return_url=" . urlencode($params['return_url']) . " &customer_id=" . $params['customer_id'] . "" . "&doc_title=" . urlencode($params['doc_title']) . "" . "&app_id=" . $params['app_id'] . "&msg_digest=" . $params['msg_digest'] . "&v=2.0";

        return $get_url;
    }

    /**
     * 调用签署接口（自动签模式）
     * @author: yaoshuifu 
     * @param transaction_id 交易号
     * @param customer_id 客户编号
     * @param client_role 客户角色
     * @param contract_id 合同编号
     * @param doc_title 文档标题
     * @param sign_keyword 定位关键字
     * @param notify_url 异步通知地址
     * @return
     */
    public function invokeExtSignAuto($transaction_id, $customer_id, $client_role, $contract_id, $doc_title, $sign_keyword, $notify_url) {

        if (empty($contract_id) || empty($customer_id) || empty($doc_title) || empty($transaction_id) || empty($sign_keyword) || empty($client_role)) {
            return json_encode(['code'=>'4004','msg'=>'必填字段为空值！']);
        }
        $timpstamp = date("YmdHis");

        $sha1 = strtoupper(sha1($this->secret . $customer_id));
        $md5 = strtoupper(md5($transaction_id . $timpstamp));
        $sha2 = strtoupper(sha1($this->appId . $md5 . $sha1));
        $msgDigest = base64_encode($sha2);

        $params['app_id'] = $this->appId;
        $params['v'] = $this->version;
        $params['timestamp'] = $timpstamp;
        $params['contract_id'] = $contract_id;
        $params['customer_id'] = $customer_id;
        $params['client_role'] = $client_role;
        $params['sign_keyword'] = $sign_keyword;
        $params['transaction_id'] = $transaction_id;
        $params['doc_title'] = $doc_title;
        $params['notify_url'] = $notify_url;
        $params['msg_digest'] = $msgDigest;
       
        //获取URL
        $url = $this->getURLOfExtSignAuto();

        //发起https的post请求
        $result = HttpClient::postFdd($url, $params);
        return $result;
    }

    /**
     * 调用合同归档
     * @author: yaoshuifu
     * @param contract_id 合同编号
     * @return 接口处理结果
     */
    public function invokeContractFilling($contract_id) {

        if (empty($contract_id))
            return ['code'=>'4004','msg'=>'必填字段为空值！'];

        $timpstamp = date("YmdHis");
       
        $md5 = strtoupper(md5($timpstamp));
        $sha1 = strtoupper(sha1($this->secret . $contract_id));
        $sha2 = strtoupper(sha1($this->appId . $md5 . $sha1));
        $msgDigest = base64_encode($sha2);

        $params['app_id'] = $this->appId;
        $params['v'] = $this->version;
        $params['timestamp'] = $timpstamp;
        $params['contract_id'] = $contract_id;
        $params['msg_digest'] = $msgDigest;

        //获取URL
        $url = $this->getURLOfContractFilling();

        //发起https的post请求
        $result = HttpClient::postFdd($url, $params);
        return $result;
    }

    /**
     * 调用客户签署状态查询接口
     * @author: yaoshuifu
     * @param contract_id 合同编号
     * @param customer_id 客户编号
     * @return
     */
    public function invokeQuerySignStatus($contract_id, $customer_id) {
        if (empty($contract_id) || empty($customer_id))
           return ['code'=>'4004','msg'=>'必填字段为空值！'];

        $timpstamp = date("YmdHis");

        $md5 = strtoupper(md5($timpstamp));
        $sha1 = strtoupper(sha1($this->secret . $contract_id . $customer_id));
        $sha2 = strtoupper(sha1($this->appId . $md5 . $sha1));
        $msgDigest = base64_encode($sha2);

        $params['app_id'] = $this->appId;
        $params['v'] = $this->version;
        $params['timestamp'] = $timpstamp;
        $params['contract_id'] = $contract_id;
        $params['customer_id'] = $customer_id;
        $params['msg_digest'] = $msgDigest;

        //获取URL
        $url = $this->getURLOfQuerySignStatus();

        //发起https的post请求
        $result = HttpClient::postFdd($url, $params);
        return $result;
    }
  
    public function aaa(){
        echo "aaa:".$this->appId;
    }


}
