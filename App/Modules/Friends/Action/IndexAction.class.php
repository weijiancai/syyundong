<?php
    /**
    *@时间:20150408
    *@功能:赛友圈信息
    */
class IndexAction extends Action {

	public function index(){
        $this->assign('sport', D('Public/Index')->sport_top());
        $this->firend_rcommend();
        $this->FriendSport();
		$this->display();
	}
    /*
     * @功能：赛友圈分类信息
     * @时间：20150416
     */
    public function branch(){
        $this->assign('sport',D('Public/Index')->sport_top());
        //查询当前分类下话题
        if($_GET['sportTypeId']){
            $list= D('DbGame')->field('id,name')->where('sport_sid='.$_GET['sportTypeId'])->select();
        }else{
            $list = D('DbGame')->field('id,name')->select();
        }
        //当前分类下赛友圈(赛事)
        $friend_game = M('VGameActivity')->field('id,name,image,focus_count,topic_count')->where('sport_sid='.$_GET['sportTypeId'])->limit(10)->select();
        $this->assign('friend_game',$friend_game);
        $this->assign('list',$list);
        $this->firend_rcommend();
        $this->display();
    }
    /*
     * @功能：搜索赛友圈(赛事)
     * @时间：20150417
     */
    public function search(){
        import('ORG.Util.Page');
        $model=D('VGameActivity');
        $order = 'input_date desc';
        $map['name'] = array('like','%'.trim($_GET['keyword']).'%');
        $map['type'] = array('eq','game');
        $count = $model->where($map)->count();
        $Page = new Page($count, 10);
        $Page->setConfig("theme", "%first% %upPage%  %linkPage%  %downPage% %end% 共%totalPage% 页");
        $Page->rollPage = 10;
        $list = $model->limit($Page->firstRow . ',' . $Page->listRows)->where($map)->order($order)->select();
        $show = $Page->show();
        $this->assign('page', $show);
        $this->assign('list', $list);
        $this->assign('count', $count);
        $this->firend_rcommend();
        $this->display();
    }
    /*
     * @功能：赛友圈信息
     * @时间:20150418
     */
    public function tag(){
        $id  =$_GET['id'];
        $this->assign('list',D('VGameActivity')->where('id='.$id)->find());
        $this->display();
    }
    /*
     * @功能：推荐赛友圈
     * @时间:20150418
     */
    public function firend_rcommend(){
        $model = New Model();
        $list = $model->query('select v.id,o.sort_num, v.name,v.province,v.image,v.province,v.join_count from v_game_activity v,op_recommend o
                                where v.id = o.gc_id and o.recommend_type = "game" and v.type="game" order by o.sort_num limit 9');
        $this->assign('recommend', $list);
    }

    /*
     * @功能：热门话题
     * @时间: 20150418
     */
    public function hotTopicLoad(){
        $order  = 'comment_count desc';
        if(!empty($_POST['source_type'])){
             $where['sport_id'] = $_POST['source_type'];
        }
        if(!empty($_POST['sportTypeId'])){
            $where['sport_sid'] = $_POST['sportTypeId'];
        }
        $last = $_POST['last'];
        $amount = $_POST['amount'];//+$_POST['last'];
        $list = D('VTopic')->where($where)->order($order)->limit($last, $amount)->select();
       echo json_encode($list);

    }
    /*
   * @功能：赛友圈大分类
   * @时间: 20150418
   */
    public function FriendSport(){
        $where['sport_type'] =1;
        $where['pid']=0;
        $sport = D('DzSport')->where($where)->select();
        $this->assign('f_sport',$sport);
    }
    /*
     * @功能：赛友圈话题
    * @时间: 20150418
    */
    public function Topic(){
        $id = $_GET['id'];
        $topic = D('VTopic')->where('id='.$id)->find();
        $this->assign('topic_images',D('VTopicImages')->where('topic_id=' . $topic['id'])->select());
        $this->assign('game',D('VGameActivity')->where('id='.$topic['game_id'])->find());
        //返回话题
        $this->assign('topic',$topic);
        $this->display();
    }
    /*
     * @时间: 20150415
     * @功能：赛友圈关注
     */
    public function topicFocus()
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
     * @时间：20150412
     * @功能：赛友圈评论加载
     */
    public function TopicCommentLoad()
    {
        $markId = deCode(I('session.mark_id'));
        $where['source_id'] = $_POST['source_id'];
        $where['source_type'] = 4;
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
        $date['source_type'] = $_POST['source_type'];
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
    * @功能: 评论赛友圈
    */
    public function publishReply()
    {
        $model = D('OpComment');
        $date['content'] = $_POST['content'];
        $date['reply_to'] = $_POST['reply_to'];
        $date['user_id'] = deCode(I('session.mark_id'));
        $date['source_id'] = $_POST['game_id'];
        $date['source_type'] = 1;
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
    * @功能: 用户时间轴
    */
    public function Passport(){
        $id = $_GET['id'];
        $this->assign('user',D('DbUser')->where('id='.$id)->find());
        $timeline = D('DbTimeLine')->where('input_user='.$id)->order('input_date desc')->select();
        $this->assign('timeline',$timeline);
        $this->display();
    }
    /*
    * @时间: 20150415
    * @功能: 关注话题页面跳转
    */
    public function selftopic(){
        //首先判断用户是否登录
        $mark = deCode(I('session.mark_id'));
        if ($mark) {
            $this->firend_rcommend();
            $this->display();
        } else {
            $str = ' <script> window.location.href="/login/login"</script>';
            echo $str;
        }
    }
    /*
    * @时间: 20150415
    * @功能: 关注话题页面
    */
    public function LoadSelfTopic(){
        $mark = deCode(I('session.mark_id'));
        $last = $_POST['last'];
        $amount = $_POST['amount'];
        $topic_id=M('OpFocus')->where('user_id='.$mark)->getField('source_id',true);
        $map['game_id'] =array('in',$topic_id);
        $map['user_id'] = array('eq',$mark);
        $list = M('VTopic')->where($map)->limit($last, $amount)->select();
        echo json_encode($list);
    }
    /*
     * @时间: 20150415
     * @功能: 推荐赛友
     */
    public function recommendFriend(){
        $id = D('VDoyenUser')->getField('id',true);
        $my = deCode(I('session.mark_id'));
        unset($id[array_search($my,$id)]);
        foreach($id as $key=>$value){
            $ids[$value]= $value;
        }
        if(count($ids)>6){
            $limit =array_rand($ids,6);
        }else{
            $limit=$ids;
        }
        $map['id'] =array('in',$limit);
        $list = D('VDoyenUser')->where($map)->select();
        foreach ($list as $key =>$val){
            $result = D('OpUserFriend')->where('user_id=' . $my . ' and friend_id=' . $val['id'])->select();
            if ($result) {
                //已添加
                $val['add'] = 1;
            } else {
                //未添加
                $val['add'] = 0;
            }
            $list[$key] = $val;
        }
        echo json_encode($list);
    }
    /*
     * @时间: 20150415
     * @功能: 新加入赛友
     */
    public function NewFriend(){
        $where['id'] = array('neq',$_POST['id']);
        $id = D('DbUser')->where($where)->getField('id',true);
        foreach($id as $key=>$value){
            $ids[$value]= $value;
        }
        $limit =array_rand($ids,4);
        $map['id'] =array('in',$limit);
        $list = D('DbUser')->where($map)->order('input_date desc')->select();
        dump(D('DbUser')->getLastSql());
        echo json_encode($list);
    }
    /*
     * @时间: 20150415
     * @功能：话题评论删除
     */
    public function CommentDel()
    {
        $model = D('OpComment');
        $id= $_POST['id'];
        $result =$model->where('id='.$id)->delete();
        if (false !== $result) {
            echo 1;
        } else {
            echo 0;
        }
    }
    /*
     * @时间: 20150415
     * @功能：热门话题
     */
    public function hotTopic()
    {
        $mark = deCode(I('session.mark_id'));
        $last = $_POST['last'];
        $amount = $_POST['amount'];
        $topic_id=M('OpFocus')->where('user_id='.$mark)->getField('source_id',true);
        $map['game_id'] =array('in',$topic_id);
        $map['user_id'] = array('eq',$mark);
        $list = M('OpGameTopic')->where($map)->limit($last, $amount)->select();
        echo json_encode($list);
    }
}