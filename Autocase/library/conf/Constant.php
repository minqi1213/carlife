<?php

/**
 * Created by PhpStorm.
 * User: ligang02
 * Date: 2015/6/24
 * Time: 17:21
 */
class Conf_Constant
{
    // 订单有效期，订单过期时间 = 订单生成时间 + 订单有效期
    // 默认有效期24小时：24 * 3600 = 86400 seconds
    const ORDER_VALID_PERIOD = 86400;

    // 支付异步通知结果 - 成功
    const PAY_NOTIFY_RESULT_STATUS_SUCCESS = 0;

    // 支付异步通知结果 - 失败
    const PAY_NOTIFY_RESULT_STATUS_FAIL = 1;

    // 退款异步通知结果 - 成功
    const REFUND_NOTIFY_RESULT_STATUS_SUCCESS = 0;

    // 退款异步通知结果 - 失败
    const REFUND_NOTIFY_RESULT_STATUS_FAIL = 1;

    // 新建订单，待支付
    const ORDER_STATUS_READY_FOR_PAY = 1;

    // 订单支付成功
    const ORDER_STATUS_PAY_SUCCESS = 2;

    // 订单支付失败
    const ORDER_STATUS_PAY_FAIL = 3;

    // 订单已完成（加油站已确认）
    const ORDER_STATUS_COMPLETE = 4;

    // 订单退款处理中
    const ORDER_STATUS_REFUNDING = 5;

    // 订单退款成功
    const ORDER_STATUS_REFUND_SUCCESS = 6;

    // 订单退款失败
    const ORDER_STATUS_REFUND_FAIL = 7;

    // 订单退款被拒绝
    const ORDER_STATUS_REFUND_REFUSED = 8;
    
    // 订单退款已同意
    const ORDER_STATUS_REFUND_ACCEPTED = 9;
    
    // 订单退款进行中
    const ORDER_STATUS_REFUND_PROCESSING = 10;

    // 订单已取消
    const ORDER_STATUS_CANCELED = 11;
    
    // 优惠券类型，满减类
    const COUPON_TYPE_CUT_ON_CONDITION = 1;

    // 优惠券类型，折扣
    const COUPON_TYPE_DISCOUNT = 2;

    // 优惠券状态：未使用
    const COUPON_STATUS_UNUSED = 0;

    // 优惠券状态：已使用
    const COUPON_STATUS_USED = 1;

    // 优惠券状态：已申请返现
    const COUPON_STATUS_CASH_BACKED = 2;

    // 优惠券状态：已过期
    const COUPON_STATUS_OVERDUE = 3;

    // 获取所有油票
    const GET_COUPONS_ALL = 0;

    // 获取所有未过期且未使用
    const GET_COUPONS_UNUSE_NOT_OVERDUE = 1;

    // 获取所有未使用
    const GET_COUPONS_UNUSE_ALL = 2;

    // 获取所有已使用
    const GET_COUPONS_USED = 3;

    // 获取所有已返现
    const GET_COUPONS_CASH_BACKED = 4;
    
    // 获取所有已过期
    const GET_COUPONS_OVERDUE = 5;

    // 最大的页数据长度
    const MAX_PAGE_SIZE = 50;

    // 默认的页数据长度
    const DEFAULT_PAGE_SIZE = 20;

    // 没有更多分页
    const LIST_NO_MORE = 0;

    // 还有更多分页
    const LIST_HAS_MORE = 1;

    // 服务器默认的参数值
    const DEFAULT_PARAM_VALUE = 0;
    //流水单记录支付成功
    const TRANSACTION_STATUS_SUCCESS = 0;
    //流水单记录支付失败
    const TRANSACTION_STATUS_FAILED = 1;
    //流水单记录订单更新成功
    const TRANSACTION_UPDATE_SUCCESS = 0;
    //流水单记录订单更新失败
    const TRANSACTION_UPDATE_FAILED = 1;

    // 配置：Client支持的最大支付金额
    const CFG_MAX_PRICE = 80000;
    // 配置：Client 可选支持金额级别 0
    const CFG_PRICE_LEVEL_0 = 10000;
    // 配置：Client 可选支持金额级别 1
    const CFG_PRICE_LEVEL_1 = 20000;
    // 配置：Client 可选支持金额级别 2
    const CFG_PRICE_LEVEL_2 = 30000;
    // 配置：Client 帮助页链接
    const CFG_CLIENT_HELP_URL = "http://oil.baidu.com/car/couponfe/help";
    // 配置：Client 获取油票帮助链接
    const CFG_CLIENT_HOW_TO_GET_COUPONS = "http://oil.baidu.com/car/couponfe/help";

    // 运营位：首页
    const OPERATION_POS_ID_HOME = 0;
    // 运营位：支付成功页
    const OPERATION_POS_ID_PAY_SUCCESS = 1;
    // 首次支付成功发放红包的活动 Id
    const OPERATION_HONGBAO_ACT_ID = 108;
    // 首次支付成功发放红包的 type_id
    const OPERATION_HONGBAO_TYPE_ID = 108176851437449208;
    // 首次支付成功发放红包的原因
    const OPETATION_HONGBAO_REASON = "First pay success!";

    //订单状态描述信息
    public static $order_map = array(
        1 => "待支付",
        2 => "支付成功",
        3 => "支付失败",
        4 => "已完成(加油站确认)",
        5 => "退款审核中",
        6 => "退款成功",
        7 => "退款失败",
        8 => "退款被拒绝",
        9 => "退款已同意",
        10 => "退款进行中",
        11 => "订单已取消",
    );

    //金额以分为单位
    const AMOUNT_FACTOR = 100;

    // POI数据标示字段
    const POI_SRC_TYPE = 'zt_life';
    // POI数据表示字段
    const POI_SUB_SRC = 'baidu_oil';
    // POI数据展示控制，为1显示，其他不显示
    const POI_PRODUCT_ID = 1;
    // 点单详情分享标题
    const ORDER_DETAIL_SHARE_TITLE = '我刚用百度加油啦，每升便宜6毛6！红包分享给你，快去试试吧！';
    // 点单详情分享内容
    const ORDER_DETAIL_SHARE_CONTENT = '万水千山只等闲，百度加油最省钱！在北京用百度加油，每升便宜6毛6！快来领红包吧！';
    // 流水表记录类型 0：付款 1：退款
	const TRAN_TYPE_PAY = 0;
	const TRAN_TYPE_REFUND = 1;
	// 是否使用发票 0：使用 1：不使用
	const INVOICE_USE = 0;
	const INVOICE_DIS_USE = 1;

    // 二期：班结状态 -> 上班中
    const SQUAD_STATUS_WORKING = 1;
    // 二期：班结状态 -> 已结班
    const SQUAD_STATUS_OFF_WORK = 2;
    // 状态 0：有效 1：删除
    const IS_ACTIVE = 0;
    const IS_DELETED = 1;
    
    // 支付成功2次优惠活动编号
    const PAY_SUCCESS_ACTIVITY_2 = 1000;
    // 支付成功3次优惠活动编号
    const PAY_SUCCESS_ACTIVITY_3 = 2000;
    
    //支付下限
    const PAY_AMOUNT_LEAST = 1000;
    //支付上限
    const PAY_AMOUNT_MOST = 80000;
}
