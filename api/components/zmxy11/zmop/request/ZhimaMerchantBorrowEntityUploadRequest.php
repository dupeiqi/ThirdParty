<?php
/**
 * ZHIMA API: zhima.merchant.borrow.entity.upload request
 *
 * @author auto create
 * @since 1.0, 2017-03-15 13:29:33
 */
class ZhimaMerchantBorrowEntityUploadRequest
{
	/** 
	 * 地址描述
	 **/
	private $addressDesc;
	
	/** 
	 * 是否可借用，Y:可借，N:不可借。如果不可借用，则不在芝麻借还频道地图展示
	 **/
	private $canBorrow;
	
	/** 
	 * 可借用数量，如果是借用实物，如自行车，传1即可。如果是借用门店或借还机柜，则传入可借用的物品数量
	 **/
	private $canBorrowCnt;
	
	/** 
	 * 类目Code，传入芝麻借还规定的类目Code
	 **/
	private $categoryCode;
	
	/** 
	 * 是否收租金，Y:收租金，N:不收租金
	 **/
	private $collectRent;
	
	/** 
	 * 联系电话，手机11位数字，座机：区号－数字
	 **/
	private $contactNumber;
	
	/** 
	 * 外部实体编号，唯一标识一个实体，如自行车编号，机柜编号
	 **/
	private $entityCode;
	
	/** 
	 * 实体名称，借用实体的描述
	 **/
	private $entityName;
	
	/** 
	 * 地址位置纬度，取值范围：纬度-90~90，中国地区经度范围：纬度3.86~53.55
	 **/
	private $latitude;
	
	/** 
	 * 地址位置经度，取值范围：经度-180~180，中国地区经度范围：73.66~135.05
	 **/
	private $longitude;
	
	/** 
	 * 营业时间，格式：xx:xx-xx:xx，24小时制，如果是昼夜00:00—24:00
	 **/
	private $officeHoursDesc;
	
	/** 
	 * 租金描述，该借还点的租金描述，例如：5元/小时，5-10元／小时
	 **/
	private $rentDesc;
	
	/** 
	 * 借用总数，如果是借用实物，如自行车，传1即可。如果是借用门店或借还机柜，则传入提供借还物品的总量
	 **/
	private $totalBorrowCnt;
	
	/** 
	 * 实体上传时间，某一借还实体信息多次上传，以最新上传时间数据为当前最新快照，格式：yyyy-mm-dd hh:MM:ss
	 **/
	private $uploadTime;

	private $apiParas = array();
	private $fileParas = array();
	private $apiVersion="1.0";
	private $scene;
	private $channel;
	private $platform;
	private $extParams;

	
	public function setAddressDesc($addressDesc)
	{
		$this->addressDesc = $addressDesc;
		$this->apiParas["address_desc"] = $addressDesc;
	}

	public function getAddressDesc()
	{
		return $this->addressDesc;
	}

	public function setCanBorrow($canBorrow)
	{
		$this->canBorrow = $canBorrow;
		$this->apiParas["can_borrow"] = $canBorrow;
	}

	public function getCanBorrow()
	{
		return $this->canBorrow;
	}

	public function setCanBorrowCnt($canBorrowCnt)
	{
		$this->canBorrowCnt = $canBorrowCnt;
		$this->apiParas["can_borrow_cnt"] = $canBorrowCnt;
	}

	public function getCanBorrowCnt()
	{
		return $this->canBorrowCnt;
	}

	public function setCategoryCode($categoryCode)
	{
		$this->categoryCode = $categoryCode;
		$this->apiParas["category_code"] = $categoryCode;
	}

	public function getCategoryCode()
	{
		return $this->categoryCode;
	}

	public function setCollectRent($collectRent)
	{
		$this->collectRent = $collectRent;
		$this->apiParas["collect_rent"] = $collectRent;
	}

	public function getCollectRent()
	{
		return $this->collectRent;
	}

	public function setContactNumber($contactNumber)
	{
		$this->contactNumber = $contactNumber;
		$this->apiParas["contact_number"] = $contactNumber;
	}

	public function getContactNumber()
	{
		return $this->contactNumber;
	}

	public function setEntityCode($entityCode)
	{
		$this->entityCode = $entityCode;
		$this->apiParas["entity_code"] = $entityCode;
	}

	public function getEntityCode()
	{
		return $this->entityCode;
	}

	public function setEntityName($entityName)
	{
		$this->entityName = $entityName;
		$this->apiParas["entity_name"] = $entityName;
	}

	public function getEntityName()
	{
		return $this->entityName;
	}

	public function setLatitude($latitude)
	{
		$this->latitude = $latitude;
		$this->apiParas["latitude"] = $latitude;
	}

	public function getLatitude()
	{
		return $this->latitude;
	}

	public function setLongitude($longitude)
	{
		$this->longitude = $longitude;
		$this->apiParas["longitude"] = $longitude;
	}

	public function getLongitude()
	{
		return $this->longitude;
	}

	public function setOfficeHoursDesc($officeHoursDesc)
	{
		$this->officeHoursDesc = $officeHoursDesc;
		$this->apiParas["office_hours_desc"] = $officeHoursDesc;
	}

	public function getOfficeHoursDesc()
	{
		return $this->officeHoursDesc;
	}

	public function setRentDesc($rentDesc)
	{
		$this->rentDesc = $rentDesc;
		$this->apiParas["rent_desc"] = $rentDesc;
	}

	public function getRentDesc()
	{
		return $this->rentDesc;
	}

	public function setTotalBorrowCnt($totalBorrowCnt)
	{
		$this->totalBorrowCnt = $totalBorrowCnt;
		$this->apiParas["total_borrow_cnt"] = $totalBorrowCnt;
	}

	public function getTotalBorrowCnt()
	{
		return $this->totalBorrowCnt;
	}

	public function setUploadTime($uploadTime)
	{
		$this->uploadTime = $uploadTime;
		$this->apiParas["upload_time"] = $uploadTime;
	}

	public function getUploadTime()
	{
		return $this->uploadTime;
	}

	public function getApiMethodName()
	{
		return "zhima.merchant.borrow.entity.upload";
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
