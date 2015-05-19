<?php

/**
 * @时间:20150422
 * @功能:赛事报名
 * @VIEW:op_join_game
 * @Author：liuliting
 */
class OpJoinGameAction extends CommonAction
{

    public function index()
    {
        $map = $this->_search();
        $this->assign('map', $map);
        if (method_exists($this, '_filter')) {
            $this->_filter($map);
        }
        $model = D('OpJoinGame');
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
        $model = D('OpJoinGame');
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
        if (isset ($_REQUEST ['user_name']) && $_REQUEST ['user_name'] != '') {
            $date['name'] = array('like', "%{$_REQUEST['user_name']}%");
            $ids = D('DbUser')->where($date)->getField('id', true);
            $map['user_id'] = array('in', $ids);
        }
        return $map;
    }

    /*
     * @功能：活动报名编辑页面
     * @时间：20150422
     */
    public function edit()
    {
        $model = D('OpJoinGame');
        $vo = $model->where('id=' . $_GET['id'])->find();
        $this->assign('vo', $vo);
        $this->display();
    }

    /*
     * @功能：赛事报名更新
     * @时间：20150422
     */
    function update()
    {
        $name = 'OpJoinGame';
        $model = D('OpJoinGame');
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
     * @功能：赛事报名删除
     * @时间：20150422
     */
    public function delAll(){
        $model = D('OpJoinGame');
        $pk=$model->getPk ();
        $data[$pk]=array('in', $_POST['ids']);
        $model->where($data)->delete();
        echo $this->ajax('1',"删除成功",$name,"","");
    }
    /*
     * @功能：赛事报名通过
     * @时间：20150422
     */
    public function audit(){
        $name = "OpJoinGame";
        $model = D($name);
        $date['id'] =$_GET['id'];
        $date['verify_date'] = date('Y-m-d H:i:s');
        $date['verify_state'] = 1;
        $result = $model->save($date);
        if(false!== $result){
            echo $this->ajax('1',"审核成功",$name,"","");
        }else{
            echo $this->ajax('0',"审核失败",$name,"","");
        }

    }
    /*
 * @功能：赛事报名不通过
 * @时间：20150422
 */
    public function Notaudit(){
        $name = "OpJoinGame";
        $model = D($name);
        $date['id'] =$_GET['id'];
        $date['verify_date'] = date('Y-m-d H:i:s');
        $date['verify_state'] = 2;
        $result = $model->save($date);
        if(false!== $result){
            echo $this->ajax('1',"滞留成功",$name,"","");
        }else{
            echo $this->ajax('0',"滞留失败",$name,"","");
        }

    }
}

?>