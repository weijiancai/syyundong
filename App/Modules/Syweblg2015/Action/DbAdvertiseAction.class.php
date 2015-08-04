<?php

/*
 * 图片广告
 * @Author  liuliting
 */

class DbAdvertiseAction extends CommonAction
{
    /*
     *框架首页
     */
    public function index()
    {
        $name = 'MAds';
        $map = $this->_search('MAds');
        $this->assign('map', $map);
        if (method_exists($this, '_filter')) {
            $this->_filter($map);
        }
        $model = D($name);
        $model = D($name);
        if (!empty ($model)) {
            $order = "(((ustime + adstime*86400)-(UNIX_TIMESTAMP(NOW()))) / 3600 / 24 ) asc";
            $this->_list($model, $map, $order);
        }
        $this->info();
        $this->getArea();
        $this->saleType();
        $this->UpdateMLife();
        $this->assign('adslist', $this->AdsClassInfo());
        $this->assign('userinfo', $this->LuserInfo());
        $this->display();
    }

    protected function _search($name)
    {
        $model = D($name);
        $map = array();
        $temp = $model->getDbFields();
        foreach ($temp as $key => $val) {
            if (isset ($_REQUEST [$val]) && $_REQUEST [$val] != '') {
                $_REQUEST [$val] = $_REQUEST[$val];
                $map[$val] = array('like', "%{$_REQUEST[$val]}%");
                if ($val == 'tstation') {
                    $map[$val] = array('eq', $_REQUEST[$val]);
                }
                if ($val == 'tname') {
                    $map[$val] = array('eq', $_REQUEST[$val]);
                }
            }
        }
        if (isset ($_REQUEST ['ID']) && $_REQUEST ['ID'] != '') {
            $map['ID'] = array('eq', $_REQUEST['ID']);
        }
        $time = 2592000 + time();
        if ($_REQUEST ['ashow'] == "") {
            $map['ashow'] = array('neq', 2);
        }
        //通过管理员等级判断广告显示页面
        $userinfo = $this->LuserInfo();
        if ($userinfo['level'] == 2) {
            $map['clientmanger'] = array(array('eq', $userinfo['code']), array('eq', ''), 'or');
        }
        return $map;
    }

    /**
     * +----------------------------------------------------------
     * 根据表单生成查询条件
     * 进行列表过滤
     * +----------------------------------------------------------
     */
    protected function _list($model, $map, $order, $sortBy = '', $asc = true)
    {
        $pk = $model->getPk();
        $dbArray = $model->getDbFields();
        unset($dbArray['_autoinc']); // _autoinc 表示主键是否自动增长类型
        unset($dbArray['_pk']); //_pk 表示主键字段名称
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
            $voList = $model->relation(true)->where($map)->order($order)->limit($pageNum)->page($_REQUEST[C('VAR_PAGE')])->select();

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

    /**
     *    新增广告页面
     * @date   2014-09-30
     * @author liuliting
     */
    public function AdsAdd()
    {
        $this->class1();
        $this->zhaopin();
        $this->info();
        $this->type();
        $this->typed();
        $this->getArea();
        $this->saleType();
        $this->assign('userinfo', $this->LuserInfo());
        $zjxq = M('ZjXq');
        $xq = $zjxq->where('qy=' . $aid)->select();
        $this->assign('xq', $xq);
        //状态信息
        $sta = $this->backstate('info_status');
        $this->assign('sta', $sta);
        $this->display();
    }

    /**
     *  新增广告方法
     * @date   2014-09-30
     * @author liuliting
     */
    function AdsInsert()
    {
        $rel = "AdsInfo";
        $name = 'MAds';
        $model = D($name);
        //生成生活信息  14-06-24  liuliting
        if ((trim(I('post.Topic')) != '') || (trim(I('post.Topic')) != NULL)) {
            $life = D('LifeInfo');
            $data['qy'] = I('post.qy');
            $data['class1'] = I('post.Class1');
            if ($_POST['ms'] != null) {
                $data['class2'] = $_POST['ms'][0];
            } else {
                $data['class2'] = $_POST['class2'];
            }
            $data['Topic'] = I('post.Topic');
            $data['Content'] = I('post.Content');
            $data['ContactMan'] = I('post.ContactMan');
            //	$data['Tel'] = trim(I('post.Tel'));
            if ((substr(trim(I('post.Tel')), 0, 1)) == 0) {
                $data['Tel'] = substr(trim(I('post.Tel')), 0, 12);
            } else {
                $data['Tel'] = substr(trim(I('post.Tel')), 0, 11);
            }
            $data['State'] = I('post.State');
            $data['ip'] = get_client_ip();
            $data['uid'] = randnum(8, 0, 9);
            $data['autostate'] = I('post.autostate');
            $data['lx'] = I('post.lx');
            $data['lc'] = I('post.lc');
            $data['hx'] = I('post.hx');
            $data['zx'] = I('post.zx');
            $data['mj'] = I('post.mj');
            $data['jg'] = I('post.jg');
            $data['xq'] = getXq(I('post.xq'));
            $data['color'] = I('post.color');
            $data['nd'] = I('post.nd');
            $data['gls'] = I('post.gls');
            $data['bsq'] = I('post.bsq');
            $data['pl'] = I('post.pl');
            $data['brand'] = I('post.brand');
            $data['types'] = I('post.types');
            $data['qq'] = I('post.qq');
            $data['cause'] = I('post.cause');
            if ($_POST['Class1'] == 104) {
                $arr = $_POST['ms'];
                $str = "";
                for ($i = 0; $i < count($arr); $i++) {
                    $str .= $arr[$i] . ',';
                }
            }
            $str = ',' . $str;
            $data['ms'] = $str;
            $data['CreateTime'] = $_POST['CreateTime'];
            $data['auditer'] = $_SESSION['account'];
            $result = $life->add($data);
        }
        //广告信息
        $up = $this->uploads('qz');
        if (false === $model->create()) {
            $this->error($model->getError());
        }
        if ($up[0]) {
            $info = $up[1];
            $model->adsimg = $info[0]['savename']; // 保存上传的照片根据需要自行组装
            $model->adsimg1 = $info[1]['savename'];
        }
        $model->uip = $_SESSION['ip'];
        $model->uname = $_SESSION['account'];
        $model->ustime = time();
        $model->adsclick = 1;
        $model->adspx = $model->max('adspx') + 1;
        $_POST['adslink1'] = trim($_POST['adslink1']);
        $_POST['adslink'] = trim($_POST['adslink']);
        $model->alid = $result;
        if (empty($_POST['adslink1'])) {
            $model->adslink1 = NUll;
        }
        if (empty($_POST['adslink'])) {
            $model->adslink = NUll;
        }
        if ($_POST['bigtype'] != 3) {
            $model->ashow = 0;
        } else {
            $model->ashow = 1;
        }
        $list = $model->add();
        if ($list !== false) {
            echo $this->ajax('1', "新增成功！！", $rel, "", "closeCurrent");
        } else {
            echo $this->ajax('0', "新增失败！！！", $rel, "", "closeCurrent");
        }
    }

    /*
     *查找单个广告
     */
    function AdsEdit()
    {
        $model = D('MAds');
        $ID = $_REQUEST [$model->getPk()];
        $vo = $model->find($ID);
        $this->assign('vo', $vo);
        $list = $this->adtype();
        $this->assign('list', $list);
        $this->info();
        //广告位置
        $mtype = M('MAdsType');
        $where['adsstation'] = $vo['tstation'];
        $arr = $mtype->where($where)->select();
        $this->assign('ttype', $arr);
        $this->getArea();
        //商家一级分类
        $this->saleType();
        //商家二级分类
        if ($vo['wtype1'] != 0) {
            $stype = M('ZjSaletype');
            $data['parent'] = $vo['wtype1'];
            $sarr = $stype->where($data)->select();
            $this->assign('stype', $sarr);
        }
        $this->type();
        //查询生活信息
        if (($vo['alid'] != ' ') && ($vo['alid'] != NULL)) {
            $life = D('LifeInfo')->where('ID=' . $vo['alid'])->find();
        }
        $this->assign('life', $life);
        $this->class1();
        //默认显示的二级分类
        $class2 = M('Class2');
        if (($life['Class1'] != ' ') && ($life['Class1'] != NULL)) {
            $arr = $class2->where('Class1=' . $life['Class1'])->select();
        }
        $this->assign('class2', $arr);
        $this->zhaopin();
        $this->typed();
        //小区信息
        if ($life['Class1'] == '117') {
            $area = M('Area');
            $data['qy'] = $life['qy'];
            $aid = $area->where($data)->getField('ID');
            $zjxq = M('ZjXq');
            $xq = $zjxq->where('qy=' . $aid)->select();
            $this->assign('xq', $xq);
        }
        //状态信息
        $sta = $this->backstate('info_status');
        $this->assign('sta', $sta);

        //权限判断
        $where['module'] = $this->getActionName();
        $where['userid'] = $_SESSION[C('USER_AUTH_KEY')];
        $list = D('Page')->where($where)->find();
        if ($list) {
            $data['pid'] = $list['nodeid'];
            $data['userid'] = $_SESSION [C('USER_AUTH_KEY')];
            $data['level'] = 4;
            $info = D('Page')->where($data)->getField('module', true);
            foreach ($info as $value => $key) {
                $str .= $key . ',';
            }
        }
        $this->assign('module', $str);
        $this->assign('userinfo', $this->LuserInfo());
        $code = M("MAdsType")->where('ID=' . $vo['tname'])->getField('code');
        //计算广告天数
        $now = time();
        $end = $vo['ustime'] + $vo['adstime'] * 86400;
        $t = round(($now - $end) / 3600 / 24); //当前时间  - 到期时间
        $this->assign('atime', $t);
        $this->assign('code', $code);
        $this->display();
    }

    /*
     *修改广告
     */
    function AdsUpdate()
    {
        $model = D('MAds');
        $rel = "AdsInfo";
        $alid = $_POST['alid'];
        if ((trim(I('post.Topic')) != '') || (trim(I('post.Topic')) != NULL)) {
            if ($alid) {
                $vos = M('LifeInfo')->where('ID=' . $alid)->find();
            }
            $value = '';
            $life = D('LifeInfo');
            $data['qy'] = I('post.qy');
            $data['class1'] = I('post.Class1');
            if ($_POST['ms'] != null) {
                $data['class2'] = $_POST['ms'][0];
            } else {
                $data['class2'] = $_POST['class2'];
            }
            $data['Topic'] = I('post.Topic');
            $data['Content'] = I('post.Content');
            $data['ContactMan'] = I('post.ContactMan');
            if ((substr(trim(I('post.Tel')), 0, 1)) == 0) {
                $data['Tel'] = substr(trim(I('post.Tel')), 0, 12);
            } else {
                $data['Tel'] = substr(trim(I('post.Tel')), 0, 11);
            }
            $data['State'] = I('post.State');
            $data['ip'] = get_client_ip();
            $data['uid'] = randnum(8, 0, 9);
            $data['autostate'] = I('post.autostate');
            $data['lx'] = I('post.lx');
            $data['lc'] = I('post.lc');
            $data['hx'] = I('post.hx');
            $data['zx'] = I('post.zx');
            $data['mj'] = I('post.mj');
            $data['jg'] = I('post.jg');
            $data['xq'] = getXq(I('post.xq'));
            $data['color'] = I('post.color');
            $data['nd'] = I('post.nd');
            $data['gls'] = I('post.gls');
            $data['bsq'] = I('post.bsq');
            $data['pl'] = I('post.pl');
            $data['brand'] = I('post.brand');
            $data['types'] = I('post.types');
            $data['qq'] = I('post.qq');
            $data['cause'] = I('post.cause');
            if ($_POST['Class1'] == 104) {
                $arr = $_POST['ms'];
                $str = "";
                for ($i = 0; $i < count($arr); $i++) {
                    $str .= $arr[$i] . ',';
                }
            }
            $str = ',' . $str;
            $data['ms'] = $str;
            $data['CreateTime'] = $_POST['CreateTime'];
            $data['audittime'] = date('Y-m-d H:i:s');
            $data['auditer'] = $_SESSION['account'];
            if (empty($vos)) {
                //新增生活信息
                if (!empty($_POST['Topic'])) {
                    $result = $life->add($data);
                    $value = $result;
                }
            } else {
                $life->where('ID=' . $alid)->save($data);
                $value = $alid;
            }
        }
        if ($alid) {
            if ((!empty($_POST['bigtype'])) && ($_POST['bigtype'] != 1)) {
                D('LifeInfo')->where('ID=' . $alid)->setField('autostate', NULL);
                D('LifeInfo')->where('ID=' . $alid)->setField('State', 5);
            }
        }
        //新增广告
        $up = $this->uploads('qz');
        if (false === $model->create()) {
            $this->error($model->getError());
        }
        if ($up[0]) {
            $info = $up[1];
            if ((!empty($_POST['p1'])) && (!empty($_POST['p2']))) {
                $model->adsimg = $info[0]['savename']; // 保存上传的照片根据需要自行组装
                $model->adsimg1 = $info[1]['savename'];
            } elseif ((empty($_POST['p1'])) && (!empty($_POST['p2']))) {
                $model->adsimg = $_POST['default'];
                $model->adsimg1 = $info[0]['savename'];
            } else {
                $model->adsimg = $info[0]['savename'];
                $model->adsimg1 = $_POST['default1'];
            }
        } else {
            $model->adsimg = $_POST['default'];
            $model->adsimg1 = $_POST['default1'];
        }
        $model->adsname = $_POST['adsname'];
        $model->bigtype = $_POST['bigtypes'];
        $model->adstime = $_POST['adstimes'];
        $model->alid = $value;
        $model->uip = $_SESSION['ip'];
        $model->uname = $_SESSION['account'];
        $model->uetime = time();
        $_POST['adslink1'] = trim($_POST['adslink1']);
        $_POST['adslink'] = trim($_POST['adslink']);
        if ($_POST['bigtypes'] == 3) {
            $model->adsimg1 = "";
            $model->adslink = "";
        }
        if (empty($_POST['adslink1'])) {
            $model->adslink1 = NUll;
        }
        if (empty($_POST['adslink'])) {
            $model->adslink = NUll;
        }
        //得到管理员等级
        $map['id'] = $_SESSION[C('USER_AUTH_KEY')];
        $level = D('LUser')->field('level,code')->where($map)->find();
        //查找广告时间
        //  $adsold = $model->where('ID=' . $_POST['ID'])->field('adstime,bigtype')->find();
        $adstime = $model->where('ID=' . $_POST['ID'])->getField('adstime');
        $bigtype = $model->where('ID=' . $_POST['ID'])->getField('bigtype');
        $ashow = $model->where('ID=' . $_POST['ID'])->getField('ashow');
        if ($ashow == 2) {
            $model->clientmanger = $level['code'];
        }
        if ($_POST['adstime']) {
            if ($level['level'] == 1) {
                $model->ustime = time();
                $model->ashow = 1;
            }
            if ($level['level'] == 2) {
                $model->ashow = 0;
                $model->ustime = time();
            }
        }
        if ($level['level'] == 2) {
            if ($_POST['bigtypes']) {
                if (($bigtype != $_POST['bigtypes']) && ($_POST['bigtypes'] != 3)) {
                    $model->ashow = 0;
                }
                if (($bigtype != $_POST['bigtypes']) && ($_POST['bigtypes'] == 3)) {
                    $model->ashow = 1;
                }
            }
        }
        $list = $model->save();
        if ($list) {
            echo $this->ajax('1', "编辑成功", $rel, "", "closeCurrent");
        } else {
            echo $this->ajax('0', "编辑失败", $rel, "", "closeCurrent");
        }
    }

    /*删除广告后图片删除*/
    public
    function deleteimg()
    {
        $name = $this->getActionName();
        $model = D($name);
        if (!empty ($model)) {
            $pk = $model->getPk();
            $ID = $_REQUEST [$pk];
            if (isset ($ID)) {
                $condition = array($pk => array('in', explode(',', $ID)));
                $arr = $model->find($ID);
                $this->delpic($arr['adsimg'], '');
                $this->delpic($arr['adsimg1'], '');
                if (false !== $model->where($condition)->delete()) {
                    echo $this->ajax('1', "删除成功！！！", $name, "", "");
                } else {
                    echo $this->ajax('0', "删除失败！！！", $name, "", "");
                }
            } else {
                $this->error('非法操作');
            }
        }
    }

    public
    function show()
    {
        $this->assign('img', $_GET['img']);
        $this->assign('path', 'qz');
        $this->assign('flag', $_GET['flag']);
        $this->assign('ID', $_GET['ID']);
        $str = substr($_GET['img'], -4, 3);
        $this->assign('str', $str);
        $this->display();
    }

    /*修改照片信息*/
    public
    function Upic()
    {
        $model = D('MAds');
        $rel = "AdsEdit";
        $data[$_POST['temp']] = trim($_POST['Pic']);
        $arr = $model->where('ID=' . $_POST['ID'])->find();
        $this->delpic($arr[trim($_POST['temp'])], 'qz');
        $list = $model->where('ID=' . $_POST['ID'])->save($data);
        if (false !== $list) {
            echo $this->ajax('1', "修改成功", $rel, "", "closeCurrent");
        } else {
            echo $this->ajax('0', "修改失败", $rel, "", "closeCurrent");
        }
    }

    /*
     *	状态禁用
     */
    function AdsForbid()
    {
        $model = D('MAds');
        $model->where('ID=' . $_GET['ID'])->setField('uname', $_SESSION['account']);
        $model->where('ID=' . $_GET['ID'])->setField('uetime', time());
        $list = $model->where('ID=' . $_GET['ID'])->setField('ashow', 0);
        if ($list) {
            echo $this->ajax('1', "禁用成功", $name, "", "");
        } else {
            echo $this->ajax('0', "禁用失败", $name, "", "");
        }
    }

    /*
     *	隐藏广告
     */
    function standAll()
    {
        $model = D('MAds');
        $data['ID'] = array('in', $_POST['ids']);
        $model->where($data)->setField('uname', $_SESSION['account']);
        $model->where($data)->setField('uetime', time());
        $list = $model->where($data)->setField('ashow', 2);
        foreach ($_POST['ids'] as $value => $ID) {
            $alid = $model->where('ID=' . $ID)->getField('alid');
            $model->where('ID=' . $ID)->setField('clientmanger', "");
            //	M('LifeInfo')->where('ID='.$alid)->delete();
            D('LifeInfo')->where('ID=' . $alid)->setField('autostate', NULL);
            D('LifeInfo')->where('ID=' . $alid)->setField('State', 5);
        }
        if ($list) {
            echo $this->ajax('1', "删除成功", $name, "", "");
        } else {
            echo $this->ajax('0', "删除失败", $name, "", "");
        }
    }

    /*
     *	状态恢复
     */
    function AdsResume()
    {
        $model = D('MAds');
        $model->where('ID=' . $_GET['ID'])->setField('uname', $_SESSION['account']);
        $model->where('ID=' . $_GET['ID'])->setField('uetime', time());
        $list = $model->where('ID=' . $_GET['ID'])->setField('ashow', 1);
        $model->uname = $_SESSION['account'];
        $model->uetime = time();
        if ($list) {
            echo $this->ajax('1', "审核成功", $name, "", "");
        } else {
            echo $this->ajax('0', "审核失败", $name, "", "");
        }
    }

    /*
     *	批量审核
     */
    function AllResume()
    {
        $model = D('MAds');
        $pk = $model->getPk();
        $data[$pk] = array('in', $_POST['ids']);

        $model->where($data)->setField('uname', $_SESSION['account']);
        $model->where($data)->setField('uetime', time());
        $model->where($data)->setField('ashow', 1);
        echo $this->ajax('1', "批量审核成功！！！", $rel, "", "");
    }

    /*
     * 功能：清除点击量
     * 时间：15-07-18
     * */
    public function CleanClick(){
        $model = D('MAds');
        $pk = $model->getPk();
        $data[$pk] = array('in', $_POST['ids']);

        $model->where($data)->setField('uname', $_SESSION['account']);
        $model->where($data)->setField('uetime', time());
        $model->where($data)->setField('adsclick', 0);
        echo $this->ajax('1', "点击量清除成功", $rel, "", "");
    }
    /*
     *	广告彻底删除
     */
    function DeleteAll()
    {
        $model = D('MAds');
        $pk = $model->getPk();
        $data[$pk] = array('in', $_POST['ids']);
        $model->where($data)->delete();
        echo $this->ajax('1', "删除成功", $rel, "", "");
    }

    /*
     *广告类别
     */
    public
    function adtype()
    {
        $type = M('MAdsType');
        $list = $type->select();
        return $list;
    }

    /*
     *@查询广告位置
     */
    public
    function info()
    {
        $model = new Model();
        $types = $model->query('select * from zjboee_datatict where STATUS =1 and TYPE=' . "'" . position . "'" . ' order by CONVERT(CODE,SIGNED)');
        $this->assign('types', $types);
    }

    /**
     * 根据位置查询区块
     * @date   2014-10-04
     * @author liuliting
     */
    public
    function getQy()
    {
        $ID = $_GET['id'];
        $tname = D('MAds')->Distinct(true)->where('tstation=' . $ID)->getField('tname', true);
        foreach ($tname as $key => $value) {
            $code = M("MAdsType")->where('id=' . $value)->getField('code');
            if ($code == 1) {
                $str .= $value . ',';
            }
        }
        $where['adsstation'] = array('eq', $ID);
        if ($str) {
            $where['ID'] = array('not in', $str);
        }
        $where['status'] = array('eq', 1);
        $data = M("MAdsType")->field('id,typename')->where($where)->select();
        echo json_encode($data);
    }

    /**
     * 首页根据位置查询区块
     * @date   2014-10-04
     * @author liuliting
     */
    public
    function gettname()
    {
        $ID = $_GET['id'];
        $type = M("MAdsType");
        $data = $type->field('ID,typename')->where("adsstation=" . $ID)->select();
        echo json_encode($data);
    }

    /*地理区域*/
    public
    function getArea()
    {
        $model = M('Area');
        $arr = $model->select();
        $this->assign('area', $arr);

    }

    public
    function type()
    {
        $model = M('ZjTypes');
        $where['types'] = 'ads';
        $type = $model->where($where)->select();
        $this->assign('type', $type);
    }

    /*
     *@查询商家一级分类
     */
    public
    function saleType()
    {
        $model = M('ZjSaletype');
        $type = $model->where('parent=0')->select();
        $this->assign('smtype', $type);
    }

    /*
     *@查询商家二级分类
     */
    public
    function getSale2()
    {
        $ID = $_GET['id'];
        $class2 = M("ZjSaletype");
        $data = $class2->field('ID,name')->where("parent=" . $ID)->select();
        echo json_encode($data);
    }

    /*
     *@查询一级分类
     */
    public
    function class1()
    {
        $model = M('Class1');
        $class1 = $model->select();
        $this->assign('class1', $class1);
    }

    /*
     *@查询二级招聘信息
     */
    public
    function zhaopin()
    {
        $model = M('Class2');
        $where['Class1'] = '104';
        $class2 = $model->where($where)->select();
        $this->assign('zhaopin', $class2);
    }

    /*
     *@查询招聘职位
     */
    public
    function getCheck()
    {
        $model = D('LifeInfo');
        $where['ID'] = $_GET['id'];
        $vo = $model->where($where)->find();
        $code = explode(",", $vo['ms']);
        echo json_encode($code);
    }

    /*
     *@查询二级分类
     */
    public
    function getClass2()
    {
        $ID = $_GET['id'];
        $class2 = M("Class2");
        if ($ID) {
            $data = $class2->field('ID,Class2Name')->where("Class1=" . $ID)->select();
        }
        echo json_encode($data);
    }

    /*
     *@查询小区
     */
    public
    function getXq()
    {
        $where['qy'] = getgb($_GET['qy']);
        $qy = M('Area')->where($where)->getField('ID');
        $data = M("ZjXq")->field('ID,sx,name')->where("qy=" . $qy)->select();
        echo json_encode($data);
    }

    /*
     *@信息状态
     */
    public
    function status()
    {
        $model = M('ZjboeeDatatict');
        $where['TYPE'] = 'info_status';
        $sta = $model->where($where)->select();
        $this->assign('sta', $sta);
    }

    /*
     * @相关信息
     */
    public
    function typed()
    {
        $model = M('ZjTypes');
        $type = $model->select();
        $this->assign('typed', $type);
    }

    /**
     * 到期用户不自动更新
     * @date   2014-10-7
     * @author liuliting
     */
    public
    function UpdateMLife()
    {
        $model = D('MAds');
        $where['alid'] = array('neq', '');
        $where['ashow'] = array('neq', 2);
        $info = $model->query('select ID,alid,((UNIX_TIMESTAMP()-(adstime*86400+ustime))/3600/24) remain_time,ashow from m_ads where ashow!=2 and ((UNIX_TIMESTAMP()-(adstime*86400+ustime))/3600/24)>7');
        if ($info) {
            $ids = "";
            $lids = "";
            foreach ($info as $key => $value) {
                $ids .= $value['ID'] . ",";
                if ($value['alid']) {
                    $alids .= $value['alid'] . ",";
                }
            }
            $ids = substr($ids, 0, strlen($ids) - 1);
            $alids = substr($alids, 0, strlen($alids) - 1);
            $map['ID'] = array('in', $ids);
            $model->where($map)->setField('ashow', 2);
            $date['ID'] = array('in', $alids);
            $date['autostate'] = 0;
            $date['state'] = 5;
            D('LifeInfo')->save($date);
        }
    }

    /**
     *    广告归属分配页面
     * @date   2014-09-29
     * @author liuliting
     */
    public
    function AdsClass()
    {
        $list = $this->AdsClassInfo();
        $this->assign('adslist', $list);
        $this->assign('ids', $_GET['id']);
        $this->display();
    }

    /**
     *    广告归属分配方法
     * @date   2014-09-29
     * @author liuliting
     */
    public
    function AClsUpdate()
    {
        $name = 'MAds';
        $model = D($name);
        if ($_POST['ids']) {
            $data['ID'] = array('in', $_POST['ids']);
            $model->where($data)->setField('clientmanger', $_POST['clientmanger']);
            $model->where($data)->setField('company', $_POST['company']);
            $model->where($data)->setField('uname', $_SESSION['account']);
            $model->where($data)->setField('uetime', date('Y-m-d H:i:s'));
            echo $this->ajax('1', "分配成功", $rel, "", "");
        } else {
            echo $this->ajax('1', "分配失败,请勾选信息", $rel, "", "");
        }
    }

    /**
     *    管理员信息
     * @date   2014-09-30
     * @author liuliting
     */
    public
    function LuserInfo()
    {
        $userinfo = D('LUser')->field('nickname,code,level')->where('ID=' . $_SESSION[C('USER_AUTH_KEY')])->find();

        return $userinfo;
    }

    public
    function AdsClassInfo()
    {
        return D('LUser')->field('ID,account,nickname,code')->where('market=1')->select();
    }

    public
    function search()
    {
        $this->saleType();
        $this->display('search');
    }

    /*
     * 广告排序查询
     */
    public
    function EditNum()
    {
        $model = D('MAds');
        $vo = $model->where('ID=' . $_GET['ID'])->field('adspx,ID')->find();
        $this->assign('vo', $vo);
        $this->display();
    }

    /*
     * 广告排序修改
     */
    public
    function UNum()
    {
        $model = D('MAds');
        $list = $model->where('ID=' . $_POST['ID'])->setField('adspx', $_POST['adspx']);
        if (false !== $list) {
            echo $this->ajax('1', "修改成功", $name, "", "");
        } else {
            echo $this->ajax('0', "修改失败", $name, "", "");
        }
    }

    /*自动更新编辑界面*/
    public function autoInfo()
    {
        $id = $_GET['ID'];
        $list = D('LifeInfo')->field('ID,autostate,State')->where('ID=' . $id)->find();
        $this->assign('list', $list);
        $this->display();
    }

    /*自动更新修改方法*/
    public function UAutoInfo()
    {
        $model = D('LifeInfo');
        $date['autostate'] = $_POST['autostate'];
        if ($_POST['autostate']) {
            $date['State'] = 1;
        } else {
            $date['State'] = 5;
        }
        $list = $model->where('id=' . $_POST['ID'])->save($date);
        $name = 'AdsInfo';
        if (false !== $list) {
            echo $this->ajax('1', "修改成功", $name, "", "");
        } else {
            echo $this->ajax('0', "修改失败", $name, "", "");
        }
    }
}
?>