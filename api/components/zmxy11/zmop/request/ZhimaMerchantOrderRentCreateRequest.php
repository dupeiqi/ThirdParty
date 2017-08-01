<?php
/**
 * ZHIMA API: zhima.merchant.order.rent.create request
 *
 * @author auto create
 * @since 1.0, 2017-03-20 11:26:29
 */
class ZhimaMerchantOrderRentCreateRequest
{
	/** 
	 * 借用周期，必须是正整数
	 **/
	private $borrowCycle;
	
	/** 
	 * 借用周期单位：
HOUR:小时
DAY:天
	 **/
	private $borrowCycleUnit;
	
	/** 
	 * 物品借用门店
	 **/
	private $borrowShopName;
	
	/** 
	 * 借用用户的真实身份证号，非必填字段
	 **/
	private $certNo;
	
	/** 
	 * 物品押金
	 **/
	private $depositAmount;
	
	/** 
	 * 是否允许不准入的用户支持支付押金借用:
Y:支持
N:不支持
	 **/
	private $depositState;
	
	/** 
	 * 物品名称
	 **/
	private $goodsName;
	
	/** 
	 * 完成借用服务后回跳到商户的url地址，与invoke_type匹配使用
	 **/
	private $invokeReturnUrl;
	
	/** 
	 * 商户发起借用服务时，需要在借用结束后返回给商户的参数
	 **/
	private $invokeState;
	
	/** 
	 * 商户访问蚂蚁的对接模式：
WINDOWS-支付宝服务窗
	 **/
	private $invokeType;
	
	/** 
	 * 借用用户的真实姓名，非必填字段
	 **/
	private $name;
	
	/** 
	 * 异步通知的url
	 **/
	private $notifyUrl;
	
	/** 
	 * 外部订单号，需要唯一，由商户传入，芝麻内部会做幂等控制，格式为：yyyyMMddHHmmss+随机数
	 **/
	private $outOrderNo;
	
	/** 
	 * 信用借还的产品码:w1010100000000002858
	 **/
	private $productCode;
	
	/** 
	 * 租金，同时也是物品价值，用户需根据该字段金额进行赔偿
:
>0.00元，代表有租金
<=0.00元或者为空，代表没有租金
	 **/
	private $rentAmount;
	
	/** 
	 * 租金信息描述 ,长度14个汉字，只用于页面展示给C端用户
	 **/
	private $rentInfo;
	
	/** 
	 * 租金的结算方式，非必填字段，默认是支付宝租金结算支付
merchant：表示商户自行结算，信用借还不提供租金支付能力；
alipay：表示使用支付宝支付功能，给用户提供租金代扣及赔偿金支付能力；
	 **/
	private $rentSettleType;
	
	/** 
	 * 租金单位：
DAY_YUAN:元/天
HOUR_YUAN:元/小时
	 **/
	private $rentUnit;

	private $apiParas = array();
	private $fileParas = array();
	private $apiVersion="1.0";
	private $scene;
	private $channel;
	private $platform;
	private $extParams;

	
	public function setBorrowCycle($borrowCycle)
	{
		$this->borrowCycle = $borrowCycle;
		$this->apiParas["borrow_cycle"] = $borrowCycle;
	}

	public function getBorrowCycle()
	{
		return $this->borrowCycle;
	}

	public function setBorrowCycleUnit($borrowCycleUnit)
	{
		$this->borrowCycleUnit = $borrowCycleUnit;
		$this->apiParas["borrow_cycle_unit"] = $borrowCycleUnit;
	}

	public function getBorrowCycleUnit()
	{
		return $this->borrowCycleUnit;
	}

	public function setBorrowShopName($borrowShopName)
	{
		$this->borrowShopName = $borrowShopName;
		$this->apiParas["borrow_shop_name"] = $borrowShopName;
	}

	public function getBorrowShopName()
	{
		return $this->borrowShopName;
	}

	public function setCertNo($certNo)
	{
		$this->certNo = $certNo;
		$this->apiParas["cert_no"] = $certNo;
	}

	public function getCertNo()
	{
		return $this->certNo;
	}

	public function setDepositAmount($depositAmount)
	{
		$this->depositAmount = $depositAmount;
		$this->apiParas["deposit_amount"] = $depositAmount;
	}

	public function getDepositAmount()
	{
		return $this->depositAmount;
	}

	public function setDepositState($depositState)
	{
		$this->depositState = $depositState;
		$this->apiParas["deposit_state"] = $depositState;
	}

	public function getDepositState()
	{
		return $this->depositState;
	}

	public function setGoodsName($goodsName)
	{
		$this->goodsName = $goodsName;
		$this->apiParas["goods_name"] = $goodsName;
	}

	public function getGoodsName()
	{
		return $this->goodsName;
	}

	public function setInvokeReturnUrl($invokeReturnUrl)
	{
		$this->invokeReturnUrl = $invokeReturnUrl;
		$this->apiParas["invoke_return_url"] = $invokeReturnUrl;
	}

	public function getInvokeReturnUrl()
	{
		return $this->invokeReturnUrl;
	}

	public function setInvokeState($invokeState)
	{
		$this->invokeState = $invokeState;
		$this->apiParas["invoke_state"] = $invokeState;
	}

	public function getInvokeState()
	{
		return $this->invokeState;
	}

	public function setInvokeType($invokeType)
	{
		$this->invokeType = $invokeType;
		$this->apiParas["invoke_type"] = $invokeType;
	}

	public function getInvokeType()
	{
		return $this->invokeType;
	}

	public function setName($name)
	{
		$this->name = $name;
		$this->apiParas["name"] = $name;
	}

	public function getName()
	{
		return $this->name;
	}

	public function setNotifyUrl($notifyUrl)
	{
		$this->notifyUrl = $notifyUrl;
		$this->apiParas["notify_url"] = $notifyUrl;
	}

	public function getNotifyUrl()
	{
		return $this->notifyUrl;
	}

	public function setOutOrderNo($outOrderNo)
	{
		$this->outOrderNo = $outOrderNo;
		$this->apiParas["out_order_no"] = $outOrderNo;
	}

	public function getOutOrderNo()
	{
		return $this->outOrderNo;
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

	public function setRentAmount($rentAmount)
	{
		$this->rentAmount = $rentAmount;
		$this->apiParas["rent_amount"] = $rentAmount;
	}

	public function getRentAmount()
	{
		return $this->rentAmount;
	}

	public function setRentInfo($rentInfo)
	{
		$this->rentInfo = $rentInfo;
		$this->apiParas["rent_info"] = $rentInfo;
	}

	public function getRentInfo()
	{
		return $this->rentInfo;
	}

	public function setRentSettleType($rentSettleType)
	{
		$this->rentSettleType = $rentSettleType;
		$this->apiParas["rent_settle_type"] = $rentSettleType;
	}

	public function getRentSettleType()
	{
		return $this->rentSettleType;
	}

	public function setRentUnit($rentUnit)
	{
		$this->rentUnit = $rentUnit;
		$this->apiParas["rent_unit"] = $rentUnit;
	}

	public function getRentUnit()
	{
		return $this->rentUnit;
	}

	public function getApiMethodName()
	{
		return "zhima.merchant.order.rent.create";
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
