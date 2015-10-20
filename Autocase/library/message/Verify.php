<?php
/**
 * 用户手机号绑定
 *
 * @author zhaopengfei04@baidu.com
 * @date 2015-06-16
 * @package 路径
 * @version 1.0
 */
class Message_Verify {
	// 短信接口API
	const APPLY_API = '/api/v1/sendVerifyCode.json';
	const VERIFY_API = '/api/v1/checkVerifyCode.json';
	// 用户名
	const USERNAME = 'map-car@baidu.com';
	// 密码
	const PASSWORD = 'map-car!@#';
	// 业务code
	const BUSINESS_CODE = 'CarLive';
	// 配置文件
	const TEXT_CONF = '/verify';
	/**
	 * 请求短信平台发送验证码
	 *
	 * @param string $mobile
	 *        	用户信息
	 *        	
	 * @return array
	 */
	public static function apply($mobile) {
		$username = self::USERNAME;
		$password = self::PASSWORD;
		$businessCcode = self::BUSINESS_CODE;
		// post参数
		$body = json_encode ( array (
			'dest' => $mobile,
			'template' => 'carwash',
		) );
		// 签名
		$str = $businessCcode . $username . $password . $body;
		$signature = md5 ( $str );
		
		// RAL Header
		$header = array (
			'username' => $username,
			'busscode' => $businessCcode,
			'signature' => $signature,
			'Content-Type' => 'application/json',
		);
		
		// 服务名
		$service = 'verify';
		// 记录时间并发送请求
		$start = gettimeofday ();
		ral_set_pathinfo ( self::APPLY_API );
		$tmp = ral ( $service, 'post', $body, null, $header );
		$data = json_decode ( $tmp, true );
		
		$end = gettimeofday ();
		$cost = ($end ['sec'] - $start ['sec']) * 1000 + ($end ['usec'] - $start ['usec']) / 1000;
		// 增加日志
		$idc = ral_get_idc ();
		$log = array (
			'service' => $service,
			'idc' => $idc,
			'cost' => $cost, 
		);
		$success = isset ( $data ['result'] ) ? $data ['result'] : 0;
		$level = ($success == 1000) ? RAL_LOG_SUM_SUCC : RAL_LOG_SUM_FAIL;
		// 日志数据
		$log ['ral_err_no'] = ral_get_errno ();
		$log ['ral_err_msg'] = ral_get_error ();
		$log = array_merge ( $log, $input, $data );
		
		// 写日志
		ral_write_log ( $level, $service, $log );
		// 成功则返回接口数据
		return $success == 1000 ? $data : false;
	}
	
	/**
	 * 验证验证码正确与否
	 * verify
	 *
	 * @param string $mobile
	 *        	电话
	 * @param string $code
	 *        	验证码
	 *        	
	 * @return array
	 */
	public static function verify($code, $mobile) {
		$username = self::USERNAME;
		$password = self::PASSWORD;
		$businessCcode = self::BUSINESS_CODE;
		
		// post参数
		
		$body = json_encode ( array (
			'code' => $code,
			'dest' => $mobile,
			'checkType' => 'DestAndType', 
		) );
		// 签名
		$str = $businessCcode . $username . $password . $body;
		$signature = md5 ( $str );
		
		// RAL Header
		$header = array (
			'username' => $username,
			'busscode' => $businessCcode,
			'signature' => $signature,
			'Content-Type' => 'application/json', 
		);
		
		// 服务名
		$service = 'verify';
		// 记录时间并发送请求
		$start = gettimeofday ();
		ral_set_pathinfo ( self::VERIFY_API );
		$tmp = ral ( $service, 'post', $body, null, $header );
		
		$data = json_decode ( $tmp, true );
		
		$end = gettimeofday ();
		$cost = ($end ['sec'] - $start ['sec']) * 1000 + ($end ['usec'] - $start ['usec']) / 1000;
		// 增加日志
		$idc = ral_get_idc ();
		$log = array (
			'service' => $service,
			'idc' => $idc,
			'cost' => $cost, 
		);
		$success = isset ( $data ['result'] ) ? $data ['result'] : 0;
		$level = ($success == 1000) ? RAL_LOG_SUM_SUCC : RAL_LOG_SUM_FAIL;
		// 日志数据
		$log ['ral_err_no'] = ral_get_errno ();
		$log ['ral_err_msg'] = ral_get_error ();
		$log = array_merge ( $log, $input, $data );
		
		// 写日志
		ral_write_log ( $level, $service, $log );
		// 成功则返回接口数据
		return $success == 1000 ? $data : false;
	}
}
