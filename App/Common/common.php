<?php
/**
 *  $功能：加密算法
 */
function enCode($string = '', $skey = 'dGzni5DcMNi1QaKF8507YcoWkqhzTCPI')
{
    $skey = array_reverse(str_split($skey));
    $strArr = str_split(base64_encode($string));
    $strCount = count($strArr);
    foreach ($skey as $key => $value) {
        $key < $strCount && $strArr[$key] .= $value;
    }
    return str_replace('=', 'O0O0O', join('', $strArr));
}

/**
 *  $功能：解密算法
 */
function deCode($string = '', $skey = 'dGzni5DcMNi1QaKF8507YcoWkqhzTCPI')
{
    $skey = array_reverse(str_split($skey));
    $strArr = str_split(str_replace('O0O0O', '=', $string), 2);
    $strCount = count($strArr);
    foreach ($skey as $key => $value) {
        $key < $strCount && $strArr[$key] = $strArr[$key][0];
    }
    return base64_decode(join('', $strArr));
}

/**
 * @功能：防御XSS攻击
 */
function remove_xss($val)
{
    $val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);
    $search = 'abcdefghijklmnopqrstuvwxyz';
    $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $search .= '1234567890!@#$%^&*()';
    $search .= '~`";:?+/={}[]-_|\'\\';
    for ($i = 0; $i < strlen($search); $i++) {
        $val = preg_replace('/(&#[xX]0{0,8}' . dechex(ord($search[$i])) . ';?)/i', $search[$i], $val); // with a ;
        $val = preg_replace('/(?{0,8}' . ord($search[$i]) . ';?)/', $search[$i], $val); // with a ;
    }
    $ra1 = array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title');
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
                    $pattern .= '|(?{0,8}([9|10|13]);)';
                    $pattern .= ')*';
                }
                $pattern .= $ra[$i][$j];
            }
            $pattern .= '/i';
            $replacement = substr($ra[$i], 0, 2) . '<x>' . substr($ra[$i], 2);
            $val = preg_replace($pattern, $replacement, $val);
            if ($val_before == $val) {
                $found = false;
            }
        }
    }
    return $val;
}

/**
 * @功能：根据赛事状态返回时间
 * @时间：20150402
 */
function getGameTime($id, $state)
{
    $model = D('VGameActivity');
    if ($state == 1) {
        $result = $model->field('reg_begin_date,reg_end_date')->where('id=' . $id)->find();
        $time = $result['reg_begin_date'] . '—' . $result['reg_end_date'];
    } else {
        $result = $model->field('start_date,end_date')->where('id=' . $id)->find();
        $time = $result['start_date'] . '—' . $result['end_date'];
    }
    return $time;
}
/**
 * @功能：赛事、活动状态
 * @时间：20150402
 */
function getState($status)
{
    switch ($status) {
        case 1:
            $status  ='报名中';
            break;
        case 2:
            $status  = '待开赛';
            break;
        case 3:
            $status  = '比赛中';
            break;
        case 4:
            $status  = '已结束';
            break;
    }

    return $status;
}
/**
 * @功能：返回赛事、活动类别
 * @时间：20150402
 */
function getSportName($sportid)
{
    return D('DzSport')->where('id='.$sportid)->getField('name');
}

/**
 * @功能：赛事、活动关注数
 * @时间：20150407
 */
function getFocus($id,$type)
{
  return D('OpFocus')->where('`source_id`='.$id .' and `source_type` ='.$type)->count();
}
/**
 *  @功能：格式化时间
 *  @时间：20150412
 */
function m_date($time = NULL) {
    $time  = strtotime($time);
    $time = $time === NULL || $time > time() ? time() : intval($time);
    $t = time() - $time; //时间差 （秒）
    if ($t == 0)
        $text = '刚刚';
    elseif ($t < 60)
        $text = $t . '秒前'; // 一分钟内
    elseif ($t < 60 * 60)
        $text = floor($t / 60) . '分钟前'; //一小时内
    elseif ($t < 60 * 60 * 24)
        $text = floor($t / (60 * 60)) . '小时前'; // 一天内
    elseif ($t < 60 * 60 * 24 * 2)
        $text = '昨天 ' . date('H:i', $time); //两天内
    elseif ($t < 60 * 60 * 24 * 3)
        $text = '前天 ' . date('H:i', $time); // 三天内
    elseif ($t < 60 * 60 * 24 * 30)
        $text = date('m月d日 H:i', $time); //一个月内
    elseif ($t < 60 * 60 * 24 * 365)
        $text = date('Y年m月d日', $time); //一年内
    else
        $text = date('Y年m月d日', $time); //一年以前
    return $text;
}
/**
 *  @功能：返回登录用户
 *  @时间：20150419
 */
function getLoginUser(){
    $id = deCode(I('session.mark_id'));
    $user = D('DbUser')->where("id = '%d'", $id)->field('nick_name,mobile')->find();
    if($user['nick_name']){
        return $user['nick_name'];
    }else{
        return $user['mobile'];
    }
}
/****************************************************************后台方法****************************************************************/
/*
 * @功能：信息状态操作
 * @时间:20150419
 */
function showStatus($status, $id, $callback="",$before,$after) {
    switch ($status) {
        case '0':
        case"F":
            $info = '<a href="__URL__/resume/id/' . $id . '/navTabId/__MODULE__" target="ajaxTodo" callback="'.$callback.'">'.$before.'</a>';
            break;
        case 2 :
            $info = '<a href="__URL__/pass/id/' . $id . '/navTabId/__MODULE__" target="ajaxTodo" callback="'.$callback.'">'.$before.'</a>';
            break;
        case '1' :
        case "T" :
            $info = '<a href="__URL__/forbid/id/' . $id . '/navTabId/__MODULE__" target="ajaxTodo" callback="'.$callback.'">'.$after.'</a>';
            break;
        case - 1 :
            $info = '<a href="__URL__/recycle/id/' . $id . '/navTabId/__MODULE__" target="ajaxTodo" callback="'.$callback.'">还原</a>';
            break;
    }
    return $info;
}
/*
 * @功能：返回信息状态
 * @时间:20150419
 */
function getStatus($status, $imageShow = true) {
    switch ($status) {
        case '0' :
            $showText = '禁用';
            $showImg = '<IMG SRC="' . __PUBLIC__ . '/images/default/locked.gif" WIDTH="20" HEIGHT="20" BORDER="0" ALT="禁用">';
            break;
        case '3':
        case 'F':
            $showText = '待审';
            $showImg = '<IMG SRC="' . __PUBLIC__ . '/images/default/prected.gif" WIDTH="20" HEIGHT="20" BORDER="0" ALT="待审">';
            break;
        case '2' :
            $showText = '删除';
            $showImg = '<IMG SRC="' . __PUBLIC__ . '/images/default/del.gif" WIDTH="20" HEIGHT="20" BORDER="0" ALT="删除">';
            break;
        case '1' :
        case "T" :
        default :
            $showText = '正常';
            $showImg = '<IMG SRC="' . __PUBLIC__ . '/images/default/ok.gif" WIDTH="20" HEIGHT="20" BORDER="0" ALT="正常">';

    }
    return ($imageShow === true) ?  $showImg  : $showText;

}
/*
 * @功能：赛事详情
 * @时间:20150419
 */
function getSecondSport($id){
    $list =D('DzSport')->where('pid='.$id)->getField('name',true);
    return implode(' | ',$list);
}
/*
 * @功能：返回用户名称
 * @时间:20150419
 */
function getUserName($id){
    $user = D('DbUser')->where("id = '%d'", $id)->field('nick_name,mobile')->find();
    if($user['nick_name']){
        return $user['nick_name'];
    }else{
        return $user['mobile'];
    }
}
/*
 * @功能：返回赛事、场馆、活动类别
 * @时间:20150419
 */
function getSportType($type){
    switch ($type) {
        case 1 :
            $result = '赛事';
            break;
        case 2 :
            $result = '活动';
            break;
        case 3 :
            $result = '场馆';
            break;
    }
    return  $result;
}
/*
 * @功能：返回图片路径
 * @时间:20150419
 */
function getImageUrl($id){
    return  D('DbImages')->where('id='.$id)->getField('local_url');
}
/*
 * @功能：返回赛事字段信息
 * @时间:20150419
 */
function getGameField($field){
    switch ($field) {
        case "game_declare" :
            $result = '参赛声明';
            break;
        case "content" :
            $result = '赛事介绍';
            break;
        case "member_right" :
            $result = '会员权益';
            break;
        case "aout_route" :
            $result = '比赛路线';
            break;
        case "about_cost" :
            $result = '关于费用';
            break;
        case "about_trip" :
            $result = '行程安排';
            break;
        case "about_hotal" :
            $result = '入住酒店';
            break;
    }
    return  $result;
}
/*
 * @功能：返回赛事名称
 * @时间:20150419
 */
function getGameName($id){
    return  D('DbGame')->where('id='.$id)->getField('name');
}
/*
 * @功能：返回活动名称
 * @时间:20150419
 */
function getActivityName($id){
    return  D('DbActivity')->where('id='.$id)->getField('name');
}
/*
 * @功能：返回活动报名审核状态
 * @时间:20150419
 */
function getJoinActivityVerify($verify){
    switch ($verify) {
        case 0 :
            $result = '待审核';
            break;
        case 1 :
            $result = '通过';
            break;
        case 2 :
            $result = '不通过';
            break;
    }
    return  $result;
}
/*
 * @功能：返回登录用户头像
 * @时间:20150419
 */
function getUserImage($id){
    $user_head = D('DbUser')->where('id='.deCode($id))->getField('user_head');
    return  D('DbImages')->where('id='.$user_head)->getField('local_url');
}
/*
 * @功能：返回用户头像
 * @时间:20150419
 */
function getUsersImage($id){
    $user_head = D('DbUser')->where('id='.$id)->getField('user_head');
    $local_url  = D('DbImages')->where('id='.$user_head)->getField('local_url');
    if($local_url){
        return $local_url;
    }else{
        return '/Public/images/default/web_pic.jpg';
    }
}
/*
 * @功能：返回区域名称
 * @时间:20150419
 */
function getRegionName($id){
   return D('DbRegion')->where('id='.$id)->getField('name');
}
/*
 * @功能：赛事分组报名信息
 * @时间:20150419
 */
function getGameGroup($group_id,$game_id){
    $result = D('OpJoinGame')->where('game_id='.$game_id.' and group_id='.$group_id)->select();
    if($result){
        return 'radio-disabled';
    }
}
/*
 * @功能：赛事关注信息
 * @时间:20150419
 */
function getGameFocus($source_id,$user_id,$source_type){
    $result = D('OpFocus')->where('user_id='.deCode($user_id).' and source_id='.$source_id.' and source_type ='.$source_type)->select();
    if($result){
        return '取消关注';
    }else{
        return '关注';
    }
}
/*
 * @功能：赛事、活动状态
 * @时间:20150419
 */
function getStates($id){
    $result = D('VGameActivity')->where('id='.$id)->getField('status');
    switch ($result) {
        case 1 :
            $result = '报名中';
            break;
        case 2 :
            $result = '待开赛';
            break;
        case 3 :
            $result = '比赛中';
            break;
        case 4 :
            $result = '已结束';
            break;
    }
    return  $result;
}
/*
 * @功能：数组转为字符串
 * @时间:20150419
 */
function ArrayToStr($arr){
    $str = join(",",$arr);
    $result = "'".str_replace(",","','",$str)."'";
    return $result;
}
?>