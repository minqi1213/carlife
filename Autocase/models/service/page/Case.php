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
		$header[] = "Cookie:BAIDUID=AE4314AC76CD0BB5B278026F2DF63A1B:FG=1; PSTM=1436147236; BIDUPSID=E7BADF734ED2B7C9792D0C1D608C9BF2; BDUSS=TY0SEw1MGRyYXdXS0ZrRWc5REFlME9HaGtoY0JPbVpGUkhJcURZSU1SMDNOTlZWQVFBQUFBJCQAAAAAAAAAAAEAAABykT4WaXZ5MTEyMndhbmcAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADenrVU3p61VN;";
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
		}
		else
		{
			$get_data = "";
		}

		$url = $url."?".$get_data;
		$header[] = "Cookie:BAIDUID=AE4314AC76CD0BB5B278026F2DF63A1B:FG=1; PSTM=1436147236; BIDUPSID=E7BADF734ED2B7C9792D0C1D608C9BF2; BDUSS=TY0SEw1MGRyYXdXS0ZrRWc5REFlME9HaGtoY0JPbVpGUkhJcURZSU1SMDNOTlZWQVFBQUFBJCQAAAAAAAAAAAEAAABykT4WaXZ5MTEyMndhbmcAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADenrVU3p61VN;";
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
				if($curData != $value)
				{
					var_dump($curData);
					var_dump($value);
					return false;
				} 
			}
			if($type == 2)
			{
				if(is_null($curData))
				{
					var_dump($curData);
					
					return false;		
				}
			}
			if($type == 3)
			{
				if(!is_null($curData))
				{
					 var_dump($curData);
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
	
	//拿接口的数据
	private function getData($CaseId)
	{
		$service = new Service_Data_Case();
		$caseDesResult = $service->getCaseDesByCaseId($CaseId);
		//本身case的输入是固定的情况
		$paramsArray = $service->getCaseInput($CaseId);
		//查找输入参数是其它case的入参的情况
		$fromCaseInArray = $service->getInputFromCaseIn($CaseId);
		//查找输入参数是其它case的出参的情况
		$fromCaseOutArray = $service->getInputFromCaseOut($CaseId);
		$fromSignArray = $service->getFromSign($CaseId);
		$inputArray = array();
		$inputNum = 0;
		if(is_array($paramsArray))
		{
			$inputArray = $paramsArray;
			$inputNum  = count($paramsArray);
		}
	
		if(is_array($fromCaseInArray))
		{
			for($i = 0; $i < count($fromCaseInArray); $i++)
			{
				$Field = $fromCaseInArray[$i]['Field'];
				$Value = $fromCaseInArray[$i]['Value'];
				$inputArray[$inputNum]['Field'] = $field;
				$inputArray[$inputNum]['Value'] = $result[0]['Value'];
				$inputNum++;
			}
		}
		
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
				$outputArray[$outputNum]['Field'] = $field;
				$outputArray[$outputNum]['FromField'] = $FromField ;
				$outputNum++;
				if($fromCaseId != $diffFromCaseId)
				{
					$result = $this->getData($fromCaseId);
					for($j = 0; $j < count($outputArray); $j++)
					{
						$fromField = $outputArray[$j]['FromField'];
						$field = $outputArray[$j]['Field'];
						$value = $this->getResultByField($result, $fromField);
						//将这些参数加入到入参数里面
						$inputArray[$inputNum]['Field'] = $field;
						$inputArray[$inputNum]['Value'] = $curResult;
						$inputNum++;
						//插入到参数表中
						$service->InsertOrUpdateInput($CaseId, $field, $curResult);
						//检查是否有check的内容和FromField相等的
						$checkPoint = $service->getResVal0Fromcase($CaseId, $fromField);
						if(is_array($checkPoint))
						{
							$field = $checkPoint[0]['Field'];
							$service->InsertOrUpdateResVal($CaseId, $field, $curResult);
						}
					}
				}
			}
			$result = $this->getData($fromCaseId);
			for($j = 0; $j < count($outputArray); $j++)
			{
				$fromField = $outputArray[$j]['FromField'];
				$field = $outputArray[$j]['Field'];
				$value = $this->getResultByField($result, $fromField);
				//将这些参数加入到入参数里面
				$inputArray[$inputNum]['Field'] = $field;
				$inputArray[$inputNum]['Value'] = $curResult;
				$inputNum++;
				//插入到参数表中
				$service->InsertOrUpdateInput($CaseId, $field, $curResult);
				//检查是否有check的内容和FromField相等的
				$checkPoint = $service->getResVal0Fromcase($CaseId, $fromField);
				if(is_array($checkPoint))
				{
					$field = $checkPoint[0]['Field'];
					$service->InsertOrUpdateResVal($CaseId, $field, $curResult);
				}
			}
		}

		if(is_array($fromSignArray))
		{
				$field = $fromSignArray[0]['Field'];
				$url = "http://cq01-ocean-13.epc.baidu.com:8240/car/sign/wallet";
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
		if($data == false)
		{
			return false;
		}
		$service = new Service_Data_Case();
		$check1 = $service->getCaseRes($CaseId);
		$check2 = $service->getResVal1FromCase($CaseId);
		$checkArray = array();
		if(is_array($Check1))
			$checkArray = $check1;
		$checkNum = count($checkArray);
		for($i = 0; $i < count($check2); $i++)
		{
			$checkArray[$checkNum]['CaseId'] = $check2[$i]['CaseId'];
			$checkArray[$checkNum]['Field'] = $check2[$i]['Field'];
			$checkArray[$checkNum]['Type'] = 1;
			$checkArray[$checkNum]['Value'] = $check2[$i]['Value'];
			$checkNum++;
		}
		var_dump($data);
		var_dump($checkArray);
		$check = $this->checkResult($data, $checkArray);
		unset($service);
		var_dump($check);
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