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
        $model = D('VDoyenHall');
        $order = ('input_date desc');
        $count = $model->order($order)->count();
        $Page = new Page($count, 3);
        $Page->setConfig("theme", "%first% %upPage%  %linkPage%  %downPage% %end% 共%totalPage% 页");
        $Page->rollPage = 10;
        $list = $model->limit($Page->firstRow . ',' . $Page->listRows)->order($order)->select();
        $show = $Page->show();
        $this->assign('page', $show);
        $this->assign('DoyenHall', $list);
        $this->assign('count', $count);
		$this->display();
	}
    /*
    * @时间:20150408
    * @功能：达仁堂详细页面
    */
    public function hall_detail()
    {
        $id = $_GET['id'];
        $detail = D('VDoyenHall')->where('id=' . $id)->find();
        $this->assign('detail', $detail);
        $this->display();
    }
}