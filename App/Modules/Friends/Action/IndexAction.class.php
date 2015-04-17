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
    /*
     * @功能：搜索赛友圈(赛事)
     * @时间：20150417
     */
    public function search(){
        import('ORG.Util.Page');
        $model=D('DbGame');
        $order = 'input_date desc';
        $map['name'] = array('like','%'.trim($_POST['keyword']).'%');
        $count = $model->where($map)->count();
        $Page = new Page($count, 3);
        $Page->setConfig("theme", "%first% %upPage%  %linkPage%  %downPage% %end% 共%totalPage% 页");
        $Page->rollPage = 10;
        $list = $model->limit($Page->firstRow . ',' . $Page->listRows)->where($map)->order($order)->select();
        $show = $Page->show();
        $this->assign('page', $show);
        $this->assign('game', $list);
        $this->assign('count', $count);
        $this->display();
    }

}