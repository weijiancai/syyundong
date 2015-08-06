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
        $name = 'DbAdvertise';
        $map = $this->_search('DbAdvertise');
        $this->assign('map', $map);
        if (method_exists($this, '_filter')) {
            $this->_filter($map);
        }
        $model = D($name);
        $order="";
        $this->_list($model, $map, $order);

        $this->assign('station',$this->adStation());

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
                if ($val == 'station1') {
                    $map[$val] = array('eq', $_REQUEST[$val]);
                }
                if ($val == 'type') {
                    $map[$val] = array('eq', $_REQUEST[$val]);
                }
            }
        }
        if (isset ($_REQUEST ['id']) && $_REQUEST ['id'] != '') {
            $map['id'] = array('eq', $_REQUEST['id']);
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
        $order .= $pk . " desc";
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
     * 功能：新增广告页面
     * 时间：2015-08-05
     */
    public function add()
    {
        $this->assign('station',$this->adStation());
        $this->assign('type',$this->adType());
        $model = New Model();
        $max_id = $model->query('select max(id) max_id from Db_advertise');
        $this->assign('max_id', $max_id[0]['max_id']+1);
        $this->display();
    }

    /**
     * 功能：新增广告方法
     * 时间：2015-08-05
     */
    function insert()
    {
        $name = 'DbAdvertise';
        $model = D($name);
        $up = $this->uploads('ad');
        if (false === $model->create()) {
            $this->error($model->getError());
        }
        if ($up[0]) {
            $info = $up[1];
            $model->img1 = $info[0]['savename']; // 保存上传的照片根据需要自行组装
            $model->img2 = $info[1]['savename'];
        }
        $model->click = 1;
        if (empty($_POST['link1'])) {
            $model->link1 = NUll;
        }
        if (empty($_POST['link2'])) {
            $model->link2 = NUll;
        }
        $list = $model->add();
        if ($list !== false) {
            echo $this->ajax('1', "新增成功", $rel, "", "closeCurrent");
        } else {
            echo $this->ajax('0', "新增失败", $rel, "", "closeCurrent");
        }
    }

    /**
     * 功能：编辑广告页面
     * 时间：2015-08-05
     */
    function edit()
    {
        $model = D('DbAdvertise');
        $vo = $model->find($_GET['id']);
        $this->assign('vo', $vo);

        //广告位置
        $this->assign('station',$this->adStation());

        $position = M('DzAdPosition');
        $where['pid'] = $vo['station1'];
        $arr = $position->where($where)->select();
        $this->assign('arr', $arr);

        //广告类型
        $this->assign('type',M('DzAdType')->select());
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
     */
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
     * 功能：广告类型
     * 时间：15-08-05
     */
    public function adType()
    {
        $model = M('DzAdType');
        $list = $model->select();
        return $list;
    }
    /*
     * 功能：广告位置查询
     * 时间：15-08-05
     */
    public function adStation()
    {
        $model = M('DzAdPosition');
        $list = $model->where('pid=0')->select();
        return $list;
    }

    /*
     * 功能：广告位置查询
     * 时间：15-08-05
     */
    public function getAdStation()
    {
        $pid = $_GET['id'];
        $model = M('DzAdPosition');
        $list = $model->where('pid='.$pid)->select();
        echo json_encode($list);
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

    public
    function type()
    {
        $model = M('ZjTypes');
        $where['types'] = 'ads';
        $type = $model->where($where)->select();
        $this->assign('type', $type);
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