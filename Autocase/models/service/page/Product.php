<?php

/**
 * 接口相关的业务model
 * @author wangcaixia@baidu.com
 * @date 2015-09-15
 * @package 路径
 * @version 1.0
 */
class Service_Page_Product extends Service_Page_Base
{
	/**
    * @param 
    * @return array|bool
    * @throws Exec_Exception
    */
	public function listProduct()
    {
		$service = new Service_Data_Product();
        $result = $service->getList();
	
        //记录执行信息
        $this->_execute_info = $service->getExecuteInfo();
        if ($result === false) {
			$error = $service->getError();
          	throw new Exec_Exception($error);
        } elseif ($result === true) {
        	$error = Conf_Error::$map[Conf_Error::PRODUCT_NOT_EXIST];
          	$error['code'] = Conf_Error::PRODUCT_NOT_EXIST;
          	$error['message'] = sprintf($error['message']);
          	throw new Exec_Exception($error);
        }
        unset($service);
		return $result;
    }
}
