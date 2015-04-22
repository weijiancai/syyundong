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
        $this->assign('dzSport',$this->DzSport());
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
                $map[$val] = array('like',"%{$_REQUEST[$val]}%");
            }
        }
        return $map;
    }
    /*
     * @功能：赛事分类
     * @时间：20150422
     */
    public function DzSport(){
        return  D('DzSport')->field('id,name')->where('pid=0 and sport_type=1')->select();
    }
    /*
     * @功能：赛事详情
     * @时间：20150422
     */
    public function getSportAjax(){
        $pid = $_GET['id'];
        $where['pid'] = $pid;
        $data = D('DzSport')->field('id,name')->where($where)->select();
        echo json_encode($data);
    }

    /*
     *	增加数据
     */
    function add()
    {
        $this->ltype();
        $this->display();
    }

    /*
     *	增加回复信息
     */
    function r_add()
    {
        $this->ltype();
        $RID = $_GET['ID'];
        $this->assign('RID', $RID);
        $this->display();
    }

    /*
     *	查询单条回复
     */
    function r_edit()
    {
        $name = $this->getActionName();
        $model = D($name);
        $id = $_REQUEST [$model->getPk()];
        $vo = $model->find($id);
        $this->assign('vo', $vo);
        $this->ltype();
        $this->display();
    }

    /*
     *	查询单条数据
     */
    function edit()
    {
        $name = $this->getActionName();
        $model = D($name);
        $id = $_REQUEST [$model->getPk()];
        $vo = $model->find($id);
        $this->assign('vo', $vo);
        $this->ltype();
        $this->display();
    }

    /*
     *	新增信息
     */
    function insert()
    {
        $name = $this->getActionName();
        $model = D($name);
        $up = $this->upload();
        if (false === $model->create()) {
            $this->error($model->getError());
        }
        if ($up[0]) {
            $model->lrimg = $up[1];
        }
        $model->luser = enCode($_POST['luser']);
        $model->ltime = time();
        $model->uip = $_SESSION['ip'];
        $model->uname = $_SESSION['account'];
        $list = $model->add();
        if ($list !== false) {
            echo $this->ajax('1', "新增成功！！！", $name, "", "closeCurrent");
        } else {
            echo $this->ajax('0', "新增失败！！！", $name, "", "closeCurrent");
        }
    }

    /*
     *	修改信息
     */
    function update()
    {
        $name = $this->getActionName();
        $model = D($name);
        $up = $this->upload();
        if (false === $model->create()) {
            $this->error($model->getError());
        }
        if ($up[0]) {
            $model->lrimg = $up[1];
        } else {
            $model->lrimg = $_POST['default'];
        }
        $model->uip = $_SESSION['ip'];
        $model->uname = $_SESSION['account'];
        $model->utime = date('Y-m-d H:i:s');
        $model->ltime = strtotime($_POST['ltime']);
        //	$model->lcontent = remove_xss($_POST['lcontent']);
        $list = $model->save();
        if ($list !== false) {
            echo $this->ajax('1', "编辑成功！！！", $name, "", "closeCurrent");
        } else {
            echo $this->ajax('0', "编辑失败！！！", $name, "", "closeCurrent");
        }
    }

    /*
     *	查看回复
     */
    public function replay()
    {
        /* 		$id = $_GET['ID'];
                $model = M('MLiao');
                $LID=$model->where('ID='.$_GET['ID'])->getField('LID');
                $where['LRID'] = 1;
                $where['LID'] = $LID;
                $liao = $model ->where($where)->select();
                $this->assign('list',$liao);
                $this->assign('ID',$id); */
        $name = $this->getActionName();
        $model = D($name);
        $LID = $model->where('ID=' . $_GET['ID'])->getField('LID');
        if (!isset($_GET['ID'])) {
            $LID = $_POST['LID'];
        }
        $map = $this->_rsearch($name, $LID);
        $this->assign('map', $map);
        if (method_exists($this, '_filter')) {
            $this->_filter($map);
        }

        if (!empty ($model)) {
            $order = "";
            $order .= "ltime asc,";
            $this->_list($model, $map, $order);
        }
        $this->assign('LID', $LID);

        $this->display();
    }

    protected function _rsearch($name, $LID)
    {
        $model = D($name);
        $map = array();
        $temp = $model->getDbFields();
        if (isset ($_REQUEST ['LID']) && $_REQUEST ['LID'] != '') {
            $_REQUEST ['LID'] = iconv("utf-8", "GBK", $_REQUEST['LID']);
            $map['LID'] = array('eq', $_REQUEST['LID']);
        } else {
            //	$map['LID'] = $LID;
            $_REQUEST['LID'] = $LID;
            $map['LID'] = array('eq', $_REQUEST['LID']);
        }
        /* 		if(isset ( $_REQUEST ['luser'] ) && $_REQUEST ['luser'] != ''){
                    $_REQUEST ['luser'] = iconv("utf-8","GBK",$_REQUEST['luser']);
                    $map['luser'] = array('eq',$_REQUEST['luser']);
                } */
        if (!empty($_REQUEST['luser'])) {
            $temp = M('Users');
            $_REQUEST ['luser'] = iconv("utf-8", "gbk", $_REQUEST['luser']);
            $id = $temp->where('uid=' . "'" . $_REQUEST['luser'] . "'")->getField('ID');
            $map['luser'] = array('eq', enCode($id));
        }
        /* 		if(!empty($_REQUEST['LID'])&& $_REQUEST ['LID'] !==' '){

                } */
        if (isset ($_REQUEST ['lcontent']) && $_REQUEST ['lcontent'] != '') {
            $_REQUEST ['lcontent'] = iconv("utf-8", "GBK", $_REQUEST['lcontent']);
            $map['lcontent'] = array('like', "%{$_REQUEST['lcontent']}%");
        }
        if (isset ($_REQUEST ['lshow']) && $_REQUEST ['lshow'] != '') {
            $_REQUEST ['lshow'] = iconv("utf-8", "GBK", $_REQUEST['lshow']);
            $map['lshow'] = array('eq', $_REQUEST['lshow']);
        }
        $map['LRID'] = 1;
        //	$map['pstate']=array(array('eq',NULL),array('neq',1),'or');
        //	dump($map);
        return $map;
    }

    /*
     *	推送信息
     */
    public function pullinfo()
    {
        $this->tsta();
        $this->display();
    }

    public function getPull2()
    {
        $id = $_GET['id'];
        $sta = M("MSta");
        $where['pid'] = $id;
        $data = $sta->field('id,staname')->where($where)->select();
        echo json_encode($data);
    }

    public function pinsert()
    {
        $name = "MLiao";
        $model = M('MPush');
        $data['pname'] = $_POST['staname'];

        //修改推送状态,推送位置
        /* 		$Models = new Model() ;// 实例化一个model对象 没有对应任何数据表
                $Models->execute("update m_liao set pstate=1,staid=".$_POST['staname'].",staid1=".$_POST['module']." where ID in(".$_POST['id'].")"); */
        $var = $this->strtoarr($_POST['id']);

        for ($i = 0; $i < count($var); $i++) {
            $val = $var[$i];
            $MLiao = D($name);
            $mvo = $MLiao->where('ID =' . $val)->getField('staid');
            $mvo1 = $MLiao->where('ID =' . $val)->getField('staid1');
            if ((!empty($mvo)) && (!empty($mvo1))) {
                //不为空叠加staid,staid1
                //	$staid = $MLiao->where('ID='.$val)->getField('staid');
                $sta['staid'] = ',' . $_POST['staname'] . $mvo;
                $sta['staid1'] = ',' . $_POST['module'] . $mvo1;
                //保证插入位置唯一
                /*  				$sta['staid']=  implode(array_unique(explode(",",$sta['staid'])),',');
                                $sta['staid']=$sta['staid'].",";
                                $sta['staid1']=  implode(array_unique(explode(",",$sta['staid1'])),',');
                                $sta['staid1']=$sta['staid1'].",";  */
                $MLiao->where('ID=' . $val)->data($sta)->save();
            } else {
                $sta['staid'] = ',' . $_POST['staname'] . ',';
                $sta['staid1'] = ',' . $_POST['module'] . ',';
                $MLiao->where('ID=' . $val)->data($sta)->save();
            }
            $list = $MLiao->where('ID=' . $val)->setField('pstate', 1);
            $MLiao->where('ID=' . $val)->setField('utime', date("Y-m-d H:i:s"));
            $MLiao->where('ID=' . $val)->setField('uname', $_SESSION['account']);
        }
        /* 		//头版头条只有一个
                 if(($_POST['staname'] == 70) ||($_POST['staname'] == 71)){
                    //修改推送状态,推送位置
                    $Model1 = new Model() ;// 实例化一个model对象 没有对应任何数据表
                    $Model1->execute("update m_push set tid= ".$_POST['id']." where pname =".$_POST['staname']);
                } */
        //判断pname是否存在
        //	else{
        $vo = $model->where('pname=' . $_POST['staname'])->getField('tid');
        if (!empty($vo)) {
            if (($_POST['staname'] == 14) || ($_POST['staname'] == 15)) {
                $Model1 = new Model(); // 实例化一个model对象 没有对应任何数据表
                $Model1->execute("update m_push set tid= '" . "," . $_POST['id'] . "," . "' where pname =" . $_POST['staname']);
            } else {
                $id = $model->where('pname=' . $_POST['staname'])->getField('id');
                $data['tid'] = ',' . $_POST['id'] . $vo;
                $data['tid'] = implode(array_unique(explode(",", $data['tid'])), ',');
                $data['tid'] = $data['tid'] . ",";
                $model->where('id=' . $id)->data($data)->save();
            }
        } else {
            $data['tid'] = ',' . $_POST['id'] . ',';
            $model->data($data)->add();
        }
        //	}
        //	echo $this->ajax('1', "推送成功",$name,"","");
        if ($list) {
            echo $this->ajax('1', "推送成功", $name, "", "");
        } else {
            echo $this->ajax('0', '推送失败', $name, "", "");
        }
    }

    /*查找带回*/
    public function searchback()
    {
        $name = 'MLiao';
        $model = D($name);
        $map = $this->_bsearch($name);
        $this->assign('map', $map);
        if (method_exists($this, '_filter')) {
            $this->_filter($map);
        }
        if (!empty ($model)) {
            $order = "ltime desc,";
            $this->_blist($model, $map, $order);
        }
        $this->ltype();
        $this->tsta();
        $this->display('searchback');
    }

    /*查找带回search方法*/
    protected function _bsearch($name)
    {
        $this->ltype();
        $model = D($name);
        $map = array();
        $temp = $model->getDbFields();
        foreach ($temp as $key => $val) {
            if (isset ($_REQUEST [$val]) && $_REQUEST [$val] != '') {
                $_REQUEST [$val] = iconv("utf-8", "GBK", $_REQUEST[$val]);
                $map[$val] = array('like', "%{$_REQUEST[$val]}%");
            }
            if (!empty($_REQUEST['ltype'])) {
                $map['ltype'] = $_REQUEST['ltype'];
            }
        }
        $map['LRID'] = 0;
        $map['lshow'] = array('eq', 1);
        //	$map['pstate']=array(array('eq',NULL),array('neq',1),'or');
        return $map;
    }

    /*查找带回list*/
    protected function _blist($model, $map, $order, $sortBy = '', $asc = true)
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
            $voList = $model->field('ID,lname,LID,ltype,lcontent,luser,pstate,ltime,staid')->relation(true)->where($map)->order($order)->limit($pageNum)->page($_REQUEST[C('VAR_PAGE')])->select();
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
        //	dump($list);
        $this->assign('totalCount', $count);
        $pageNum = empty($_REQUEST['numPerPage']) ? C('PAGE_LISTROWS') : $_REQUEST['numPerPage'];
        $this->assign('numPerPage', $pageNum); //每页显示多少条
        $this->assign('currentPage', !empty($_REQUEST[C('VAR_PAGE')]) ? $_REQUEST[C('VAR_PAGE')] : 1);
        Cookie::set('_currentUrl_', __SELF__);
        return;
    }

    /*
     *	不推送信息,表示把显示的此条信息全部拿掉
     */
    public function  stay()
    {
        $name = $this->getActionName();
        $model = M($name);
        $list = $model->where('ID=' . $_GET['ID'])->setField('pstate', 0);
        $model->where('ID=' . $_GET['ID'])->setField('staid', NULL);
        $model->where('ID=' . $_GET['ID'])->setField('staid1', NULL);
        $model->where('ID=' . $_GET['ID'])->setField('utime', date("Y-m-d H:i:s"));
        $model->where('ID=' . $_GET['ID'])->setField('uname', $_SESSION['account']);
        //从已推送信息中去除
        $push = M('MPush');
        $temp = $push->getField('tid', true);
        $value = $_GET['ID'] . ",";
        foreach ($temp as $key => $val) {
            //检索$val 中是否存在$value
            $result = substr_count($val, $value);
            if ($result != 0) {
                $tid = str_replace($value, '', $val);
                $var = $push->where("tid=" . "'" . $val . "'")->getfield('id');
                $Models = new Model(); // 实例化一个model对象 没有对应任何数据表
                $Models->execute("update m_push set tid='" . $tid . "'" . " where id=" . $var);
            }
        }
        if ($list) {
            echo $this->ajax('1', '成功', $name, "", "");
        } else {
            echo $this->ajax('0', "失败", $name, "", "");
        }
    }

    /*把信息单独撤掉*/

    public function single()
    {
        $this->tsta();
        $this->assign('ID', $_GET['ID']);
        $this->display();
    }
    //staname----pname,staid
    //module---staid1
    public function siinsert()
    {
        $name = $this->getActionName();
        $model = M($name);
        $staid = $_POST['staname'];
        $staid1 = $_POST['module'];

        $ID = $_POST['ID'];
        $MPush = M('MPush');
        $val = $MPush->where('pname=' . $_POST['staname'])->getField('tid');
        //检索$val 中是否存在$ID,从Push中去除
        $result = substr_count($val, $ID);
        if ($result != 0) {
            $tid = str_replace("," . $ID, '', $val);
            $Models = new Model(); // 实例化一个model对象 没有对应任何数据表
            $Models->execute("update m_push set tid='" . $tid . "'" . " where pname=" . $staid);
        }
        if (trim($tid) == ",") {
            $MPush->where('pname=' . $staid)->setField('tid', '');
        }
        //从m_liao中去除
        $mstaid = $model->where('ID=' . $ID)->getField('staid');
        $result1 = substr_count($mstaid, $staid);
        if ($result1 != 0) {
            $pos = strpos($mstaid, $staid);
            $len = strlen($staid) + 1;
            $mstaid = substr_replace($mstaid, '', $pos, $len);
            //	$mstaid=str_replace(",".$staid,'',$mstaid);
            $Models = new Model(); // 实例化一个model对象 没有对应任何数据表
            $Models->execute("update m_liao set staid='" . $mstaid . "'" . " where ID=" . $ID);

        }

        $mstaid1 = $model->where('ID=' . $ID)->getField('staid1');
        $result2 = substr_count($mstaid1, $staid1);
        if ($result2 != 0) {
            $pos = strpos($mstaid1, $staid1);
            $len = strlen($staid1) + 1;
            $mstaid1 = substr_replace($mstaid1, '', $pos, $len);
            //		$mstaid1=str_replace(",".$staid1,'',$mstaid1);
            $Models = new Model(); // 实例化一个model对象 没有对应任何数据表
            $Models->execute("update m_liao set staid1='" . $mstaid1 . "'" . " where ID=" . $ID);
        }
        if (($mstaid == ",") && ($mstaid1 == ",")) {
            $list = $model->where('ID=' . $ID)->setField('pstate', 0);
            $model->where('ID=' . $ID)->setField('staid', NULL);
            $model->where('ID=' . $ID)->setField('staid1', NULL);
            $model->where('ID=' . $ID)->setField('utime', date("Y-m-d H:i:s"));
            $model->where('ID=' . $ID)->setField('uname', $_SESSION['account']);
        }
        //	 if ($list) {
        echo $this->ajax('1', "成功", $name, "", "");
        //	} else {
        //		echo $this->ajax('0', "失败",$name,"","");
        //	}
    }

    /*
     *	推送信息
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

    /*
     *	状态禁用
     */
    public function forbid()
    {
        $name = "MLiao";
        $model = D('MLiao');
        $rel = "replay";
        $parent = $model->where('ID=' . $_GET['ID'])->setField('lshow', 0);
        $model->where('ID=' . $_GET['ID'])->setField('utime', date("Y-m-d H:i:s"));
        $model->where('ID=' . $_GET['ID'])->setField('uname', $_SESSION['account']);
        //隐藏回复贴
        $child = $model->where('LRID=' . $_GET['ID'])->setField('lshow', 0);
        if ($parent) {
            echo $this->ajax('1', "状态禁用成功", $rel, "", "");
        } else {
            echo $this->ajax('0', "状态禁用失败", $rel, "", "");
        }
    }

    /*
     *	状态恢复
     */
    public function resume()
    {
        $name = "MLiao";
        $model = D('MLiao');
        $rel = "replay";
        $parent = $model->where('ID=' . $_GET['ID'])->setField('lshow', 1);
        $model->where('ID=' . $_GET['ID'])->setField('utime', date("Y-m-d H:i:s"));
        $model->where('ID=' . $_GET['ID'])->setField('uname', $_SESSION['account']);
        //隐藏回复贴
        $child = $model->where('LRID=' . $_GET['ID'])->setField('lshow', 1);
        if ($parent) {
            echo $this->ajax('1', "状态恢复成功", $rel, "", "");
        } else {
            echo $this->ajax('0', "状态恢复失败", $rel, "", "");
        }
    }

    /*删除广告后图片删除*/
    public function deleteimg()
    {
        $name = $this->getActionName();
        $model = D($name);
        if (!empty ($model)) {
            $pk = $model->getPk();
            $id = $_REQUEST [$pk];
            if (isset ($id)) {
                $condition = array($pk => array('in', explode(',', $id)));
                $arr = $model->find($id);
                $this->delpic($arr['lrimg']);
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

    /*
     *	聊吧类别
     */
    public function ltype()
    {
        $model = M('MSta');
        $type = $model->where('pid = 0')->select();

        $this->assign('msta', $type);
    }

    /*
     *	图片预览
     */
    public function show()
    {
        $this->assign('img', $_GET['img']);
        $this->display();
    }

    public function tsta()
    {
        $model = M('MSta');
        $where['pid'] = 0;
        $list = $model->where($where)->select();
        $this->assign('list1', $list);
    }

    /*     public function delAll(){
            $name='MLiao';
            $model = CM ($name);
            $pk=$model->getPk ();
            $data[$pk]=array('in', $_POST['ids']);
        //	$model->where($data)->delete();
            //从已推送信息中去除

            //循环要删除的id
            foreach ( $_POST['ids'] as $idkey => $id ) {
                    //循环已推送信息
                    $push = M('MPush');
                    $temp = $push->getField('tid',true);
                    foreach ( $temp as $key => $val ) {
                        $value=$id.",";
                        //检索$val 中是否存在$value
                        $result = substr_count($val,$value);
                        if($result!=0){
                            $tid=str_replace($value,'',$val);
                            $var =$push->where("tid="."'".$val."'")->getfield('id');
                            $Models = new Model() ;// 实例化一个model对象 没有对应任何数据表
                            $Models->execute("update m_push set tid='".$tid."'"." where id=".$var);
                        }
                    }
            }
            //删除回复贴
    /* 		$LID = $model->where($data)->getField('LID',true);
            foreach ( $LID as $lkey => $lid ) {
                $this->plusscore($luser,1);
                $this->record($luser,1);
                $model->where("LID = '".$lid."' and LRID =1")->delete();
            }
            //回复贴记录、减积分、删除
            $LRID = $model->where($data)->getField('LID',true);
            foreach ( $LRID as $lkey => $lrid ) {
                 $luser=$model->where("LID = '".$lrid ."' and LRID = 1")->getField('luser',true);
                    foreach($luser as $key => $val ){
                        $this->plusscore($val,1);
                        $this->record($val,1);
                    }
                 $model->where("LID = '".$lrid."' and LRID =1")->delete();
            }
            //主贴操作
            $LID = $model->where($data)->getField('luser',true);
             foreach ( $LID as $lkey => $luser ) {
                 $this->plusscore($luser,2);
                 $this->record($luser,2);
            }
            $model->where($data)->delete();
            echo $this->ajax('1',"删除成功",$name,"","");
        //	echo $this->ajax('1',$_POST['ids'],$rel,"","");
        } */
    public function delAll()
    {
        $name = 'MLiao';
        $rel = 'MLiao';
        if (isset($_GET['temp'])) {
            $rel = 'replay';
        }
        $model = CM($name);
        $pk = $model->getPk();
        $data[$pk] = array('in', $_POST['ids']);

        //从已推送信息中去除
        //循环要删除的id
        foreach ($_POST['ids'] as $idkey => $id) {
            //循环已推送信息
            $push = M('MPush');
            $temp = $push->getField('tid', true);
            foreach ($temp as $key => $val) {
                $value = $id . ",";
                //检索$val 中是否存在$value
                $result = substr_count($val, $value);
                if ($result != 0) {
                    $tid = str_replace($value, '', $val);
                    $var = $push->where("tid=" . "'" . $val . "'")->getfield('id');
                    $Models = new Model(); // 实例化一个model对象 没有对应任何数据表
                    $Models->execute("update m_push set tid='" . $tid . "'" . " where id=" . $var);
                }
            }
        }
        //首先删除回复贴
        $LRID = $model->where($data)->field('LRID,ID,LID,luser')->select();
        $user = D('Users');
        $array = Array();
        $array2 = Array();
        $compare2 = Array();
        //如果是主贴,那么将主贴和回复贴都删除,删除主帖扣2分
        foreach ($LRID as $lkey => $lrid) {
            //如果是主贴,查询出回复贴
            if ($LRID[$lkey]['LRID'] == 0) {
                $this->plusscore($LRID[$lkey]['luser'], 2);
                $this->record($LRID[$lkey]['luser'], 2);
                //得到回帖UID,循环回复贴减少一分
                $array = $model->where("LID = '" . $LRID[$lkey]['LID'] . "' and LRID = 1")->getField('ID', true);
                //提取luser进行比较
                foreach ($LRID as $lkeys => $lrids) {
                    if ($LRID[$lkeys]['LRID'] == 1) {
                        $array2[$lkeys] = $LRID[$lkeys]['ID'];
                    }
                }
                //找array()和array2()的差值,将不重复的luser减少一分
                $compare2 = array_diff($array, $array2);
                foreach ($compare2 as $key => $val) {
                    $luser = $model->where('ID=' . $val)->getField('luser');
                    $this->plusscore($luser, 1);
                    $this->record($luser, 1);
                }
                $model->where("LID = '" . $LRID[$lkey]['LID'] . "' and LRID =1")->delete();
            }
            //如果是回复贴,减积分并删除
            if ($LRID[$lkey]['LRID'] == 1) {
                $this->plusscore($LRID[$lkey]['luser'], 1);
                $this->record($LRID[$lkey]['luser'], 1);
            }
        }
        //删除帖子
        $model->where($data)->delete();
        echo $this->ajax('1', '删除成功', $rel, "", "");
    }

    function  strtoarr($strs)
    {
        $result = array();
        $array = array();
        $strs = str_replace("n", ',', $strs);
        $strs = str_replace("rn", ',', $strs);
        $strs = str_replace(' ', ',', $strs);
        $array = explode(',', $strs);
        return $array;
    }

    function mbstringtoarray($str, $charset)
    {
        $strlen = mb_strlen($str);
        while ($strlen) {
            $array[] = mb_substr($str, 0, 1, $charset);
            $str = mb_substr($str, 1, $strlen, $charset);
            $strlen = mb_strlen($str);
        }
        return $array;
    }

    function mbplus($str)
    {
        $arr = $this->mbstringtoarray($str, "gbk"); //分割字符串
        $arr = array_unique($arr); //过滤重复字符
        $str = implode('', $arr); //合并数组
        return $str;
    }

    /*	减积分方法
        帖子uid：$luser
        减少的分数：$temp
    */
    public function plusscore($luser, $temp)
    {
        $user = D('Users');
        $SCORE = $user->where('ID=' . deCode($luser))->getField('SCORE');
        if ($SCORE - $temp < 0) {
            $user->where('uid=' . deCode($luser))->setField('SCORE', 0);
        } else {
            $user->where('ID=' . deCode($luser))->setDec('SCORE', $temp);
        }
    }

    /*	操作日志记录
        帖子uid：$luser
        减少的分数：$score
    */
    public function record($luser, $score)
    {
        $model = D('Score');
        $log['num'] = $score;
        $log['operate'] = 'minus';
        $log['editer'] = $_SESSION['account'];
        $log['editime'] = time();
        $log['IP'] = get_client_ip();
        $log['cause'] = '帖子不符合要求,后台删除';
        $log['userid'] = deCode($luser);
        $log['uid'] = getUserID(deCode($luser));
        $log['type'] = 1;
        $model->add($log);
    }
}

?>