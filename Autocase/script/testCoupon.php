<?php
/**
 * @name sampleScript
 * @desc 示例脚本
 * @author zhangheng04
 */
Bd_Init::init ();

// 主体功能逻辑写在这里
echo 'Hello, sample script running...';
$coupon = Marketing_Coupon::applyHongbao ( null, 260479212, 390, null, 3902083741435129811, '加油测试', null, null, null, '{test:1}' );
var_dump ( 'applyHongbao' );
var_dump ( $coupon );
var_dump ( 'userList' );
var_dump ( Marketing_Coupon::userList ( null, 260479212 ) );
if ($coupon ['errorNo'] === 0) {
	$couponNo = $coupon ['data'];
	$orderid = 'oil_no_' . $couponNo;
	var_dump ( 'hongbaodetail' );
	var_dump ( Marketing_Coupon::detail ( $couponNo ) );
	var_dump ( 'useHongbao' );
	var_dump ( Marketing_Coupon::useHongbao ( $orderid, null, 260479212, $couponNo, 10000, null ) );
	var_dump ( 'userList' );
	var_dump ( Marketing_Coupon::userList ( null, 260479212 ) );
	var_dump ( 'orderDetail' );
	var_dump ( Marketing_Coupon::orderDetail ( $orderid ) );
	var_dump ( 'cancel' );
	var_dump ( Marketing_Coupon::cancel ( $orderid ) );
	var_dump ( 'userList' );
	var_dump ( Marketing_Coupon::userList ( null, 260479212 ) );
}
// 如果利用noah ct任务系统运行脚本，需要显示退出，设置退出码为0，否则监控系统会报警
exit ( 0 );
