<?php

/*
 * 角色管理
 * @Author  liuliting
 */
class DbRoleAction extends CommonAction
{
    function _filter(&$map)
    {
        $map['name'] = array('like', "%" . $_POST['name'] . "%");
    }

    /**
     * +----------------------------------------------------------
     * 增加组操作权限
     *
     * +----------------------------------------------------------
     * @access public
     * +----------------------------------------------------------
     * @return void
    +----------------------------------------------------------
     * @throws FcsException
    +----------------------------------------------------------
     */
    public function setApp()
    {
        $id = $_POST['groupAppId'];
        $groupId = $_POST['groupId'];
        $group = D('DbRole');
        $group->delGroupApp($groupId);
        $result = $group->setGroupApps($groupId, $id);

        if ($result === false) {
            $this->error('项目授权失败！');
        } else {
            $this->success('项目授权成功！');
        }
    }

    /**
     * +----------------------------------------------------------
     * 组操作权限列表
     *
     * +----------------------------------------------------------
     * @access public
     * +----------------------------------------------------------
     * @return void
    +----------------------------------------------------------
     * @throws FcsException
    +----------------------------------------------------------
     */
    public function app()
    {
        //读取系统的项目列表
        $node = D("DbNode");
        $list = $node->where('level=1')->field('id,title')->select();
        foreach ($list as $vo) {
            $appList[$vo['id']] = $vo['title'];
        }

        //读取系统组列表
        $group = D('DbRole');
        $list = $group->field('id,name')->select();
        foreach ($list as $vo) {
            $groupList[$vo['id']] = $vo['name'];
        }
        $this->assign("groupList", $groupList);

        //获取当前用户组项目权限信息
        $groupId = isset($_GET['groupId']) ? $_GET['groupId'] : '';
        $groupAppList = array();
        if (!empty($groupId)) {
            $this->assign("selectGroupId", $groupId);
            //获取当前组的操作权限列表
            $list = $group->getGroupAppList($groupId);
            foreach ($list as $vo) {
                $groupAppList[$vo['id']] = $vo['id'];
            }
        }
        $this->assign('groupAppList', $groupAppList);
        $this->assign('appList', $appList);
        $this->display();

        return;
    }

    /**
     * +----------------------------------------------------------
     * 增加组操作权限
     *
     * +----------------------------------------------------------
     * @access public
     * +----------------------------------------------------------
     * @return void
    +----------------------------------------------------------
     * @throws FcsException
    +----------------------------------------------------------
     */
    public function setModule()
    {
        $id = $_POST['groupModuleId'];
        $groupId = $_POST['groupId'];
        $appId = $_POST['appId'];
        $group = D("DbRole");
        $group->delGroupModule($groupId, $appId);
        $result = $group->setGroupModules($groupId, $id);

        if ($result === false) {
            $this->error('模块授权失败！');
        } else {
            $this->success('模块授权成功！');
        }
    }

    /**
     * +----------------------------------------------------------
     * 组操作权限列表
     *
     * +----------------------------------------------------------
     * @access public
     * +----------------------------------------------------------
     * @return void
    +----------------------------------------------------------
     * @throws FcsException
    +----------------------------------------------------------
     */
    public function module()
    {
        $groupId = $_GET['groupId'];
        $appId = $_GET['appId'];

        $group = D("DbRole");
        //读取系统组列表
        $list = $group->field('id,name')->select();
        foreach ($list as $vo) {
            $groupList[$vo['id']] = $vo['name'];
        }
        $this->assign("groupList", $groupList);

        if (!empty($groupId)) {
            $this->assign("selectGroupId", $groupId);
            //读取系统组的授权项目列表
            $list = $group->getGroupAppList($groupId);
            foreach ($list as $vo) {
                $appList[$vo['id']] = $vo['title'];
            }
            $this->assign("appList", $appList);
        }
        $node = D("DbNode");
        if (!empty($appId)) {
            $this->assign("selectAppId", $appId);
            //读取当前项目的模块列表
            $where['level'] = 2;
            $where['pid'] = $appId;
            $nodelist = $node->field('id,title')->where($where)->select();
            foreach ($nodelist as $vo) {
                $moduleList[$vo['id']] = $vo['title'];
            }
        }
        //获取当前项目的授权模块信息
        $groupModuleList = array();
        if (!empty($groupId) && !empty($appId)) {
            $grouplist = $group->getGroupModuleList($groupId, $appId);
            foreach ($grouplist as $vo) {
                $groupModuleList[$vo['id']] = $vo['id'];
            }
        }
        $this->assign('groupModuleList', $groupModuleList);
        $this->assign('moduleList', $moduleList);

        $this->display();

        return;
    }

    /**
     * +----------------------------------------------------------
     * 增加组操作权限
     *
     * +----------------------------------------------------------
     * @access public
     * +----------------------------------------------------------
     * @return void
    +----------------------------------------------------------
     * @throws FcsException
    +----------------------------------------------------------
     */
    public function setAction()
    {
        $id = $_POST['groupActionId'];
        $groupId = $_POST['groupId'];
        $moduleId = $_POST['moduleId'];
        $group = D("DbRole");
        $group->delGroupAction($groupId, $moduleId);
        $result = $group->setGroupActions($groupId, $id);

        if ($result === false) {
            $this->error('操作授权失败！');
        } else {
            $this->success('操作授权成功！');
        }
    }

    /**
     * +----------------------------------------------------------
     * 组操作权限列表
     *
     * +----------------------------------------------------------
     * @access public
     * +----------------------------------------------------------
     * @return void
    +----------------------------------------------------------
     * @throws FcsException
    +----------------------------------------------------------
     */
    public function action()
    {
        $groupId = $_GET['groupId'];
        $appId = $_GET['appId'];
        $moduleId = $_GET['moduleId'];

        $group = D("DbRole");
        //读取系统组列表
        $grouplist = $group->field('id,name')->select();
        foreach ($grouplist as $vo) {
            $groupList[$vo['id']] = $vo['name'];
        }
        $this->assign("groupList", $groupList);

        if (!empty($groupId)) {
            $this->assign("selectGroupId", $groupId);
            //读取系统组的授权项目列表
            $list = $group->getGroupAppList($groupId);
            foreach ($list as $vo) {
                $appList[$vo['id']] = $vo['title'];
            }
            $this->assign("appList", $appList);
        }
        if (!empty($appId)) {
            $this->assign("selectAppId", $appId);
            //读取当前项目的授权模块列表
            $list = $group->getGroupModuleList($groupId, $appId);
            foreach ($list as $vo) {
                $moduleList[$vo['id']] = $vo['title'];
            }
            $this->assign("moduleList", $moduleList);
        }
        $node = D("DbNode");
        if (!empty($moduleId)) {
            $this->assign("selectModuleId", $moduleId);
            //读取当前项目的操作列表
            $map['level'] = 3;
            $map['pid'] = $moduleId;
            $list = $node->where($map)->field('id,title')->select();
            if ($list) {
                foreach ($list as $vo) {
                    $actionList[$vo['id']] = $vo['title'];
                }
            }
        }
        //获取当前用户组操作权限信息
        $groupActionList = array();
        if (!empty($groupId) && !empty($moduleId)) {
            //获取当前组的操作权限列表
            $list = $group->getGroupActionList($groupId, $moduleId);
            if ($list) {
                foreach ($list as $vo) {
                    $groupActionList[$vo['id']] = $vo['id'];
                }
            }
        }
        $this->assign('groupActionList', $groupActionList);
        //$actionList = array_diff_key($actionList,$groupActionList);
        $this->assign('actionList', $actionList);

        $this->display();

        return;
    }

    /**
     * +----------------------------------------------------------
     * 增加组操作权限
     * +----------------------------------------------------------
     * @access public
     * +----------------------------------------------------------
     * @return void
    +----------------------------------------------------------
     * @throws FcsException
    +----------------------------------------------------------
     */
    public function setUser()
    {
        $id = $_POST['groupUserId'];
        $groupId = $_POST['groupId'];
        $group = D("DbRole");
        $group->delGroupUser($groupId);
        $result = $group->setGroupUsers($groupId, $id);
        if ($result === false) {
            echo $this->ajax('0', "授权失败", $name, "", "");
        } else {
            echo $this->ajax('1', "授权成功", $name, "", "");
        }
    }

    /**
     * +----------------------------------------------------------
     * 组操作权限列表
     * +----------------------------------------------------------
     * @access public
     * +----------------------------------------------------------
     * @return void
    +----------------------------------------------------------
     * @throws FcsException
    +----------------------------------------------------------
     */
    public function user()
    {
        //读取系统的用户列表
        $user = D("DbUser");
        $where['status'] = 1;
        $list2 = $user->where($where)->field('id,name,nickname')->select();
        echo $user->getlastsql();
        //dump(	$user);
        foreach ($list2 as $vo) {
            $userList[$vo['id']] = $vo['account'] . ' ' . $vo['nickname'];
        }
        $group = D("DbRole");
        $list = $group->field('id,name')->select();
        foreach ($list as $vo) {
            $groupList[$vo['id']] = $vo['name'];
        }
        $this->assign("groupList", $groupList);

        //获取当前用户组信息
        $groupId = isset($_GET['id']) ? $_GET['id'] : '';
        $groupUserList = array();
        if (!empty($groupId)) {
            $this->assign("selectGroupId", $groupId);
            //获取当前组的用户列表
            $list = $group->getGroupUserList($groupId);
            foreach ($list as $vo) {
                $groupUserList[$vo['id']] = $vo['id'];
            }
        }
        $this->assign('groupUserList', $groupUserList);
        $this->assign('userList', $userList);
        $this->display();
        return;
    }

    public function _before_edit()
    {
        $Group = D('DbRole');
        //查找满足条件的列表数据
        $list = $Group->field('id,name')->select();
        $this->assign('list', $list);

    }

    public function _before_add()
    {
        $Group = D('DbRole');
        //查找满足条件的列表数据
        $list = $Group->field('id,name')->select();
        $this->assign('list', $list);

    }

    public function select()
    {
        $map = $this->_search();
        //创建数据对象
        $Group = D('DbRole');
        //查找满足条件的列表数据
        $list = $Group->field('id,name')->select();
        $this->assign('list', $list);
        $this->display();
        return;
    }

    /*
        lxz扩展
    */

    public function addAccess()
    {
        $node = M("DbNode")->select();
        $nodeData = list_to_tree($node);
        $this->node = $nodeData;

        $groupId = $_GET['groupId'];
        $Access = M("DbAccess")->where(array('role_id' => "{$groupId}"))->select();

        $array = array();
        foreach ($Access as $val) {
            $array[$val['level']][] = $val['node_id'];
        }
        $this->selectdNode = $array;
        $this->display();
    }

    public function insertAccess()
    {
        $name = 'DbRole';
        $role_id = $_POST['role_id'];
        $data = $dataNode = array();
        M("Dbaccess")->where(array('role_id' => "$role_id"))->delete();

        foreach ($_POST['node_id'] as $key => $val) {
            $postNode = explode('_', $val);
            $dataNode['role_id'] = $role_id;
            $dataNode['node_id'] = $postNode['0'];
            $dataNode['level'] = $postNode['1'];
            $dataNode['pid'] = $postNode['2'];
            $dataNode['group_id'] = $postNode['3'];
            $data[] = $dataNode;
            $accNum = M("l_access")->add($data[$key]);
        }
        echo $this->ajax('1', "授权成功", $name, "", "");
        /*      $accNum=M("l_access")->addAll($data);
                if($accNum){
                    echo $this->ajax('1', "授权成功",$name,"","");
                }else{
                    echo $this->ajax('0', "授权失败",$name,"","");
                } */
    }

    /*状态恢复*/
    public function resume()
    {
        $name = $this->getActionName();
        $model = D($name);
        $list = $model->where('id=' . $_GET['ID'])->setField('status', 1);
        if ($list) {
            echo $this->ajax('1', "状态恢复成功！！", $name, "", "");
        } else {
            echo $this->ajax('0', "状态恢复失败！！", $name, "", "");
        }
    }

    /*状态禁用*/
    public function forbid()
    {
        $name = $this->getActionName();
        $model = D($name);
        $list = $model->where('id=' . $_GET['ID'])->setField('status', 0);
        if ($list) {
            echo $this->ajax('1', "状态禁用成功！！", $name, "", "");
        } else {
            echo $this->ajax('0', "状态禁用失败！！", $name, "", "");
        }
    }
	/*清除角色*/
	public function delzj(){
		$ids = M('DbRole')->getField('id',true);
		$where['role_id'] = array('not in',$ids);
		M('DbRoleUser')->where($where)->delete();
		M('DbAccess')->where($where)->delete();
		dump(M('LAccess')->getLastSql());
	}
	
    public function foreverdelete()
    {
        $name = $this->getActionName();
        $model = D($name);
        D('DbRoleUser')->where('role_id=' . $_GET['id'])->delete();
        if (false !== $model->where('id=' . $_GET['id'])->delete()) {
            echo $this->ajax('1', "删除成功", $name, "", "");
        } else {
            echo $this->ajax('0', "删除失败", $name, "", "");
        }
    }
}

?>