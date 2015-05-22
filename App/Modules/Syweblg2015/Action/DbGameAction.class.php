<?php

/**
 * @时间:20150422
 * @功能:赛事管理
 * @VIEW:db_game
 * @Author：liuliting
 */
class DbGameAction extends CommonAction
{

    public function index()
    {
        $map = $this->_search();
        $this->assign('map', $map);
        if (method_exists($this, '_filter')) {
            $this->_filter($map);
        }
        $model = D('DbGame');
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
        $model = D('DbGame');
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
     * @功能：赛事新增页面
     * @时间：20150422
     */
    function add()
    {
        $this->assign('dzSport', $this->DzSport());
        $this->display();
    }

    /*
     * @功能：赛事新增方法
     * @时间：20150422
     */
    function insert()
    {
        $model = D('DbGame');
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
     * @功能：赛事编辑页面
     * @时间：20150422
     */
    public function edit()
    {
        $model = D('DbGame');
        $vo = $model->where('id=' . $_GET['id'])->find();
        $this->assign('vo', $vo);
        //赛事详情
        $where['pid'] = $vo['sport_id'];
        $sport = D('DzSport')->where($where)->select();
        $this->assign('sport', $sport);
        $this->assign('dzSport', $this->DzSport());
        $this->display();
    }

    /*
     * @功能：赛事更新
     * @时间：20150422
     */
    function update()
    {
        $name = 'DbGame';
        $model = D('DbGame');
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
     * @功能：赛事删除
     * @时间：20150422
     */
    public function delAll()
    {
        $model = D('DbGame');
        $pk = $model->getPk();
        $data[$pk] = array('in', $_POST['ids']);
        $model->where($data)->delete();
        echo $this->ajax('1', "删除成功", $name, "", "");
    }

    /*
     * @功能：赛事分类
     * @时间：20150422
     */
    public function DzSport()
    {
        return D('DzSport')->field('id,name')->where('pid=0 and sport_type=1')->select();
    }

    /*
     * @功能：赛事详情
     * @时间：20150422
     */
    public function getSportAjax()
    {
        $pid = $_GET['id'];
        $where['pid'] = $pid;
        $where['sport_type'] = 1;
        $data = D('DzSport')->field('id,name')->where($where)->select();
        echo json_encode($data);
    }

    /*
    * @功能：赛事其他详细信息
    * @时间：20150422
    */
    public function detail()
    {
        $id = $_GET['id'];
        $list = D('DbGame')->where('id=' . $id)->find();
        $this->assign('vo', $list);
        $this->display();
    }

    /*
    * @功能：赛事其他详细信息编辑页面
    * @时间：20150422
    */
    public function other_edit()
    {
        $id = $_GET['id'];
        $field = $_GET['field'];
        $list = D('DbGame')->where('id=' . $id)->find();
        $this->assign('vo', $list);
        $this->assign('field', $field);
        $this->display();
    }

    /*
    * @功能：赛事其他详细信息编辑页面
    * @时间：20150422
    */
    public function other_update()
    {
        $name = "detail";
        $model = D('DbGame');
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
     * @功能：禁用赛事
     * @时间：20150422
     */
    public function forbid()
    {
        $name = "DbGame";
        $model = D('DbGame');
        $date['id'] = array('eq', $_GET['id']);
        $date['is_verify'] = 'F';
        $date['verify_date'] = date("Y-m-d H:i:s");
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
        $name = "DbGame";
        $model = D('DbGame');
        $date['id'] = array('eq', $_GET['id']);
        $date['is_verify'] = 'T';
        $date['verify_date'] = date("Y-m-d H:i:s");
        $list = $model->save($date);
        if (false !== $list) {
            echo $this->ajax('1', "赛事恢复成功", $name, "", "");
        } else {
            echo $this->ajax('0', "赛事恢复失败", $name, "", "");
        }
    }

    /*
     * @功能：赛事分组
     * @时间：20150422
     */
    public function group()
    {
        $model = D('OpGameGroup');
        $id = $_REQUEST['id'];
        $map['game_id'] = array('eq', $id);
        if ($_REQUEST ['group_name']) {
            $map['group_name'] = array('like', "%{$_REQUEST['group_name']}%");
        }
        $count = $model->where($map)->count();
        if ($count > 0) {
            import("ORG.Util.Page");
            if (!empty ($_REQUEST ['listRows'])) {
                $listRows = $_REQUEST ['listRows'];
            } else {
                $listRows = '';
            }
            $p = new Page ($count, $listRows);
            $pageNum = empty($_REQUEST['numPerPage']) ? C('PAGE_LISTROWS') : $_REQUEST['numPerPage'];
            $voList = $model->relation(true)->where($map)->order($order)->limit($pageNum)->page($_REQUEST[C('VAR_PAGE')])->select();
            //分页跳转的时候保证查询条件
            foreach ($map as $key => $val) {
                if (!is_array($val)) {
                    $p->parameter .= "$key=" . urlencode($val) . "&";
                }
            }
            $page = $p->show();
            $this->assign('list', $voList);
            $this->assign('sort', $sort);
            $this->assign('order', $order);
            $this->assign('sortImg', $sortImg);
            $this->assign('sortType', $sortAlt);
            $this->assign("page", $page);

        }
        $this->assign('totalCount', $count);
        $pageNum = empty($_REQUEST['numPerPage']) ? C('PAGE_LISTROWS') : $_REQUEST['numPerPage'];
        $this->assign('numPerPage', $pageNum);
        $this->assign('currentPage', !empty($_REQUEST[C('VAR_PAGE')]) ? $_REQUEST[C('VAR_PAGE')] : 1);
        Cookie::set('_currentUrl_', __SELF__);
        $this->display();
    }
    /*
     * @功能：添加分组页面
     * @时间：20150422
     */
    public function group_add(){
        $this->assign('game_id',$_GET['game_id']);
        $this->display();
    }
    /*
     * @功能：添加赛事分组
     * @时间：20150422
     */
    public function group_insert(){
        $model = D('OpGameGroup');
        $name="group";
        if (false === $model->create()) {
            $this->error($model->getError());
        }
        $list = $model->add();
        if ($list !== false) {
            echo $this->ajax('1', "添加成功", $name, "", "closeCurrent");
        } else {
            echo $this->ajax('0', "添加失败", $name, "", "closeCurrent");
        }
    }
    /*
     * @功能：添加分组页面
     * @时间：20150422
     */
    public function group_edit(){
        M('OpGameGroup')->where('id='.$_GET['id'])->find();

        $this->assign('game_id',$_GET['game_id']);
        $this->display();
    }
    /*
     * @功能：推荐赛事
     * @时间：20150422
     */
    public function  pull()
    {
        $name = $this->getActionName();
        $model = M($name);
        $list = $model->where('ID=' . $_GET['ID'])->setField($_GET['item'], 0);
        if ($list) {
            echo $this->ajax('1', "滞留成功", $name, "", "");
        } else {
            echo $this->ajax('0', "滞留失败", $name, "", "");
        }
    }

    public function  push()
    {
        $name = $this->getActionName();
        $model = M($name);
        $list = $model->where('ID=' . $_GET['ID'])->setField($_GET['item'], 1);
        if ($list) {
            echo $this->ajax('1', "顶贴成功", $name, "", "");
        } else {
            echo $this->ajax('0', "顶贴失败", $name, "", "");
        }
    }
}

?>