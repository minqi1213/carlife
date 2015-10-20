<?php
/**
 * 自定义参数检查异常类
 *
 * @author wangdazhuo
 * @date   2015-05-19
 */
class Exec_Exception extends Exception
{
	//异常级别
	public $level = '';
	/**
	 * 附加信息、包括DB等执行信息,
	 * 形式类似于array('db' => 'xxx','xxx' => 'yyy');
	 * 用于记录错误日志
	 */
	public $append = null;

	//构造函数
	public function __construct($error, $append = null) {
		//父类异常构造函数
		$message = $error['message'];
		$code = $error['code'];
		$this->level = $error['level'];
		parent::__construct($message, $code);
		//记录日志
		Bd_Log::fatal($message, $code, $append);
		//TODO 根据错误级别修改错误信息,日志记录为全局错误码详细信息
	}

    /**
     * @return string
     */
	public function getLevel() {
		return $this->level;
	}

    /**
     * @return null
     */
	public function getAppend() {
		return $this->append;
	}
}
?>
