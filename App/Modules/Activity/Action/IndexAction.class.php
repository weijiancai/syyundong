<?php

/**
 *@时间:20150316
 *@功能:显示首页
 */
class IndexAction extends Action
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
            $map['status'] = $status;
        }
        //关键字
        if (trim($_GET['keyword'])) {
            $map['name'] = array('like', '%' . trim($_GET['keyword']) . '%');
        }
        //赛事分类
        if ($_GET['sportType']) {
            $map['sport_id'] = array('eq', $_GET['sportType']);
        }
        //默认排序
        if ($_GET['orderByNew'] == 'S') {
            $order = 'input_date desc';
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

        $map['type'] = array('eq', 'activity');
        $count = $model->where($map)->count();
        $Page = new Page($count, 3);
        $Page->setConfig("theme", "%first% %upPage%  %linkPage%  %downPage% %end% 共%totalPage% 页");
        $Page->rollPage = 10;
        $list = $model->limit($Page->firstRow . ',' . $Page->listRows)->where($map)->order($order)->select();
        $show = $Page->show();
        $this->assign('page', $show);
        $this->assign('activity', $list);
        $this->assign('count', $count);
        $this->assign('region', D('Public/Index')->region());
        $this->assign('venue_sport', $this->venue_sport());
        $this->hotactivity();
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
            $this->display();
        } else {
            $this->success('进军活动……', U('@www.syyundong.com/login/login'));
        }
    }

    /*
   * @时间:20150402
   * @功能：热门活动推荐
   */
    public function hotactivity()
    {
        $model = New Model();
        $list = $model->query('select v.id,o.sort_num, v.name,v.province,v.image,v.join_count,v.interest_count,v.cost,(v.limit_count-v.join_count) remain from v_game_activity v,op_recommend o
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
        $detail = D('VGameActivity')->where('id=' . $id.' and type=\'activity\'')->find();
        $this->assign('detail', $detail);
        //已通过报名
        $this->assign('through',D('VJoinActivity')->where('activity_id='.$id.' and verify_state=1')->select());
        $this->assign('through_count',D('VJoinActivity')->where('activity_id='.$id.' and verify_state=1')->count());
        //未通过报名
        $this->assign('not_through',D('VJoinActivity')->where('activity_id='.$id.' and verify_state=2')->select());
        $this->assign('not_through_count',D('VJoinActivity')->where('activity_id='.$id.' and verify_state=2')->count());
        //审核中
        $this->assign('wait',D('VJoinActivity')->where('activity_id='.$id.' and verify_state=0')->select());
        $this->assign('wait_count',D('VJoinActivity')->where('activity_id='.$id.' and verify_state=0')->count());
        $this->display();
    }

    /*
     * 功能：活动项目
     * 时间：20150407
     */
    public function venue_sport()
    {
        return D('DzSport')->where('sport_type=2')->select();
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
        $date['reply_to'] = $_POST['reply_to'];
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

}