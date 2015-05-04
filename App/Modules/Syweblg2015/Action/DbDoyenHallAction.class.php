<?php

/**
 * @时间:20150422
 * @功能:达仁堂
 * @VIEW:db_doyen_hall
 * @Author：liuliting
 */
class DbDoyenHallAction extends CommonAction
{

    public function index()
    {
        $map = $this->_search();
        $this->assign('map', $map);
        if (method_exists($this, '_filter')) {
            $this->_filter($map);
        }
        $model = D('DbDoyenHall');
        if (!empty ($model)) {
            $order = "input_date desc,";
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
        $model = D('DbDoyenHall');
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
     * @功能：新增达人
     * @时间：20150422
     */
    function add()
    {
        $this->display();
    }

    /*
     * @功能：达人新增方法
     * @时间：20150422
     */
    function insert()
    {
        $model = D('DbDoyenHall');
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
     * @功能：达人编辑页面
     * @时间：20150422
     */
    public function edit()
    {
        $model = D('OpGameNews');
        $vo = $model->where('id=' . $_GET['id'])->find();
        $this->assign('vo', $vo);
        $this->display();
    }

    /*
     * @功能：达人更新
     * @时间：20150422
     */
    function update()
    {
        $name = 'OpGameNews';
        $model = D('OpGameNews');
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
     * @功能：达人删除
     * @时间：20150422
     */
    public function delAll()
    {
        $model = D('OpGameNews');
        $pk = $model->getPk();
        $data[$pk] = array('in', $_POST['ids']);
        $model->where($data)->delete();
        echo $this->ajax('1', "删除成功", $name, "", "");
    }
    /*
     * @功能：达人图片预览
     * @时间：20150422
     */
    public function show()
    {
        /*$id = $_GET['id'];
        $image = D('DbDoyenHall')->where('id='.$id)->getField('image');
        $local_url=D('DbImages')->where('id='.$image)->getField('local_url');
        $this->assign('local_url',$local_url);*/
        $this->assign('local_url',$_GET['img']);
        $this->display();
    }

}
?>