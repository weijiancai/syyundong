<?php
/**
 * @时间:20150615
 * @功能:省份区域
 * @VIEW:db_region
 * @Author：liuliting
 */

class DbRegionAction extends CommonAction
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
            $order = "sort asc,";
            $this->_list($model, $map, $order);
        }
        $this->display();
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
        /* $map['level'] = array('in', array('1','2','3')); */
		$map['level'] = array('eq', 1);
        return $map;
    }
    /*
    * @功能：新增省份页面
    * @时间：20150421
   */
    function add(){
        $model = New Model();
        $max_id = $model->query('select max(id) max_id from db_region');
        $this->assign('max_id', $max_id[0]['max_id']+1);
        $this->display();
    }

    /*
     * @功能：市区新增页面
     * @时间：201504021
     */
    public function second()
    {
        $sid = $_GET['sid'];
        $list = D('DbRegion')->where('pid=' . $sid )->order('sort asc')->select();
        $model = New Model();
        $max_id = $model->query('select max(id) max_id from db_region');
        $this->assign('list', $list);
        $this->assign('sid', $sid);
        $this->assign('max_id', $max_id[0]['max_id']);
        $this->display();
    }

    /*
     * @功能：详细市区新增方法
     * @时间：201504021
     */
    public function insert_second()
    {
        $model = D('DbRegion');
        $where['pid'] = $_GET['sid'];
        //删除之前的赛事,插入新内容
        $model->where($where)->delete();
        foreach ($_POST['id'] as $key => $val) {
            $dataNode['id'] = $val;
            $dataNode['name'] = $_POST['name'][$key];
            $dataNode['sort'] = $_POST['sort'][$key];
            $dataNode['level'] = $_POST['level'][$key];
            $dataNode['pid'] = $_GET['sid'];
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
        $model = D('DbRegion');
        $pk = $model->getPk();
        $data[$pk] = array('in', $_POST['ids']);
        if (false !== $model->where($data)->delete()) {
            $where['pid'] = array('in', $_POST['ids']);
            $model->where($where)->delete();
            echo $this->ajax('1', "删除成功", $name, "", "");
        }
    }
}

?>