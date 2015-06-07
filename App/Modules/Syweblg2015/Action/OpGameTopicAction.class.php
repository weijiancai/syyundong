<?php

/**
 * @时间:20150422
 * @功能:赛事话题
 * @Table:op_game_topic
 * @Author：liuliting
 */
class OpGameTopicAction extends CommonAction
{

    public function index()
    {
        $map = $this->_search();
        $this->assign('map', $map);
        if (method_exists($this, '_filter')) {
            $this->_filter($map);
        }
        $model = D('OpGameTopic');
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

        $model = D('OpGameTopic');
        $map = array();
        $temp = $model->getDbFields();
        foreach ($temp as $key => $val) {
            if (isset ($_REQUEST [$val]) && $_REQUEST [$val] != '') {
                $_REQUEST [$val] = $_REQUEST[$val];
                $map[$val] = array('like', "%{$_REQUEST[$val]}%");
            }
        }
        if (isset ($_REQUEST ['game_id']) && $_REQUEST ['game_id'] != '') {
            $map['game_id'] = array('eq', "{$_REQUEST['game_id']}");
        } else {
            if (isset ($_REQUEST ['game_name']) && $_REQUEST ['game_name'] != '') {
                $date['name'] = array('like', "%{$_REQUEST['game_name']}%");
                $ids = D('DbGame')->where($date)->getField('id', true);
                $map['game_id'] = array('in', $ids);
            }
        }
        if (!empty($_REQUEST['content'])) {
            $map['content'] = array('like', "%{$_REQUEST['content']}%");
        }
        return $map;
    }


    /*
     * @功能：话题编辑页面
     * @时间：20150422
     */
    public function edit()
    {
        $model = D('OpGameTopic');
        $vo = $model->where('id=' . $_GET['id'])->find();
        $this->assign('vo', $vo);
        $this->display();
    }

    /*
     * @功能：话题更新
     * @时间：20150422
     */
    function update()
    {
        $name = 'OpGameTopic';
        $model = D('OpGameTopic');
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
     * @功能：赛事新闻删除
     * @时间：20150422
     */
    public function delAll()
    {
        $model = D('OpGameTopic');
        $pk = $model->getPk();
        $data[$pk] = array('in', $_POST['ids']);
        $model->where($data)->delete();
        echo $this->ajax('1', "删除成功", $name, "", "");
    }

}
?>