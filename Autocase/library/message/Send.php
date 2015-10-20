<?php
/**
 * 利用短信平台发送短信
 * @author zhaopengfei04@baidu.com
 * @date 2015-07-27
 * @package 路径
 * @version 1.0
 */
class Message_Send {
	// 短信接口API
	const API = '/service/sendSms.json';
	// 用户名
	const USERNAME = 'map-car@baidu.com';
	// 密码
	const PASSWORD = 'map-car!@#';
	// 业务code
	const BUSINESS_CODE = 'CarLive';
	// 配置文件
	const TEXT_CONF = '/sms';
	
	/**
	 * 发送短信
	 *
	 * @param int $mobile
	 *        	手机号
	 *        	
	 * @param string $content
	 *        	发送内容
	 *        	
	 * @return boolean
	 */
	public static function send($mobile, $content) {
		$username = self::USERNAME;
		$password = self::PASSWORD;
		$businessCcode = self::BUSINESS_CODE;
		// 签名
		$str = $username . $password . $mobile . $content . $businessCcode;
		$signature = md5 ( $str );
		// RAl POST数据
		$input = array (
			'username' => $username,
			'businessCode' => $businessCcode,
			'signature' => $signature, 
		);
		$input ['msgDest'] = $mobile;
		$input ['msgContent'] = $content;
		// 服务名
		$service = 'sms';
		// 记录时间并发送请求
		$start = gettimeofday ();
		ral_set_pathinfo ( self::API );
		$tmp = ral ( $service, 'post', $input, rand () );
		
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
		return $success == 1000 ? true : false;
	}
}
