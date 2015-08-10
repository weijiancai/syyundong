<?php
/**
 * @时间:20150421
 * @功能:广告位置
 * @VIEW:dz_ad_posotion
 * @Author：liuliting
 */
import('ORG.Util.Page');

class DzAdPositionAction extends CommonAction
{
    public function index()
    {
        $map = $this->_search();
        $this->assign('map', $map);
        if (method_exists($this, '_filter')) {
            $this->_filter($map);
        }
        $name = $this->getActionName();
        $model = D($name);
        if (!empty ($model)) {
            $order = "id asc,";
            $this->_list($model, $map, $order);
        }
        $this->display();
        return;
    }

    /*
     * @功能：返回查询条件
     * @时间：20150421
     */
    protected function _search()
    {
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
        $map['pid'] = array('eq', 0);
        return $map;
    }
    /*
    * @功能：新增广告位置页面
    * @时间：20150421
   */
    function add(){

        $this->display();
    }

    /*
     * @功能：新增页面位置方法
     * @时间：20150421
    */
    function insert()
    {
        $name = $this->getActionName();
        $model = D($name);
        if (false === $model->create()) {
            $this->error($model->getError());
        }
        $list = $model->add();
        if ($list !== false) {
            echo $this->ajax('1', "新增成功", $name, "", "closeCurrent");
        } else {
            echo $this->ajax('0', "新增失败", $name, "", "closeCurrent");
        }
    }

    /*
     * @功能：广告位置新增页面
     * @时间：201504021
     */
    public function second()
    {
        $list = D('DzAdPosition')->where('pid=' . $_GET['sid'] . ' and status=1')->select();
        $this->assign('list', $list);
        $model = New Model();
        $max_id = $model->query('select max(code) max_code from Dz_ad_position');
        $this->assign('max_code', $max_id[0]['max_code']+1);
		$this->assign('sid',$_GET['sid']);
        $this->display();
    }

    /*
     * @功能：广告位置新增方法
     * @时间：201504021
     */
    public function insert_second()
    {
        $model = D('DzAdPosition');
		$pid = $_GET['sid'];
        $where['pid'] = $_GET['sid'];
        //删除之前的赛事,插入新内容
        $model->where($where)->delete();
        foreach ($_POST['name'] as $key => $val) {
            $dataNode['name'] = $_POST['name'][$key];
            $dataNode['status'] = $_POST['status'][$key];
            $dataNode['code'] = $_POST['code'][$key];
            $dataNode['input_date'] = date('Y-m-d H:i:s');
            $dataNode['input_user'] = $_SESSION[C('USER_AUTH_KEY')];
            $dataNode['pid'] = $pid;
            $data[$key] = $dataNode;
        }
        $list = $model->addAll($data);
        if ($list !== false) {
            echo $this->ajax('1', "更新成功", $rel, "", "closeCurrent");
        } else {
            echo $this->ajax('0', "更新失败", $rel, "", "closeCurrent");
        }
    }

    /*
     * @功能：删除大赛事,详细赛事关联删除
     * @时间：20150421
    */
    public function delAll()
    {
        $model = D('DzAdPosition');
        $pk = $model->getPk();
        $data[$pk] = array('in', $_POST['ids']);
        if (false !== $model->where($data)->delete()) {
            $where['pid'] = array('in', $_POST['ids']);
            $model->where($where)->delete();
            echo $this->ajax('1', "删除成功", $name, "", "");
        }
    }

    /*
     * @功能：修改广告位置
     * @时间：20150421
     */
    function edit()
    {
        $name = $this->getActionName();
        $model = D($name);
        $vo = $model->find($_GET['id']);
        $this->assign('vo', $vo);
        $this->display();
    }
}

?>