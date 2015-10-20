<?php

/**
 * 产品线控制器
 * @author wangcaixia@baidu.com
 * @date 2015-09-15
 * @package 路径
 * @version 1.0
 */
class Controller_Product extends Controller_Api {
	/**
	 * 查询接口列表详情
	 */
	public function listAction() {
		try {
			$pageObj = new Service_Page_Product();
			$data = $pageObj->listProduct();
			
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
}
?>
