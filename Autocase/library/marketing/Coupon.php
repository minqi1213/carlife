<?php
/**
 * 运营平台优惠劵接口
 * @author yangliang02
 *
 */
class Marketing_Coupon {
	private static $SERVICE_NAME = 'marketing';
	// 业务线Id
	private static $BUSINESS_TYPE = 6;
	public static function request($qt, $params, $logid = null) {
		if (isset ( $logid )) {
			ral_set_logid ( $logid );
		}
		ral_set_pathinfo ( "/marketing?qt=$qt" );
		$arrResult = array ();
		$params ['business_type'] = self::$BUSINESS_TYPE;
		$params ['api_request'] = 1;
		$params ['sign'] = self::buildSign ( $params );
		$ret = ral ( self::$SERVICE_NAME, '', $params, '' );
		if (! $ret) {
			$arrResult = array ();
			$arrResult ['errorNo'] = ral_get_errno ();
			Bd_Log::fatal ( 'invoke marketing error' . ral_get_error (), $arrResult ['errno'], $params );
		} else {
			$arrResult = json_decode ( $ret, true );
			if ($arrResult ['errorNo'] != 0) {
				Bd_Log::fatal ( 'marketing error' . $arrResult ['errorMsg'], $arrResult ['errorNo'], $params );
			}
		}
		return $arrResult;
	}
	/**
	 *
	 * @param array $params
	 *        	int phone 手机号、int user_id两者必有其一
	 *        	int act_id Required 活动Id
	 *        	string apply_reason Optional 申请理由
	 *        	其它参数参见营销平台行业接口文档
	 * @param string $logid        	
	 * @return object(int errorNo,string errorMsg,data array( string code) )
	 */
	public static function applyActivity($params, $logid = null) {
		return self::request ( 'user_apply_activity', $params, $logid );
	}
	/**
	 *
	 * @param int $phone
	 *        	用户手机号
	 * @param int $userId
	 *        	与手机号必有其一
	 * @param int $actId
	 *        	Required 活动Id
	 * @param int $typeId
	 *        	Optional 红包ID，为空则发放活动下全部红包
	 * @param string $reason
	 *        	Optional 申请理由
	 * @param int $startstart
	 *        	Optional 使用开始时间(默认为配置时间，没配置起始时间，配置了有效时长，则默认为请求时间)
	 * @param int $end
	 *        	Optional 使用结束时间
	 * @param int $price
	 *        	实际金额，后台校验合法性，单位（元）
	 * @param string $extra
	 *        	业务线备注，给业务线具体业务逻辑扩展的字段。
	 * @param string $logid        	
	 * @return object(int errorNo,string errorMsg,int data 红包Id)
	 */
	public static function applyHongbao($phone, $userId, $actId, $src_code, $typeId = null, $reason = null, $start = null, $end = null, $price = null, $extra = null, $code_from = 0) {
		$params = array ();
		if (isset ( $typeId )) {
			$params ['hongbao_type_id'] = $typeId;
		}
		return self::request ( 'user_apply_hongbao', array (
			'phone' => $phone,
			'user_id' => $userId,
			'act_id' => $actId,
			'src_code' => $src_code,
			'hongbao_type_id' => $typeId,
			'apply_reason' => $reason,
			'start_time' => $start,
			'end_time' => $end,
			'price' => $price,
			'indus_ext' => $extra,
		    'code_from' => $code_from, 
		) );
	}
	/**
	 * 使用红包
	 *
	 * @param string $orderId
	 *        	用户订单号
	 * @param int $phone
	 *        	用户手机号
	 * @param int $userId
	 *        	与手机号必有其一
	 * @param string $user_hongbao_ids
	 *        	红包Id列表，逗号分隔
	 * @param int $orderQuantity
	 *        	订单流水（分）
	 * @param string $orderExt
	 *        	订单扩展信息，json
	 * @param string $logid        	
	 * @return object(int errorNo,string errorMsg,int result 0 成功;1失败)
	 */
	public static function useHongbao($orderId, $phone, $userId, $user_hongbao_ids, $orderQuantity, $orderExt = null, $logid = null) {
		return self::request ( 'order_use_hongbao', array (
			'order_id' => $orderId,
			'phone' => $phone,
			'user_id' => $userId,
			'user_hongbao_ids' => $user_hongbao_ids,
			'order_quantity' => $orderQuantity,
			'order_ext_info' => $orderExt 
		), $logid );
	}
	/**
	 * 撤销使用接口
	 *
	 * @param string $orderId
	 *        	订单Id
	 * @param string $logid        	
	 * @return array(int errorNo,string errorMsg,int data 0 成功;1失败)
	 *         1是成功？
	 */
	public static function cancel($orderId, $logid = null) {
		return self::request ( 'order_cancel_hongbao', array (
			'order_id' => $orderId 
		), $logid );
	}
	/**
	 * 订单使用红包详情
	 *
	 * @param string $orderId
	 *        	订单号
	 * @return object(int errorNo,string errorMsg,Array data)
	 *         红包详情字段
	 *         --user_hongbao_id 用户红包id
	 *         --hongbao_name 红包名称
	 *         --hongba_value 红包面值
	 *         --cash_back_button_show 红包是否可领取返现 0/1
	 *         --cash_back_start_time 红包申请返现开始时间
	 *         --cash_back_end_time 红包申请返现结束时间
	 *        
	 */
	public static function orderDetail($orderId) {
		return self::request ( 'order_hongbao_detail', array (
			'order_id' => $orderId 
		) );
	}
	/**
	 * 用户红包列表
	 *
	 * @param int $phone
	 *        	用户手机号
	 * @param int $user_id
	 *        	与手机号必有其一
	 * @param int $status
	 *        	0全部，1未使用（未过期），2未使用（全部），3已使用，4已返现，5已过期
	 * @return 字段名 result 使用结果 0 使用成功 1 使用失败
	 *         --data used_hongbao/ unuse_hongbao (data数组有2个元素，已使用红包和未使用红包)
	 *         ----id 用户红包id
	 *         ----hongbao_type_id 红包类型id
	 *         ----business_type 红包使用范围 0，全部，1酒店,2 租车，3 拼车 4团购，5外卖
	 *         ----is_overlying 红包是否可叠加使用 0/1
	 *         ----once_usered_amout 该类型红包单次可使用数量 1/n
	 *         ----hongbao_status 红包当前使用状态 0 未使用 1 已使用 2 已申请返现 3 已过期
	 *         ----use_time 使用时间(如果红包状态为已使用)
	 *         ----use_start_time 使用开始时间
	 *         ----use_end_time 使用结束时间
	 *         ----hongbao_value 红包面值 20
	 *         ----hongbao_name 红包名称
	 *         ----activity_id 红包所属活动id 1
	 *         ----indus_ext_info 业务线备注
	 *         errorNo 请求状态码 0： 请求成功
	 *         1： 校验参数失败
	 *         errorMsg 错误提示信息
	 *        
	 */
	public static function userList($phone, $user_id, $status = 0) {
		return self::request ( 'user_hongbao_list', array (
			'phone' => $phone,
			'user_id' => $user_id,
			'hongbao_available' => $status 
		) );
	}
	
	/**
	 * 
	 * 查询用户红包列表
	 * @param string $phone 用户手机号
	 * @param string $src_code 来源code，仅对分享红包有效，非分享红包请传null
	 * @param int $act_id 活动id
	 * @param string $type_id 红包id
	 * @return array
	 */
	public static function userCouponCount($phone, $src_code, $act_id, $type_id) {
	    $params = array('phone' => $phone, 'src_code' => $src_code, 'active_type_id' => $act_id, "hongbao_type_id" => $type_id);
	    return self::request ( 'hongbao_list_count', $params);
	}
	
	/**
	 *
	 * @param int $couponId
	 *        	优惠劵ID
	 * @return Ambigous <multitype:, mixed, multitype:NULL >
	 */
	public static function detail($couponId) {
		return self::request ( 'hongbao_detail', array (
			'hongbao_id' => $couponId 
		) );
	}
	
	/**
	 * 
	 * 通过order_id创建src_code
	 * @param int $order_id 订单id 
	 * @return array
	 */
	public static function buildShareSrcCode($order_id) {
	    $src_code = "share_$order_id";
	    return $src_code;
	}

	/**
	 * 
	 * 通过act_id和type_id获取src_code
	 * @param int $act_id
	 * @param string $type_id
	 * @return string src_code
	 */
	public static function buildMarketSrcCode($act_id, $type_id) {
	    $src_code = "market_$act_id_$type_id";
	    return $src_code;
	}
	
	/**
	 * 创建红包参数签名
	 * 
	 * @param $act_id 活动id        	
	 * @param $typeId 红包类型        	
	 * @return string 参数签名
	 */
	public static function buildHongBaoSig($act_id, $typeId, $src_code) {
		$authKey = Bd_Conf::getAppConf ( 'coupon/authkey' );
		$sig = base64_encode ( md5 ( $act_id . $typeId . $src_code . $authKey ) );
		return $sig;
	}
	
	/**
	 * 创建分享链接
	 * 
	 * @param string $phone
	 *        	分享用户的手机号
	 * @param string $act_id
	 *        	活动id
	 * @param string $typeId
	 *        	订单类型
	 * @param string $src_code
	 *        	来源
	 * @return string 分享链接
	 */
	public static function buildHongBaoShareLink($act_id, $typeId, $src_code) {
	    $path = "/car/couponfe/jump";
	    $sig = self::buildHongBaoSig ( $act_id, $typeId, $src_code );
	    $param = "?act_id=$act_id&type_id=$typeId&src_code=$src_code&sig=$sig";
	    return "http://oil.baidu.com" . $path . $param;
	}
	
	/**
	 * 检测领券资格
	 * 
	 * @param $act_id 活动的id        	
	 * @param $type 红包类型        	
	 * @param $signature 传入的签名值        	
	 */
	public static function checkHongBaoQuali($act_id, $type, $src_code, $signature) {
		$authKey = Bd_Conf::getAppConf ( 'coupon/authkey' );
		$param = base64_encode ( md5 ( $act_id . $type . $src_code . $authKey ) );
		if ($param != $signature) {
			return false;
		}
		return true;
	}
	
	/**
	 * 参数签名
	 *
	 * @param array $params        	
	 * @return string 签名字符串
	 */
	private static function buildSign($params) {
		$authKey = Bd_Conf::getAppConf ( 'coupon/authkey' );
		ksort ( $params );
		$strInput = '';
		foreach ( $params as $key => $value ) {
			$value = mb_convert_encoding ( $value, "GBK", 'auto' );
			if ($key != 'sign' && $key != 'log_id') {
				$strInput .= $value;
			}
		}
		$strInput .= $authKey;
		return md5 ( $strInput );
	}
}
