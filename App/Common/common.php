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
function getStatus($id,$type)
{
    $status = D('VGameActivity')->where('id='.$id.' and type = '."'".$type."'")->getField('status');

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

?>