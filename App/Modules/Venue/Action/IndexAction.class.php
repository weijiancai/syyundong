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
    /*
    * @时间:20150408
    * @功能：场馆详细页面
    */
    public function venue_detail()
    {
        $id = $_GET['id'];
        $detail = D('VVenue')->where('id=' . $id)->find();
        $this->assign('detail', $detail);
        $this->display();
    }
    /*
     * @时间: 20150409
     * @功能：场馆评论
     */
    public function publishReply(){
        $model = D('OpComment');
        $date['content'] = $_POST['content'];
        $date['star_count'] = $_POST['starLevel'];
        $date['user_id'] = deCode(I('session.mark_id'));
        $date['source_id']  = $_POST['source_id'];
        $date['source_type']  = 1;
        $date['input_date']  = date('Y-m-d H:i:s');
        $result  = $model->add($date);
        if(false!==$result){
            echo 1;
        }else{
           echo 0;
        }
    }
    /*
     * @时间：20150412
     * @功能：场馆评论加载
     */
    public function VenueCommentLoad(){
        $where['source_id'] = $_POST['source_id'];
        $where['source_type'] = 3;
        $last = $_POST['last'];
        $amount = $_POST['amount'];
        $order = 'input_date desc';
        $list = D('OpComment')->where($where)->order($order)->limit($last, $amount)->select();
        echo json_encode($list);
    }
}