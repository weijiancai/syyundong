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
        $model = D('VSportAssociation');
        $order = ('input_date desc');
        $count = $model->order($order)->count();
        $Page = new Page($count, 3);
        $Page->setConfig("theme", "%first% %upPage%  %linkPage%  %downPage% %end% 共%totalPage% 页");
        $Page->rollPage = 10;
        $list = $model->limit($Page->firstRow . ',' . $Page->listRows)->order($order)->select();
        $show = $Page->show();
        $this->assign('page', $show);
        $this->assign('association', $list);
        $this->assign('count', $count);
		$this->display();
	}
    /*
    * @时间:20150408
    * @功能：体育协会详细页面
    */
    public function ass_detail()
    {
        $id = $_GET['id'];
        $detail = D('VSportAssociation')->where('id=' . $id)->find();
        $this->assign('detail', $detail);
        $this->display();
    }

}