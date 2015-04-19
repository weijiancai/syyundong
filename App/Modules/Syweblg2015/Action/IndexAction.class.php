<?php

class IndexAction extends CommonAction
{

    // 框架首页
    public function index()
    {
        if (isset ($_SESSION [C('USER_AUTH_KEY')])) {
            //显示菜单项
            /*   $menu = array();
               if (isset($_SESSION['menu' . $_SESSION[C('USER_AUTH_KEY')]])) {
                   $menu = $_SESSION['menu' . $_SESSION[C('USER_AUTH_KEY')]];
               } else {*/
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
                  //  $_SESSION['menu' . $_SESSION[C('USER_AUTH_KEY')]] = $menu;
                }
            /*}*/
            if (!empty ($_GET ['tag'])) {
                $this->assign('menuTag', $_GET ['tag']);
            }
            //根据user_id查找role_id
            $roleid = M('db_role_user')->where('user_id = ' . $_SESSION [C('USER_AUTH_KEY')])->getField('role_id');

            //根据role_id 查找group_id
            $access = M('DbAccess')->Distinct(true)->field('group_id')->where('group_id != 0 and role_id = ' . $roleid)->select();
            $this->assign('acc', $access);


            $groups = M("DbGroup")->where('status = 1')->order("id asc")->select();
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
}

?>