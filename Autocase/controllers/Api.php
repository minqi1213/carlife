<?php
/**
 * 业务控制器基础类
 * 
 * @author wangdazhuo@baidu.com
 * @date 2015-06-16
 * @package 路径
 * @version 1.0
 */
class Controller_Api extends Ap_Controller_Abstract
{
	//GET参数请求
	protected $_query = null;
	//POST参数请求
	protected $_post = null;
	//passport 账户信息
	protected $_user = null;

	//初始化方法
	public function init(){
		//统一为json格式输出
		header('Content-type: application/json');
		//首先记录所有的请求参数,作为问题排查依据
		$query = $this->_request->getQuery();
		if (is_array($query) && count($query) > 0) {
			$this->_query = $query;
			Bd_Log::notice('Get Request Params', 0, $query);
		}
		$post = $this->_request->getPost();
		if (is_array($post) && count($post) > 0) {
			$this->_post = $post;
			Bd_Log::notice('Post Request Params', 0, $post);
		}
		//获取用户信息存储与类变量中
		$user = Saf_SmartMain::getUserInfo();
		if (is_array($user) && count($user) > 0) {
			$this->_user = $user;
		}
	}
	
	//权限检查
	public function checkAuth(){
		$is_product = Bd_Conf::getAppConf('env/isproduct');
		if(intval($is_product)) {
			if (is_array($this->_user)) {
				return $this->_user;
			} else {
				$code = Conf_Error::USER_AUTH_ILLEGAL_ERRNO;
				$error = Conf_Error::$map[$code];
				$error['code'] = $code;
				throw new Exec_Exception($error);
			}
		} else {
			$user = Bd_Passport::getUserInfoFromCookie();
			if(isset($user['uid'])) {
				return $user;
			} else {
				$code = Conf_Error::USER_AUTH_ILLEGAL_ERRNO;
				$error = Conf_Error::$map[$code];
				$error['code'] = $code;
				throw new Exec_Exception($error);
			}
		}
		
	}

    /**
     * 检查参数签名
     * @param $request 参数数组
     * @throws Exec_Exception
     */
    public function checkSignature($request) {
        $sign = $request['sign'];
        $code = null;
        if (!isset($sign)) {
            $code = 'sign';
        }
        $appCode = $request['appCode'];
        if (!isset($appCode)) {
            $code = 'appCode';
        }
        $timestamp = $request['timestamp'];
        if (!isset($timestamp)) {
            $code = 'timestamp';
        }
        if (isset($code)) {
            $errno = Conf_Error::PARAMETER_EMPTY_ERRNO;
            $error = Conf_Error::$map[$errno];
            $error['message'] = sprintf($error['message'], $code);
            throw new Exec_Exception($error);
        }
        $service = new Service_Page_Merchant();
        $merchant = $service->getMerchantInfo($appCode);
        if ($merchant === false) {
            // 查询商户信息失败;
            $errno = Conf_Error::SYSTER_ERRNO;
            $error = Conf_Error::$map[$errno];
            throw new Exec_Exception($error);
        }
        $copy = array();
        foreach($request as $k => $v) {
            if ($k !== 'sign' && $k !== 'signMethod') {
                $copy[$k] = $v;
            }
        }
        $key = $merchant['sign_key'];
        $mysign = Partner_Api::signParams($copy, $key);
        if ($mysign !== $sign) {
            $errno = Conf_Error::PARAMETER_SIGN_ERRNO;
            $error = Conf_Error::$map[$errno];
            throw new Exec_Exception($error);
        }
    }
}
?>