<?php
/**
 * ZHIMA API: zhima.merchant.order.rent.modify request
 *
 * @author auto create
 * @since 1.0, 2017-05-15 09:51:32
 */
class ZhimaMerchantOrderRentModifyRequest
{
	/** 
	 * 芝麻借还订单的开始借用时间，格式：yyyy-mm-dd hh:MM:ss 
如果同时传入另一参数:应归还时间expiry_time，则传入的开始借用时间不能晚于传入的应归还时间，如果没有传入应归还时间，则传入的开始借用时间不能晚于原有应归还时间
	 **/
	private $borrowTime;
	
	/** 
	 * 芝麻借还订单的应归还时间(到期时间)，格式：yyyy-mm-dd hh:MM:ss 
传入的应归还时间不能早于原有应归还时间
	 **/
	private $expiryTime;
	
	/** 
	 * 信用借还订单号
	 **/
	private $orderNo;
	
	/** 
	 * 信用借还的产品码:w1010100000000002858
	 **/
	private $productCode;

	private $apiParas = array();
	private $fileParas = array();
	private $apiVersion="1.0";
	private $scene;
	private $channel;
	private $platform;
	private $extParams;

	
	public function setBorrowTime($borrowTime)
	{
		$this->borrowTime = $borrowTime;
		$this->apiParas["borrow_time"] = $borrowTime;
	}

	public function getBorrowTime()
	{
		return $this->borrowTime;
	}

	public function setExpiryTime($expiryTime)
	{
		$this->expiryTime = $expiryTime;
		$this->apiParas["expiry_time"] = $expiryTime;
	}

	public function getExpiryTime()
	{
		return $this->expiryTime;
	}

	public function setOrderNo($orderNo)
	{
		$this->orderNo = $orderNo;
		$this->apiParas["order_no"] = $orderNo;
	}

	public function getOrderNo()
	{
		return $this->orderNo;
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

	public function getApiMethodName()
	{
		return "zhima.merchant.order.rent.modify";
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
