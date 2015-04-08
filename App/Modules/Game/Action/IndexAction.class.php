<?php

/**
 * @时间:20150325
 * @功能:查询赛事信息
 * @VIEW:v_game_activity
 * @Author：liuliting
 */
class IndexAction extends Action
{
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

        $map['type'] = array('eq', 'game');
        $count = $model->where($map)->count();
        $Page = new Page($count, 3);
        $Page->setConfig("theme", "%first% %upPage%  %linkPage%  %downPage% %end% 共%totalPage% 页");
        $Page->rollPage = 10;
        $list = $model->limit($Page->firstRow . ',' . $Page->listRows)->where($map)->order($order)->select();
        $show = $Page->show();
        $this->assign('page', $show);
        $this->assign('game', $list);
        $this->assign('count', $count);
        $this->hotgame();
        $this->hotrecommend();
        $this->display();
    }

    /*
     * @时间:20150325
     * @功能：发起赛事
     */
    public function publish()
    {
        //首先判断用户是否登录
        $mark = I('session.mark');
        if ($mark) {
            $this->display();
        } else {
            $this->redirect('/login/login');
        }
    }

    /*
     * @时间:20150325
     * @功能：发布赛事
     */
    public function addgame()
    {
        $model = D('DbGame');
        $date['sport_id'] = I('post.sportTypeId');
        $date['name'] = I('post.name');
        $date['province'] = I('post.provinceId');
        $date['sponor'] = I('post.sponor');
        $date['phone'] = I('post.phone');
        $date['limit_count'] = I('post.limitCount');
        $date['content'] = I('post.description');
        $date['apply_name'] = I('post.applyName');
        $date['apply_phone'] = I('post.applyPhone');
        $date['apply_email'] = I('post.applyEmail');
        $result = $model->add($date);
        if (false !== $result) {
            //申请人ID
            $this->assign('applyID', date(Ymd) . $result);
            $this->assign('name', I('post.name'));
            $this->assign('applyPhone', I('post.applyPhone'));
            $this->assign('applyEmail', I('post.applyEmail'));
            $this->display('applyresult');
        } else {
            $this->error('发布失败');
        }
    }

    /*
   * @时间:20150402
   * @功能：热门赛事排行
   */
    public function hotgame()
    {
        $model = D('VHotGameRanking');
        $hot = $model->limit(10)->select();
        $this->assign('hot', $hot);
    }

    /*
   * @时间:20150402
   * @功能：热门赛事推荐
   */
    public function hotrecommend()
    {
        $model = New Model();
        $list = $model->query('select v.id,o.sort_num, v.name,v.province,v.image,v.join_count from v_game_activity v,op_recommend o
                                where v.id = o.gc_id and o.recommend_type = "game" and v.type="game" order by o.sort_num');
        $this->assign('recommend', $list);
    }

    /*
    * @时间:20150402
    * @功能：赛事详细页面
    */
    public function game_detail()
    {
        $id = $_GET['id'];
        $detail = D('DbGame')->where('id=' . $id)->find();
        //赛事公告
        $notice = D('OpGameNotice')->where('game_id=' . $id)->select();
        //
        $this->assign('notice', $notice);
        $this->assign('detail', $detail);
        $this->display();
    }
    /*
  * @时间: 20150408
  * @功能：赛事关注
  */
    public function game_remon()
    {
        $id = $_GET['id'];
        $detail = D('DbGame')->where('id=' . $id)->find();
        //赛事公告
        $notice = D('OpGameNotice')->where('game_id=' . $id)->select();
        //
        $this->assign('notice', $notice);
        $this->assign('detail', $detail);
        $this->display();
    }
}