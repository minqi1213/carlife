<?php
/**
 * 自定义参数检查异常类
 *
 * @author wangcaixia
 * @date   2015-09-15
 * @version 1.0
 * @package 路径
 */
class Request_Case
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
	public static function filterAddParams($params) {
		$check = array('RequestType', 'CaseDes', 'InterfaceId', 'CreateBy');
		$result = array();
		foreach ($check as $v) {
			$errno = 0;
			switch($v) {
				case 'RequestType':
					//0表示get请求,1表示post请求
					var_dump($params[$v] == 0);
					if (!isset($params[$v]) || $params[$v] == "") {
						$errno = Conf_Error::PARAMETER_EMPTY_ERRNO;
					} elseif (! (intval($params[$v]) == 0 || intval($params[$v]) == 1 ) ) {
						$errno = Conf_Error::PARAMETER_ILLEGAL_ERRNO;
					}
					break;
				case 'CaseDes':
					if (!isset($params[$v]) || empty($params[$v])) {
						$errno = Conf_Error::PARAMETER_EMPTY_ERRNO;
					}
					break;
				case 'InterfaceId':
					if (!isset($params[$v]) || empty($params[$v])) {
						$errno = Conf_Error::PARAMETER_EMPTY_ERRNO;
					} elseif (intval($params[$v]) < 0) {
						$errno = Conf_Error::PARAMETER_ILLEGAL_ERRNO;
					}
					break;
				case 'CreateBy':
					if (!isset($params[$v]) || empty($params[$v])) {
						$errno = Conf_Error::PARAMETER_EMPTY_ERRNO;
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
	
	public static function filterAddInputValueParams($params) {
		$check = array('CaseId', 'Field', 'Value');
		$result = array();
		foreach ($check as $v) {
			$errno = 0;
			switch($v) {
				case 'CaesId':
					if (!isset($params[$v]) || empty($params[$v])) {
						$errno = Conf_Error::PARAMETER_EMPTY_ERRNO;
					} else if (intval($params[$v]) < 0) {
						$errno = Conf_Error::PARAMETER_ILLEGAL_ERRNO;
					}
				case 'Field':
				case 'Value':
					if (!isset($params[$v]) || empty($params[$v])) {
						$errno = Conf_Error::PARAMETER_EMPTY_ERRNO;
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
	
	public static function filterAddInputFromCaseParams($params) {
		$check = array("CaseId", "Field", "FromCaseId", "FromField", "FromFieldIsInput");
		$result = array();
		foreach ($check as $v) {
			$errno = 0;
			switch($v) {
				case "CaesId":
				case "FromCaseId":
					if (!isset($params[$v]) || empty($params[$v])) {
						$errno = Conf_Error::PARAMETER_EMPTY_ERRNO;
					} else if (intval($params[$v]) < 0) {
						$errno = Conf_Error::PARAMETER_ILLEGAL_ERRNO;
					}
					break;
				case "Field":
				case "FromField":
					if (!isset($params[$v]) || empty($params[$v])) {
						$errno = Conf_Error::PARAMETER_EMPTY_ERRNO;
					}
					break;
				case "FromFieldIsInput":
					var_dump( $params[$v] == "1");
					if (!isset($params[$v]) || !($params[$v] == "0" || $params[$v] == "1")) {
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
	
	public static function filterAddResValueParams($params) {
		$check = array('CaseId', 'Field', 'Type', 'Value');
		$result = array();
		foreach ($check as $v) {
			$errno = 0;
			switch($v) {
				case 'CaesId':
				case 'Type':
					if (!isset($params[$v]) || $params[$v] == "") {
						$errno = Conf_Error::PARAMETER_EMPTY_ERRNO;
					} else if (intval($params[$v]) < 0) {
						$errno = Conf_Error::PARAMETER_ILLEGAL_ERRNO;
					}
				case 'Field':
					if (!isset($params[$v]) || $params[$v] == "") {
						$errno = Conf_Error::PARAMETER_EMPTY_ERRNO;
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

