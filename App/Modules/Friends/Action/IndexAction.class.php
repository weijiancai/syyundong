<?php
    /**
    *@时间:20150408
    *@功能:赛友圈信息
    */
class IndexAction extends Action {

	public function index(){
        $this->assign('sport', D('Public/Index')->sport_top());
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
}