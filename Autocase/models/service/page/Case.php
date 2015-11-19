<?php

/**
 * 用例相关的业务model
 * @author wangcaixia@baidu.com
 * @date 2015-09-15
 * @package 路径
 * @version 1.0
 */
class Service_Page_Case extends Service_Page_Base
{
    /**
     * @param array
     * @return array|bool
     * @throws Exec_Exception
     */
    
    public function addCase($params)
    {
		$service = new Service_Data_Case();
        $result = $service->insertCase($params);
	
        //记录执行信息
        $this->_execute_info = $service->getExecuteInfo();
		if (!$result) {
            $error = $service->getError();
            $db_execute = $service->getExecuteInfo();
            throw new Exec_Exception($error, array('db_execute' => $db_execute));
        }
        unset($service);
        return $result;
    }

    public function addCaseInputValue($params)
    {
		$service = new Service_Data_Case();
		$result = $service->insertInputValue($params);
		
		$this->_execute_info = $service->getExecuteInfo();
		if (!$result) {
			$error = $service->getError();
			$db_execute = $service->getExecuteInfo();
			throw new Exec_Exception($error, array('db_execute' => $db_execute));
		}
		unset($service);
		return $result;
    }
    
     public function addInputFromCase($params)
    {
		$service = new Service_Data_Case();
		$result = $service->insertInputFromCase($params);
		
		$this->_execute_info = $service->getExecuteInfo();
		if (!$result) {
			$error = $service->getError();
			$db_execute = $service->getExecuteInfo();
			throw new Exec_Exception($error, array('db_execute' => $db_execute));
		}
		unset($service);
		return $result;
    }

	public function addCaseResValue($params)
	{
		$service = new Service_Data_Case();
		$result = $service->insertResValue($params);
	
		$this->_execute_info = $service->getExecuteInfo();
		if ( !$result ) {
			$error = $service->getError();
			$db_execute = $service->getExecuteInfo();
			throw new Exec_Exception($error, array('db_execute' => $db_execute));
		}
		unset($service);
		return $result;
	}
	
	 public function addResFromCase($params)
   {
		$service = new Service_Data_Case();
		$result = $service->insertResFromCase($params);
		
		$this->_execute_info = $service->getExecuteInfo();
		if (!$result) {
			$error = $service->getError();
			$db_execute = $service->getExecuteInfo();
			throw new Exec_Exception($error, array('db_execute' => $db_execute));
		}
		unset($service);
		return $result;
    }

	private function requestPost($url = '', $post_data = array())
	{
		if (empty($url))
		{
			return false;
		}
		$o = "";
		for($i = 0; $i < count($post_data); $i++)
		{
			$field = $post_data[$i]['Field'];
			$value = $post_data[$i]['Value'];
			$o .= "$field=" . urlencode($value). "&";
		}
		if($o != "")
		{
			$post_data = substr($o, 0, -1);
		}
		else
		{
			$post_data = "";
		}

		$postUrl = $url;
		$curlPost = $post_data;
		var_dump($url);
		var_dump($post_data);
		$header[] = "Cookie:PSTM=1436147236; BIDUPSID=E7BADF734ED2B7C9792D0C1D608C9BF2; BDUSS=pzRH5Od0NHUTlLZ2w1WjBHbjZoTmpFeTczSXhNdDFvM2h0OUQxa2FCSHRCRU5XQVFBQUFBJCQAAAAAAAAAAAEAAABykT4WaXZ5MTEyMndhbmcAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAO13G1btdxtWMH; Hm_lvt_24a72bde5fc530003072ca4b3c0b271c=1443592043,1444877253; PHPSESSID=ST-20447-hLODM9KVdw53QuuvOzk0-uuap; BDRCVFR[dG2JNJb_ajR]=mk3SLVN4HKm; BDRCVFR[-pGxjrCMryR]=mk3SLVN4HKm; BDRCVFR[feWj1Vr5u3D]=I67x6TjHwwYf0; BAIDUID=A7B22434FC07B62FE7EFBF9DE1C2587E:FG=1; _5t_trace_sid=d6e4e5949835c6b2cf27b05e9df5580b; _5t_trace_tms=1; H_PS_PSSID=1455_17619_12826_14429_10211_17001_17470_17072_17052_15277_12313_17421_17051";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $postUrl);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}

	private function requestGet($url = '', $request_data = array())
	{
		if (empty($url))
		{
			return false;
		}
		$o = "";
		for($i = 0; $i < count($request_data); $i++)
		{
			$field = $request_data[$i]['Field'];
			$value = $request_data[$i]['Value'];
			$o .= "$field=" . urlencode($value). "&";
		}
		if($o != "")
		{
			$get_data = substr($o, 0, -1);
			$url = $url."?".$get_data;
		}
		var_dump($url);

		$header[] = "Cookie:PSTM=1436147236; BIDUPSID=E7BADF734ED2B7C9792D0C1D608C9BF2; BDUSS=pzRH5Od0NHUTlLZ2w1WjBHbjZoTmpFeTczSXhNdDFvM2h0OUQxa2FCSHRCRU5XQVFBQUFBJCQAAAAAAAAAAAEAAABykT4WaXZ5MTEyMndhbmcAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAO13G1btdxtWMH; Hm_lvt_24a72bde5fc530003072ca4b3c0b271c=1443592043,1444877253; PHPSESSID=ST-20447-hLODM9KVdw53QuuvOzk0-uuap; BDRCVFR[dG2JNJb_ajR]=mk3SLVN4HKm; BDRCVFR[-pGxjrCMryR]=mk3SLVN4HKm; BDRCVFR[feWj1Vr5u3D]=I67x6TjHwwYf0; BAIDUID=A7B22434FC07B62FE7EFBF9DE1C2587E:FG=1; _5t_trace_sid=d6e4e5949835c6b2cf27b05e9df5580b; _5t_trace_tms=1; H_PS_PSSID=1455_17619_12826_14429_10211_17001_17470_17072_17052_15277_12313_17421_17051";		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}

	private function checkResult($data, $checkResult)
	{
		var_dump($data);
		for($i = 0; $i < count($checkResult); $i++)
		{
			$field = $checkResult[$i]['Field'];
			$type = $checkResult[$i]['Type'];
			$value = $checkResult[$i]['Value'];
			$curData = $data;
			$fieldArray = explode("|", $field);
			for($j = 0; $j < count($fieldArray); $j++)
			{
				$curField = $fieldArray[$j];
				if(array_key_exists($curField, $curData))
				{
					$curData = $curData[$curField];
				}
				else
				{
					return false;
				}
			}

			
			if($type == 1)
			{
				if(is_bool($curData))
				{
					if(($curData === true && $value === "false") || ($curData === false && $value === "true"))
					{
						return false;
					} 
				}
				else
				{	
					if(strval($curData) !== $value)
					{
						return false;
					}
				} 
			}
			if($type == 2)
			{
				if(is_null($curData))
				{
					return false;		
				}
			}
			if($type == 3)
			{
				
				if(!is_null($curData))
				{
					return false;	
				}
			}
			if($type == 4)
			{
				if (!ereg($value, $curData))
				{
					return false;
				} 
			}
		}
		return true;
	}
	
	private function getResultByField($result, $field)
	{
		$fieldArray = explode("|", $field);
		$curResult = $result;	
		for($k = 0; $k < count($fieldArray); $k++)
		{
			$curField = $fieldArray[$k];
			if(array_key_exists($curField, $curResult))
			{
				$curResult = $curResult[$curField];
			}
			else
			{
				return false;
			}
		}
		return $curResult;
	}
	
	private function getFromCaseOut($CaseId, $fromCaseId, $outputArray)
	{
		$service = new Service_Data_Case();
		$result = $this->getData($fromCaseId);
		for($j = 0; $j < count($outputArray); $j++)
		{
			$fromField = $outputArray[$j]['FromField'];
			$field = $outputArray[$j]['Field'];
			$value = $this->getResultByField($result, $fromField);
			
			//插入到参数表中
			$service->InsertOrUpdateInput($CaseId, $field, $value);
			//检查是否有check的内容和FromField相等的
			$checkPoint = $service->getResVal0Fromcase($CaseId, $fromField);
			if(is_array($checkPoint))
			{
				$field = $checkPoint[0]['Field'];
				$service->InsertOrUpdateResVal($CaseId, $field, $value);
			}
		}
		unset($service);
	}
	
	//拿接口的数据
	private function getData($CaseId)
	{
		$service = new Service_Data_Case();
		$caseDesResult = $service->getCaseDesByCaseId($CaseId);
	
		//查找输入参数是其它case的入参，而它依赖的case也依赖其它case
		$fromCaseIdArray = $service->getInputFromCaseId($CaseId);
		//查找case依赖其它case，仅仅是依赖，没有任何参数上依赖
		$dependIdArray = $service->getCaseDependId($CaseId);
	
		if(is_array($fromCaseIdArray))
		{
			//var_dump($fromCaseIdArray);
			for($i = 0; $i < count($fromCaseIdArray); $i++)
			{
				$fromCaseId = $fromCaseIdArray[$i]['CaseId'];
				$this->getData($fromCaseId);
			}
		}
		
		if(is_array($dependIdArray))
		{
			//var_dump($dependIdArray);
			for($i = 0; $i < count($dependIdArray); $i++)
			{
				$fromCaseId = $dependIdArray[$i]['FromCaseId'];
				$this->getData($fromCaseId);
			}
		}
	
		//查找输入参数是其它case的出参的情况
		$fromCaseOutArray = $service->getInputFromCaseOut($CaseId);
		if(is_array($fromCaseOutArray))
		{
			$diffFromCaseId = $fromCaseOutArray[0]['FromCaseId'];
			$outputArray = array();
			$outputNum = 0;
			for($i = 0; $i < count($fromCaseOutArray); $i++)
			{
				$fromCaseId = $fromCaseOutArray[$i]['FromCaseId']; 
				$Field = $fromCaseOutArray[$i]['Field'];
				$FromField = $fromCaseOutArray[$i]['FromField'];
				$outputArray[$outputNum]['Field'] = $Field;
				$outputArray[$outputNum]['FromField'] = $FromField ;
				$outputNum++;
				if($fromCaseId != $diffFromCaseId)
				{
					$this->getFromCaseOut($CaseId, $fromCaseId, $outputArray);
					$outputArray = array();
					$outputNum = 0;
				}
			}
			$this->getFromCaseOut($CaseId, $fromCaseId, $outputArray);
		}
		
		$service->InsertOrUpdateAutocaseInput($CaseId);
		
		//最终case的输入
		$inputArray = $service->getCaseInput($CaseId);
		$inputNum = count($inputArray);
	
		//查找依赖签名的情况
		$fromSignArray = $service->getFromSign($CaseId);
		if(is_array($fromSignArray))
		{
				$field = $fromSignArray[0]['Field'];
				//$url = "http://cq01-ocean-13.epc.baidu.com:8240/car/sign/wallet";
				$url = "http://nj03-map-carlife-caroil01.nj03.baidu.com:8240/autotest/sign/wallet";
				$data = $this->requestPost($url, $inputArray);
				$inputArray[$inputNum]['Field'] = $field;
				$inputArray[$inputNum]['Value'] = $data;
				$inputNum++;
		}	

		if(is_array($caseDesResult ))
		{
				$requestType = $caseDesResult[0]['RequestType'];
				$url =  $caseDesResult[0]['Url'];
				if($requestType == 1)
				{
					$url = "http://nj03-map-carlife-caroil01.nj03.baidu.com:8240".$url;
					$data = $this->requestPost($url, $inputArray);
					$result = json_decode($data, true);
					unset($service);
					return $result;
				}
				if($requestType == 0)
				{
					$url = "http://nj03-map-carlife-caroil01.nj03.baidu.com:8240".$url;
					$data = $this->requestGet($url, $inputArray);
					$result = json_decode($data, true);
					unset($service);
					return $result;
				}
		}
		else
		{
			unset($service);
			return false;
		}
	}

	private function checkOneCase($CaseId)
	{
		$data = $this->getData($CaseId);
		if($data === false)
		{
			return false;
		}
		$service = new Service_Data_Case();
		$check1 = $service->getCaseRes($CaseId);
		$check2 = $service->getResVal1FromCase($CaseId);
		$checkArray = array();
		if(is_array($check1))
			$checkArray = $check1;
		$checkNum = count($checkArray);
		if(is_array($check2))
		{
			for($i = 0; $i < count($check2); $i++)
			{
				$checkArray[$checkNum]['CaseId'] = $check2[$i]['CaseId'];
				$checkArray[$checkNum]['Field'] = $check2[$i]['Field'];
				$checkArray[$checkNum]['Type'] = 1;
				$checkArray[$checkNum]['Value'] = $check2[$i]['Value'];
				$checkNum++;
			}
		}
		var_dump($checkArray);
		$check = $this->checkResult($data, $checkArray);
		unset($service);
		return $check;
	}

	public function runCase($params)
	{
		$CaseId = $params['CaseId'];
		$InterfaceId = $params['InterfaceId'];
		$result = array();
		if($CaseId != null)
		{
			$result[0]['CaseId'] = $CaseId;
			$result[0]['CaseResult'] = $this->checkOneCase($CaseId);
		}
		else  if($InterfaceId != null)
		{
			$service = new Service_Data_Case();
			$caseDesResult = $service->getCasDesByInterfaceId($InterfaceId);
			for($i = 0; $i < count($caseDesResult); $i++)
			{
				$CaseId = $caseDesResult[$i]['CaseId'];
				$result[$i]['CaseId'] = $CaseId; 
				$result[$i]['CaseResult'] = $this->checkOneCase($CaseId);
			}					
		}

		unset($service);
		return $result;
	}
}
