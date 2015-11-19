<?php
/**
 * 数据库操作抽样类
 *
 * @author wangdazhuo@baidu.com
 * @date   2015-06-16
 */
abstract class Service_Data_Db
{
	//数据库DB对象
	protected $_db = null;
	//数据库执行信息记录
	protected $_db_execute_info = array();
	//错误码
	private $_error = array('code' => 0, 'message' => 'unknow', 'leval' => 'unknow');

	//构造函数
	public function __construct($cluster) {
		$this->_db = Bd_Db_ConnMgr::getConn($cluster);
		if (!is_object($this->_db)) {
			$this->_setError(Conf_Error::DB_LINK_ERRNO, $cluster); 	
		}
	}

	/**
	 * 设置错误信息
	 * 
	 * @param int    $code 错误码
	 * @param string $str  错误信息替换字符
	 * 
	 * @return void
	 */
	protected function _setError($code, $str = null) {
		if (isset(Conf_Error::$map[$code])) {
			$error = Conf_Error::$map[$code];
			$error['code'] = $code;
			if ($str) {
				$error['message'] = sprintf($error['message'], $str);
			}
			$this->_error = $error;
		}
	}
	
	/**
	 * 获取错误信息
	 *
	 * @return array
	 */
	public function getError(){
		return $this->_error;
	}

	/**
	 * 设置数据库执行记录
	 *
	 * @return void
	 */
	protected function _setExecuteInfo(){
		$tmp = array('sql' => $this->_db->lastSQL, 'errno' => $this->_db->errno, 'error' => $this->_db->error);
		//var_dump($tmp);
		$this->_db_execute_info[] = $tmp;
	}

	/**
	 * 获取数据库执行记录
	 *
	 * @return array
	 */
	public function getExecuteInfo(){
		return $this->_db_execute_info;
	}

    /**
     * @param $orderid
     * @param $status
     * @return bool
     */
    public function record($orderid, $status) {
        if (!is_object($this->_db)) {
            return false;
        }

        $values = array(
            'order_id' => $orderid,
            'status' => $status,
            'content' => Conf_Constant::$order_map[$status],
            'client_ip' => CLIENT_IP,
            'create_time' => isset($_SERVER['REQUEST_START_TIME']) ? $_SERVER['REQUEST_START_TIME'] : (int)time()
        );

        $this->_db->insert('order_trace', $values);
        $this->_setExecuteInfo();
    }
}
?>
