<?php

/**
 * 接口数据库操作类
 *
 * @author wangcaixia@baidu.com
 * @date 2015-09-15
 * @package 路径
 * @version 1.0
 */
class Service_Data_Case extends Service_Data_Db
{
    //数据库链接key
    private $_cluster = 'car';
    //接口表
    private $_case_table = '`autocase`';
	
	private $_case_input_table = '`autocase_input_value`';
	
	private $_input_from_case_table = '`autocase_input_fromcase`';
	
	private $_input_from_sign_table = '`autocase_input_fromsign`';
    
	private $_case_result_table = '`response_validate`';
	
	private $_res_from_case_table = '`response_validate_fromcase`';

    //构造函数
    public function __construct()
    {
        parent::__construct($this->_cluster);
    }

    /**
     * 根据订单ID查询数据库信息
     *
     * @param $order_id 订单ID
     *
     * @return array | bool
     */
    public function insertCase($params)
    {
        if (!is_object($this->_db)) {
            return false;
        }
        
		$CaseItem = array();
        $CaseItem['RequestType'] = $this->_db->escapeString($params['RequestType']);
        $CaseItem['CaseDes'] =  $this->_db->escapeString($params['CaseDes']);
        $CaseItem['InterfaceId'] = $this->_db->escapeString($params['InterfaceId']);
        $CaseItem['CreateBy'] = $this->_db->escapeString($params['CreateBy']);
        $CaseItem['CreateTime'] =  date('Y-m-d H:i:s');

        $success = true;
        //插入新的case记录
        $this->_db->insert($this->_case_table, $CaseItem);
        $this->_setExecuteInfo();
				
		$executeInfo = $this->_db_execute_info;
		foreach ($executeInfo as $k => $v){
			if($v['errno'] > 0) {
				$success = false;
				break;
			}
		}	
		return $success;
	}


	public function insertInputValue($params)
	{
		if (!is_object($this->_db)) {
			return false;
		}

		$CaseInputItem = array();
		$CaseInputItem['CaseId'] = $this->_db->escapeString($params['CaseId']);
		$CaseInputItem['Field'] = $this->_db->escapeString($params['Field']);
		$CaseInputItem['Value'] = $this->_db->escapeString($params['Value']);
		
		$success = true;
		$this->_db->insert($this->_case_input_table, $CaseInputItem);
		$this->_setExecuteInfo();

		$executeInfo = $this->_db_execute_info;
		foreach ($executeInfo as $k => $v) {
			if($v['errno'] > 0) {
				$success = false;
				break;
			}
		}
		return $success;
	}
	
	public function insertInputFromCase($params)
	{
		if (!is_object($this->_db)) {
			return false;
		}

		$CaseInputItem = array();
		$CaseInputItem['CaseId'] = $this->_db->escapeString($params['CaseId']);
		$CaseInputItem['Field'] = $this->_db->escapeString($params['Field']);
		$CaseInputItem['FromCaseId'] = $this->_db->escapeString($params['FromCaseId']);
		$CaseInputItem['FromField'] = $this->_db->escapeString($params['FromField']);
		$CaseInputItem['FromFieldIsInput'] = $this->_db->escapeString($params['FromFieldIsInput']);
		
		$success = true;
		$this->_db->insert($this->_input_from_case_table, $CaseInputItem);
		$this->_setExecuteInfo();

		$executeInfo = $this->_db_execute_info;
		foreach ($executeInfo as $k => $v) {
			if($v['errno'] > 0) {
				$success = false;
				break;
			}
		}
		return $success;
	}
	
	public function insertResValue($params)
	{
		if (!is_object($this->_db)) {
			return false;
		}

		$CaseResItem = array();
		$CaseResItem['CaseId'] = $this->_db->escapeString($params['CaseId']);
		$CaseResItem['Field'] = $this->_db->escapeString($params['Field']);
		$CaseResItem['Type'] = $params['Type']; 
		$CaseResItem['Value'] = $this->_db->escapeString($params['Value']);

		$success = true;
		$this->_db->insert($this->_case_result_table, $CaseResItem);
		$this->_setExecuteInfo();

		$executeInfo = $this->_db_execute_info;
		foreach ($executeInfo as $k => $v) {
			if($v['errno'] > 0) {
				$success = false;
				break;
			}
		}
		return $success;
	}
	
	public function insertResFromCase($params)
	{
		if (!is_object($this->_db)) {
			return false;
		}

		$CaseResItem = array();
		$CaseResItem['CaseId'] = $this->_db->escapeString($params['CaseId']);
		$CaseResItem['Field'] = $this->_db->escapeString($params['Field']);
		$CaseResItem['FromCaseId'] = $this->_db->escapeString($params['FromCaseId']);
		$CaseResItem['FromField'] = $this->_db->escapeString($params['FromField']);
		$CaseResItem['FromFieldIsInput'] = $this->_db->escapeString($params['FromFieldIsInput']);
		
		$success = true;
		$this->_db->insert($this->_res_from_case_table, $CaseResItem);
		$this->_setExecuteInfo();

		$executeInfo = $this->_db_execute_info;
		foreach ($executeInfo as $k => $v) {
			if($v['errno'] > 0) {
				$success = false;
				break;
			}
		}
		return $success;
	}
	
	public function getCaseInput($CaseId, $fromField = "")
	{
		if (!is_object($this->_db)) {
			return false;
		}
		
		$fields = array('*');
		if($fromField == "")
		{	
			$conditions = array("CaseId = $CaseId");
		}
		else
		{
			$conditions = array("CaseId = $CaseId", "Field = '$fromField'");
		}
		$tmp = $this->_db->select($this->_case_input_table, $fields, $conditions, null, null);
		$this->_setExecuteInfo();
		$result = isset($tmp[0]) ? $tmp : true;
		if (!isset($tmp[0]) && $this->_db->errno) {
			$this->_setError(Conf_Error::DB_EXECUTE_ERRNO);
			$result = false;
		}
		return $result;
	}
	
	public function getCaseRes($CaseId)
	{
		if (!is_object($this->_db)) {
			return false;
		}
		
		$fields = array('*');
		$conditions = array("CaseId = $CaseId");
		$tmp = $this->_db->select($this->_case_result_table, $fields, $conditions, null, null);
		$this->_setExecuteInfo();
		$result = isset($tmp[0]) ? $tmp : true;
		if (!isset($tmp[0]) && $this->_db->errno) {
			$this->_setError(Conf_Error::DB_EXECUTE_ERRNO);
			$result = false;
		}
		return $result;
	}

	public function getFromCaseId($CaseId)
	{
		if (!is_object($this->_db)) {
            return false;
        }

		$tmp = $this->_db->query("SELECT distinct(FromCaseId)  as FromCaseId FROM autocase_input_fromcase where CaseId = $CaseId");
		$this->_setExecuteInfo();
        $result = isset($tmp[0]) ? $tmp : true;
        if (!isset($tmp[0]) && $this->_db->errno) {
            $this->_setError(Conf_Error::DB_EXECUTE_ERRNO);
            $result = false;
        }
        return $result;
	}

	//case的输入参数依赖于它的上一个case的入参
	public function getInputFromCaseIn($CaseId)
	{
		if (!is_object($this->_db)) {
			return false;
		}

		$tmp = $this->_db_query("select a.Field, b.Value from autocase_input_fromcase as a, autocase_input_value as b where a.CaseId = $CaseId and a.FromCaseId = b.CaseId and a.FromField = b.Field");
		$this->_setExecuteInfo();
		$result = isset($tmp[0]) ? $tmp : true;
		if (!isset($tmp[0]) && $this->_db->errno) {
			$this->_setError(Conf_Error::DB_EXECUTE_ERRNO);
			$result = false;
		}
		return $result;
	}

	//case的输入参数依赖于它的上一个case的出参
	public function getInputFromCaseOut($CaseId)
	{
        if (!is_object($this->_db)) {
            return false;
        }
		
		$tmp = $this->_db_query("SELECT * FROM `autocase_input_fromcase`  where FromFieldIsInput = 0 and CaseId = $CaseId order by FromCaseId");
		$this->_setExecuteInfo();
		$result = isset($tmp[0]) ? $tmp : true;
		if (!isset($tmp[0]) && $this->_db->errno) {
			$this->_setError(Conf_Error::DB_EXECUTE_ERRNO);
			$result = false;
		}
		return $result;
	}
	
	public function getFromSign($CaseId)
	{
		if (!is_object($this->_db)) {
			return false;
		}
		
		$fields = array('*');
		$conditions = array("CaseId = $CaseId");
		$tmp = $this->_db->select($this->_input_from_sign_table, $fields, $conditions, null, null);
		$this->_setExecuteInfo();
		$result = isset($tmp[0]) ? $tmp : true;
		if (!isset($tmp[0]) && $this->_db->errno) {
			$this->_setError(Conf_Error::DB_EXECUTE_ERRNO);
			$result = false;
		}
		return $result;
	}
	
	public function getResFromCase($CaseId)
	{
		if (!is_object($this->_db)) {
			return false;
		}
		
		$fields = array('*');
		$conditions = array("CaseId = $CaseId");
		$tmp = $this->_db->select($this->_res_from_case_table, $fields, $conditions, null, null);
		$this->_setExecuteInfo();
		$result = isset($tmp[0]) ? $tmp : true;
		if (!isset($tmp[0]) && $this->_db->errno) {
			$this->_setError(Conf_Error::DB_EXECUTE_ERRNO);
			$result = false;
		}
		return $result;
	}

	public function getCaseDesByCaseId($CaseId)
	{
		if (!is_object($this->_db)) {
            return false;
        }

		$tmp = $this->_db->query("SELECT autocase.*, interface.* FROM autocase, interface where autocase.CaseId = $CaseId and autocase.InterfaceId = interface.InterfaceId");
		$this->_setExecuteInfo();
		$result = isset($tmp[0]) ? $tmp : true;	
		if (!isset($tmp[0]) && $this->_db->errno) {
			$this->_setError(Conf_Error::DB_EXECUTE_ERRNO);
			$result = false;
		}
		return $result;
	}

	public function InsertOrUpdateResVal($CaseId, $Field, $Value)
	{
		if (!is_object($this->_db)) {
			return false;
		}
		$tmp = $this->_db->query("SELECT * from response_validate where CaseId = $CaseId and Field = '$Field'");
		if($tmp == array())
		{
			$tmp = $this->_db->query("insert into response_validate(CaseId, Field, Type, Value) values ($CaseId, '$Field', 1, '$Value')");
		}
		else
		{
			$tmp = $this->_db->query("update response_validate set Value = '$Value' where CaseId = $CaseId and Field = '$Field'");
		}
        return $true;
	}

	public function InsertOrUpdateInput($CaseId, $Field, $Value)
	{
		if (!is_object($this->_db)) {
            return false;
        }
		$tmp = $this->_db->query("SELECT * from autocase_input_value where CaseId = $CaseId and Field = '$Field'");
		if($tmp == array())
		{
			$tmp = $this->_db->query("insert into autocase_input_value(CaseId, Field, Value) values ($CaseId, '$Field','$Value')");
		}
		else
		{
			$tmp = $this->_db->query("update autocase_input_value set Value = '$Value' where CaseId = $CaseId and Field = '$Field'");
		}
	}

	//找出FromFieldIsInput字段等于1的check点
	public function getResVal1FromCase($CaseId)
	{
		if (!is_object($this->_db)) {
            return false;
        }
		$tmp = $this->_db->query("SELECT a.CaseId, a.Field, b.Value FROM  response_validate_fromcase as a,  autocase_input_value as b where a.FromCaseId = b.CaseId and a.FromField = b.Field and a.CaseId = $CaseId and a.FromFieldIsInput = 1");
		$result = isset($tmp[0]) ? $tmp : true;
		if (!isset($tmp[0]) && $this->_db->errno) {
            $this->_setError(Conf_Error::DB_EXECUTE_ERRNO);
            $result = false;
        }
        return $result;
	}

	//找出FromFieldIsInput字段等于0的check点
	public function getResVal0Fromcase($CaseId, $Field)
	{
		if (!is_object($this->_db)) {
            return false;
        }
		$tmp = $this->_db->query("SELECT a.Field as Field FROM  response_validate_fromcase as a where a.CaseId = $CaseId and a.FromField = '$Field' and a.FromFieldIsInput = 0");
		$result = isset($tmp[0]) ? $tmp : true;
        if (!isset($tmp[0]) && $this->_db->errno) {
            $this->_setError(Conf_Error::DB_EXECUTE_ERRNO);
            $result = false;
        }
        return $result;
	}
		
	
	public function getCasDesByInterfaceId($InterfaceId)
	{
		if (!is_object($this->_db)) {
			return false;
		}
		
		$fields = array('*');
		$conditions = array("InterfaceId = $InterfaceId");
		$tmp = $this->_db->select($this->_case_table, $fields, $conditions, null, null);
		$this->_setExecuteInfo();
		$result = isset($tmp[0]) ? $tmp : true;
		if (!isset($tmp[0]) && $this->_db->errno) {
			$this->_setError(Conf_Error::DB_EXECUTE_ERRNO);
			$result = false;
		}
		return $result;
	}
}
