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
        $model = D('DbGame');
        $Page  = new Page($count,5);
        $Page->setConfig("theme","%first% %upPage%  %linkPage%  %downPage% %end% 共%totalPage% 页");
        $Page->rollPage = 10;
        $list = $model->limit($Page->firstRow.','.$Page->listRows)->select();
        $show = $Page->show();
        $this->assign('page',$show);
        $this->assign('game',$list);
        $this->assign('count',$count);
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
}