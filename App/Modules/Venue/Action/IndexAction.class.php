<?php
/**
*@时间:20150316
*@功能:显示首页
*/
class IndexAction extends Action {
	/*
	 * 首页内容
	 */
	public function index(){
        import('ORG.Util.Page');
        $model = D('VVenue');
        $count = $model->count();
        $Page = new Page($count, 3);
        $Page->setConfig("theme", "%first% %upPage%  %linkPage%  %downPage% %end% 共%totalPage% 页");
        $Page->rollPage = 10;
        $list = $model->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $show = $Page->show();
        $this->assign('page', $show);
        $this->assign('venue', $list);
        $this->assign('count', $count);
        $this->assign('area',D('Public/Index')->area());
        $this->assign('venue_sport',$this->venue_sport());
		$this->display();
	}
    /*
     * 功能：场馆信息
     * 时间：20150407
     */
    public function venue_sport(){
        return D('DzSport')->where('sport_type=3')->select();
    }
    /*
     * 功能：最新评论
     * 时间：20150407
     */
    public function new_comment(){

    }
}