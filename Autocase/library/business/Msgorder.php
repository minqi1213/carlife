<?php
/**
 * MSG 订单中心对接相关
 * @author 康永根
 * @date: 2015-08-04
 */

class Business_Msgorder
{
    // 产品线标识
    const MSG_TPL = 7;
    // 订单渠道来源
    const MSG_CHNNEL = '自营';
    // 产品分类
    const MSG_CAT_NAME = 'm';
    // 车生活加油 prdtoken
    const MSG_PRD_TOKEN = 'c795a462f73a54c14d725d9d4c571c56';
    // 订单系统类目id
    const MSG_CAT_ID = 345;
    // 加油订单状态与MSG订单中心状态映射表
    private static $msg_status_map = array(
        1 => array('msg_pay_status' => 1, 'msg_pay_label' => '待支付', 'msg_bus_status' => 1, 'label' => '待支付'),
        2 => array('msg_pay_status' => 2, 'msg_pay_label' => '已支付', 'msg_bus_status' => 1, 'label' => '等待加油站确认'),
        3 => array('msg_pay_status' => 1, 'msg_pay_label' => '待支付', 'msg_bus_status' => 1, 'label' => '支付失败'),
        4 => array('msg_pay_status' => 2, 'msg_pay_label' => '已支付', 'msg_bus_status' => 6, 'label' => '已完成(已确认)'),
        5 => array('msg_pay_status' => 4, 'msg_pay_label' => '退款中', 'msg_bus_status' => 1, 'label' => '退款审核中'),
        6 => array('msg_pay_status' => 5, 'msg_pay_label' => '已退款', 'msg_bus_status' => 1, 'label' => '退款成功'),
        7 => array('msg_pay_status' => 6, 'msg_pay_label' => '已关闭', 'msg_bus_status' => 1, 'label' => '退款失败'),
        8 => array('msg_pay_status' => 6, 'msg_pay_label' => '已关闭', 'msg_bus_status' => 1, 'label' => '退款被拒绝'),
        9 => array('msg_pay_status' => 4, 'msg_pay_label' => '退款中', 'msg_bus_status' => 1, 'label' => '退款已同意'),
        10 => array('msg_pay_status' => 4, 'msg_pay_label' => '退款中', 'msg_bus_status' => 1, 'label' => '退款进行中'),
        11 => array('msg_pay_status' => 6, 'msg_pay_label' => '已关闭', 'msg_bus_status' => 1, 'label' => '订单已取消'),
    );
    // 星期映射表
    private static $weekly_map = array('周日', '周一', '周二', '周三', '周四', '周五', '周六');
    // RAL 配置文件名
    private static $SERVICE_NAME = 'msgordercenter';

    // MSG: 成功
    const MSG_OK = 2000;
    // MSG: 没有权限
    const MSG_FORBIDDEN = 4003;
    // MSG: 参数错误
    const MSG_PARAMS_ERROR = 4000;
    // MSG: 服务器繁忙
    const MSG_SERVER_ERROR = 5003;

    private static $errno_map = array(
        2000 => 'ok',
        4003 => 'forbidden',
        4000 => 'bad request',
        5003 => 'unavailable',
    );

    /**
     * @param $action
     * @param $params
     * @param $logid
     * @return array | null
     *         {
     *           "code" : "xxx",
     *           "msg" : "xxx",
     *           "logid" : "1223"
     *           "data" : xxxxx  //data为具体的请求值，data为空的时候为一个空数组，
     *         }
     *
     *         2000 => ok          成功
     *         4003 => Forbidden   没有权限
     *         4000 => Bad Request 参数错误
     *         5003 => Unavailable 服务繁忙
     */
    public function request($action, $params = null, $logid = null)
    {
        if (isset($logid)) {
            ral_set_logid($logid);
        }

        ral_set_pathinfo("/order/center/" . $action);
        if ($params) {
            $ret = ral(self::$SERVICE_NAME, 'post', $params, '');
        } else {
            $ret = ral(self::$SERVICE_NAME, 'get', null, null);
        }

        if (!$ret) {
            $arrResult = array();
            $arrResult['code'] = ral_get_errno();
            Bd_Log::fatal('invoke msg error: ' . ral_get_error(), $arrResult['errno'], $params);
        } else {
            $arrResult = json_decode($ret, true);
            if ($arrResult['code'] != Business_Msgorder::MSG_OK) {
                Bd_Log::fatal('MSG Error: ' . print_r($arrResult, true), $arrResult['code'], $params);
            }
        }

        return $arrResult;
    }

    /**
     * 加油订单 -> MSG 订单字段转换
     * @param $inner_order 加油订单详细信息
     *        {
     *            "id": "26",
     *            "order_id": "1435047409",
     *            "status": "6",
     *            "pid": "172921162",
     *            "car_no": "京Y1UI58",
     *            "mobile": "18600784543",
     *            "invoice": "百度在线网络技术有限公司",  //发票抬头
     *            "oil_station_id": "222",
     *            "oil_station_name": "中石油",
     *            "oil_gun_id": "0",
     *            "oil_no": "643",
     *            "gun_no": "255",
     *            "gun_machine": "",
     *            "unit_amount": "22",
     *            "total_amount": "100",
     *            "coupon_amount": "20",
     *            "coupon_no": "8",
     *            "coupon_type": "33",
     *            "pay_tx_no": "0",
     *            "pay_request_id": "0",
     *            "pay_amount": "80",
     *            "pay_time": "0",
     *            "refund_tx_no": "0",
     *            "refund_batch_no": "0",
     *            "refund_time": "0",
     *            "update_time": "0",
     *            "create_time": "1435198272",
     *            "expired_time": "0"
     *          }
     * @return array | false
     */
    public function covertToMsgOrder($inner_order)
    {
        if (!is_array($inner_order)) {
            return false;
        }

        $inner_status = intval($inner_order['status']);
        $msg_status_map = Business_Msgorder::$msg_status_map;
        return array(
            'prdtoken' => Business_Msgorder::MSG_PRD_TOKEN, //产品线密钥Secret
            'tpl' => Business_Msgorder::MSG_TPL, //产品线标识
            'order_no' => $inner_order['order_id'], //业务方商户订单号
            'order_title' => $inner_order['oil_station_name'], //订单名称
            'order_add' => json_encode(
                array(
                    'a' => '订单号：' . $inner_order['order_id'],
                    'b' => '加油时间：' . date('Y-m-d', $inner_order['create_time']) . ' '
                    . Business_Msgorder::$weekly_map[date('w', $inner_order['create_time'])] . ' '
                    . date('H:i', $inner_order['create_time']),
                )
            ),
            'channel' => Business_Msgorder::MSG_CHNNEL, //订单渠道来源
            'total_amount' => $inner_order['total_amount'],
            'op_uid' => $inner_order['pid'], //百度账号id
            'co_id' => $inner_order['oil_station_id'], //业务方商户id
            'co_name' => $inner_order['oil_station_name'], //商户名称
            'status' => $msg_status_map[$inner_status]['msg_pay_status'], //订单中心支付状态ID
            'business_status' => $msg_status_map[$inner_status]['msg_bus_status'], //订单中心业务状态ID
            'tpl_status' => $msg_status_map[$inner_status]['label'], //业务系统订单状态,中文文本
            'create_time' => $inner_order['create_time'], //业务系统下单时间
            'cat_id' => Business_Msgorder::MSG_CAT_ID, //订单归属类目ID
            'co_detail' => json_encode(
                array(
                    array(
                        'item_id' => $inner_order['oil_station_id'],
                        'name' => empty ( $inner_order ['car_no'] ) ? $inner_order ['oil_station_name'] : $inner_order ['car_no'],
                        'price' => $inner_order['unit_amount'],
                        'amount' => intval($inner_order['oil_no']),
                        'type' => '#',
                    ),
                )
            ), //商品详情
            'order_source_url' => $this->jointOrderDetailUrl($inner_order['order_id']), //订单详情在商户网站上的URL
        );
    }

    /**
     * @param $order_id
     * @return order detail url
     */
    private function jointOrderDetailUrl($order_id)
    {
        $host = Bd_Conf::getAppConf('env/host');
        $port = Bd_Conf::getAppConf('env/port');
        return "http://" . $host . ($port ? ":" . $port : "") . "/car/order/showdetail?order_id=" . $order_id;
    }

    /**
     * 添加 MSG 订单
     * @param $order_item
     * @return true | array for error
     */
    public function addOrderToMSG($order_item)
    {
        $ddzx_order = $this->covertToMsgOrder($order_item);
        if (!is_array($ddzx_order)) {
            return array('local order item illegal!');
        }

        $action = 'add?' . $this->array2UrlParams($ddzx_order, array(
            'prdtoken',
            'tpl',
            'order_no',
            'op_uid',
            'status',
            'business_status',
            'create_time',
        ));

        $params = $this->filterPostParams($ddzx_order, array(
            'order_title',
            'cuid',
            'channel',
            'co_id',
            'co_name',
            'co_mobile',
            'tpl_status',
            'total_amount',
            'discount_amount',
            'pay_amount',
            'return_amount',
            'cat_id',
            'co_detail',
            'photo_url',
            'order_add',
            'order_source_url',
            'op_address',
            'operate',
            'del_url',
            'client_ip',
        ));

        unset($ddzx_order);
        $msg_result = $this->request($action, $params);

        if ($msg_result['code'] == Business_Msgorder::MSG_OK) {
            return true;
        } else {
            return $msg_result;
        }
    }

    /**
     * 更新 MSG 订单
     * @param $order_item
     * @return true | array for error
     */
    public function updateOrderToMSG($order_item)
    {
        $ddzx_order = $this->covertToMsgOrder($order_item);
        if (!is_array($ddzx_order)) {
            return array('local order item illegal!');
        }

        $action = 'modify?' . $this->array2UrlParams($ddzx_order, array(
            'prdtoken',
            'tpl',
            'order_no',
            'op_uid',
            'status',
            'business_status',
        ));

        $params = $this->filterPostParams($ddzx_order, array(
            'co_name',
            'co_mobile',
            'tpl_status',
            'total_amount',
            'discount_amount',
            'pay_amount',
            'return_amount',
            'photo_url',
            'order_source_url',
            'operate',
            'del_url',
        ));

        unset($ddzx_order);
        $msg_result = $this->request($action, $params);

        if ($msg_result['code'] == Business_Msgorder::MSG_OK) {
            return true;
        } else {
            return $msg_result;
        }
    }

    /**
     * 查询 NSG 订单列表
     * @param $pid
     * @param $mobile
     * @param $page_size    [10, 50]
     * @param $order_status {1：进行中，2：已完成}
     * @param $time_start   >=, default: 0 unlimit
     * @param $time_end     <=, default: 0 unlimit
     * @return array
     */
    public function queryMsgOrderList($pid, $mobile, $page_size = 20, $order_status = 0, $time_start = 0, $time_end = 0)
    {
        $params = array(
            'prdtoken' => Business_Msgorder::MSG_PRD_TOKEN,
            'tpl' => Business_Msgorder::MSG_TPL,
            'cat_name' => Business_Msgorder::MSG_CAT_NAME,
            'op_uid' => $pid,
            'op_uid_mobile' => $mobile,
            'size' => $page_size,
        );

        if ($order_status) {
            $params['order_status'] = $order_status;
        }

        if ($time_start) {
            $params['time_start'] = $time_start;
        }

        if ($time_end) {
            $params['time_end'] = $time_end;
        }

        return $this->request('list?' . $this->array2UrlParams($params));
    }

    /**
     * 参数封装
     * @param $params
     * @param $filter
     * @return array
     */
    private function array2UrlParams($params, $filter = null)
    {
        $url_params = null;
        foreach ($params as $key => $value) {
            if (is_array($filter) && !in_array($key, $filter)) {
                continue;
            }
            $url_params = ($url_params ? ($url_params . '&') : '') . $key . '=' . urlencode($value);
        }
        return $url_params;
    }

    /**
     * @param $params
     * @param $filter
     * @return mixed
     */
    public function filterPostParams($raw_params, $filter = null)
    {
        if (is_array($filter)) {
            $params = array();
            foreach ($raw_params as $key => $value) {
                if (in_array($key, $filter)) {
                    $params[$key] = $value;
                }
            }
            return $params;
        } else {
            return $raw_params;
        }
    }
}
