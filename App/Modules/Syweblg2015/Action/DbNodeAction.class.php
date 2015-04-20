<?php
/*
 * 权限管理
 * @Author  liuliting
 */
class DbNodeAction extends CommonAction
{
    /**
     * +----------------------------------------------------------
     * 默认排序操作
     * +----------------------------------------------------------
     * @access public
     * +----------------------------------------------------------
     * @return void
    +----------------------------------------------------------
     * @throws FcsException
    +----------------------------------------------------------
     */
    public function sort()
    {
        $node = M('LGroup');
        if (!empty($_GET['sortId'])) {
            $map = array();
            $map['status'] = 1;
            $map['id'] = array('in', $_GET['sortId']);
            $sortList = $node->where($map)->order('sort asc')->select();
        } else {
            $sortList = $node->where('status=1')->order('sort asc')->select();
        }
        $this->assign("sortList", $sortList);
        $this->display();
        return;
    }

    public function index()
    {
        $name = $this->getActionName();
        $map = $this->_search($name, '');
        $this->assign('map', $map);
        if (method_exists($this, '_filter')) {
            $this->_filter($map);
        }
        $model = D($name);
        if (!empty ($model)) {
            $order = "";
            $order .= "sort asc,";
            //$order.="id asc,";
            $this->_list($model, $map, $order);
        }
        $this->display();
    }

    public function add()
    {
        //   $this->groupClass=M("GroupClass")->where(array('status'=>1))->select();
        $this->assign('groupid', $_GET['group_id']);
        $model = D('DbGroup');
        $arr = $model->field('id,title')->select();
        $this->assign('group', $arr);
        $this->addnode();
        $this->display();
    }

    public function node()
    {
        $name = $this->getActionName();
        $map = $this->_search($name, $_REQUEST['group_id']);
        $this->assign('map', $map);
        if (method_exists($this, '_filter')) {
            $this->_filter($map);
        }
        $model = D($name);
        if (!empty ($model)) {
            $order = "";
            if (in_array("sort", $dbArray)) {
                $order .= "sort asc,";
            }
            $this->_list($model, $map, $order);
        }
        $this->assign('groupid', $_REQUEST['group_id']);
        $this->display();
    }

    protected function _search($name, $group_id)
    {
        //生成查询条件
        if (empty ($name)) {
            $name = $this->getActionName();
        }
        $name = $this->getActionName();
        $model = D($name);
        $map = array();
        $temp = $model->getDbFields();
        foreach ($temp as $key => $val) {
            if (isset ($_REQUEST [$val]) && $_REQUEST [$val] != '') {
                $_REQUEST [$val] = $_REQUEST[$val];
                $map[$val] = array('like', "%{$_REQUEST[$val]}%");
            }
        }
        if (!empty($group_id)) {
            $map['group_id'] = $group_id;
        }

        return $map;

    }

    public function edit()
    {
        /*查询分组信息*/
        $model = D('DbGroup');
        $arr = $model->field('id,title')->select();
        $this->assign('group', $arr);
        $this->addnode();
        parent::edit();
    }

    /*修改*/
    function update()
    {
        $name = $this->getActionName();
        $model = D($name);
        if (false === $model->create()) {
            $this->error($model->getError());
        }
        if (($_POST['pid'] == 1) && ($_POST['show'] == 1)) {
            $model->where('pid=' . $_POST['id'] . ' and level =4')->setField('show', 1);
        }
        if (($_POST['pid'] == 1) && ($_POST['show'] == 0)) {
            $model->where('pid=' . $_POST['id'] . ' and level =4')->setField('show', 0);
        }
        // 更新数据
        $list = $model->save();
        if (false !== $list) {
            echo $this->ajax('1', "编辑成功", $name, "", "closeCurrent");
        } else {
            echo $this->ajax('0', "编辑失败", $name, "", "closeCurrent");
        }
    }

    /*状态恢复*/
    public function resume()
    {
        $rel = 'child';
        $name = $this->getActionName();
        $model = D($name);
        $list = $model->where('id=' . $_GET['id'])->setField('status', 1);
        if ($list) {
            echo $this->ajax('1', "状态恢复成功！！", $rel, "", "");
        } else {
            echo $this->ajax('0', "状态恢复失败！！", $rel, "", "");
        }
    }

    /*状态禁用*/
    public function forbid()
    {
        $name = $this->getActionName();
        $rel = 'child';
        $model = D($name);
        $list = $model->where('id=' . $_GET['id'])->setField('status', 0);
        if ($list) {
            echo $this->ajax('1', "状态禁用成功！！", $rel, "", "");
        } else {
            echo $this->ajax('0', "状态禁用失败！！", $rel, "", "");
        }
    }

    //权限节点
    public function addnode()
    {
        $node = M('DbNode')->where('level !=3')->order('sort')->select();
        $this->assign('node', $node);
    }

}

?>