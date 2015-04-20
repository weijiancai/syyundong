<?php
/*
 * 分组管理
 * @Author  liuliting
 */
class DbGroupAction extends CommonAction
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
        $node = M('DbGroup');
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
        /*         $groupClass=M("GroupClass")->where(array('status'=>1))->select();
                $array=array();
                foreach($groupClass as $val){
                    $array[$val['menu']]=$val['name'];
                }
                $this->menu=$array; */
        parent::index();

    }

    public function add()
    {
        $this->groupClass = M("GroupClass")->where(array('status' => 1))->select();
        $this->display();
    }
	
    public function nedit()
    {
        $name = 'LNode';
        $model = D($name);
        $id = $_REQUEST [$model->getPk()];
        $vo = $model->getById($id);
        $this->assign('vo', $vo);
        $this->display();
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

}

?>