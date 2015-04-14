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
            $map['name'] = array('like', '%' .trim($_GET['keyword']). '%');
        }
        //赛事分类
        if ($_GET['sportType']) {
            $map['sport_id'] = array('eq', $_GET['sportType']);
        }
        //默认排序
        if ($_GET['orderByNew'] == 'S') {
            $order = 'reg_begin_date desc';
        }
        //最新赛事
        if ($_GET['orderByNew'] == 'C') {
            $order = 'start_date desc';
        }
        //最热赛事
        if ($_GET['orderByNew'] == 'F') {
            $order = 'focus_count desc';
        }
        if($_GET['date']=='today'){
            $map['start_date'] =  array('like',date('Y-m-d').'%');
        }else if($_GET['date']=='tomorrow'){
            $map['start_date'] =  array('like',date("Y-m-d",strtotime("+1 day")).'%');
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
        $this->assign('region',D('Public/Index')->region());
        $this->assign('venue_sport',$this->venue_sport());
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
        /*$mark = I('session.mark');
        if ($mark) {
            $this->display();
        } else {
            $this->redirect('/login/login');
        }*/
        $this->display();
    }

    /*
   * @时间:20150402
   * @功能：热门活动推荐
   */
    public function hotactivity()
    {
        $model = New Model();
        $list = $model->query('select v.id,o.sort_num, v.name,v.province,v.image,v.join_count,v.interest_count,v.cost,(v.limit_count-v.join_count) remain from v_game_activity v,op_recommend o,dz_sport s
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
        $detail = D('DbActivity')->where('id=' . $id)->find();
        $this->assign('detail', $detail);
        $this->display();
    }
    /*
     * 功能：活动项目
     * 时间：20150407
     */
    public function venue_sport(){
        return D('DzSport')->where('sport_type=2')->select();
    }
    /*
     * 功能:相似活动
     * 时间：20150407
     */
    public function similar_activity(){
        return D('DzSport')->where('sport_type=2')->select();
    }

}