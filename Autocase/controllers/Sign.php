<?php

//各种加密算法
class Controller_Sign extends Controller_Api {
	/**
	 * 查询接口列表详情
	 */
	public function walletAction() {
		$ret = false;
		$copy = array ();
		$params = $this->_post;
		foreach ( $params as $k => $v ) {
			if ($k == 'sign') {
				$sign = $v;
				continue;
			} 
			else if ($k == 'signType') {
				$signType = intval ( $v );
				continue;
			}
			$copy [$k] = $v;
		}           
		ksort ( $copy );
		$copy ['key'] = "a96cfe240a15911ce8ce4c916e34422d"; 
		//var_dump($copy);
		$signContent = urldecode ( http_build_query ( $copy ) ); 
		$sign = md5 ( $signContent );
		echo $sign;
	} 
}
?>
