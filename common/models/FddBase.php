<?php

namespace common\models;

use Yii;
use yii\base\Model;

class FddBase extends Model {

    /** appid */
    public $appId;

    /** app_secret */
    public  $secret;

    /** 版本号，建议填写，默认2.0 */
    public  $version;

    /** 接口地址，见对接邮件 */
    public  $url;

    public function __construct() {

        $this->appId = Yii::$app->params['fddConfig']['app_id'];
        $this->secret = Yii::$app->params['fddConfig']['app_secret'];
        $this->version = Yii::$app->params['fddConfig']['version'];
        $this->url = Yii::$app->params['fddConfig']['url'];
    }

// ========================TODO 基础接口 start======================
	/**
	 * 获取接口地址：个人CA证书申请接口
	 * @author: yaoshuifu
	 
	 * @return
	 */
	public function getURLOfSyncPersonAuto() {
		return $this->url."syncPerson_auto.api";
	}

	/**
	 * 获取接口地址：文档传输接口
	 * @author: yaoshuifu 
	 
	 * @return
	 */
	public function getURLOfUploadDocs() {
		return $this->url."uploaddocs.api";
	}

	/**
	 * 获取接口地址：合同模板传输接口
	 * @author: yaoshuifu
	 
	 * @return
	 */
	public function getURLOfUploadTemplate() {
		return $this->url."uploadtemplate.api";
	}

	/**
	 * 获取接口地址：合同生成接口
	 * @author: yaoshuifu
	 
	 * @return
	 */
	public function getURLOfGenerateContract() {
		return $this->url."generate_contract.api";
	}

	/**
	 * 获取接口地址：文档签署接口（手动签署模式）
	 * @author: yaoshuifu
	 
	 * @return
	 */
	public function getURLOfExtSign() {
		return $this->url. "extsign.api";
	}

	/**
	 * 获取接口地址：文档签署接口（自动签署模式）
	 * @author: yaoshuifu
	 
	 * @return
	 */
	public function getURLOfExtSignAuto() {
		return $this->url."extsign_auto.api";
	}

	/**
	 * 获取接口地址：客户签署状态查询接口
	 * @author: yaoshuifu
	 
	 * @return
	 */
	public function getURLOfQuerySignStatus() {
		return $this->url. "query_signstatus.api";
	}

	/**
	 * 获取接口地址：归档接口
	 * @author: yaoshuifu
	 
	 * @return
	 */
	public function getURLOfContractFilling() {
		return $this->url. "contractFiling.api";
	}

	// ========================基础接口 end========================

	// ========================TODO 扩展接口 start======================

	/**
	 * 获取接口地址：修改用户信息
	 * @author: yaoshuifu
	 
	 * @return
	 */
	public function getURLOfInfoChange() {
		return $this->url."infochange.api";
	}

	/**
	 * 获取接口地址：合同下载接口
	 * @author: yaoshuifu
	 
	 * @return
	 */
	public function getURLOfDownloadPdf() {
		return $this->url. "downLoadContract.api";
	}

	/**
	 * 获取接口地址：合同查看接口
	 * @author: yaoshuifu
	 
	 * @return
	 */
	public function getURLOfViewContract() {
		return $this->url. "viewContract.api";
	}

	/**
	 * 获取接口地址：合同验签接口
	 * @author: yaoshuifu
	 
	 * @return
	 */
	public function getURLOfContractVerify() {
		return $this->url. "contract_verify.api";
	}

	/**
	 * 获取接口地址：查询合同HASH值接口
	 * @author: yaoshuifu
	 
	 * @return
	 */
	public function getURLOfContractHash() {
		return $this->url. "getContractHash.api";
	}

	/**
	 * 获取接口地址：文档签署接口（含有效期和次数）
	 * @author: yaoshuifu
	 
	 * @return
	 */
	public function getURLOfExtSignValidation() {
		return $this->url. "extsign_validation.api";
	}

	/**
	 * 获取接口地址：文档临时查看下载地址接口（带有效期和次数）
	 * @author: yaoshuifu
	 
	 * @return
	 */
	public function getURLOfViewUrl() {
		return $this->url. "geturl.api";
	}
	// ========================扩展接口 end========================
        
        
        
}