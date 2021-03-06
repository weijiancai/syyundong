<?php

/**
 *@时间:20150316
 *@功能:显示首页
 */
class IndexAction extends BaseAction
{
    //首页内容
    public function index()
    {
        import('ORG.Util.Page');
        $model = D('VGameActivity');
        //赛事状态
        if ($_GET['statusReg'] == 'T') {
            $status = ',1';
        }
        if ($_GET['statusIn'] == 'T') {
            $status .= ',3';
        }
        if ($_GET['statusOver'] == 'T') {
            $status .= ',4';
        }
        $status = ltrim($status, ',');
        if ($_GET['state']) {
            $map['status'] = $_GET['state'];
        } else if ($status) {
            $map['status'] = array('in',strtoarr($status));
        }
        //关键字
        if (trim($_GET['keyword'])) {
            $map['name'] = array('like', '%' . trim($_GET['keyword']) . '%');
        }
        //赛事分类
        if (($_GET['sportTypeId']) && ($_GET['sportTypeId'] != 'all')) {
            $map['sport_sid'] = array('eq', $_GET['sportTypeId']);
        }
        //默认排序
        if (($_GET['orderByNew'] == 'S') or (empty($_GET['orderByNew']))) {
            $order = 'status asc';
        }
        //最新活动
        if ($_GET['orderByNew'] == 'C') {
            $order = 'start_date desc';
        }
        //最热活动
        if ($_GET['orderByNew'] == 'F') {
            $order = 'focus_count desc';
        }
        if ($_GET['date'] == 'today') {
            $map['start_date'] = array('like', date('Y-m-d') . '%');
        } else if ($_GET['date'] == 'tomorrow') {
            $map['start_date'] = array('like', date("Y-m-d", strtotime("+1 day")) . '%');
        }
        //省市
        if ($_GET['cityId']) {
            if ($_GET['cityId'] != 'all') {
                $map['city'] = array('eq', $_GET['cityId']);
                $buss = D('DbRegion')->where('pid = ' . $_GET['cityId'])->select();
            }
        }
        //区域
        if (($_GET['region'])&&($_GET['region']!='all')) {
            $map['region'] = $_GET['region'];
        }
        $map['type'] = array('eq', 'activity');
        $count = $model->where($map)->count();
        $Page = new Page($count, 10);
        $Page->setConfig("theme", "%first% %upPage%  %linkPage%  %downPage% %end% 共%totalPage% 页");
        $Page->rollPage = 10;
        $list = $model->limit($Page->firstRow . ',' . $Page->listRows)->where($map)->order($order)->select();
        $show = $Page->show();
        $this->assign('page', $show);
        $this->assign('activity', $list);
        $this->assign('count', $count);
        $this->assign('city', D('Public/Index')->city());
        $this->assign('venue_sport', $this->activity_sport());
        $this->assign('buss', $buss);
        $this->hotactivity();
        $this->sport_doyen();
        $this->display();
    }

    /*
     * @时间:20150406
     * @功能：发起活动
     */
    public function publish()
    {
        //首先判断用户是否登录
        $mark = I('session.mark_id');
        if ($mark) {
            $this->assign('venue_sport', $this->activity_sport());
            $this->assign('region', D('Public/Index')->region());
            $this->display();
        } else {
            $str = '<script> window.location.href="/login/login"</script>';
            echo $str;
        }
    }

    /*
     * @时间:20150618
     * @功能：发起活动
     */
    public function update()
    {
        //首先判断用户是否登录
        $mark = I('session.mark_id');
        if ($mark) {
            $this->assign('venue_sport', $this->activity_sport());
            $this->assign('region', D('Public/Index')->region());
            $this->display();
        } else {
            $str = '<script> window.location.href="/login/login"</script>';
            echo $str;
        }
    }

    /*
   * @时间:20150402
   * @功能：热门活动推荐
   */
    public function hotactivity()
    {
        $model = New Model();
        $list = $model->query('select v.id,o.sort_num, v.name,v.province,v.city,v.region,v.image,v.join_count,v.interest_count,v.cost,(v.limit_count-v.join_count) remain from v_game_activity v,op_recommend o
 where v.id = o.gc_id and o.recommend_type = "activity" and v.type="activity" order by o.sort_num');
        $this->assign('recommend', $list);
    }

    /*
     * @时间:20150408
     * @功能：活动详细页面
     */
    public function activity_detail()
    {
        $id = $_GET['id'];
        //感兴趣人数
        M('DbActivity')->where('id=' . $id)->setInc('interest_count', 1);
        //详情
        $detail = D('VGameActivity')->where('id=' . $id . ' and type=\'activity\'')->find();
        $this->assign('detail', $detail);
        //已通过报名
        $this->assign('through', D('VJoinActivity')->where('activity_id=' . $id . ' and verify_state=1')->select());
        $this->assign('through_count', D('VJoinActivity')->where('activity_id=' . $id . ' and verify_state=1')->count());
        //未通过报名
        $this->assign('not_through', D('VJoinActivity')->where('activity_id=' . $id . ' and verify_state=2')->select());
        $this->assign('not_through_count', D('VJoinActivity')->where('activity_id=' . $id . ' and verify_state=2')->count());
        //审核中
        $this->assign('wait', D('VJoinActivity')->where('activity_id=' . $id . ' and verify_state=0')->select());
        $this->assign('wait_count', D('VJoinActivity')->where('activity_id=' . $id . ' and verify_state=0')->count());
        $this->display();
    }

    /*
     * 功能:相似活动
     * 时间：20150407
     */
    public function SimilarActivity()
    {
        $where['id'] = array('neq', $_POST['id']);
        $where['sport_id'] = array('eq', $_POST['sport_id']);
        $ids = D('VGameActivity')->where($where)->getField('id', true);
        $len = count($ids);
        $result = rand(0, ($len - 4));
        if ($len < 4) {
            $result = 0;
        }
        $list = D('VGameActivity')->where($where)->limit($result, 4)->select();
        echo json_encode($list);
    }

    /*
     * @时间: 20150415
     * @功能：活动评论
     */
    public function publishReply()
    {
        $model = D('OpComment');
        $date['content'] = $_POST['content'];
        $date['user_id'] = deCode(I('session.mark_id'));
        $date['source_id'] = $_POST['source_id'];
        $date['source_type'] = 2;
        $date['input_date'] = date('Y-m-d H:i:s');
        $result = $model->add($date);
        if (false !== $result) {
            echo 1;
        } else {
            echo 0;
        }
    }

    /*
 * @时间: 20150415
 * @功能:评论回复
 */
    public function CommentReply()
    {
        $model = D('OpComment');
        $date['content'] = $_POST['content'];
        $date['replay_to'] = $_POST['replay_to'];
        $date['user_id'] = deCode(I('session.mark_id'));
        $date['source_id'] = $_POST['source_id'];
        $date['source_type'] = 2;
        $date['input_date'] = date('Y-m-d H:i:s');
        $result = $model->add($date);
        if (false !== $result) {
            echo 1;
        } else {
            echo 0;
        }
    }

    /*
     * @时间：20150412
     * @功能：活动评论加载
     */
    public function ActivityCommentLoad()
    {
        $markId = deCode(I('session.mark_id'));
        $where['source_id'] = $_POST['source_id'];
        $where['source_type'] = 2;
        $last = $_POST['last'];
        $amount = $_POST['amount'] + $_POST['last'];
        $order = 'input_date desc';
        $list = D('v_comment')->where($where)->order($order)->limit($last, $amount)->select();
        foreach ($list as $key => $val) {
            $userId = $val['user_id'];
            if ($markId == $userId) {
                $val['nowuser'] = 1;
            } else {
                $val['nowuser'] = 0;
            }
            $list[$key] = $val;
        }
        echo json_encode($list);
    }

    /*
     * @时间：20150512
     * @功能：发起活动
     */
    public function AddActivity()
    {
        $date['name'] = $_POST['name'];
        $date['sport_id'] = $_POST['sportTypeId'];
        $date['reg_begin_date'] = $_POST['regBeginDate'];
        $date['reg_end_date'] = $_POST['regEndDate'];
        $date['start_date'] = $_POST['startDate'];
        $date['end_date'] = $_POST['endDate'];
        $date['limit_count'] = $_POST['limitCount'];
        $date['join_need_info'] = '1,2,3,4';
        $date['is_verify'] = 'T';
        $date['cost_type'] = $_POST['money'];
        $date['cost'] = $_POST['cost'];
        $date['province'] = 1;
        $date['city'] = 2;
        $date['region'] = $_POST['region'];
        $date['address'] = $_POST['address'];
        $date['content'] = $_POST['content'];
        $date['input_date'] = date('Y-m-d H:i:s');
        $date['input_user'] = deCode(I('session.mark_id'));
        $result = M('DbActivity')->add($date);
        if (false !== $result) {
            //记录足迹
            $this->TimeLine($result, '', '发布活动', 'Activity');
            echo $result;
        } else {
            echo false;
        }
    }

    /*
     * @时间：20150512
     * @功能：参加活动
     */
    public function joinActivity()
    {
        $user_id = deCode(I('session.mark_id'));
        if (M('OpJoinActivity')->where('user_id=' . $user_id . ' and activity_id =' . $_POST['activityId'])->find()) {
            echo 'exist';
            return false;
        } else {
            if ($_POST['judge']) {
                $date['true_name'] = $_POST['true_name'];
                $date['gender'] = $_POST['gender'];
                $date['mobile'] = $_POST['mobile'];
                $date['certificate_num'] = $_POST['certificate_num'];
                $date['message'] = $_POST['message'];
                $date['activity_id'] = $_POST['activityId'];
                $date['user_id'] = deCode($_POST['userId']);
                $date['input_date'] = date('Y-m-d H:i:s');
                $result = D('OpJoinActivity')->add($date);
                if (false !== $result) {
                    echo 'success';
                } else {
                    echo 'error';
                }
            }
        }
    }

    /*
     * @功能：运动达人
     * @时间:20150418
     */
    public function sport_doyen()
    {
        $doyen = M('VDoyenHall')->order('input_date desc')->limit(5)->select();
        $this->assign('doyen', $doyen);
    }
}