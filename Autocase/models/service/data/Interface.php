<?php

/**
 * 接口数据库操作类
 *
 * @author wangcaixia@baidu.com
 * @date 2015-09-15
 * @package 路径
 * @version 1.0
 */
class Service_Data_Interface extends Service_Data_Db
{
    //数据库链接key
    private $_cluster = 'autotest';
    //接口表
    private $_interface_table = '`interface`';
    
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
    public function getList($product_id)
    {
        if (!is_object($this->_db)) {
            return false;
        }

        $fields = array('*');
        $conditions = array("`ProductId` = $product_id");
        //执行查询
        $tmp = $this->_db->select($this->_interface_table, $fields, $conditions, null, null);
        $this->_setExecuteInfo();
		 //数据库连接断了，重新连接 
        if($executeInfo['errno'] == 2006)
        {
            $this->_db = Bd_Db_ConnMgr::getConn($this->_cluster);
            $tmp = $this->_db->select($this->_interface_table, $fields, $conditions, null, null);
            $this->_setExecuteInfo();
        }
        $result = isset($tmp[0]) ? $tmp : true;
        if (!isset($tmp[0]) && $this->_db->errno) {
            $this->_setError(Conf_Error::DB_EXECUTE_ERRNO);
            $result = false;
        }

        return $result;
    }
    
    /**
     * 根据订单ID查询数据库信息
     *
     * @param $order_id 订单ID
     *
     * @return array | bool
     */
    public function insertInterface($params)
    {
        if (!is_object($this->_db)) {
            return false;
        }
				
		$InterfaceItem = array();
		$InterfaceItem['Url'] = $this->_db->escapeString($params['Url']);
		$InterfaceItem['Name'] = $this->_db->escapeString($params['Name']);
		$InterfaceItem['ProductId'] = $params['ProductId'];
        
		$success  = true;
		//插入新的接口
        $this->_db->insert($this->_interface_table, $InterfaceItem);
        $this->_setExecuteInfo();

        $executeInfo = $this->_db_execute_info;
		//数据库连接断了，重新连接 
		if($executeInfo['errno'] == 2006)
		{
			$this->_db = Bd_Db_ConnMgr::getConn($this->_cluster);
			$this->_db->insert($this->_interface_table, $InterfaceItem);
			$this->_setExecuteInfo();
		}
        foreach ($executeInfo as $k => $v){
            if($v['errno'] > 0) {
                $success = false;
                break;
            }
        }
        return $success;
    }
}
