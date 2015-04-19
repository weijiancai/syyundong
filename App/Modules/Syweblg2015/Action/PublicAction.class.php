<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2009 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

class PublicAction extends Action
{
    // 检查用户是否登录

    protected function checkUser()
    {
        if (!isset($_SESSION[C('USER_AUTH_KEY')])) {
            $this->assign('jumpUrl', 'Public/login');
            $this->error('没有登录');
        }
    }

    // 顶部页面
    public function top()
    {
        C('SHOW_RUN_TIME', false); // 运行时间显示
        C('SHOW_PAGE_TRACE', false);
        $model = M("Group");
        $list = $model->where('status=1')->getField('id,title');
        $this->assign('nodeGroupList', $list);
        $this->display();
    }

    // 尾部页面
    public function footer()
    {
        C('SHOW_RUN_TIME', false); // 运行时间显示
        C('SHOW_PAGE_TRACE', false);
        $this->display();
    }

    public function menu()
    {
        $this->checkUser();
        if (isset ($_SESSION [C('USER_AUTH_KEY')])) {
            //显示菜单项
            $menu = array();
            $node = M("DbNode");
            $id = $node->getField("id");
            $list = $node->query("select id,name,link,group_id,title,level from db_node where level = 2 and status= 1 and pid=" . $id . " order by sort asc");
            if (isset($_SESSION['_ACCESS_LIST'])) {
                $accessList = $_SESSION['_ACCESS_LIST'];
            } else {
                import('ORG.Util.RBAC');
                $accessList = RBAC::getAccessList($_SESSION[C('USER_AUTH_KEY')]);
                if (is_array($list)) {
                    foreach ($list as $key => $module) {
                        if (isset ($accessList [strtoupper(GROUP_NAME)] [strtoupper($module ['name'])]) || session(C('ADMIN_AUTH_KEY'))) {
                            //设置模块访问权限
                            $module ['access'] = 1;
                            //lxz 修改 获取当前分类的module
                            $menu[$module['group_id']] [$key] = $module;
                        }
                    }
                }
                //缓存菜单访问
                //	$_SESSION['menu'.$_SESSION[C('USER_AUTH_KEY')]]	=$menu;
            }
            //	}
            if (!empty ($_GET ['tag'])) {
                $this->assign('menuTag', $_GET ['tag']);
            }
            //根据user_id查找role_id
            $roleid = M('db_role_user')->where('user_id = ' . $_SESSION [C('USER_AUTH_KEY')])->getField('role_id');

            //根据role_id 查找group_id
            $access = M('DbAccess')->Distinct(true)->where('group_id != 0 and role_id = ' . $roleid)->getField('group_id', true);
            //	$this->assign('acc',$access);

            $groups = M("DbGroup")->where('status = 1')->order("sort asc")->select();
            //	$groups=M("Group")->where(array('group_menu'=>"{$volist[0]['menu']}",'status'=>"1"))->order("sort desc,id desc")->select();
            $this->assign("groups", $groups);

            $array = array();
            foreach ($access as $key => $val) {
                foreach ($groups as $keys => $var) {
                    if ($access[$key]['group_id'] == $groups[$keys]['id']) {
                        $array[$key]['id'] = $groups[$keys]['id'];
                        $array[$key]['title'] = $groups[$keys]['title'];
                    }
                }
            }
            $this->assign('menulist', $array);

            $this->assign('userid', $_SESSION [C('USER_AUTH_KEY')]);

            $this->assign('menu', $menu);

        }
        C('SHOW_RUN_TIME', false); // 运行时间显示
        C('SHOW_PAGE_TRACE', false);
        $this->display();
    }

    // 后台首页 查看系统信息
    public function main()
    {
        $info = array(
            '操作系统' => PHP_OS,
            '运行环境' => $_SERVER["SERVER_SOFTWARE"],
            'PHP运行方式' => php_sapi_name(),
            'ThinkPHP版本' => THINK_VERSION . ' [ <a href="http://thinkphp.cn" target="_blank">查看最新版本</a> ]',
            '上传附件限制' => ini_get('upload_max_filesize'),
            '执行时间限制' => ini_get('max_execution_time') . '秒',
            '服务器时间' => date("Y年n月j日 H:i:s"),
            '北京时间' => gmdate("Y年n月j日 H:i:s", time() + 8 * 3600),
            '服务器域名/IP' => $_SERVER['SERVER_NAME'] . ' [ ' . gethostbyname($_SERVER['SERVER_NAME']) . ' ]',
            '剩余空间' => round((@disk_free_space(".") / (1024 * 1024)), 2) . 'M',
            'register_globals' => get_cfg_var("register_globals") == "1" ? "ON" : "OFF",
            'magic_quotes_gpc' => (1 === get_magic_quotes_gpc()) ? 'YES' : 'NO',
            'magic_quotes_runtime' => (1 === get_magic_quotes_runtime()) ? 'YES' : 'NO',
        );
        $this->assign('info', $info);
        $this->display();
    }

    // 用户登录页面
    public function login()
    {
        if (!isset($_SESSION[C('USER_AUTH_KEY')])) {
            $this->display();
        } else {
            $this->redirect('/Syweblg2015');
        }
    }

    public function index()
    {
        //如果通过认证跳转到首页
        redirect(__APP__);
    }

    // 用户登出
    public function logout()
    {
        if (isset($_SESSION[C('USER_AUTH_KEY')])) {
            unset($_SESSION[C('USER_AUTH_KEY')]);
            unset($_SESSION);
            session_destroy();
            $this->success('登出成功！');
        } else {
            $this->error('已经登出！');
        }
    }

    // 登录检测
    public function checkLogin()
    {
        if (empty($_POST['account'])) {
            $this->error('帐号错误！');
        } elseif (empty($_POST['password'])) {
            $this->error('密码必须！');
        } elseif (empty($_POST['verify'])) {
            $this->error('验证码必须！');
        }
        //生成认证条件
        $map = array();
        // 支持使用绑定帐号登录130181199512063632
        $map['name'] = $_POST['account'];
        if ($_SESSION['verify'] != md5($_POST['verify'])) {
            $this->error('验证码错误！');
        }
        import('ORG.Util.RBAC');
        $authInfo = RBAC::authenticate($map);
        //使用用户名、密码和状态的方式进行认证
        if (empty($authInfo)) {
            $this->error('帐号不存在或已禁用！');
        } else { 
            if ($authInfo['password'] != base64_encode(strtoupper(md5($_POST['password'])))) {
                $this->error('密码错误！');
            }
            $_SESSION[C('USER_AUTH_KEY')] = $authInfo['id'];
            $_SESSION['loginUserName'] = $authInfo['nick_name'];
            $_SESSION['ip'] = get_client_ip();
            $_SESSION['account'] = $authInfo['name'];
            /*             if($authInfo['account']=='admlogin') {
                            $_SESSION['administrator']		=	true;
                        } */
            if ($authInfo['name'] == C('RBAC_SUPERADMIN')) {
                //$_SESSION['ADMIN_AUTH_KEY']		=	true;
                session(C('ADMIN_AUTH_KEY'), true);
            }
            // 缓存访问权限
            RBAC::saveAccessList();
            $this->success('登录成功!');
        }
    }

    // 更换密码
    public function changePwd()
    {
        $name = "index";
        $this->checkUser();
        //对表单提交处理进行处理或者增加非表单数据
        /* 		if(md5($_POST['verify'])	!= $_SESSION['verify']) {
                    $this->error('验证码错误！');
                } */
        $map = array();
        $map['password'] = pwdHash($_POST['oldpassword']);
        if (isset($_POST['account'])) {
            $map['account'] = $_POST['account'];
        } elseif (isset($_SESSION[C('USER_AUTH_KEY')])) {
            $map['id'] = $_SESSION[C('USER_AUTH_KEY')];
        }
        //检查用户
        $User = M("LUser");
        if (!$User->where($map)->field('id')->find()) {
            echo $this->ajax('0', "旧密码不符或者用户名错误！", $name, "", "closeCurrent");
        } else {
            $User->password = pwdHash($_POST['password']);
            $User->save();
            echo $this->ajax('1', "密码修改成功！", $name, "", "closeCurrent");
        }
    }

    public function profile()
    {
        $this->checkUser();
        $User = M("User");
        $vo = $User->getById($_SESSION[C('USER_AUTH_KEY')]);
        $this->assign('vo', $vo);
        $this->display();
    }

    public function verify()
    {
        import("ORG.Util.Image");
        Image::buildImageVerify(4, 1, 'png');
    }

// 修改资料
    public function change()
    {
        $this->checkUser();
        $User = D("User");
        if (!$User->create()) {
            $this->error($User->getError());
        }
        $result = $User->save();
        if (false !== $result) {
            $this->success('资料修改成功！');
        } else {
            $this->error('资料修改失败!');
        }
    }

    // 检查帐号
    public function checkAccount()
    {
        /*         if(!preg_match('/^[a-z]\w{4,}$/i',$_POST['account'])) {
                    $this->error( '用户名必须是字母，且5位以上！');
                } */
        $User = M("LUser");
        // 检测用户名是否冲突
        $where['account'] = $_REQUEST['account'];
        $where['password'] = md5($_REQUEST['password']);
        $result = $User->where($where)->find();
        if ($result) {
            echo 1;
        } else {
            echo 0;
        }
    }

    function guid()
    {
        if (function_exists('com_create_guid')) {
            return com_create_guid();
        } else {
            mt_srand((double)microtime() * 10000); //optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);
            $uuid = chr(123)
                . substr($charid, 0, 8) . $hyphen
                . substr($charid, 8, 4) . $hyphen
                . substr($charid, 12, 4) . $hyphen
                . substr($charid, 16, 4) . $hyphen
                . substr($charid, 20, 12)
                . chr(125);
            return $uuid;
        }
    }
}

?>