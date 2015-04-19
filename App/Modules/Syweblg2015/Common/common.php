<?php
// +----------------------------------------------------------------------
// | ThinkPHP
// +----------------------------------------------------------------------
// | Copyright (c) 2007 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id$

//公共函数
function toDate($time, $format = 'Y-m-d H:i:s') {
	if (empty ( $time )) {
		return '';
	}
	$format = str_replace ( '#', ':', $format );
	return date ($format, $time );
}


function qtDate($time, $format = 'Y-m-d H:i:s') {
	if (empty ( $time )) {
		return '';
	}
	$format = str_replace ( '#', ':', $format );
	return date ($format, $time );
}


function qtDatet($time, $format = 'Y-m-d') {
	if (empty ( $time )) {
		return '';
	}
	$format = str_replace ( '#', ':', $format );
	return date ($format, $time );
}



// 缓存文件
function cmssavecache($name = '', $fields = '') {
	$Model = D ( $name );
	$list = $Model->select ();
	$data = array ();
	foreach ( $list as $key => $val ) {
		if (empty ( $fields )) {
			$data [$val [$Model->getPk ()]] = $val;
		} else {
			// 获取需要的字段
			if (is_string ( $fields )) {
				$fields = explode ( ',', $fields );
			}
			if (count ( $fields ) == 1) {
				$data [$val [$Model->getPk ()]] = $val [$fields [0]];
			} else {
				foreach ( $fields as $field ) {
					$data [$val [$Model->getPk ()]] [] = $val [$field];
				}
			}
		}
	}
	$savefile = cmsgetcache ( $name );
	// 所有参数统一为大写
	$content = "<?php\nreturn " . var_export ( array_change_key_case ( $data, CASE_UPPER ), true ) . ";\n?>";
	file_put_contents ( $savefile, $content );
}

function cmsgetcache($name = '') {
	return DATA_PATH . '~' . strtolower ( $name ) . '.php';
}
function getStatus($status, $imageShow = true) {
	switch ($status) {
		case 0 :
			$showText = '禁用';
			$showImg = '<IMG SRC="' . __PUBLIC__ . '/images/locked.gif" WIDTH="20" HEIGHT="20" BORDER="0" ALT="禁用">';
			break;
		case 2 :
			$showText = '待审';
			$showImg = '<IMG SRC="' . __PUBLIC__ . '/images/prected.gif" WIDTH="20" HEIGHT="20" BORDER="0" ALT="待审">';
			break;
		case - 1 :
			$showText = '删除';
			$showImg = '<IMG SRC="' . __PUBLIC__ . '/images/del.gif" WIDTH="20" HEIGHT="20" BORDER="0" ALT="删除">';
			break;
		case 1 :
		default :
			$showText = '正常';
			$showImg = '<IMG SRC="' . __PUBLIC__ . '/images/ok.gif" WIDTH="20" HEIGHT="20" BORDER="0" ALT="正常">';

	}
	return ($imageShow === true) ?  $showImg  : $showText;

}
function getDefaultStyle($style) {
	if (empty ( $style )) {
		return 'blue';
	} else {
		return $style;
	}

}
function IP($ip = '', $file = 'UTFWry.dat') {
	$_ip = array ();
	if (isset ( $_ip [$ip] )) {
		return $_ip [$ip];
	} else {
		import ( "ORG.Net.IpLocation" );
		$iplocation = new IpLocation ( $file );
		$location = $iplocation->getlocation ( $ip );
		$_ip [$ip] = $location ['country'] . $location ['area'];
	}
	return $_ip [$ip];
}

function getNodeName($id) {
	if (Session::is_set ( 'nodeNameList' )) {
		$name = Session::get ( 'nodeNameList' );
		return $name [$id];
	}
	$Group = D ( "Node" );
	$list = $Group->getField ( 'id,name' );
	$name = $list [$id];
	Session::set ( 'nodeNameList', $list );
	return $name;
}

function get_pawn($pawn) {
	if ($pawn == 0)
		return "<span style='color:green'>没有</span>";
	else
		return "<span style='color:red'>有</span>";
}
function get_patent($patent) {
	if ($patent == 0)
		return "<span style='color:green'>没有</span>";
	else
		return "<span style='color:red'>有</span>";
}


function getNodeGroupName($id) {
	if (empty ( $id )) {
		return '未分组';
	}
	if (isset ( $_SESSION ['nodeGroupList'] )) {
		return $_SESSION ['nodeGroupList'] [$id];
	}
	$Group = D ( "Group" );
	$list = $Group->getField ( 'id,title' );
	$_SESSION ['nodeGroupList'] = $list;
	$name = $list [$id];
	return $name;
}

function getCardStatus($status) {
	switch ($status) {
		case 0 :
			$show = '未启用';
			break;
		case 1 :
			$show = '已启用';
			break;
		case 2 :
			$show = '使用中';
			break;
		case 3 :
			$show = '已禁用';
			break;
		case 4 :
			$show = '已作废';
			break;
	}
	return $show;

}

// zhanghuihua@msn.com
function showStatus($status, $id, $callback="") {
	switch ($status) {
		case 0 :
			$info = '<a href="__URL__/resume/id/' . $id . '/navTabId/__MODULE__" target="ajaxTodo" callback="'.$callback.'">恢复</a>';
			break;
		case 2 :
			$info = '<a href="__URL__/pass/id/' . $id . '/navTabId/__MODULE__" target="ajaxTodo" callback="'.$callback.'">批准</a>';
			break;
		case 1 :
			$info = '<a href="__URL__/forbid/id/' . $id . '/navTabId/__MODULE__" target="ajaxTodo" callback="'.$callback.'">禁用</a>';
			break;
		case - 1 :
			$info = '<a href="__URL__/recycle/id/' . $id . '/navTabId/__MODULE__" target="ajaxTodo" callback="'.$callback.'">还原</a>';
			break;
	}
	return $info;
}

function showState($status, $id, $temp, $callback="") {
	switch ($status) {
		case 0 :
			$info = '<a href="__URL__/resume/ID/' . $id . '/temp/'.$temp.'/navTabId/__MODULE__" target="ajaxTodo" callback="'.$callback.'">恢复</a>';
			break;
		case 1 :
			$info = '<a href="__URL__/forbid/ID/' . $id . '/temp/'.$temp.'/navTabId/__MODULE__" target="ajaxTodo" callback="'.$callback.'">禁用</a>';
			break;
			break;
	}
	return $info;
}
	/*
	* @生活信息状态
	*/
function getInfoStatus($status) {
	switch ($status) {
		case 0 :
			$show = '<span style="color:red">未审批</span>';
			break;
		case 1 :
			$show = '<span style="color:green">已审批</span>';
			break;
		case 2 :
			$show = '<span style="color:yellow">虚假信息</span>';
			break;
		case 3 :
			$show = '<span style="color:blue">设置过期</span>';
			break;
		case 4 :
			$show = '<span style="color:pink">自删</span>';
			break;
		case 5 :
			$show = '<span style="color:blue">删除</span>';
			break;
		case 6 :
			$show = '打回';
			break;
		case 7 :
			$show = '未审改信息';
			break;
	}
	return $show;

}
/**
 +----------------------------------------------------------
 * 获取登录验证码 默认为4位数字
 +----------------------------------------------------------
 * @param string $fmode 文件名
 +----------------------------------------------------------
 * @return string
 +----------------------------------------------------------
 */
function build_verify($length = 4, $mode = 1) {
	return rand_string ( $length, $mode );
}


function getGroupName($id) {
	if ($id == 0) {
		return '无上级组';
	}
	if ($list = F ( 'groupName' )) {
		return $list [$id];
	}
	$dao = D ( "LRole" );
	$list = $dao->select ( array ('field' => 'id,name' ) );
	foreach ( $list as $vo ) {
		$nameList [$vo ['id']] = $vo ['name'];
	}
	$name = $nameList [$id];
	F ( 'groupName', $nameList );
	return $name;
}
function sort_by($array, $keyname = null, $sortby = 'asc') {
	$myarray = $inarray = array ();
	# First store the keyvalues in a seperate array
	foreach ( $array as $i => $befree ) {
		$myarray [$i] = $array [$i] [$keyname];
	}
	# Sort the new array by
	switch ($sortby) {
		case 'asc' :
			# Sort an array and maintain index association...
			asort ( $myarray );
			break;
		case 'desc' :
		case 'arsort' :
			# Sort an array in reverse order and maintain index association
			arsort ( $myarray );
			break;
		case 'natcasesor' :
			# Sort an array using a case insensitive "natural order" algorithm
			natcasesort ( $myarray );
			break;
	}
	# Rebuild the old array
	foreach ( $myarray as $key => $befree ) {
		$inarray [] = $array [$key];
	}
	return $inarray;
}

/**
	 +----------------------------------------------------------
 * 产生随机字串，可用来自动生成密码
 * 默认长度6位 字母和数字混合 支持中文
	 +----------------------------------------------------------
 * @param string $len 长度
 * @param string $type 字串类型
 * 0 字母 1 数字 其它 混合
 * @param string $addChars 额外字符
	 +----------------------------------------------------------
 * @return string
	 +----------------------------------------------------------
 */
function rand_string($len = 6, $type = '', $addChars = '') {
	$str = '';
	switch ($type) {
		case 0 :
			$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz' . $addChars;
			break;
		case 1 :
			$chars = str_repeat ( '0123456789', 3 );
			break;
		case 2 :
			$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' . $addChars;
			break;
		case 3 :
			$chars = 'abcdefghijklmnopqrstuvwxyz' . $addChars;
			break;
		default :
			// 默认去掉了容易混淆的字符oOLl和数字01，要添加请使用addChars参数
			$chars = 'ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789' . $addChars;
			break;
	}
	if ($len > 10) { //位数过长重复字符串一定次数
		$chars = $type == 1 ? str_repeat ( $chars, $len ) : str_repeat ( $chars, 5 );
	}
	if ($type != 4) {
		$chars = str_shuffle ( $chars );
		$str = substr ( $chars, 0, $len );
	} else {
		// 中文随机字
		for($i = 0; $i < $len; $i ++) {
			$str .= msubstr ( $chars, floor ( mt_rand ( 0, mb_strlen ( $chars, 'utf-8' ) - 1 ) ), 1 );
		}
	}
	return $str;
}
function pwdHash($password, $type = 'md5') {
	return hash ( $type, $password );
}

/* zhanghuihua */
function percent_format($number, $decimals=0) {
	return number_format($number*100, $decimals).'%';
}
/**
 * 动态获取数据库信息
 * @param $tname 表名
 * @param $where 搜索条件
 * @param $order 排序条件 如："id desc";
 * @param $count 取前几条数据 
 */
function findList($tname,$where="", $order, $count){
	$m = M($tname);
	if(!empty($where)){
		$m->where($where);
	}
	if(!empty($order)){
		$m->order($order);
	}
	if($count>0){
		$m->limit($count);
	}
	return $m->select();
}
function findById($name,$id){
	$m = M($name);
	return $m->find($id);
}
function attrById($name, $attr, $id){
	$m = M($name);
	$a = $m->where('id='.$id)->getField($attr);
	return $a;
}


//CommonModel 自动继承
function CM($name){
	static $_model = array();
	if(isset($_model[$name])){
		return $_model[$name];
	}
$class=$name."Model";
import('@.Model.' . $className);
	if(class_exists($class)){
		$return=new $class();
	}else{
		$return=M("CommonModel:".$name);
	}
	$_model[$name]=$return;

return $return;
}


function list_to_tree($list, $pk='id',$pid = 'pid',$child = '_child',$root=0)
{
    // 创建Tree
    $tree = array();
    if(is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] =& $list[$key];
        }
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId = $data[$pid];
            if ($root == $parentId) {
                $tree[] =& $list[$key];
            }else{
                if(isset($refer[$parentId])) {
                    $parent =& $refer[$parentId];
                    $parent[$child][] =& $list[$key];
                }
            }
        }
    }
    return $tree;
}
/*推送信息*/
function showPush($ispush,$id,$item,$callback="") {
	switch ($ispush) {
		case 0 :
			$info = '<a href="__URL__/push/ID/' . $id . '/item/'. $item .'/navTabId/__MODULE__" target="ajaxTodo" callback="'.$callback.'">否</a>';
			break;
		case 1 :
			$info = '<a href="__URL__/pull/ID/' . $id . '/item/'. $item .'/navTabId/__MODULE__" target="ajaxTodo" callback="'.$callback.'">是</a>';
			break;
	}
	return $info;
}
/*美食推送*/
function pushFood($ispush,$id,$callback="") {
	switch ($ispush) {
		case 1 :
			$info = '<a href="__URL__/food/ID/' . $id . '/navTabId/__MODULE__" target="dialog" mask="true" callback="'.$callback.'">A区</a>';
			break;
		case 2 :
			$info = '<a href="__URL__/food/ID/' . $id . '/navTabId/__MODULE__" target="dialog" mask="true" callback="'.$callback.'">B区</a>';
			break;
		case 3 :
			$info = '<a href="__URL__/food/ID/' . $id . '/navTabId/__MODULE__" target="dialog" mask="true" callback="'.$callback.'">C区</a>';
			break;
	}
	return $info;
}

	/**
	*@功能：根据数组字符得到名称
	*/
function  getName($strs){
	$result = array(); 
	$array = array(); 
	$strs = str_replace("n", ',', $strs); 
	$strs = str_replace("rn", ',', $strs); 
	$strs = str_replace(' ', ',', $strs); 
	$array = explode(',', $strs); 
	foreach ($array as $key => $value) { 
	if ('' != ($value = trim($value))) { 
	$model = M('Class2');
	$where['ID'] = $value;
	$list = $model->where($where)->getField('Class2Name');
	$result[] =$list; 
	$str .=$list." | ";
	} 
	}
	return $str;
}
	/**
	*@法律问答追问
	*/
	function goOnQues($id){
		$model = M('ZjLawQuestion');
		$content= $model->field('content')->where('pid='.$id)->select();
		return $content;
	}	
	/**
	*@简历开关
	*/
	function getKg($Jlkg, $id, $callback=""){
	switch ($Jlkg) {
		case 0 :
			$info = '<a href="__URL__/open/ID/' . $id . '/navTabId/__MODULE__" target="ajaxTodo" mask="true" callback="'.$callback.'">关</a>';
			break;
		case 1 :
			$info = '<a href="__URL__/close/ID/' . $id . '/navTabId/__MODULE__" target="ajaxTodo" mask="true" callback="'.$callback.'">开</a>';
			break;
	}
	return $info;
	}
	/**
	*@人才库返回性别
	*/
	function getSex($xb){
	switch ($xb) {
		case 0 :
			$info = '女';
			break;
		case 1 :
			$info = '男';
			break;
	}
	return $info;
	}
	/**
	*@人才库返回返回行业类别
	*/
	function getYqhy($id){
		$model=M('RcCls');
		$where['id'] = $id;
		$info=$model->where($where)->getField('Zw_name');
		return $info;
	}
	
	/**
	*@返回号码类型
	*/
	function getMobile($lx){
 	$model=M('ZjTypes');
	$where['id']=$lx;
	$info=$model->where($where)->getField('name');
	return $info; 
	}
	/**
	*@根据id查找Class1
	*/
	function getClassOne($id){
 	$model=M('Class1');
	$where['id']=$id;
	$info=$model->where($where)->getField('Class1Name');
	return $info; 
	}
	/**
	*@根据id查找Class1
	*/
	function getClassTwo($id){
 	$model=M('Class2');
	$where['id']=$id;
	$info=$model->where($where)->getField('Class2Name');
	return $info; 
	}
	/*广告位置*/
	function getMads($code){
		$model = M('ZjboeeDatatict');
		$where['TYPE'] = 'position';
		$where['CODE'] = $code;
		$name= $model->where($where)->getField('Name');
		return $name;
	}
	/*广告类型*/
	function getMtype($type){
		$model = M('ZjTypes');
		$where['id'] = $type;
		$name= $model->where($where)->getField('name');
		return $name;
	}
	/*根据广告位置查询区域*/
	function getPlace($type){
	   $model= M("MAdsType");
	   $where['id']=$type;	
	   $name=$model->where($where)->getField('typename');	     
	   return $name;
	}
	/*得到所属区域*/
	function getArea($qy){
	   $model= M("Area");
	   $where['ID']=$qy;	
	   $name=$model->where($where)->getField('qy');	     
	   return $name;
	}
	/*得到用户验证状态*/
	function getYz($yz){
	   $model= M("ZjboeeDatatict");
	   $where['CODE']=$yz;	
	   $where['TYPE']='verification';
	   $yz=$model->where($where)->getField('NAME');	     
	   return $yz;
	}
	/*查询出相关信息名称*/
	function getTypes($lx){
	switch ($lx) {
		case 'color' :
			$show = '汽车颜色';
			break;
		case 'types' :
			$show = '汽车类型';
			break;
		case 'hdlx' :
			$show = '号段类型';
			break;
		case 'brand' :
			$show = '汽车品牌';
			break;
		case 'haoduan' :
			$show = '号段';
			break;
		case 'hx' :
			$show = '户型';
			break;
		case 'lc' :
			$show = '楼层';
			break;
		case 'zx' :
			$show = '装修';
			break;
		case 'gglx' :
			$show = '广告类型';
			break;
		case 'bsq' :
			$show = '变速器';
			break;
		case 'lx' :
			$show = '房屋地址';
			break;
	}
	return $show;
		}
	/**
	*@功能：防御XSS攻击
	*/

	function remove_xss($val) {
	   $val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);
	   $search = 'abcdefghijklmnopqrstuvwxyz';
	   $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	   $search .= '1234567890!@#$%^&*()';
	   $search .= '~`";:?+/={}[]-_|\'\\';
	   for ($i = 0; $i < strlen($search); $i++) {
		  $val = preg_replace('/(&#[xX]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ;
		  $val = preg_replace('/(�{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ;
	   }
	   $ra1 = array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
	   $ra2 = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
	   $ra = array_merge($ra1, $ra2);
	   $found = true;
	   while ($found == true) {
		  $val_before = $val;
		  for ($i = 0; $i < sizeof($ra); $i++) {
			 $pattern = '/';
			 for ($j = 0; $j < strlen($ra[$i]); $j++) {
				if ($j > 0) {
				   $pattern .= '(';
				   $pattern .= '(&#[xX]0{0,8}([9ab]);)';
				   $pattern .= '|';
				   $pattern .= '|(�{0,8}([9|10|13]);)';
				   $pattern .= ')*';
				}
				$pattern .= $ra[$i][$j];
			 }
			 $pattern .= '/i';
			 $replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2); 
			 $val = preg_replace($pattern, $replacement, $val); 
			 if ($val_before == $val) {
				$found = false;
			 }
		  }
	   }
	   return $val;
	}
	
?>