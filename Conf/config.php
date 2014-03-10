<?php
return array(
	//'配置项'=>'配置值'
	// 添加数据库配置信息
	'DB_TYPE'   => 'mysql', // 数据库类型
	'DB_HOST'   => 'localhost', // 服务器地址
	'DB_NAME'   => 'think_book', // 数据库名
	'DB_USER'   => 'root', // 用户名
	'DB_PWD'    => '12345abcde', // 密码
	'DB_PORT'   => 3306, // 端口
	'DB_PREFIX' => 'think_', // 数据库表前缀
	'URL_ROUTER_ON'   => true, //开启路由
	 'URL_ROUTE_RULES' => array( //定义路由规则
	 ),
	 'APP_STATUS' => 'debug', //应用调试模式状态
	 'SHOW_PAGE_TRACE' =>true, // 显示页面Trace信息
);
?>