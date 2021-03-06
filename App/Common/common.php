<?php
/**
 *  功能:SEO标题
 */
function SEO()
{
    $list = GROUP_NAME;
    switch ($list) {
        case 'Home':
            $list = array(
                'title' => '松原运动网|松原比赛|松原赛事',
                'Keywords' => '松原运动网,松原体育,松原赛事,松原活动,松原比赛,松原场馆,松原羽毛球,松原乒乓球,松原篮球,松原台球,松原户外,松原健美,松原体育舞蹈,松原瑜伽,松原自行车',
                'Description' => '松原运动网致力于打造松原最大的体育健康互动平台，以互联网和移动互联网体育赛事服务、体育社交、体育线上线下互动业务为核心，形成新一代参与型大众体育健康消费的互联网新入口',
            );
            return $list;
            break;

        case 'Game':
            $list = array(
                'title' => '松原运动网|松原比赛|松原赛事',
                'Keywords' => '松原运动网,松原体育,松原赛事,松原比赛,松原羽毛球,松原乒乓球,松原篮球,松原台球,松原户外,松原健美,松原体育舞蹈,松原瑜伽,松原自行车,松原马拉松，松原路跑,发布赛事',
                'Description' => '松原运动|爱运动|赛事搜索',
            );
            return $list;
            break;

        case 'Activity':
            $list = array(
                'title' => '松原运动网|松原活动',
                'Keywords' => '松原运动网,松原体育,松原活动,松原羽毛球,松原乒乓球,松原篮球,松原台球,松原户外,松原健美,松原体育舞蹈,松原瑜伽,松原自行车,松原马拉松，松原路跑,松原钓鱼,发布活动,参加活动,',
                'Description' => '松原运动网|爱运动|约活动',
            );
            return $list;
            break;
        case 'Friends':
            $list = array(
                'title' => '松原运动网|松原赛友圈|松原朋友圈',
                'Keywords' => '松原运动网,松原体育,松原朋友圈,松原赛友圈',
                'Description' => '松原运动网|朋友圈|赛友圈',
            );
            return $list;
            break;
        case 'Venue':
            $list = array(
                'title' => '松原运动网|松原体育场馆|松原运动场馆',
                'Keywords' => '松原运动网,松原场馆,松原场馆价格,松原羽毛球馆,松原乒乓球馆,松原篮球馆,松原台球馆,松原体育舞蹈馆,松原瑜伽馆',
                'Description' => '松原运动网|场馆',
            );
            return $list;
            break;
        case 'Association':
            $list = array(
                'title' => '松原运动网|松原体育协会|协会',
                'Keywords' => '松原运动网|体育协会 加协会|松原乒乓球协会 松原篮球协会 松原足球协会 松原羽毛球协会 松原自行车协会',
                'Description' => '松原运动网|体育协会|协会',
            );
            return $list;
            break;
        case 'Doyenhall':
            $list = array(
                'title' => '松原运动网|松原达人堂|松原运动达人',
                'Keywords' => '松原运动网,松原运动达人,松原运动明星',
                'Description' => '松原运动网|达人堂|运动达人',
            );
            return $list;
            break;
        default:
            $list = array(
                'title' => '松原运动网|松原比赛|松原赛事',
                'Keywords' => '松原运动网,松原体育,松原赛事,松原活动,松原比赛,松原场馆',
                'Description' => '松原运动网致力于打造松原最大的体育健康互动平台，以互联网和移动互联网体育赛事服务、体育社交、体育线上线下互动业务为核心，形成新一代参与型大众体育健康消费的互联网新入口。',
            );
            return $list;
            break;
    }
}

/**
 *  $功能：详细优化
 */
function site($name, $description)
{
    $list = ACTION_NAME;
    switch ($list) {
        case 'game_detail':
            $list = array(
                'title' => $name . '|松原运动|赛事|' . $name,
                'Keywords' => '松原运动|赛事|' . $name . '报名时间 报名费用 规则介绍 分享 照片 成绩查询 地点 主办方 赛事主办 话题讨论 赛事赛友 赛事图片墙',
                'Description' => '松原运动|赛事|' . $name,
            );
            return $list;
            break;

        case 'activity_detail':
            $list = array(
                'title' => '松原运动|活动|' . $name,
                'Keywords' => '松原运动|活动|' . $name,
                'Description' => '松原运动|活动|' . $name,
            );
            return $list;
            break;

        case 'venue_detail':
            $list = array(
                'title' => '松原运动|场馆|' . $name,
                'Keywords' => '松原运动|场馆|' . $name,
                'Description' => '松原运动|场馆|' . $name,
            );
            return $list;
            break;
        case 'passport':
            $list = array(
                'title' => '松原运动网|爱运动|足迹',
                'Keywords' => '松原运动网|爱运动|足迹',
                'Description' => '松原运动网|爱运动|足迹',
            );
            return $list;
            break;
    }
}

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
 * @功能：角色管理分组名称
 * @时间：20150701
 */
function getGroupName($id)
{
    if ($id == 0) {
        return '无上级组';
    }
    if ($list = F('groupName')) {
        return $list [$id];
    }
    $dao = D("DbRole");
    $list = $dao->select(array('field' => 'id,name'));
    foreach ($list as $vo) {
        $nameList [$vo ['id']] = $vo ['name'];
    }
    $name = $nameList [$id];
    F('groupName', $nameList);
    return $name;
}

/**
 * @功能：角色管理分组授权树形
 * @时间：20150701
 */
function list_to_tree($list, $pk = 'id', $pid = 'pid', $child = '_child', $root = 0)
{
    // 创建Tree
    $tree = array();
    if (is_array($list)) {
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
            } else {
                if (isset($refer[$parentId])) {
                    $parent =& $refer[$parentId];
                    $parent[$child][] =& $list[$key];
                }
            }
        }
    }
    return $tree;
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
            $status = '报名中';
            break;
        case 2:
            $status = '待开赛';
            break;
        case 3:
            $status = '比赛中';
            break;
        case 4:
            $status = '已结束';
            break;
        case 5:
            $status = '筹备中';
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
    return D('DzSport')->where('id=' . $sportid)->getField('name');
}

/**
 * @功能：赛事、活动关注数
 * @时间：20150407
 */
function getFocus($id, $type)
{
    return D('OpFocus')->where('`source_id`=' . $id . ' and `source_type` =' . $type)->count();
}

/**
 *  @功能：格式化时间
 *  @时间：20150412
 */
function m_date($time = NULL)
{
    $time = strtotime($time);
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
function getLoginUser()
{
    $id = deCode(I('session.mark_id'));
    $user = D('DbUser')->where("id = '%d'", $id)->field('nick_name,mobile')->find();
    if ($user['nick_name']) {
        return $user['nick_name'];
    } else {
        return $user['mobile'];
    }
}

/****************************************************************后台方法****************************************************************/
/*
 * @功能：信息状态操作
 * @时间:20150419
 */
function showStatus($status, $id, $callback = "", $before, $after)
{
    switch ($status) {
        case '0':
        case"F":
            $info = '<a href="__URL__/resume/id/' . $id . '/navTabId/__MODULE__" target="ajaxTodo" callback="' . $callback . '">' . $before . '</a>';
            break;
        case 2 :
            $info = '<a href="__URL__/pass/id/' . $id . '/navTabId/__MODULE__" target="ajaxTodo" callback="' . $callback . '">' . $before . '</a>';
            break;
        case '1' :
        case "T" :
            $info = '<a href="__URL__/forbid/id/' . $id . '/navTabId/__MODULE__" target="ajaxTodo" callback="' . $callback . '">' . $after . '</a>';
            break;
        case -1 :
            $info = '<a href="__URL__/recycle/id/' . $id . '/navTabId/__MODULE__" target="ajaxTodo" callback="' . $callback . '">还原</a>';
            break;
    }
    return $info;
}

/*
 * @功能：返回信息状态
 * @时间:20150419
 */
function getStatus($status, $imageShow = true)
{
    switch ($status) {
        case '0' :
        case 'F':
            $showText = '禁用';
            $showImg = '<IMG SRC="' . __PUBLIC__ . '/images/default/locked.gif" WIDTH="20" HEIGHT="20" BORDER="0" ALT="禁用">';
            break;
        case '3':
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
    return ($imageShow === true) ? $showImg : $showText;

}

/*
 * @功能：赛事详情
 * @时间:20150419
 */
function getSecondSport($id)
{
    $list = D('DzSport')->where('pid=' . $id)->getField('name', true);
    return implode(' | ', $list);
}

/*
 * @功能：返回用户名称
 * @时间:20150419
 */
function getUserName($id)
{
    $user = D('DbUser')->where("id = '%d'", $id)->field('nick_name,mobile')->find();
    if ($user['nick_name']) {
        return $user['nick_name'];
    } else {
        return $user['mobile'];
    }
}

/*
 * @功能：返回赛事、场馆、活动类别
 * @时间:20150419
 */
function getSportType($type)
{
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
        case 4 :
            $result = '话题';
            break;
    }
    return $result;
}

/*
 * @功能：返回图片路径
 * @时间:20150419
 */
function getImageUrl($id)
{
    return D('DbImages')->where('id=' . $id)->getField('local_url');
}

/*
 * @功能：返回赛事字段信息
 * @时间:20150419
 */
function getGameField($field)
{
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
    return $result;
}

/*
 * @功能：返回赛事名称
 * @时间:20150419
 */
function getGameName($id)
{
    return D('DbGame')->where('id=' . $id)->getField('name');
}

/*
 * @功能：返回活动名称
 * @时间:20150419
 */
function getActivityName($id)
{
    return D('DbActivity')->where('id=' . $id)->getField('name');
}

/*
 * @功能：返回活动/赛事报名审核状态
 * @时间:20150419
 */
function getJoinActivityVerify($verify)
{
    switch ($verify) {
        case 0 :
            $result = '<span style="color:blue">待审核</span>';
            break;
        case 1 :
            $result = '通过';
            break;
        case 2 :
            $result = '<span style="color:red">不通过</span>';
            break;
    }
    return $result;
}

/*
 * @功能：返回登录用户头像
 * @时间:20150419
 */
function getUserImage($id)
{
    $user_head = D('DbUser')->where('id=' . deCode($id))->getField('user_head');
    return D('DbImages')->where('id=' . $user_head)->getField('size2_url');
}

/*
 * @功能：返回用户头像
 * @时间:20150419
 */
function getUsersImage($id)
{
    $user_head = D('DbUser')->where('id=' . $id)->getField('user_head');
    $local_url = D('DbImages')->where('id=' . $user_head)->getField('size2_url');
    if ($local_url) {
        return $local_url;
    } else {
        return '/Public/images/default/web_pic.jpg';
    }

}

/*
 * @功能：返回区域名称
 * @时间:20150419
 */
function getRegionName($id)
{
    return D('DbRegion')->where('id=' . $id)->getField('name');
}

/*
 * @功能：赛事分组报名信息
 * @时间:20150419
 */
function getGameGroup($group_id, $game_id)
{
    $result = D('OpJoinGame')->where('game_id=' . $game_id . ' and group_id=' . $group_id)->select();
    if ($result) {
        return 'radio-disabled';
    }
}

/*
 * @功能：赛事关注信息
 * @时间:20150419
 */
function getGameFocus($source_id, $user_id, $source_type)
{
    if ($user_id) {
        $result = D('OpFocus')->where('user_id=' . deCode($user_id) . ' and source_id=' . $source_id . ' and source_type =' . $source_type)->select();
        if ($result) {
            //关注
            return 0;
        } else {
            //取消关注
            return 1;
        }
    }
}

/*
 * @功能：加赛友判断
 * @时间:20150419
 */
function getFriends($user_id, $friend_id)
{
    if (deCode($user_id) == $friend_id) {
        return 1;
    } else {
        $result = D('OpUserFriend')->where('user_id=' . deCode($user_id) . ' and friend_id=' . $friend_id)->select();
        if ($result) {
            //已添加
            return 1;
        } else {
            //未添加
            return 0;
        }
    }
}

/*
 * @功能：赛事、活动状态
 * @时间:20150419
 */
function getStates($id)
{
    $result = D('VGameActivity')->where('id=' . $id)->getField('status');
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
        case 5:
            $status = '筹备中';
            break;
    }
    return $result;
}

/*
 * @功能：发起的活动
 * @时间:20150419
 */
function  initiate_activity($id)
{
    return D('DbActivity')->where('input_user=' . $id)->count();
}

/*
 * @功能：参加的活动
 * @时间:20150419
 */
function  join_activity($id)
{
    return D('OpJoinActivity')->where('user_id=' . $id)->count();
}

/*
 * @功能：赛事组别
 * @时间:20150419
 */
function  GameGroup($game_id, $user_id)
{
    $group_id = D('OpJoinGame')->field('group_id')->where('game_id=' . $game_id . ' and user_id=' . $user_id)->select();
    $group_name = D('OpGameGroup')->where('id=' . $group_id[0]['group_id'])->getField('group_name');
    return $group_name;
}

/*
 * @功能：个人运动喜好
 * @时间:20150419
 */
function  UserFavGame($interest)
{
    $array = strtoarr($interest);
    foreach ($array as $key => $value) {
        if ('' != ($value = trim($value))) {
            $model = M('DzSport');
            $where['id'] = $value;
            $list = $model->where($where)->getField('name');
            $str .= $list . "  ";
        }
    }
    return $str;
}

/*
 * @功能：用户总赛事数量
 * @时间: 20150512
 */
function  UserGameCount($mark_id)
{
    $map['user_id'] = deCode($mark_id);
    $count = D('VJoinGame')->where($map)->count();
    $where['input_user'] = deCode($mark_id);
    $count1 = D('DbGame')->where($where)->count();
    return $count + $count1;
}

/*
 * @功能：用户总活动数量
 * @时间: 20150512
 */
function  UserActivityCount($mark_id)
{
    $map['user_id'] = deCode($mark_id);
    $count = D('VJoinActivity')->where($map)->count();
    $where['input_user'] = deCode($mark_id);
    $count1 = D('DbActivity')->where($where)->count();
    return $count + $count1;
}

/*
 * @功能：用户话题数量
 * @时间: 20150512
 */
function  UserTopicCount($mark_id)
{
    $map['user_id'] = deCode($mark_id);
    $count = D('OpGameTopic')->where($map)->count();
    return $count;
}

/*
 * @功能：赛事、活动、场馆是否推荐
 * @时间: 20150512
 */
function  isGameRecommend($id, $type)
{
    $list = M('OpRecommend')->where('category = "recommend" and recommend_type = "' . $type . '" and gc_id=' . $id)->find();
    if ($list) {
        return false;
    } else {
        return true;
    }
}

/*
 * @功能：是否是精选赛事
 * @时间: 20150617
 */
function  isChoiceGame($id)
{
    $result = M('OpRecommend')->where('category = "choice" and recommend_type="game" and gc_id=' . $id)->find();
    if ($result) {
        $showImg = '<IMG SRC="' . __PUBLIC__ . '/images/default/ok.gif" WIDTH="20" HEIGHT="20" BORDER="0" ALT="正常">';
    } else {
        $showImg = '<IMG SRC="' . __PUBLIC__ . '/images/default/locked.gif" WIDTH="20" HEIGHT="20" BORDER="0" ALT="禁用">';
    }
    return $showImg;
}

/*
 * @功能：返回推荐信息名称
 * @时间: 20150512
 */
function  getRecommendName($id, $type)
{
    if ($type == 'game') {
        return D('DbGame')->where('id=' . $id)->getField('name');
    }
    if ($type == 'activity') {
        return D('DbActivity')->where('id=' . $id)->getField('name');
    }
    if ($type == 'venue') {
        return D('DbVenue')->where('id=' . $id)->getField('name');
    }
}

/*
 * @功能：评论来源
 * @时间: 20150607
 */
function getCommentName($source_id, $source_type)
{
    switch ($source_type) {
        //活动
        case 2 :
            $result = D('DbActivity')->where('id=' . $source_id)->getField('name');
            break;
        //场馆
        case 3 :
            $result = D('DbVenue')->where('id=' . $source_id)->getField('name');
            break;
        //话题
        case 4 :
            $game_id = D('OpGameTopic')->where('id=' . $source_id)->getField('game_id');
            $result = D('DbGame')->where('id=' . $game_id)->getField('name');
            break;
    }
    return $result;
}

/*
* 功能：判断是否登录
* 时间：20150407
*/
function isLogin()
{
    $mark = I('session.mark_id');
    if ($mark) {
        return true;
    } else {
        return false;
    }
}

/*
* 功能：省份->区域
* 时间：20150615
*/
function getRegion($id, $level)
{
    if (($id != 1) && ($id != 0)) {
        $list = M('DbRegion')->where('pid=' . $id)->getField('name', true);
        return implode(' | ', $list);
    }
}

/*
* 功能：分组名称
* 时间：20150615
*/
function getGameGroupName($id)
{
    return M('OpGameGroup')->where('id=' . $id)->getField('group_name');
}

/*
 * @功能：广告位置详情
 * @时间:20150419
 */
function getSecondPosition($id)
{
    $list = D('DzAdPosition')->where('pid=' . $id)->getField('name', true);
    return implode(' | ', $list);
}

/*
 * @功能：广告调用
 * @时间:20150804
 */
function ads($id)
{
    $list = D('Public/Ads')->ads_list($id);
    foreach ($list AS $vo) {
        //整体判断开始结束时间
        $t = round((strtotime($vo['stoptime']) - time()) / 3600 / 24); //到期时间  - 当前时间
        if ($t > 0) {
            //长条广告 1190*60
            if ($vo['type'] == '1') {
                if (trim($vo['img2']) == '' and trim($vo['link1']) == '') {
                    echo '<div class="ad container"><img src="__PUBLIC__/Upload/ad/' . $vo['img1'] . '"/></div>';
                } else {
                    echo '<div class="ad container"><a target="_blank" href="' . larger($vo['id']) . '"><img src="__PUBLIC__/Upload/ad/' . $vo['img1'] . '"/></a></div>';
                }
            }
        }

    }
}

/*
 * @功能：广告大图插件
 * @时间:20150804
 */
function larger($val)
{
    $list = D('db_advertise')->field('id,link1,link2,img2,img1')->where("ID = '%d'", $val)->find();
    if ($list['link1'] != null or !empty($list['link1'])){
        if ((trim($list['link1']) == null) && ($list['img2'] == null or empty($list['img2']))) {
            return '#';
        } else {
            return U('/larger/' . $list['id'] . '@www.syyundong.com');
        }
    } else {
        if ($list['img2'] == null or empty($list['img2'])) {
            return '#';
        } else {
            return U('/larger/' . $list['id'] . '@www.syyundong.com');
        }
    }
}

/*
 * @功能：广告位置
 * @时间:20150804
 */
function getAdPosition($id)
{
    $model = M('DzAdPosition');
    $where['code'] = $id;
    $name = $model->where($where)->getField('name');
    return $name;
}

/*
 * @功能：广告到期时间
 * @时间:20150804
 */
function due_date($val)
{
    $time = time();
    $stop = strtotime($val);
    $temp = round(($stop - $time) / 3600 / 24); //到期时间  - 当前时间
    //$temp = $temp +1;
    if ($temp < 0) {
        $info = substr($val, 0, -8) .'|<span style="color:red">' . '过' . abs($temp) . '</span>';
    } elseif ($temp >= 0 and $temp <= 7) {
        $info = substr($val, 0, -8) .'|<span style="color:red">' . '剩' . abs($temp) . '</span>';
    } else {
        $info = substr($val, 0, -8) .'|<span style="color:red">' . '剩' . abs($temp) . '</span>';
    }
    return $info;
}

/*
 * @功能：数组转为字符串
 * @时间:20150419
 */
function ArrayToStr($arr)
{
    $str = join(",", $arr);
    $result = "'" . str_replace(",", "','", $str) . "'";
    return $result;
}

/*
 * @功能：字符串转为数组
 * @时间:20150419
 */
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

/*
 * @功能：字符串格式去除
 * @时间:20150419
 */
function  RemoveFormat($str)
{
    return str_replace(array('<p>', '</p>'), '', strip_tags(htmlspecialchars_decode(stripcslashes(stripslashes($str)))));
}

?>