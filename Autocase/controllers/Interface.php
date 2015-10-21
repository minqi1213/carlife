<?php

/**
 * 接口控制器
 * @author wangcaixia@baidu.com
 * @date 2015-09-15
 * @package 路径
 * @version 1.0
 */
class Controller_Interface extends Controller_Api {
	/**
	 * 查询接口列表详情
	 */
	public function listAction() {
		try {
			$params = Request_Interface::filterListParams ( $this->_query );
			$product_id = $params ['product_id'];
			$pageObj = new Service_Page_Interface();
			$data = $pageObj->listInterface($product_id);
				
			if (is_array ( $data )) {
				$result = array (
					'errno' => 0,
					'errstr' => 'ok',
					'data' => $data 
				);
			}
		} catch ( Exec_Exception $e ) {
			$code = $e->getCode ();
			$message = $e->getMessage ();
			$result = array (
					'errno' => $code,
					'errstr' => $message,
					'data' => null 
			);
		}
		exit ( json_encode ( $result ) );
	}

	/**
	 * 新增接口
	 */
	public function addAction() {
		try {
			$params =  Request_Interface::filterAddParams ( $this->_post );
			$pageObj = new Service_Page_Interface();
			$data = $pageObj->addInterface($params);
			
			$result = array(
				'errno' => 0,
				'errstr' => 'ok',
				'data' => $data
			);
		} catch ( Exec_Exception $e ) {
			$code = $e->getCode();
			$message = $e->getMessage();
			$result = array(
				'errno' => $code,
				'errstr' => $message,
				'data' => null
			);
		}
		exit(json_encode($result));
	}
}
?>
