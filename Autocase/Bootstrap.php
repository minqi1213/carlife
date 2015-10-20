<?php
/**
 * 车生活项目Bootstrap.php
 * 
 * @author  wangdazhuo@baidu.com
 * @date    2015-06-17
 * @package 路径
 * @version 1.0
 */
class Bootstrap extends Ap_Bootstrap_Abstract
{
	public function _initRoute(Ap_Dispatcher $dispatcher) {
		//在这里注册自己的路由协议,默认使用static路由
	}
	
	public function _initPlugin(Ap_Dispatcher $dispatcher) {
        //注册saf插件
        $objPlugin = new Saf_ApUserPlugin();
        $dispatcher->registerPlugin($objPlugin);
    }
	
	public function _initView(Ap_Dispatcher $dispatcher){
		//在这里注册自己的view控制器，例如smarty,firekylin
		$dispatcher->disableView();//禁止ap自动渲染模板
	}
	
    public function _initDefaultName(Ap_Dispatcher $dispatcher) {
		//设置路由默认信息
		$dispatcher->setDefaultModule('Main')
		           ->setDefaultController('Main');
	}
}
