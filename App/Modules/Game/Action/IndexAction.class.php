<?php

/**
 * @时间:20150325
 * @功能:查询赛事信息
 * @VIEW:v_game_activity
 * @Author：liuliting
 */
class IndexAction extends BaseAction
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
            $map['name'] = array('like', '%' . trim($_GET['keyword']) . '%');
        }
        //赛事分类
        if (($_GET['sportTypeId']) and ($_GET['sportTypeId'] !== 'all')) {
            $map['sport_sid'] = $_GET['sportTypeId'];
        }
        //赛事区域
        if ($_GET['region']) {
            $map['region'] = $_GET['region'];
        }
        //默认排序
        if (($_GET['orderByNew'] == 'S') or ($_GET['orderByNew'] == '')) {
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
        if ($_GET['date'] == 'today') {
            $map['start_date'] = array('like', date('Y-m-d') . '%');
        } else if ($_GET['date'] == 'tomorrow') {
            $map['start_date'] = array('like', date("Y-m-d", strtotime("+1 day")) . '%');
        } else if ($_GET['date'] == 'week') {
            $map['start_date'] = array('like', date("Y-m-d", strtotime("+7 day")) . '%');
        } else if ($_GET['date'] == 'month') {
            $map['start_date'] = array('like', date("Y-m-d", strtotime("+30 day")) . '%');
        }
        $map['type'] = array('eq', 'game');
        $count = $model->where($map)->count();
        $Page = new Page($count, 10);
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
        $mark = I('session.mark_id');
        if ($mark) {
            $this->assign('region', D('Public/Index')->region());
            $this->display();
        } else {
            $str = ' <script> window.location.href="/login/login"</script>';
            echo $str;
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
        $date['province'] = 1;
        $date['city'] = 2;
        $date['region'] = I('post.regionId');
        $date['sponsor'] = I('post.sponsor');
        $date['phone'] = I('post.phone');
        $date['limit_count'] = I('post.limitCount');
        $date['content'] = I('post.description');
        $date['apply_name'] = I('post.applyName');
        $date['apply_phone'] = I('post.applyPhone');
        $date['apply_email'] = I('post.applyEmail');
        $date['is_verify'] = 'T';
        $date['input_date'] = date('Y-m-d H:i:s');
        $date['input_user'] = deCode(I('session.mark_id'));
        $result = $model->add($date);
        if (false !== $result) {
            //记录足迹
            $this->TimeLine($result, I('post.name'), '发布赛事', 'Game');
            //申请人ID
            $this->assign('applyID', date('Ymd') . $result);
            $this->assign('name', I('post.name'));
            $this->assign('applyPhone', I('post.applyPhone'));
            $this->assign('applyEmail', I('post.applyEmail'));
            $this->assign('apply_name', I('post.applyName'));
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
        $list = $model->query("select v.id,o.sort_num, v.name,v.province,v.image,v.province,v.join_count from v_game_activity v,op_recommend o
                                where v.id = o.gc_id and o.recommend_type = 'game' and v.type='game' order by o.sort_num limit 4");
        $this->assign('recommend', $list);
    }

    /*
    * @时间:20150402
    * @功能：赛事详细页面
    */
    public function game_detail()
    {
        $id = $_GET['id'];
        $detail = D('VGameActivity')->where('id=' . $id)->find();
        //赛事公告
        $notice = D('OpGameNotice')->where('game_id=' . $id)->limit(2)->select();
        //赛事新闻
        $news = D('OpGameNews')->where('game_id=' . $id)->limit(2)->select();
        //赛事字段
        $model = New Model();
        $field_list = $model->query('select game_id,field_id,sort_num,field_value,
                      (select name from db_game where id = game_id) game_name,
                      (select name from mt_field_define where id = field_id) field_name,
                      (select code from mt_field_define where id = field_id) field_code
                       from op_game_field where game_id=' . $_GET['id'] . " order by sort_num asc");

        //赛事关注人物
        $user_id = D('OpFocus')->where('source_id=' . $id . ' and source_type=1')->getField('user_id', true);
        $model = new Model();
        $user = $model->query('select u.id id,u.nick_name nick_name,u.mobile mobile,u.name name,u.gender gender,i.local_url image from db_user u LEFT JOIN db_images i  on (u.user_head = i.id) where u.id in(' . ArrayToStr($user_id) . ')');
        $this->assign('user', $user);
        $this->assign('detail', $detail);
        $this->assign('field_list', $field_list);
        $this->assign('notice', $notice);
        $this->assign('news', $news);
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

    /*
     * @时间: 20150415
     * @功能：赛事其他信息(公告、新闻)
     */
    public function game_other()
    {
        import('ORG.Util.Page');
        $id = $_GET['id'];
        $info = $_GET['info'];
        //赛事字段
        $model = New Model();
        $field_list = $model->query('select game_id,field_id,sort_num,field_value,
                      (select name from db_game where id = game_id) game_name,
                      (select name from mt_field_define where id = field_id) field_name,
                      (select code from mt_field_define where id = field_id) field_code
                       from op_game_field where game_id=' . $_GET['id'] . " order by sort_num asc");
        if ($info == 'notice') {
            $model = D('OpGameNotice');
            $where['game_id'] = array('eq', $id);
            $count = $model->where($where)->count();
            $Page = new Page($count, 10);
            $Page->setConfig("theme", "%first% %upPage%  %linkPage%  %downPage% %end% 共%totalPage% 页");
            $Page->rollPage = 10;
            $list = $model->limit($Page->firstRow . ',' . $Page->listRows)->where($where)->order('input_date desc')->select();
            $show = $Page->show();
            $this->assign('page', $show);
            $this->assign('count', $count);
        }
        if ($info == 'news') {
            $model = D('OpGameNews');
            $where['game_id'] = array('eq', $id);
            $count = $model->where($where)->count();
            $Page = new Page($count, 10);
            $Page->setConfig("theme", "%first% %upPage%  %linkPage%  %downPage% %end% 共%totalPage% 页");
            $Page->rollPage = 10;
            $list = $model->limit($Page->firstRow . ',' . $Page->listRows)->where($where)->order('input_date desc')->select();
            $show = $Page->show();
            $this->assign('page', $show);
            $this->assign('count', $count);
        }

        //赛事信息
        $detail = D('VGameActivity')->where('id=' . $id)->find();
        $this->assign('id', $id);
        $this->assign('info', $info);
        $this->assign('other', $list);
        $this->assign('detail', $detail);
        $this->assign('field_list', $field_list);
        $this->display();
    }

    /*
     * @时间: 20150415
     * @功能：赛事成绩查询
     */
    public function score()
    {
        $id = $_GET['id'];
        //赛事信息
        $detail = D('VGameActivity')->where('id=' . $id)->find();
        //赛事字段
        $model = New Model();
        $field_list = $model->query('select game_id,field_id,sort_num,field_value,
                      (select name from db_game where id = game_id) game_name,
                      (select name from mt_field_define where id = field_id) field_name,
                      (select code from mt_field_define where id = field_id) field_code
                       from op_game_field where game_id=' . $_GET['id'] . " order by sort_num asc");
        //赛事组别
        $this->assign('group', D('OpGameGroup')->where('game_id=' . $id)->select());

        $where['game_id'] = array('eq', $id);
        if ($_GET['groupId']) {
            $where['group_id'] = array('eq', $_GET['groupId']);
        }
        $where['game_number'] = array('eq', $_GET['playerId']);
        $list = D('OpGameScore')->where($where)->order('score desc')->select();
        $this->assign('detail', $detail);
        $this->assign('list', $list);
        $this->assign('field_list', $field_list);
        $this->display('game_score');
    }

    /*
     * @时间: 20150415
     * @功能：赛事其他信息(公告、新闻)详细
     */
    public function game_other_detail()
    {
        $info = $_GET['info'];
        $where['game_id'] = $_GET['id'];
        $where['id'] = $_GET['d_id'];
        $list = D('op_game_' . $info)->where($where)->find();
        $this->assign('list', $list);
        //赛事字段
        $model = New Model();
        $field_list = $model->query('select game_id,field_id,sort_num,field_value,
                      (select name from db_game where id = game_id) game_name,
                      (select name from mt_field_define where id = field_id) field_name,
                      (select code from mt_field_define where id = field_id) field_code
                       from op_game_field where game_id=' . $_GET['id'] . " order by sort_num asc");
        $this->assign('field_list', $field_list);
        //赛事信息
        $detail = D('DbGame')->field('id,sport_id,name')->where('id=' . $_GET['id'])->find();
        $this->assign('detail', $detail);
        $this->display();
    }

    /*
     * @时间: 20150415
     * @功能：报名赛事
     */
    public function apply()
    {
        //首先判断用户是否登录
        $mark = I('session.mark_id');
        if ($mark) {
            $id = $_GET['id'];
            $this->assign('game_group', D('OpGameGroup')->where('game_id=' . $id)->select());

            $this->display();
        } else {
            echo ' <script> window.location.href="/login/login"</script>';
        }
    }

    /*
     * @时间: 20150415
     * @功能：赛事报名
     */
    public function GameGroupAdd()
    {
        $date['game_id'] = $_POST['game_id'];
        $date['group_id'] = $_POST['group_id'];
        $date['true_name'] = $_POST['true_name'];
        $date['user_id'] = deCode(session('mark_id'));
        $date['verify_state'] = 0;
        $date['input_date'] = date('Y-m-d H:i:s');
        $date['gender'] = $_POST['gender'];
        $date['mobile'] = $_POST['mobile'];
        $date['certificate_num'] = $_POST['certificate_num'];
        $date['em_contact'] = $_POST['em_contact'];
        $date['em_tel'] = $_POST['em_tel'];
        $result = D('OpJoinGame')->add($date);
        if (false !== $result) {
            echo 1;
        } else {
            echo 2;
        }
    }

    /*
     * @时间: 20150415
     * @功能：赛事关注
     */
    public function GameFocus()
    {
        $date['user_id'] = deCode(session('mark_id'));
        $date['source_id'] = $_POST['source_id'];
        $date['source_type'] = 1;
        $date['input_date'] = date('Y-m-d H:i:s');
        $result = D('OpFocus')->add($date);
        if (false !== $result) {
            echo 1;
        } else {
            echo 2;
        }
    }

    /*
    * @时间: 20150415
    * @功能：取消赛事关注
    */
    public function GameFocusCancel()
    {
        $date['user_id'] = deCode(session('mark_id'));
        $date['source_id'] = $_POST['source_id'];
        $date['source_type'] = 1;
        $result = D('OpFocus')->where($date)->delete();
        if (false !== $result) {
            echo 1;
        } else {
            echo 2;
        }
    }

    /*
    * @时间: 20150415
    * @功能：加赛友
    */
    public function GameAddFriend()
    {
        $date['user_id'] = deCode(session('mark_id'));
        $date['friend_id'] = $_POST['friend_id'];
        $date['input_date'] = date('Y-m-d H:i:s');
        $result = D('OpUserFriend')->add($date);
        if (false !== $result) {
            echo 1;
        } else {
            echo 2;
        }
    }

    /*
 * @时间：20150412
 * @功能：关注赛友换一换
 */
    public function UserFriend()
    {
        $id = $_POST['game_id'];
        $ids = D('OpFocus')->where('source_id=' . $id . ' and source_type=1 and user_id !=' . $id)->getField('user_id', true);
        $len = count($ids);
        $result = rand(0, ($len - 6));
        if ($len < 6) {
            $result = 0;
        }
        $model = new Model();
        $user = $model->query('select u.id id,u.nick_name nick_name,u.mobile mobile,u.name name,u.gender gender,i.local_url image from db_user u LEFT JOIN db_images i  on (u.user_head = i.id) where u.id in(' . ArrayToStr($ids) . ')limit ' . $result . ',6');
        echo json_encode($user);
    }

    /*
    * @时间: 20150415
    * @功能：赛事话题发布
    */
    public function AddTopic()
    {
        $mark = I('session.mark_id');
        if ($mark) {
            if ($_POST['game_id']) {
                $date['content'] = $_POST['content'];
                $date['user_id'] = deCode(I('session.mark_id'));
                $date['game_id'] = $_POST['game_id'];
                $date['input_date'] = date('Y-m-d H:i:s');
                $date['game_id'] = $_POST['game_id'];
                $result = D('OpGameTopic')->add($date);
                //图片存储
                $img = strtoarr($_POST['imgMsg']);
                foreach ($img as $key => $val) {
                    if (!empty($val) && $val !== '') {
                        $map['image_id'] = $val;
                        $map['topic_id'] = $result;
                        D('OpGameTopicImages')->add($map);
                    }
                }
                if (false !== $result) {
                    echo 1;
                } else {
                    echo 2;
                }
            } else {
                echo 3;
            }
        } else {
            echo 4;
        }
    }

    /*
    * @时间: 20150415
    * @功能：赛事话题加载
    */
    public function GameCommentLoad()
    {
        $markId = deCode(I('session.mark_id'));
        $last = $_POST['last'];
        $amount = $_POST['amount'] + $_POST['last'];
        $order = 'input_date desc';
        $list = D('VTopic')->where('game_id=' . $_POST['game_id'])->order($order)->limit($last, $amount)->select();
        foreach ($list as $key => $val) {
            $topic_image = D('VTopicImages')->where('topic_id=' . $val['id'])->select();
            $val['topic_images'] = $topic_image;
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
    * @时间: 20150415
    * @功能：赛事话题图片加载
    */
    public function GameImageLoad()
    {
        $last = $_POST['last'];
        $amount = $_POST['amount'] + $_POST['last'];
        $order = 'input_date desc';
        $list = D('VTopic')->where('game_id=' . $_POST['game_id'] . ' and topic_image is not null')->order($order)->limit($last, $amount)->select();
        //    dump(D('VTopic')->getLastSql());
        /*foreach ($list as $key => $val) {
            $topic_image = D('VTopicImages')->where('topic_id=' . $val['id'])->select();
            $val['topic_images'] = $topic_image;
            $list[$key] = $val;
        }*/
        echo json_encode($list);
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
        $date['source_type'] = 4;
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
    * @功能: 加载评论回复
    */
    public function LoadReply()
    {
        $markId = deCode(I('session.mark_id'));
        $id = $_POST['topicId'];
        $model = D('v_comment');
        $list = $model->where('source_id=' . $id . ' and source_type = 4')->limit(5)->order('input_date desc')->select();
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