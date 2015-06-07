<?php

/**
 * @时间:20150422
 * @功能:赛事管理
 * @VIEW:db_activity
 * @Author：liuliting
 */
class DbActivityAction extends CommonAction
{

    public function index()
    {
        $map = $this->_search();
        $this->assign('map', $map);
        if (method_exists($this, '_filter')) {
            $this->_filter($map);
        }
        $model = D('DbActivity');
        if (!empty ($model)) {
            $order = "";
            $order .= "input_date desc,";
            $this->_list($model, $map, $order);
        }
        $this->assign('dzSport', $this->DzSport());
        $this->display();
    }

    /*
     * @功能：查询条件返回
     * @时间：20150422
     */
    protected function _search()
    {
        $model = D('DbActivity');
        $map = array();
        $temp = $model->getDbFields();
        foreach ($temp as $key => $val) {
            if (isset ($_REQUEST [$val]) && $_REQUEST [$val] != '') {
                $_REQUEST [$val] = $_REQUEST[$val];
                $map[$val] = array('like', "%{$_REQUEST[$val]}%");
            }
        }
        return $map;
    }

    /*
     * @功能：活动页面
     * @时间：20150422
     */
    function add()
    {
        $this->assign('province', $this->getProvince());
        $this->assign('dzSport', $this->dzSport());
        $this->display();
    }

    /*
     * @功能：活动新增方法
     * @时间：20150422
     */
    function insert()
    {
        $model = D('DbActivity');
        if (false === $model->create()) {
            $this->error($model->getError());
        }
        $arr = $_POST['join_need_info'];
        $str="";
        for($i=0;$i<count($arr);$i++) {
            $str.=$arr[$i].',';
        }
        $str = ",".$str;
        $model->join_need_info = $str;
        $list = $model->add();
        if ($list !== false) {
            echo $this->ajax('1', "新增成功", $name, "", "closeCurrent");
        } else {
            echo $this->ajax('0', "新增失败", $name, "", "closeCurrent");
        }
    }

    /*
     * @功能：活动编辑页面
     * @时间：20150422
     */
    public function edit()
    {
        $model = D('DbActivity');
        $vo = $model->where('id=' . $_GET['id'])->find();
        $this->assign('vo', $vo);
        //活动城市
        $where['pid'] = $vo['province'];
        $city = D('DbRegion')->where($where)->select();
        $this->assign('city', $city);
        //活动区域
        $where['pid'] = $vo['city'];
        $venue = D('DbRegion')->where($where)->select();
        $this->assign('venue', $venue);
        $this->assign('province', $this->getProvince());
        $this->assign('dzSport', $this->dzSport());
        $this->display();
    }

    /*
     * @功能：活动更新
     * @时间：20150422
     */
    function update()
    {
        $name = 'DbActivity';
        $model = D('DbActivity');
        if (false === $model->create()) {
            $this->error($model->getError());
        }
        $arr = $_POST['join_need_info'];
        $str="";
        for($i=0;$i<count($arr);$i++) {
            $str.=$arr[$i].',';
        }
        $str = ",".$str;
        $model->join_need_info = $str;
        $list = $model->save();
        if ($list !== false) {
            echo $this->ajax('1', "更新成功", $name, "", "closeCurrent");
        } else {
            echo $this->ajax('0', "更新失败", $name, "", "closeCurrent");
        }
    }
    /*
     * @功能：活动删除
     * @时间：20150422
     */
    public function delAll(){
        $model = D('DbActivity');
        $pk=$model->getPk ();
        $data[$pk]=array('in', $_POST['ids']);
        $model->where($data)->delete();
        echo $this->ajax('1',"删除成功",$name,"","");
    }
    /*
     * @功能：活动分类
     * @时间：20150422
     */
    public function DzSport()
    {
        return D('DzSport')->field('id,name')->where('pid=0 and sport_type=2')->select();
    }

    /*
     * @功能：活动报名填写信息
     * @时间：20150422
     */
    public function getCheck(){
        $model = D('DbActivity');
        $where['id'] =$_GET['id'];
        $vo = $model->where($where)->find();
        $code = explode(",",$vo['join_need_info']);
        echo json_encode($code);
    }

    /*
     * @功能：禁用赛事
     * @时间：20150422
     */
    public function forbid()
    {
        $name = "DbActivity";
        $model = D('DbActivity');
        $date['id'] = array('eq', $_GET['id']);
        $date['is_verify'] = 'T';
        $list = $model->save($date);
        if (false !== $list) {
            echo $this->ajax('1', "赛事禁止成功", $name, "", "");
        } else {
            echo $this->ajax('0', "赛事禁止失败", $name, "", "");
        }
    }

    /*
     * @功能：禁用恢复
     * @时间：20150422
     */
    public function resume()
    {
        $name = "DbActivity";
        $model = D('DbActivity');
        $date['id'] = array('eq', $_GET['id']);
        $date['is_verify'] = 'F';
        $list = $model->save($date);
        if (false !== $list) {
            echo $this->ajax('1', "赛事恢复成功", $name, "", "");
        } else {
            echo $this->ajax('0', "赛事恢复失败", $name, "", "");
        }
    }
}

?>