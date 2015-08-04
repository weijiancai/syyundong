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
        //关键字
        if (trim($_GET['keyword'])) {
            $map['name'] = array('like', '%' . trim($_GET['keyword']) . '%');
        }

        //区域

        if (trim($_GET['region'])) {
            if ($_GET['region'] != 'all') {
                $map['region'] = array('eq', $_GET['region']);
                $buss = D('DbRegion')->where('pid = ' . $_GET['region'])->select();
            }

        }
        //省市
        if ($_GET['cityId']) {
            if ($_GET['cityId'] != 'all') {
                $map['city'] = array('eq', $_GET['cityId']);
                $region = D('DbRegion')->where('pid = ' . $_GET['cityId'])->select();
            }
        }
        import('ORG.Util.Page');
        $model = D('DbTourism');
        $count = $model->where($map)->order('input_date desc')->count();
        $Page = new Page($count, 10);
        $Page->setConfig("theme", "%first% %upPage%  %linkPage%  %downPage% %end% 共%totalPage% 页");
        $Page->rollPage = 10;
        $list = $model->where($map)->limit($Page->firstRow . ',' . $Page->listRows)->order('input_date desc')->select();
        $show = $Page->show();
        $this->assign('page', $show);
        $this->assign('tourism', $list);
        $this->assign('count', $count);
        $this->assign('buss', $buss);
        $this->assign('region',$region);
        $this->assign('city', D('Public/Index')->city());

        $this->display();
	}
    /*
    * @时间:20150803
    * @功能：旅游场地详细页面
    */
    public function tourism_detail()
    {
        $id = $_GET['id'];
        $detail = D('DbTourism')->where('id=' . $id)->find();
        $this->assign('detail', $detail);
        $this->display();
    }
}