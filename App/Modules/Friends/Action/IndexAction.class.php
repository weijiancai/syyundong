<?php
    /**
    *@时间:20150408
    *@功能:赛友圈信息
    */
class IndexAction extends Action {
	/*
	 * 首页内容
	 */
	public function index(){
        $this->assign('sport', D('Public/Index')->sport_top());

		$this->display();
	}

}