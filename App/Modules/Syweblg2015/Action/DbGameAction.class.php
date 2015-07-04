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
        $this->assign('province', $this->getProvince());
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
        //活动城市
        $where['pid'] = $vo['province'];
        $city = D('DbRegion')->where($where)->select();
        $this->assign('city', $city);
        //活动区域
        $where['pid'] = $vo['city'];
        $venue = D('DbRegion')->where($where)->select();
        $this->assign('venue', $venue);
        $this->assign('province', $this->getProvince());
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
        $result = $model->where($data)->delete();
        if (false !== $result) {
            echo $this->ajax('1', "删除成功", $name, "", "");
        } else {
            echo $this->ajax('0', "删除失败", $name, "", "");
        }
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
        $model = New Model();
        $list = $model->query('select game_id,field_id,sort_num,field_value,
                      (select name from db_game where id = game_id) game_name,
                      (select name from mt_field_define where id = field_id) field_name
                       from op_game_field where game_id='.$_GET['id']);
        $this->assign('list', $list);
        $this->assign('game_id',$_GET['id']);
        $this->display();
    }

    /*
    * @功能：赛事其他详细信息新增页面
    * @时间：20150422
    */
    public function other_add()
    {
        //字段名称
        $this->assign('field',M('MtFieldDefine')->field('id,name,code')->where("category='game'")->select());
        //赛事名称
        $list = D('DbGame')->field('id,name')->where('id=' . $_GET['id'])->find();
        //排序
        $this->assign('max_sort',M('OpGameField')->where('game_id='.$_GET['id'])->max('sort_num')+1);
        $this->assign('vo', $list);
        $this->display();
    }
    /*
    * @功能：赛事其他详细信息新增方法
    * @时间：20150612
    */
    public function other_insert()
    {
        $model = D('OpGameField');
        $name = "detail";
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
    * @功能：赛事其他详细信息编辑页面
    * @时间：20150422
    */
    public function other_edit()
    {
        $model = New Model();
        $vo = $model->query('select game_id,field_id,sort_num,field_value,key_word,
                      (select name from db_game where id = game_id) game_name,
                      (select name from mt_field_define where id = field_id) field_name
                       from op_game_field where game_id='.$_GET['game_id'].' and field_id='.$_GET['field_id']);
        $this->assign('other', $vo);
        $this->display();
    }

    /*
    * @功能：赛事其他详细信息编辑页面
    * @时间：20150422
    */
    public function other_update()
    {
        $name = "detail";
        $date['game_id']=$_POST['game_id'];
        $date['field_id']=$_POST['field_id'];
        $model = D('OpGameField');
        if (false === $model->create()) {
            $this->error($model->getError());
        }
        $list = $model->where($date)->save();
        if ($list !== false) {
            echo $this->ajax('1', "更新成功", $name, "", "closeCurrent");
        } else {
            echo $this->ajax('0', "更新失败", $name, "", "closeCurrent");
        }
    }
    /*
     * @功能：字段定义删除
     * @时间：20150422
     */
    public function other_delete()
    {
        $name='detail';
        $model = D('OpGameField');
        $date['game_id']=$_GET['game_id'];
        $date['field_id']=$_GET['field_id'];
        $result = $model->where($date)->delete();
        if (false !== $result) {
            echo $this->ajax('1', "删除成功", $name, "", "");
        } else {
            echo $this->ajax('0', "删除失败", $name, "", "");
        }
    }
    /*
     * @功能：字段定义删除
     * @时间：20150422
     */
    public function Field_delAll()
    {
        $model = D('MtFieldDefine');
        $pk = $model->getPk();
        $data[$pk] = array('in', $_POST['ids']);
        $result = $model->where($data)->delete();
        if (false !== $result) {
            echo $this->ajax('1', "删除成功", $name, "", "");
        } else {
            echo $this->ajax('0', "删除失败", $name, "", "");
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
     * @功能：批量审核
     * @时间：20150612
     */
    public function statusAll()
    {
        $model = M('DbGame');
        $date['id'] = array('in', $_POST['ids']);
        $date['is_verify']= 'T';
        $date['verify_date'] = date("Y-m-d H:i:s");
        $list = $model->save($date);
        if (false !== $list) {
            echo $this->ajax('1', "审核成功", $name, "", "");
        } else {
            echo $this->ajax('0', "审核失败", $name, "", "");
        }
    }
    /*
     * @功能：赛事分数
     * @时间：20150630
     */
    public function score()
    {
        $model = D('OpGameScore');
        $id = $_REQUEST['id'];
        $map['game_id'] = array('eq', $id);
        if ($_REQUEST ['user_name']) {
            $map['user_name'] = array('like', "%{$_REQUEST['user_name']}%");
        }
        /*if ($_REQUEST ['game_id']) {
            $map['game_id'] = array('eq',$_REQUEST['game_id']);
        }*/
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
     * @功能：添加分数页面
     * @时间：20150422
     */
    public function score_add()
    {
        $this->assign('game_id', $_GET['game_id']);
        $this->assign('game_group',M('OpGameGroup')->where('game_id='.$_GET['game_id'])->select());
        $this->display();
    }
    /*
     * @功能：添加分数方法
     * @时间：20150704
     */
    public function score_insert(){
        $model = D('OpGameScore');
        $name = "score";
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
     * @功能：编辑分数页面
     * @时间：20150704
     */
    public function score_edit(){
        $vo = M('OpGameScore')->where('id=' . $_GET['id'])->find();
        $this->assign('game_group',M('OpGameGroup')->where('game_id='.$vo['game_id'])->select());
        $this->assign('vo', $vo);
        $this->display();
    }
    /*
     * @功能：赛事分组更新
     * @时间：20150422
     */
    public function score_update(){
        $this->common_update('OpGameScore','score');
    }
    /*
     * @功能：选手分数删除
     * @时间：20150704
     */
    public function score_del(){
        $this->common_del('OpGameScore','score');
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
    public function group_add()
    {
        $this->assign('game_id', $_GET['game_id']);
        $this->display();
    }

    /*
     * @功能：添加赛事分组
     * @时间：20150422
     */
    public function group_insert()
    {
        $model = D('OpGameGroup');
        $name = "group";
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
     * @功能：编辑分组页面
     * @时间：20150422
     */
    public function group_edit()
    {
        $vo = M('OpGameGroup')->where('id=' . $_GET['id'])->find();
        $this->assign('vo', $vo);
        $this->display();
    }

    /*
     * @功能：赛事分组更新
     * @时间：20150422
     */
    function group_update()
    {
        $name = 'group';
        $model = D('OpGameGroup');
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
     * @功能：赛事分组删除
     * @时间：20150422
     */
    public function group_del()
    {
        $this->common_del('OpGameGroup','group');
    }

    /*
     * @功能：精选赛事
     * @时间：20150422
     */
    public function  ChoiceGame()
    {
        $model = D('OpRecommend');
        $list_id=M('OpRecommend')->where("category='choice'")->getField('gc_id',true);
        foreach($_POST['ids'] as $k=>$value){
            $result = array_search($value,$list_id);
            if(in_array($value,$list_id)){
                unset($_POST['ids'][array_search($value,$_POST['ids'])]);
            };
        }
        sort($_POST['ids']);
        foreach ($_POST['ids'] as $key => $val) {
            $date[$key]['gc_id']=  $val;
            $date[$key]['recommend_type'] = 'game';
            $date[$key]['input_date'] = date('Y-m-d H:i:s');
            $date[$key]['input_user'] = $_SESSION[C('USER_AUTH_KEY')];
            $date[$key]['category'] = 'choice';
        }
        $list = $model->addAll($date);
        if (false !== $list) {
            echo $this->ajax('1', "操作成功", $name, "", "");
        } else {
            echo $this->ajax('0', "操作失败", $name, "", "");
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
    /*
     * @功能：公共修改方法
     * @时间：20150422
     */
    function common_update($model,$name)
    {
        $model = D($model);
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
     * @功能：公共删除方法
     * @时间：20150422
     */
    public function common_del($model,$name)
    {
        $model = D($model);
        $pk = $model->getPk();
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