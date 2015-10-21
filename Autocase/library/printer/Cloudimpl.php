<?php

class Printer_Cloudimpl {
    
    /**
     * 调用云打印机打印
     * @param $sn 打印机序列号
     * @param $key 打印机key
     * @param string $content 要打印的字符内容
     * @return string 云打印机返回的字符串
     */
    public static function printOrder($sn, $key, $content) {
        $service = 'yunprint';
        $method = 'post';
        ral_set_pathinfo("/WPServer/printOrderAction");
        $param = array(
            'sn'=>$sn,  
            'printContent'=>$content,
            //'apitype'=>'php',//如果打印出来的订单中文乱码，请把注释打开
            'key'=>$key,
            'times'=>1//打印次数
        );
        $result = ral($service, $method, $param);
        if($result === false){
            Bd_Log::notice("Cloudimpl :: printerOrder errno %d, error_msg %s, protocol_status %d", ral_get_errno(), ral_get_error(), ral_get_protocol_code());
        }
        return $result;
    }
    
    /**
     * 获取云打印机状态
     * @param $sn 打印机序列号
     * @param $key 打印机key 详见打印机背面标示
     * @return string 云端返回结果
     */
    public static function queryPrinterStatus($sn, $key) {
        $service =  "yunprint";
        $method = "post";
        ral_set_pathinfo("/WPServer/queryPrinterStatusAction");
        $param = array(
            'sn'=>$sn,  
            'key'=>$key,
        );
        $result = ral($service, $method, $param);
        if($result === false){
            Bd_Log::notice("Cloudimpl :: queryPrinterStatus errno %d, error_msg %s, protocol_status %d", ral_get_errno(), ral_get_error(), ral_get_protocol_code());
        }
        return $result;
    }
    
    /**
     * 获取订单状态
     * @param $sn 打印机序列号
     * @param $key 打印机key 详见打印机背面标示
     * @param $index 打印机订单单号
     * @return string 云端返回结果
     */
    public static function queryOrderStatus($sn, $key, $index) {
        $service =  "yunprint";
        $method = "post";
        ral_set_pathinfo("/WPServer/queryOrderStateAction");
        $param = array(
            'sn'=>$sn,  
            'key'=>$key,
            'index'=>$index,
        );
        $result = ral($service, $method, $param);
        if($result === false){
            Bd_Log::notice("Cloudimpl :: queryOrderStatus errno %d, error_msg %s, protocol_status %d", ral_get_errno(), ral_get_error(), ral_get_protocol_code());
        }
        return $result;
    }
    
    /**
     * 获取订单状态
     * @param $sn 打印机序列号
     * @param $key 打印机key 详见打印机背面标示
     * @param $date 打印机订单日期
     * @return string 云端返回结果
     */
    public static function queryOrderByDate($sn, $key, $date) {
        $service =  "yunprint";
        $method = "post";
        ral_set_pathinfo("/WPServer/queryOrderInfoAction");
        $param = array(
            'sn'=>$sn,  
            'key'=>$key,
            'date'=>$date,
        );
        $result = ral($service, $method, $param);
        if($result === false){
            Bd_Log::notice("Cloudimpl :: queryOrderByDate errno %d, error_msg %s, protocol_status %d", ral_get_errno(), ral_get_error(), ral_get_protocol_code());
        }
        return $result;
    }
}
?>