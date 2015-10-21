<?php
/**
 * 业务逻辑基础类
 * 
 * @author wangdazhuo@baidu.com
 * @date   2015-05-18
 */
abstract class Service_Page_Base
{
	//数据库执行记录
	protected $_execute_info = null;

	/**
	 * 获取执行信息
	 *
	 * @return array | null
	 */
	public function getExecuteInfo(){
/*		$info = $this->_execute_info;
		$result = null;
		if (is_array($info) && count($info) > 0) {
			$result = '';
			foreach($info as $k => $v) {
				$tmp = 'num:'.$k.'@sql:'.$v['sql'].'@errno:'.$v['errno'].'@error:'.$v['error'];
				$result .= $tmp;
			}
		}
		return $result;*/
	}
}
?>
