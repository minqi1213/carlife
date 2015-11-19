<?php

/**
 * 接口数据库操作类
 *
 * @author wangcaixia@baidu.com
 * @date 2015-09-15
 * @package 路径
 * @version 1.0
 */
class Service_Data_Product extends Service_Data_Db
{
    //数据库链接key
    private $_cluster = 'autotest';
    //接口表
    private $_product_table = '`product`';
    
    //构造函数
    public function __construct()
    {
        parent::__construct($this->_cluster);
    }

    /**
     * 查询product表，将里面所有的产品名称找出来
     *
     * @param
     *
     * @return array | bool
     */
    public function getList()
    {
        if (!is_object($this->_db)) {
            return false;
        }

        $fields = array('*');
        $conditions = array();
        //执行查询
        $tmp = $this->_db->select($this->_product_table, $fields, $conditions, null, null);
        $this->_setExecuteInfo();
        //数据库连接断了，重新连接 
        if($executeInfo['errno'] == 2006)
        {
            $this->_db = Bd_Db_ConnMgr::getConn($this->_cluster);
            $tmp = $this->_db->select($this->_product_table, $fields, $conditions, null, null);
			$this->_setExecuteInfo();
        }
		$result = isset($tmp[0]) ? $tmp[0] : true;
        if (!isset($tmp[0]) && $this->_db->errno) {
            $this->_setError(Conf_Error::DB_EXECUTE_ERRNO);
            $result = false;
        }

        return $result;
    }
}
