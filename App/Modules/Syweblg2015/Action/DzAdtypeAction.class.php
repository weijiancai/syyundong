<?php

/**
 * @时间:20150612
 * @功能:广告类型
 * @VIEW:dz_ad_type
 * @Author：liuliting
 */
class DzAdTypeAction extends CommonAction
{

    public function index()
    {
        $map = $this->_search();
        $this->assign('map', $map);
        if (method_exists($this, '_filter')) {
            $this->_filter($map);
        }
        $model = D('DzAdType');
        if (!empty ($model)) {
            $order = "id desc,";
            $this->_list($model, $map, $order);
        }
        $this->display();
    }

    /*
     * @功能：查询条件返回
     * @时间：20150422
     */
    protected function _search()
    {
        $model = D('DzAdType');
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
     * @功能：字段新增方法
     * @时间：20150612
     */
    function insert()
    {
        $model = D('DzAdType');
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
     * @功能：字段页面
     * @时间：20150422
     */
    public function edit()
    {
        $model = D('DzAdType');
        $vo = $model->where('id=' . $_GET['id'])->find();
        $this->assign('vo', $vo);
        $this->display();
    }

    /*
     * @功能：字段更新
     * @时间：20150422
     */
    function update()
    {
        $name = 'DzAdType';
        $model = D('DzAdType');
        if (false === $model->create()) {
            $this->error($model->getError());
        }
        $list = $model->save();
        if ($list !== false) {
            echo $this->ajax('1', "更新成功", $name, "", "closeCurrent");
        } else {
            echo $this->ajax('0', "更新失败", $name, "", "closeCurrent");
        }
    }

    /*
     * @功能：字段删除
     * @时间：20150422
     */
    public function delAll()
    {
        $model = D('DzAdType');
        $pk = $model->getPk();
        $data[$pk] = array('in', $_POST['ids']);
        $model->where($data)->delete();
        echo $this->ajax('1', "删除成功", $name, "", "");
    }
}
?>