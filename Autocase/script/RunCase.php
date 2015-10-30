<?php
	Bd_Init::init();
	$param = $argv[1];
    $param_array = explode("=", $param);
	$query = array();
	if(is_array($param_array))
	{
		$query[$param_array[0]] = $param_array[1];
	}
	$pageObj = new Service_Page_Case();
	$data = $pageObj->runCase($query);
