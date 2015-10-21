<?php

/**
 * 用例控制器
 * @author wangcaixia@baidu.com
 * @date 2015-09-15
 * @package 路径
 * @version 1.0
 */
class Controller_Case extends Controller_Api {
	/**
	 * 查询接口列表详情
	 */
	public function addAction() {
		try {
			$params = Request_Case::filterAddParams($this->_post);
			$pageObj = new Service_Page_Case();
			$data = $pageObj->addCase($params);
			
			$result = array (
				'errno' => 0,
				'errstr' => 'ok',
				'data' => $data
			);	
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

	public function addinputvalueAction() {
		try{
			$params =  Request_Case::filterAddInputValueParams($this->_post);
			$pageObj = new Service_Page_Case();
			$data = $pageObj->addCaseInputValue($params);
		
			$result = array (
				'errno' => 0,
				'errstr' => 'ok',
				'data' => $data
			);			
		} catch ( Exec_Exception $e ) {
			$code = $e->getCode ();
			$message = $e->getMessage ();
			
			$result  = array(
				'errno' => $code,
				'errstr' => $message,
				'data' => null
			);
		}
		exit( json_encode ($result) );	
	}
	
	public function addInputFromCaseAction() {
		try{
			$params =  Request_Case::filterAddInputFromCaseParams($this->_post);
			$pageObj = new Service_Page_Case();
			$data = $pageObj->addInputFromCase($params);
		
			$result = array (
				'errno' => 0,
				'errstr' => 'ok',
				'data' => $data
			);			
		} catch ( Exec_Exception $e ) {
			$code = $e->getCode ();
			$message = $e->getMessage ();
			
			$result  = array(
				'errno' => $code,
				'errstr' => $message,
				'data' => null
			);
		}
		exit( json_encode ($result) );	
	}

	public function addresvalAction() {
		try{
			$params = Request_Case::filterAddResValueParams($this->_post);
			$pageObj = new Service_Page_Case();
			$data = $pageObj->addCaseResValue($params);
			
			$result = array(
				'errno' => 0,
				'errstr' => 'ok',
				'data' => $data
			);
		} catch ( Exec_Exception $e ) {
			$code = $e->getCode ();
			$message = $e->getMessage ();

			$result = array(
				'errno' => $code,
				'errstr' => $message,
				'data' => null
			);
		}
		exit( json_encode ($result) );				
	}
	
	public function addResFromCaseAction() {
		try{
			$params =  Request_Case::filterAddInputFromCaseParams($this->_post);
			$pageObj = new Service_Page_Case();
			$data = $pageObj->addResFromCase($params);
		
			$result = array (
				'errno' => 0,
				'errstr' => 'ok',
				'data' => $data
			);			
		} catch ( Exec_Exception $e ) {
			$code = $e->getCode ();
			$message = $e->getMessage ();
			
			$result  = array(
				'errno' => $code,
				'errstr' => $message,
				'data' => null
			);
		}
		exit( json_encode ($result) );	
	}

	public function runCaseAction() {
		try{
			var_dump($this->_query);
			$pageObj = new Service_Page_Case();
			$data = $pageObj->runCase($this->_query);
		
			$result = array(
				'errno' => 0,
				'errstr' => 'ok',
				'data' => $data
			);
		} catch ( Exec_Exception $e ) {
			$code = $e->getCode ();
			$message = $e->getMessage ();

			$result = array(
				'errno' => $code,
				'errstr' => $message,
				'data' => null
			);
		}
		exit( json_encode ($result) );
	} 
}
?>
