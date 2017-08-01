<?php
/**
 * ZHIMA API: zhima.open.userid.openid request
 *
 * @author auto create
 * @since 1.0, 2016-05-13 19:21:13
 */
class ZhimaOpenUseridOpenidRequest
{
	/** 
	 * 支付宝会员id.
	 **/
	private $alipayUserId;
	
	/** 
	 * 
	 **/
	private $contactsCredit;

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

	public function setContactsCredit($contactsCredit)
	{
		$this->contactsCredit = $contactsCredit;
		$this->fileParas["contacts_credit"] = $contactsCredit;
	}

	public function getContactsCredit()
	{
		return $this->contactsCredit;
	}

	public function getApiMethodName()
	{
		return "zhima.open.userid.openid";
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
