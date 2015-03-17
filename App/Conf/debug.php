<?php
return array(
	'SHOW_RUN_TIME'=>false,					 // 运行时间显示/kekai
	'SHOW_ADV_TIME'=>false,					 // 显示详细的运行时间kekai
	'SHOW_DB_TIMES'=>false,					 // 显示数据库查询和写入次数
	'SHOW_CACHE_TIMES'=>false,				 // 显示缓存操作次数
	'SHOW_USE_MEM'=>false,					 // 显示内存开销
	'SHOW_PAGE_TRACE'=>true,				//显示调试信息
	'LOG_RECORD'=>true,             		 // 进行日志记录
    'LOG_EXCEPTION_RECORD'  => true,    	 // 是否记录异常信息日志
    'LOG_LEVEL'       =>   'EMERG,ALERT,CRIT,ERR,WARN,INFO,DEBUG,SQL',  // 允许记录的日志级别
	
    'DB_FIELDS_CACHE'=> false, 				 // 字段缓存信息
    'APP_FILE_CASE'  =>   false, 			 // 是否检查文件的大小写 对Windows平台有效
    'TMPL_CACHE_ON'    => false,       		 // 是否开启模板编译缓存,设为false则每次都会重新编译
    'TMPL_STRIP_SPACE'      => false,        // 是否去除模板文件里面的html空格与换行
    'SHOW_ERROR_MSG'        => false,    	 // 显示错误信息
);
?>

