<?php
return array(
    /*
     * 0:普通模式 (采用传统癿URL参数模式 )
     * 1:PATHINFO模式(http://<serverName>/appName/module/action/id/1/)
     * 2:REWRITE模式(PATHINFO模式基础上隐藏index.php)
     * 3:兼容模式(普通模式和PATHINFO模式, 可以支持任何的运行环境, 如果你的环境不支持PATHINFO 请设置为3)
     */
    /* 	'TMPL_EXCEPTION_FILE'=>'D:\APP\Modules\qzweblg2014\Tpl\Public\error.html',
        'ERROR_PAGE'=>'D:\APP\Modules\qzweblg2014\Tpl\Public\error.html',*/
    'TMPL_ACTION_SUCCESS' => 'Syweblg2015@Public:success',
    'TMPL_ACTION_ERROR' => 'Syweblg2015@Public:error',
    'DEFAULT_THEME' => '',
    'APP_AUTOLOAD_PATH' => '@.TagLib',
    'SESSION_AUTO_START' => true,
    'URL_CASE_INSENSITIVE' => false,
    'VAR_PAGE' => 'pageNum',
    'URL_ROUTE_RULES' => array(
        '/^Syweblg2015\/DbGame\/detail\/(\w+)\/(\d+)$/' => 'Syweblg2015/DbGame/detail?field=:1&id=:2',
    ),
    //lxz
    'PAGE_LISTROWS' => 20, //分页 每页显示多少条
    'PAGE_NUM_SHOWN' => 10, //分页 页标数字多少个

    /*RBAC权限控制信息*/
    'RBAC_SUPERADMIN' => 'admlogin', // 超级管理员，对应用户表中某一用户
    'USER_AUTH_ON' => true, // 开启认证
    'USER_AUTH_TYPE' => 2, // 默认认证类型 1 登录认证 2 实时认证,使用Session进行标记
    'USER_AUTH_KEY' => 'authId', // 用户认证SESSION标记,Session名称
    'ADMIN_AUTH_KEY' => 'administrator', // 设置管理员用户标记
    'USER_AUTH_MODEL' => 'db_user', // 默认验证数据表模型
    'AUTH_PWD_ENCODER' => 'md5', // 用户认证密码加密方式
    'USER_AUTH_GATEWAY' => '/Syweblg2015/Public/login', // 默认认证网关
    'NOT_AUTH_MODULE' => '/Syweblg2015/Public', // 默认无需认证模块
//	'REQUIRE_AUTH_MODULE'=>'',						// 默认需要认证模块
    'NOT_AUTH_ACTION' => '', // 默认无需认证操作
    'REQUIRE_AUTH_ACTION' => '', // 默认需要认证操作
    'GUEST_AUTH_ON' => false, // 是否开启游客授权访问
    'GUEST_AUTH_ID' => 0, // 游客的用户ID

    /**权限表*/
    'DB_LIKE_FIELDS' => 'title|remark',
    'RBAC_ROLE_TABLE' => 'db_role',
    'RBAC_USER_TABLE' => 'db_role_user',
    'RBAC_ACCESS_TABLE' => 'db_access',
    'RBAC_NODE_TABLE' => 'db_node',

//	'SESSION_AUTO_START' =>true,	
//	'SESSION_EXPIRE'=>'3',  
    /*模板替换*/
    'TMPL_PARSE_STRING' => array(
        '__APP__' => '/Syweblg2015',

    )


);
?>
