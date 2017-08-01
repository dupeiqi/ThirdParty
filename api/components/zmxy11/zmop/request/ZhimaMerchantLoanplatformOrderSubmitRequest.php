<?php
/**
 * ZHIMA API: zhima.merchant.loanplatform.order.submit request
 *
 * @author auto create
 * @since 1.0, 2017-03-20 16:52:30
 */
class ZhimaMerchantLoanplatformOrderSubmitRequest
{
	/** 
	 * 支付宝userId
	 **/
	private $alipayUserId;
	
	/** 
	 * 
	 **/
	private $contractFlag;
	
	/** 
	 * ISV代替商户进行授权
	 **/
	private $isvAuthInfo;
	
	/** 
	 * 产品码
	 **/
	private $productCode;
	
	/** 
	 * 风险评估信息
	 **/
	private $riskEvalInfo;
	
	/** 
	 * 商户订单号
	 **/
	private $transactionId;
	
	/** 
	 * 芝麻通行证信息
	 **/
	private $zmPassInfo;

	private $apiParas = array();
	private $fileParas = array();
	private $apiVersion="1.0";
	private $scene;
	private $channel;
	private $platform;
	private $extParams;

	
	public function setAlipayUserId($alipayUserId)
	{
		$this->alipayUserId = $alipayUserId;
		$this->apiParas["alipay_user_id"] = $alipayUserId;
	}

	public function getAlipayUserId()
	{
		return $this->alipayUserId;
	}

	public function setContractFlag($contractFlag)
	{
		$this->contractFlag = $contractFlag;
		$this->apiParas["contract_flag"] = $contractFlag;
	}

	public function getContractFlag()
	{
		return $this->contractFlag;
	}

	public function setIsvAuthInfo($isvAuthInfo)
	{
		$this->isvAuthInfo = $isvAuthInfo;
		$this->apiParas["isv_auth_info"] = $isvAuthInfo;
	}

	public function getIsvAuthInfo()
	{
		return $this->isvAuthInfo;
	}

	public function setProductCode($productCode)
	{
		$this->productCode = $productCode;
		$this->apiParas["product_code"] = $productCode;
	}

	public function getProductCode()
	{
		return $this->productCode;
	}

	public function setRiskEvalInfo($riskEvalInfo)
	{
		$this->riskEvalInfo = $riskEvalInfo;
		$this->apiParas["risk_eval_info"] = $riskEvalInfo;
	}

	public function getRiskEvalInfo()
	{
		return $this->riskEvalInfo;
	}

	public function setTransactionId($transactionId)
	{
		$this->transactionId = $transactionId;
		$this->apiParas["transaction_id"] = $transactionId;
	}

	public function getTransactionId()
	{
		return $this->transactionId;
	}

	public function setZmPassInfo($zmPassInfo)
	{
		$this->zmPassInfo = $zmPassInfo;
		$this->apiParas["zm_pass_info"] = $zmPassInfo;
	}

	public function getZmPassInfo()
	{
		return $this->zmPassInfo;
	}

	public function getApiMethodName()
	{
		return "zhima.merchant.loanplatform.order.submit";
	}

	public function setScene($scene)
	{
		$this->scene=$scene;
	}

	public function getScene()
	{
		return $this->scene;
	}
	
	public function setChannel($channel)
	{
		$this->channel=$channel;
	}

	public function getChannel()
	{
		return $this->channel;
	}
	
	public function setPlatform($platform)
	{
		$this->platform=$platform;
	}

	public function getPlatform()
	{
		return $this->platform;
	}

	public function setExtParams($extParams)
	{
		$this->extParams=$extParams;
	}

	public function getExtParams()
	{
		return $this->extParams;
	}	

	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function getFileParas()
	{
		return $this->fileParas;
	}

	public function setApiVersion($apiVersion)
	{
		$this->apiVersion=$apiVersion;
	}

	public function getApiVersion()
	{
		return $this->apiVersion;
	}

}
