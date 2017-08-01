<?php
/**
 * ZHIMA API: zhima.merchant.order.rent.complete request
 *
 * @author auto create
 * @since 1.0, 2017-04-10 15:05:06
 */
class ZhimaMerchantOrderRentCompleteRequest
{
	/** 
	 * 芝麻信用借还订单号
	 **/
	private $orderNo;
	
	/** 
	 * 支付金额,单位：元
	 **/
	private $payAmount;
	
	/** 
	 * 金额类型：
RENT:租金
DAMAGE:赔偿金
	 **/
	private $payAmountType;
	
	/** 
	 * 信用借还的产品码:w1010100000000002858
	 **/
	private $productCode;
	
	/** 
	 * 归还门店
	 **/
	private $restoreShopName;
	
	/** 
	 * 物品归还时间，格式为yyyy-MM-dd HH:mm:ss
	 **/
	private $restoreTime;

	private $apiParas = array();
	private $fileParas = array();
	private $apiVersion="1.0";
	private $scene;
	private $channel;
	private $platform;
	private $extParams;

	
	public function setOrderNo($orderNo)
	{
		$this->orderNo = $orderNo;
		$this->apiParas["order_no"] = $orderNo;
	}

	public function getOrderNo()
	{
		return $this->orderNo;
	}

	public function setPayAmount($payAmount)
	{
		$this->payAmount = $payAmount;
		$this->apiParas["pay_amount"] = $payAmount;
	}

	public function getPayAmount()
	{
		return $this->payAmount;
	}

	public function setPayAmountType($payAmountType)
	{
		$this->payAmountType = $payAmountType;
		$this->apiParas["pay_amount_type"] = $payAmountType;
	}

	public function getPayAmountType()
	{
		return $this->payAmountType;
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

	public function setRestoreShopName($restoreShopName)
	{
		$this->restoreShopName = $restoreShopName;
		$this->apiParas["restore_shop_name"] = $restoreShopName;
	}

	public function getRestoreShopName()
	{
		return $this->restoreShopName;
	}

	public function setRestoreTime($restoreTime)
	{
		$this->restoreTime = $restoreTime;
		$this->apiParas["restore_time"] = $restoreTime;
	}

	public function getRestoreTime()
	{
		return $this->restoreTime;
	}

	public function getApiMethodName()
	{
		return "zhima.merchant.order.rent.complete";
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
