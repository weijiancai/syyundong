<?php
/**
 * @时间:20150422
 * @功能:活动、场馆分类
 * @VIEW:dz_sport
 * @Author：liuliting
 */
import('ORG.Util.Page');

class DzActivityVenueAction extends CommonAction
{
    public function index()
    {
        $map = $this->_search();
        $this->assign('map', $map);
        if (method_exists($this, '_filter')) {
            $this->_filter($map);
        }
        $model = D('DzSport');
        if (!empty ($model)) {
            $order = "sport_type asc,";
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
        $model = D('DzSport');
        $map = array();
        $temp = $model->getDbFields();
        foreach ($temp as $key => $val) {
            if (isset ($_REQUEST [$val]) && $_REQUEST [$val] != '') {
                $_REQUEST [$val] = $_REQUEST[$val];
                $map[$val] = array('like', "%{$_REQUEST[$val]}%");
            }
        }
        if (!$_REQUEST['sport_type']) {
            $map['sport_type'] = array(array('eq', 3), array('eq', 2), 'or');
        }
        $map['pid'] = array('eq', 0);
        return $map;
    }

    /*
    * @功能：新增活动、场馆页面
    * @时间：20150421
   */
    function add()
    {
        $model = New Model();
        $max_id = $model->query('select max(id) max_id from dz_sport');
        $this->assign('max_id', $max_id[0]['max_id'] + 1);
        $this->display();
    }

    /*
     * @功能：新增活动、场馆方法
     * @时间：20150421
    */
    function insert()
    {
        $model = D('DzSport');
        if (false === $model->create()) {
            $this->error($model->getError());
        }
        $list = $model->add();
        if ($list !== false) {
            echo $this->ajax('1', "更新成功", $name, "", "closeCurrent");
        } else {
            echo $this->ajax('0', "更新失败", $name, "", "closeCurrent");
        }
    }

    /*
     * @功能：删除大赛事,详细赛事关联删除
     * @时间：20150421
    */
    public function delAll()
    {
        $model = D('DzSport');
        $pk = $model->getPk();
        $data[$pk] = array('in', $_POST['ids']);
        if (false !== $model->where($data)->delete()) {
            echo $this->ajax('1', "删除成功", $name, "", "");
        } else {
            echo $this->ajax('1', "删除失败", $name, "", "");
        }
    }

    /*
     * @功能：修改赛事页面
     * @时间：20150421
     */
    function edit()
    {
        $model = D('DzSport');
        $vo = $model->find($_GET['id']);
        $this->assign('vo', $vo);
        $this->display();
    }

    /*
     * @功能：修改赛事方法
     * @时间：20150421
     */
    function update()
    {
        $model = D('DzSport');
        if (false === $model->create()) {
            $this->error($model->getError());
        }
        $list = $model->save();
        if (false !== $list) {
            echo $this->ajax('1', "编辑成功", $name, "", "closeCurrent");
        } else {
            echo $this->ajax('0', "编辑失败", $name, "", "closeCurrent");
        }
    }

    /*
     * @功能：场馆活动更新页面
     * @时间：201504021
     */
    public function second()
    {
        $sport_type = $_GET['st_id'];
        $list = D('DzSport')->where('sport_type=' . $sport_type)->select();
        $model = New Model();
        $max_id = $model->query('select max(id) max_id from dz_sport');
        $this->assign('list', $list);
        $this->assign('st_id', $sport_type);
        $this->assign('max_id', $max_id[0]['max_id']);
        $this->display();
    }

    /*
     * @功能：详细赛事新增方法
     * @时间：201504021
     */
    public function insert_second()
    {
        $model = D('DzSport');
        $where['sport_type'] = $_GET['st_id'];
        //删除之前的赛事,插入新内容
        $model->where($where)->delete();
        foreach ($_POST['id'] as $key => $val) {
            $dataNode['id'] = $val;
            $dataNode['name'] = $_POST['name'][$key];
            $dataNode['sport_show'] = null;
            $dataNode['sport_type'] = $_GET['st_id'];
            $dataNode['input_date'] = date('Y-m-d H:i:s');
            $dataNode['input_user'] = $_SESSION[C('USER_AUTH_KEY')];
            $dataNode['level'] = 1;
            $dataNode['pid'] = 0;
            $data[$key] = $dataNode;
        }
        $list = $model->addAll($data);
        if ($list !== false) {
            echo $this->ajax('1', "更新成功", $rel, "", "closeCurrent");
        } else {
            echo $this->ajax('0', "更新失败", $rel, "", "closeCurrent");
        }
    }
}

?>