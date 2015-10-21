<?php
/**
 * 自定义参数检查异常类
 *
 * @author wangcaixia
 * @date   2015-09-15
 * @version 1.0
 * @package 路径
 */
class Request_Interface
{
    /**
     * 检查接口列表参数
     *
     * @param array $params 参数信息
     *
     * @return array 过滤后的参数信息
     *
     * @throws Exec_Exception
     */
	public static function filterListParams($params) {
		$check = array('product_id');
		$result = array();
		foreach ($check as $v) {
			$errno = 0;
			switch($v) {
				// 必须提供，而且正整数
				case 'product_id':
					if (!isset($params[$v]) || empty($params[$v])) {
						$errno = Conf_Error::PARAMETER_EMPTY_ERRNO;
					} elseif (intval($params[$v]) <= 0) {
						$errno = Conf_Error::PARAMETER_ILLEGAL_ERRNO;
					}
					break;
			}
			if ($errno) {
				$error = Conf_Error::$map[$errno];
				$error['code'] = $errno;
				$error['message'] = sprintf($error['message'], $v);
				throw new Exec_Exception($error);
			} else {
				$result[$v] = $params[$v];
			}
		}
		return $result;
	}
	
	public static function filterAddParams($params) {
		$check = array('Url', 'Name', 'ProductId');
		$result = array();
		foreach ($check as $v) {
			$errno = 0;
			switch($v) {
				case 'Url':
				case 'Name':
					if (!isset($params[$v]) || empty($params[$v])) {
						$errno = Conf_Error::PARAMETER_EMPTY_ERRNO;
					}
					break;
				case 'ProductId':
					if (!isset($params[$v]) || empty($params[$v])) {
						$errno = Conf_Error::PARAMETER_EMPTY_ERRNO;
					} elseif (intval($params[$v]) <= 0) {
						$errno = Conf_Error::PARAMETER_ILLEGAL_ERRNO;
					}
					break;
			}
			if ($errno) {
				$error = Conf_Error::$map[$errno];
				$error['code'] = $errno;
				$error['message'] = sprintf($error['message'], $v);
				throw new Exec_Exception($error);
			} else {
				$result[$v] = $params[$v];
			}
		}
		return $result;
	}
}
?>

