<?php
/**
 * ZHIMA API: zhima.open.sandbox.test request
 *
 * @author auto create
 * @since 1.0, 2017-03-14 15:59:42
 */
class ZhimaOpenSandboxTestRequest
{
	/** 
	 * 需要mock数据的接口名称
	 **/
	private $methodName;
	
	/** 
	 * 实际请求的入参json串；
历史原因，实际没有用到
	 **/
	private $params;

	private $apiParas = array();
	private $fileParas = array();
	private $apiVersion="1.0";
	private $scene;
	private $channel;
	private $platform;
	private $extParams;

	
	public function setMethodName($methodName)
	{
		$this->methodName = $methodName;
		$this->apiParas["method_name"] = $methodName;
	}

	public function getMethodName()
	{
		return $this->methodName;
	}

	public function setParams($params)
	{
		$this->params = $params;
		$this->apiParas["params"] = $params;
	}

	public function getParams()
	{
		return $this->params;
	}

	public function getApiMethodName()
	{
		return "zhima.open.sandbox.test";
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
