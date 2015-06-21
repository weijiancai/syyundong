<?php

/**
 * @时间:20150422
 * @功能:推荐管理
 * @VIEW:op_recommend
 * @Author：liuliting
 */
class OpRecommendAction extends CommonAction
{

    public function index()
    {
        $map = $this->_search();
        $this->assign('map', $map);
        if (method_exists($this, '_filter')) {
            $this->_filter($map);
        }
        $model = D('OpRecommend');
        if (!empty ($model)) {
            $order = "";
            $order .= "input_date desc,";
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
        $model = D('OpRecommend');
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
     * @功能：推荐内容编辑页面
     * @时间：20150422
     */
    public function edit()
    {
        $model = D('OpRecommend');
        $vo = $model->where('id=' . $_GET['id'])->find();
        $this->assign('vo', $vo);
        $this->display();
    }

    /*
     * @功能：推荐更新
     * @时间：20150422
     */
    function update()
    {
        $model = D('OpRecommend');
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
     * @功能：推荐删除
     * @时间：20150422
     */
    public function delAll()
    {
        $model = D('OpRecommend');
        $pk = $model->getPk();
        $data['category'] = $_GET['category'];
        $data[$pk] = array('in', $_POST['ids']);
        $result = $model->where($data)->delete();
        if (false !== $result) {
            echo $this->ajax('1', "删除成功", $name, "", "");
        } else {
            echo $this->ajax('0', "删除失败", $name, "", "");
        }
    }
}

?>