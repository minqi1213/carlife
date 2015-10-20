<?php
/**
 * 全局错误码配置文件
 *
 * @author wangdazhuo@baidu.com
 * @date   2015-05-23
 */
final class Conf_Error
{
    //产品线不存在
    const PRODUCT_NOT_EXIST = 1001;
    //该产品线接口不存在
    const INTERFACE_NOT_EXIST = 1002;
    

    //系统级别错误、一般产生在DB级别
    const SYSTER_ERRNO = 2001;
    //数据库配置错误前缀
    const DB_CONF_ERRNO = 2002;
    //数据库链接错误前缀
    const DB_LINK_ERRNO = 2003;
    //数据库执行错误码前缀
    const DB_EXECUTE_ERRNO = 2004;
    //数据库事务执行失败
    const DB_TRANSACTION_ERRNO = 2005;
    //数据库status 状态设置错误
    const DB_STATUS_ERRNO = 2006;
    //数据库Trace 辅助信息获取失败
    const DB_TRACE_INFO_CONF_ERRNO = 2007;
    
    //参数为空
    const PARAMETER_EMPTY_ERRNO = 3001;
    //参数不合法
    const PARAMETER_ILLEGAL_ERRNO = 3002;
    
    
    public static $map = array(
    		1001 => array('message' => 'product does not exist', 'level' => 1),
        1002 => array('message' => 'this product does not have interface', 'level' => 1),
     
        2002 => array('message' => 'Db Cluster Conf Error', 'level' => 3),
        2003 => array('message' => 'Db (%s) Link Error', 'level' => 3),
        2004 => array('message' => 'Db Execute Error', 'level' => 3),
        2005 => array('message' => 'Db Transaction Error', 'level' => 3),
        2006 => array('message' => 'Trace Conf ', 'level' => 3),
        2007 => array('message' => 'Trace Info Conf ', 'level' => 3),
        
        3001 => array('message' => 'parameter (%s) is empty', 'level' => 1),
        3002 => array('message' => 'parameter (%s) is illegal', 'level' => 1),
    );

    /**
     * 根据错误码查询定义的描述信息
     *
     * @param $errno
     * @return string
     */
    public static function getMessage($errno)
    {
        if (isset(Conf_Error::$map[$errno])) {
            return Conf_Error::$map[$errno]['message'];
        }

        return 'Unknow';
    }
}
