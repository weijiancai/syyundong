<?php
$DB_Config = require 'config.inc.php';
$debug = require 'debug.php';
$Public_Config =  array(
	//错误指向
 	/* 'TMPL_EXCEPTION_FILE'=>'D:\APP\Modules\Public\Tpl\default\Public\error1.html',
	'ERROR_PAGE'=>'D:\APP\Modules\Public\Tpl\default\Public\error1.html',
	'TMPL_ACTION_SUCCESS' => 'home@Public:success',
	'TMPL_ACTION_ERROR'   => 'home@Public:error',  */
	//URL模式
	'LOG_RECORD' => false,
	'LIMIT_REFLESH_TIME'=>'10',
	'DEFAULT_MODULE'     => 'Index',
	'URL_CASE_INSENSITIVE'  => true,
	'DEFAULT_THEME'	=> 'default',
	'TMPL_L_DELIM'	=>'<{',
	'TMPL_R_DELIM'	=>'}>',
    //'URL_MODEL'=>0,
	'URL_PATHINFO_DEPR'	=>'/',
	'URL_ROUTER_ON'   => true,
	'URL_ROUTE_RULES' => array(
        '/^verify/'=>'home/index/verify',
        '/^Game\/publish/' => 'Game/index/publish',
        '/^Game\/addgame/' => 'Game/index/addgame',
        '/^Game\/(\d+)$/' => 'Game/view?id=:1',
	),
	'URL_HTML_SUFFIX'	=>'.html',
	'VAR_FILTERS'=>'htmlspecialchars,stripslashes,strip_tags',
	'HTML_CACHE_ON'	=> false,

	/*调试状态*/
	'APP_STATUS' => 'debug',
	'SHOW_PAGE_TRACE'	 => true,
	'SHOW_ERROR_MSG' => true,
	'DEFAULT_CHARSET'       => 'utf-8',

	/*子域名服务*/
	'APP_GROUP_MODE'	 => 1,
	'APP_GROUP_LIST'     => 'Home,Public,Game,Activity,Syweblg2015',
	'DEFAULT_GROUP'      => 'Home',
	'HTML_CACHE_ON'	=>true,
	'HTML_CACHE_TIME'	=>true,

	/*TokenBuild行为配置*/
	'TOKEN_ON'	=>true,
	'TOKEN_NAME'	=>'__hash__',
	'TOKEN_TYPE'	=>'md5',
	'TOKEN_RESET'=>true,

    /*SESSION开启*/
    'SESSION_AUTO_START' =>true,

	/*模板替换*/
	'TMPL_PARSE_STRING'  =>array(
        '__APP__'=>'http://www.syyundong.com',
	),

);
return array_merge($DB_Config,$Public_Config,$debug);
?>