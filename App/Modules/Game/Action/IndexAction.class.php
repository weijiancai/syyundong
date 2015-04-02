<?php
	/**
	*	@时间:20150325
	*	@功能:查询赛事信息
	*	@VIEW:v_game_activity
	*	@Author：liuliting
	*/
class IndexAction extends Action {
	public function index(){
        import('ORG.Util.Page');
        $model = D('VGameActivity');
        $where['type'] = array('eq','game');
        $count = $model->where($where)->count();
        $Page  = new Page($count,10);
        $Page->setConfig("theme","%first% %upPage%  %linkPage%  %downPage% %end% 共%totalPage% 页");
        $Page->rollPage = 10;
        $list = $model->limit($Page->firstRow.','.$Page->listRows)->where($where)->select();
        $show = $Page->show();
        $this->assign('page',$show);
        $this->assign('game',$list);
        $this->assign('count',$count);
        $this->hotgame();
		$this->display();
	}
	/*
	 * @时间:20150325
	 * @功能：发起赛事
	 */
	public function publish(){
		//首先判断用户是否登录
		$mark = I('session.mark');
		if($mark){
			$this->display();
		}else{
			$this->redirect('/login/login');
		}
	}
    /*
     * @时间:20150325
     * @功能：发布赛事
     */
    public function addgame(){
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
        $result  = $model->add($date);
        if(false!==$result){
            //申请人ID
            $this->assign('applyID',date(Ymd).$result);
            $this->assign('name',I('post.name'));
            $this->assign('applyPhone',I('post.applyPhone'));
            $this->assign('applyEmail',I('post.applyEmail'));
            $this->display('applyresult');
        }else{
            $this->error();
        }
    }
    /*
   * @时间:20150402
   * @功能：热门赛事排行
   */
    public function hotgame(){
        $model = D(VHotGameRanking);
        $hot  = $model->limit(10)->select();
        $this->assign('hot',$hot);
    }

    /*
   * @时间:20150402
   * @功能：热门赛事推荐
   */
/*    public function hotgame(){
        $model = D(VHotGameRanking);
        $hot  = $model->limit(4)->select();
        $this->assign('hot',$hot);
    }*/
}