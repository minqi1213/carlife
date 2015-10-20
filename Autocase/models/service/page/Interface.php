<?php

/**
 * 接口相关的业务model
 * @author wangcaixia@baidu.com
 * @date 2015-09-15
 * @package 路径
 * @version 1.0
 */
class Service_Page_Interface extends Service_Page_Base
{
    /**
     * @param $order_id
     * @param $pid
     * @return array|bool
     * @throws Exec_Exception
     */
    
    public function listInterface($product_id)
    {	
		$service = new Service_Data_Interface();
        $result = $service->getList($product_id);
	
        //记录执行信息
        $this->_execute_info = $service->getExecuteInfo();
        if ($result === false) {
			$error = $service->getError();
          	throw new Exec_Exception($error);
        } elseif ($result === true) {
			$error = Conf_Error::$map[Conf_Error::INTERFACE_NOT_EXIST];
          	$error['code'] = Conf_Error::INTERFACE_NOT_EXIST;
          	$error['message'] = sprintf($error['message'], 'product_id');
          	throw new Exec_Exception($error);
        }
        unset($service);
        return $result;
    }
    
    public function addInterface($params)
    {	
		$service = new Service_Data_Interface();
        $result = $service->insertInterface($params);
	
        //记录执行信息
        $this->_execute_info = $service->getExecuteInfo();
        if (!$result) {
            $error = $service->getError();
            $db_execute = $service->getExecuteInfo();
            throw new Exec_Exception($error, array('db_execute' => $db_execute));
        }
        unset($service);
       var_dump($result);
		 return $result;
    }
}
