<?php

/**
 * @时间:20150422
 * @功能:赛事公告
 * @VIEW:db_game
 * @Author：liuliting
 */
class OpGameNoticeAction extends CommonAction
{

    public function index()
    {
        $map = $this->_search();
        $this->assign('map', $map);
        if (method_exists($this, '_filter')) {
            $this->_filter($map);
        }
        $model = D('OpGameNotice');
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
        $model = D('OpGameNotice');
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
        if (!empty($_REQUEST['key'])) {
            $where['title'] = array('like', "%{$_REQUEST['key']}%");
            $where['content'] = array('like', "%{$_REQUEST['key']}%");
            $where['_logic'] = 'or';
            $map['_complex'] = $where;
        }
        return $map;
    }

    /*
     * @功能：赛事新闻新增页面
     * @时间：20150422
     */
    function add()
    {
        $this->display();
    }

    /*
     * @功能：赛事新闻新增方法
     * @时间：20150422
     */
    function insert()
    {
        $model = D('OpGameNotice');
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
     * @功能：赛事新闻编辑页面
     * @时间：20150422
     */
    public function edit()
    {
        $model = D('OpGameNotice');
        $vo = $model->where('id=' . $_GET['id'])->find();
        $this->assign('vo', $vo);
        $this->display();
    }

    /*
     * @功能：赛事新闻更新
     * @时间：20150422
     */
    function update()
    {
        $name = 'OpGameNotice';
        $model = D('OpGameNotice');
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
        $model = D('OpGameNotice');
        $pk = $model->getPk();
        $data[$pk] = array('in', $_POST['ids']);
        $model->where($data)->delete();
        echo $this->ajax('1', "删除成功", $name, "", "");
    }

    /*
     * @功能：查找带回赛事
     * @时间：20150422
     */
    public function searchback()
    {
        $name = 'DbGame';
        $model = D($name);
        $map = $this->_busearch($name);
        $this->assign('map', $map);
        if (method_exists($this, '_filter')) {
            $this->_filter($map);
        }
        if (!empty ($model)) {
            $this->_bulist($model, $map, $order);
        }

        $this->display('searchback');
    }

    /*
     * @功能：查找带赛事  条件组装
     * @时间：20150422
     */
    protected function _busearch($name)
    {
        $model = D('Users');
        $map = array();
        $temp = $model->getDbFields();
        foreach ($temp as $key => $val) {
            if (isset ($_REQUEST [$val]) && $_REQUEST [$val] != '') {
                $map[$val] = array('like', "%{$_REQUEST[$val]}%");
            }
        }
        return $map;
    }

    /*查找带回list*/
    protected function _bulist($model, $map, $sortBy = '', $asc = true)
    {
        $pk = $model->getPk();
        $order .= $pk . " desc";
        //取得满足条件的记录数
        $count = $model->where($map)->count($pk);
        if ($count > 0) {
            import("ORG.Util.Page");
            //创建分页对象
            if (!empty ($_REQUEST ['listRows'])) {
                $listRows = $_REQUEST ['listRows'];
            } else {
                $listRows = '';
            }
            $p = new Page ($count, $listRows);
            $pageNum = empty($_REQUEST['numPerPage']) ? C('PAGE_LISTROWS') : $_REQUEST['numPerPage'];
            //分页查询数据
            $voList = $model->relation(true)->field('id,name,phone')->where($map)->order($order)->limit($pageNum)->page($_REQUEST[C('VAR_PAGE')])->select();
            //分页跳转的时候保证查询条件
            foreach ($map as $key => $val) {
                if (!is_array($val)) {
                    $p->parameter .= "$key=" . urlencode($val) . "&";
                }
            }
            //分页显示
            $page = $p->show();
            //模板赋值显示
            $this->assign('list', $voList);
            $this->assign('sort', $sort);
            $this->assign('order', $order);
            $this->assign('sortImg', $sortImg);
            $this->assign('sortType', $sortAlt);
            $this->assign("page", $page);

        }
        $this->assign('totalCount', $count);
        $pageNum = empty($_REQUEST['numPerPage']) ? C('PAGE_LISTROWS') : $_REQUEST['numPerPage'];
        $this->assign('numPerPage', $pageNum); //每页显示多少条
        $this->assign('currentPage', !empty($_REQUEST[C('VAR_PAGE')]) ? $_REQUEST[C('VAR_PAGE')] : 1);
        Cookie::set('_currentUrl_', __SELF__);
        return;
    }
}
?>