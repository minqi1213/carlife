<?php

/**
 * Created by PhpStorm.
 * User: ligang02
 * Date: 2015/6/29
 * Time: 21:25
 */

class Business_Order {
    /**
     * 加油业务，准备油枪和油站信息
     *
     * @param array $params 参数信息
     *
     * @return array 订单中的油枪和油站信息
     *
     * @throws Exec_Exception
     */
    public static function prepareStationAndGun($params) {
        $oil_station_id_param = intval($params['oil_station_id']);
        $oil_gun_id_param = intval($params['oil_gun_id']);

        // 返回结果集合
        $orderItem = array();

        // 通过oil_station_id补充订单中的station的相关字段：oil_station_name
        $stationService = new Service_Data_Station();
        $result = $stationService->getByStationId($oil_station_id_param);
        if (!$result) {
            $error = $stationService->getError();
            //记录数据库执行信息
            $db_execute = $stationService->getExecuteInfo();
            throw new Exec_Exception($error, array('db_execute' => $db_execute));
        }

        if (is_array($result)) {
            $orderItem['oil_station_name'] = $result['name'];
            $orderItem['oil_station_id'] = $oil_station_id_param;
        } else {
            $errno = Conf_Error::PARAMETER_ILLEGAL_ERRNO;
            $error = Conf_Error::$map[Conf_Error::PARAMETER_ILLEGAL_ERRNO];
            $error['code'] = $errno;
            $error['message'] = sprintf($error['message'], 'oil_station_id');
            throw new Exec_Exception($error);
        }
        unset($stationService);
        unset($result);


        // 通过oil_gun补充订单中的oil_gun的相关字段：oil_no, unit_amount
        $gunService = new Service_Data_Gun();
        $result = $gunService->getGun($oil_station_id_param, $oil_gun_id_param);
        if (!$result) {
            $error = $gunService->getError();
            //记录数据库执行信息
            $db_execute = $gunService->getExecuteInfo();
            throw new Exec_Exception($error, array('db_execute' => $db_execute));
        }

        if (is_array($result)) {
            $orderItem['oil_no'] = $result['oil_no'];
            $orderItem['gun_no'] = $result['gun_no'];
            $orderItem['gun_machine'] = $result['gun_machine'];
            $orderItem['unit_amount'] = $result['price'];
            $orderItem['oil_gun_id'] = $oil_gun_id_param;
        } else {
            $errno = Conf_Error::PARAMETER_ILLEGAL_ERRNO;
            $error = Conf_Error::$map[Conf_Error::PARAMETER_ILLEGAL_ERRNO];
            $error['code'] = $errno;
            $error['message'] = sprintf($error['message'], 'oil_gun_id');
            throw new Exec_Exception($error);
        }
        unset($gunService);
        unset($result);
        return $orderItem;
    }

    /**
     * 加油业务，准备用户信息
     *
     * @param int $pid 用户id
     *
     * @param array $params 参数信息
     *
     * @return array 订单中的用户信息
     *
     * @throws Exec_Exception
     */
    public static function prepareAccount($pid, $params) {
        // 返回结果集合
        $orderItem = array();
        //获取用户信息
        $accountService = new Service_Data_Account();
        $result = $accountService->get($pid);
        if (!$result) {
            $error = $accountService->getError();
            //记录数据库执行信息
            $db_execute = $accountService->getExecuteInfo();
            throw new Exec_Exception($error, array('db_execute' => $db_execute));
        }

        if (!is_array($result)) { // 如果不存在，为了能够下单成功，需要创建该用户  
            $account = array('pid' => $pid, 'mobile' => $params['mobile'], 'car_no' => $params['car_no']);
            $result = $accountService->add($account);
            if (!$result) {
                $error = $accountService->getError();
                //记录数据库执行信息
                $db_execute = $accountService->getExecuteInfo();
                throw new Exec_Exception($error, array('db_execute' => $db_execute));
            }
        } else { //如果存在，更新用户信息数据 
            if ($result['car_no'] != $params['car_no'] || $result['mobile'] != $params['mobile'] ) { //车牌信息或者手机号或者发票不一致，更新数据库
                $account = array('mobile' => $params['mobile'], 'car_no' => $params['car_no']);
                $accountService->update($pid, $account);
                if (!$result) {
                    $error = $accountService->getError();
                    //记录数据库执行信息
                    $db_execute = $accountService->getExecuteInfo();
                    throw new Exec_Exception($error, array('db_execute' => $db_execute));
                }
            }
        }

        $orderItem['pid'] = $pid;
        $orderItem['mobile'] = $params['mobile'];
        $orderItem ['car_no'] = empty ( $params ['car_no'] ) ? '' : $params ['car_no'];
        return $orderItem;
    }

    /**
     * 加油业务，准备订单金额，负责校验优惠券信息，检验金额是否正确
     *
     * @param int $pid 用户id
     *
     * @param array $params 参数信息
     *
     * @return array 订单中的金额信息
     *
     * @throws Exec_Exception
     */
    public static function preparePrice($pid, $params) {
        // 返回结果集合
        $orderItem = array();

        $total_amount_param = intval($params['total_amount']);
        $orderItem['total_amount'] = $total_amount_param;
        $pay_amount_param = intval($params['pay_amount']);
        $orderItem['pay_amount'] = $pay_amount_param;

        if(isset($params['coupon_no'])) { // 客户端提交参数里面提供Coupon信息

            if (!isset($params['coupon_amount'])) {
                Business_Order::throwException(Conf_Error::PARAMETER_EMPTY_ERRNO, 'coupon_amount');
            }

            if (!isset($params['coupon_type'])) {
                Business_Order::throwException(Conf_Error::PARAMETER_EMPTY_ERRNO, 'coupon_type');
            }

            $coupon_no_param = intval($params['coupon_no']);
            $orderItem['coupon_no'] = $coupon_no_param;
            $coupon_amount_param = intval($params['coupon_amount']);
            $orderItem['coupon_amount'] = $coupon_amount_param;
            $coupon_type_param = intval($params['coupon_type']);
            $orderItem['coupon_type'] = $coupon_type_param;

            $couponService = new Service_Page_Coupon();
            $result = $couponService->couponDetail($coupon_no_param);

            if (is_array($result)) { // 找到了对应的coupon
                // coupon是否已经使用过
                if(Conf_Constant::COUPON_STATUS_UNUSED != $result['status']) {
                    Business_Order::throwException(Conf_Error::PARAMETER_ILLEGAL_ERRNO, 'coupon_no', 'coupon is already used');
                }

                // coupon是否过期
                $currentTime = time();
                $expirationTime = $result['expiration_time'];
                if($currentTime > $expirationTime) {
                    Business_Order::throwException(Conf_Error::PARAMETER_ILLEGAL_ERRNO, 'coupon_no', 'coupon is already expired');
                }

                // 客户端提交的coupon信息和数据库中的数据是否一致
                if( $coupon_amount_param != $result['amount']
                    || $coupon_type_param != $result['type']) {
                    Business_Order::throwException(Conf_Error::PARAMETER_ILLEGAL_ERRNO, 'coupon_no', 'coupon info is not correct');
                } else {
                    // coupon类型是否是满减
                    if (Conf_Constant::COUPON_TYPE_CUT_ON_CONDITION == $result['type']) {
                        $couponMinCharge = $result['min_charge'];
                        // coupon要求的满减金额是否符合要求
                        if($total_amount_param < $couponMinCharge) {
                            Business_Order::throwException(Conf_Error::PARAMETER_ILLEGAL_ERRNO, 'total_amount', 'coupon minimum price is not satisfied');
                        }

                        // 订单金额是否计算正确
                        if ( ($coupon_amount_param + $pay_amount_param) != $total_amount_param) {
                            Business_Order::throwException(Conf_Error::PARAMETER_ILLEGAL_ERRNO, 'total_amount, pay_amount, coupon_amount', 'price calculation is not correct');
                        }
                    } else { // 非法的coupon类型
                        Business_Order::throwException(Conf_Error::PARAMETER_ILLEGAL_ERRNO, 'coupon_type');
                    }
                }

            } else { // 未能找到对应的coupon
                Business_Order::throwException(Conf_Error::PARAMETER_ILLEGAL_ERRNO, 'coupon_no', 'coupon not found');
            }
        } else { // 客户端提交参数里面没有提供coupon_no信息
            if (isset($params['coupon_amount'])) {
                Business_Order::throwException(Conf_Error::PARAMETER_ILLEGAL_ERRNO, 'coupon_amount', 'coupon_no not found');
            }

            if (isset($params['coupon_type'])) {
                Business_Order::throwException(Conf_Error::PARAMETER_ILLEGAL_ERRNO, 'coupon_type', 'coupon_no not found');
            }

            // 订单金额是否计算正确
            if($total_amount_param != $pay_amount_param) {
                Business_Order::throwException(Conf_Error::PARAMETER_ILLEGAL_ERRNO, 'total_amount, pay_amount', 'price calculation is not correct');
            }
        }

        return $orderItem;
    }

    /**
     * 抛异常
     *
     * @param int $errno
     *
     * @param string $errstr
     *
     * @param string $extrastr
     *
     * @throws Exec_Exception
     */
    public static function throwException($errno, $errstr, $extrastr = '')
    {
        $error = Conf_Error::$map[$errno];
        $error['code'] = $errno;
        $error['message'] = sprintf($error['message'], $errstr) . '==' . $extrastr;
        throw new Exec_Exception($error);
    }

    /**
     * 加油业务，生成订单号，生成规则：10位microtime()sec + 4位userid + 4位microtime()msec
     *
     * @param int $userId 用户id
     *
     * @return int 订单号
     *
     * @throws Exec_Exception
     */
    public static function generateOrderNum($userId)
    {
        return self::_generateOrderId($userId);
    }

    /**
     * 加油业务，生成钱包要求的签名后的支付信息
     *
     * @param array $orderItem 原始订单信息
     *
     * @return array 经过签名的订单信息
     *
     * @throws exception
     */
    public static function signOrderInfo($orderItem)
    {
        $notifyUrl = Bd_Conf::getAppConf('env/payurl');
        return self::_signOrderInfo(
            $notifyUrl,
            $orderItem['order_id'],
            $orderItem['create_time'],
            $orderItem['pay_amount'],
            $orderItem['total_amount'],
            $orderItem['pid'],
            $orderItem['oil_station_name'],
            "mapapp", // 来源，取值见附录tn来源（地图：mapapp），OPTION ，限制只用钱包：act_qianbao_only
            $orderItem['mobile'],
            $orderItem['unit_amount'],
            $orderItem['oil_no']
        );
    }

    /**
     * 加油业务，请求钱包退款接口
     *
     * @param array $orderInfo
     *
     * @return array
     *
     * @throws exception
     */
    public static function innerRefund($orderInfo)
    {
        $port = Bd_Conf::getAppConf("env/port");
        $port = empty($port) ? "" : ":$port";
        $host = Bd_Conf::getAppConf("env/host");
        $notifyUrl = "http://" . $host . $port . "/car/wallet/refund";
        return self::_refund($notifyUrl, $orderInfo);
    }

    /**
     * 通用业务，生成订单号，生成规则：10位microtime()sec + 2位业务号 + 4位userid + 4位microtime()msec
     *
     * @param int $userId 用户id
     *
     * @param string $businessType 业务类型
     *
     * @return int 订单号
     *
     * @throws Exec_Exception
     */
    public static function commGenerateOrderId($userId, $businessType)
    {
        return self::_generateOrderId($userId, $businessType);
    }

    /**
     * 通用业务，生成钱包要求的签名后的支付信息
     *
     * @param array $orderItem 原始订单信息
     *
     * @return array $result 经过签名的订单信息
     *
     * @throws exception
     */
    public static function commSignOrderInfo($orderItem)
    {
        $notifyUrl = Bd_Conf::getAppConf('commwallet/paynotify');
        return self::_signOrderInfo(
            $notifyUrl,
            $orderItem['order_id'],
            $orderItem['create_time'],
            $orderItem['pay_amount'],
            $orderItem['total_amount'],
            $orderItem['pid'],
            $orderItem['order_title'],
            "mapapp", // 来源，取值见附录tn来源（地图：mapapp），OPTION ，限制只用钱包：act_qianbao_only
            $orderItem['mobile'],
            $orderItem['pay_amount'],
            $orderItem['product_name']
        );
    }

    /**
     * 通用业务，请求钱包退款接口
     *
     * @param array $orderInfo
     *
     * @return array
     *
     * @throws exception
     */
    public static function commRefund($orderInfo)
    {
        $notifyUrl = Bd_Conf::getAppConf('commwallet/refundnotify');
        return self::_refund($notifyUrl, $orderInfo);
    }

    /**
     * 共用内部方法，生成业务订单号
     * 有$business_type时生成规则：10位microtime()sec + 2位业务号 + 4位userid + 4位microtime()msec
     * 无$business_type时生成规则：10位microtime()sec + 4位userid + 4位microtime()msec
     *
     * @param string $user_id
     *
     * @param string $business_type 业务号
     * 洗车业务号：02；
     * 保养业务号：03；
     *
     * @return int $order_id 订单号
     *
     * @throws Exec_Exception
     */
    private static function _generateOrderId($user_id, $business_type = null)
    {
        list($msec, $sec) = explode(" ", microtime());
        $order_id_sec = $sec;

        list($integer, $point) = explode(".", $msec);
        $order_id_msec = substr($point, 0, 4);

        $order_id_user_id = substr($user_id, -4, 4);

        // 保证订单号不存在，如果已经存在，异常返回
        if (isset($business_type) && !empty($business_type)) {
            $order_id = $order_id_sec . $business_type . $order_id_user_id . $order_id_msec;
            $service = new Service_Data_Commorder();
            $result = $service->getOrderInfoByOrderId($order_id);
        } else {
            $order_id = $order_id_sec . $order_id_user_id . $order_id_msec;
            $service = new Service_Data_Order();
            $result = $service->getDetailInfo($order_id);
        }
        if (!$result) {
            $error = $service->getError();
            $db_execute = $service->getExecuteInfo();
            throw new Exec_Exception($error, array('db_execute' => $db_execute));
        }

        if (is_array($result)) { // 订单号已经存在，返回系统异常错误
            $errno = Conf_Error::ORDER_ID_DUPLICATED;
            $error = Conf_Error::$map[$errno];
            $error['code'] = $errno;
            throw new Exec_Exception($error);
        }

        return $order_id;
    }

    /**
     * 共用内部方法，生成钱包要求的签名后的支付信息
     *
     * @param string $notifyUrl
     * @param string $orderId
     * @param string $createTime
     * @param string $payAmount
     * @param string $totalAmount
     * @param string $pid
     * @param string $orderTitle
     * @param string $tn 来源，取值见附录tn来源（地图：mapapp），OPTION ，限制只用钱包：act_qianbao_only
     * @param string $mobile
     * @param string $productPrice
     * @param string $productName
     *
     * @return array $result
     *
     * @throws exception
     */
    private static function _signOrderInfo(
        $notifyUrl,
        $orderId,
        $createTime,
        $payAmount,
        $totalAmount,
        $pid,
        $orderTitle,
        $tn,
        $mobile,
        $productPrice,
        $productName)
    {
        $customerId = Bd_Conf::getAppConf("payinfo/customer_id");
        $result = array(
            'customerId' => intval($customerId),  // 业务系统ID，整型值，由百度钱包分配给商户，MUST
            'service' => "cashier", // 服务定义，固定值：cashier，MUST
            'orderId' => $orderId, // 订单号，商户须保证订单号在商户系统内部唯一。只能为大小写英文字母或数字，最大长度为64个字符，MUST
            'orderCreateTime' => intval($createTime), // 应用方订单生成时间，格式为当前计算机的GMT时间，单位为秒，MUST
            'deviceType' => 1, // 终端类型，固定值：1，MUST
            'payAmount' => intval($payAmount), // 实际支付金额，以分为单位，正整数，MUST
            'originalAmount' => intval($totalAmount), // 原价，以分为单位，正整数，MUST
            'notifyUrl' => $notifyUrl, // 主动通知商户支付结果的URL，仅支持http和https的URL，MUST
            'passuid' => intval($pid), // 百度passuid，MUST
            'title' => $orderTitle, // 商品的名称，长度256个字符，MUST
            'tn' => $tn, // 来源，取值见附录tn来源（地图：mapapp），OPTION ，限制只用钱包：act_qianbao_only
            // 'url' => "", // 订单查看链接，url地址，OPTION
            'mobile' => intval($mobile), // 用户手机号，11位数字，MUST，mobile允许为空串
            'itemInfo' => array( // 商品信息，MUST
                array(
                    "id" => 1001001, // 商品ID
                    "number" => 1, // 数量
                    "price" => intval($productPrice), // 单价，单位为分
                    "subCategory" => 1001, // 种类
                   	"originalAmount" => $orderItem['total_amount'],//总价
                    "name" => $orderItem['oil_no'], // 商品名称
                ),
            ),
            // 'imei' => "", // 手机imei号，OPTION
            'sdk' => 1, // SDK支付，固定值：1，MUST
            // 'extData' => "", // 业务扩展字段，异步通知的时候会原样返回，OPTION
            // 'signType' => "MD5", // 摘要算法，取值列表:（1~2），1（默认值）：MD5，2：SHA-1，OPTION
            //'sign' => "ec8da05adf27c467ccab6b3c6dcada52", // 签名结果，取决于签名方法，MUST
        );

        // 请求参数都按照名称字符升序排列（参数名称不允许相同 ）
        ksort($result);

        $result['key'] = Bd_Conf::getAppConf("payinfo/sign_key");

        $signContentArray = array();
        foreach ($result as $key => $value) {
            if ('itemInfo' == $key) {
                $item_info = json_encode($value, JSON_UNESCAPED_UNICODE);
                //Android 客户端处理json时会乱序，替换成字符串下发
                $result['itemInfo']=$item_info;
                $temp = $key . '=' . $item_info;
            } else {
                $temp = $key . '=' . $value;
            }

            array_push($signContentArray, $temp);
        }

        $signContent = implode('&', $signContentArray);
        $signValue = md5($signContent);

        // 删除key
        unset($result['key']);

        // 将百度钱包支付合作密钥作为最后一个参数，参数名为key，参数值就是百度钱包支付合作密钥本身
        $result['signType'] = 1;
        $result['sign'] = $signValue;

        return $result;
    }

    private static $service = 'counter';

    /**
     * 共用内部方法，通过ral proxy请求钱包支付接口
     *
     * @param array $params
     *
     * @param string $logid
     *
     * @return array
     *
     * @throws exception
     */
    private static function _request($params, $logid = null)
    {
        if (isset ($logid)) {
            ral_set_logid($logid);
        }
        ral_set_pathinfo("/proxy/req/refundv2");
        $ret = ral(self::$service, '', $params, '');
        if (!$ret) {
            $result = array();
            $result ['errorNo'] = ral_get_errno();
            Bd_Log::warning('invoke counter error' . ral_get_error(), $result ['errno'], $params);
        } else {
            $result = json_decode($ret, true);
        }
        return $result;
    }

    /**
     * 共用内部方法，请求钱包退款接口
     *
     * @param string $notifyUrl 钱包回调的地址
     *
     * @param array $orderInfo
     *
     * @return array
     *
     * @throws exception
     */
    private static function _refund($notifyUrl, $orderInfo)
    {
        $customerId = Bd_Conf::getAppConf("payinfo/customer_id");
        $request['customerId'] = $customerId;
        $request['service'] = "reqrefund";
        $request['requestId'] = $orderInfo['pay_request_id'];
        $request['txNo'] = $orderInfo['pay_tx_no'];
        $request['orderId'] = $orderInfo['order_id'];
        $request['batchNo'] = 1;
        $request['refundAmount'] = $orderInfo['pay_amount'];
        $request['notifyUrl'] = $notifyUrl;
        $request['signType'] = 1;
        $request['sign'] = self::_signRefund($request);
        return self::_request($request);
    }

    /**
     * 共用内部方法，签名钱包退款接口参数
     *
     * @param array $params
     *
     * @return string 签名字符串
     *
     * @throws exception
     */
    private static function _signRefund($params)
    {
        $authKey = Bd_Conf::getAppConf("payinfo/sign_key");
        ksort($params);
        $strInput = null;
        foreach ($params as $key => $value) {
            if ($key != 'sign' && $key != 'log_id' && $key != 'signType') {
                if ($strInput) {
                    $strInput .= "&";
                }
                $strInput .= $key . "=" . $value;
            }
        }
        $strInput .= "&key=" . $authKey;
        return md5($strInput);
    }
	
	/**
	 * 验证钱包回调参数签名是否正确
	 *
	 * @param array $params
	 *            收到的原始post参数组
	 * @return boolean 签名是否正确
	 */
	public static function verifyWalletSign($params) {
		$ret = false;
		$copy = array ();
		$signType = 1;
		foreach ( $params as $k => $v ) {
			if ($k == 'sign') {
				$sign = $v;
				continue;
			} else if ($k == 'signType') {
				$signType = intval ( $v );
				continue;
			}
			$copy [$k] = $v;
		}
		ksort ( $copy );
		$authKey = Bd_Conf::getAppConf ( "payinfo/sign_key" );
		$copy ['key'] = $authKey;
		$signContent = urldecode ( http_build_query ( $copy ) );
		if ($signType === 1) {
			$ret = ($sign === md5 ( $signContent ));
		}
		return $ret;
	}
	
	
}
?>
