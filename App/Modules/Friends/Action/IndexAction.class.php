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
        $Page = new Page($count, 3);
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
    * @功能：推荐赛友
    * @时间:20150418
    */
    public function recommend_friend_user(){
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
        $last = $_POST['last'];
        $amount = $_POST['amount']+$_POST['last'];
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
}