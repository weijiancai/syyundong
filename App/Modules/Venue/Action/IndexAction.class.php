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
            $map['name'] = array('like', '%' .trim($_GET['keyword']). '%');
        }
        //场馆分类
        if ($_GET['sportType']) {
            $map['sport_id'] = array('eq', $_GET['sportType']);
        }
        //区域
        if (trim($_GET['region'])) {
            $map['region'] = array('eq', $_GET['region']);
            $buss = D('DbRegion')->where('pid = '.$_GET['region'])->select();
        }
        //商圈
        if ($_GET['business']) {
            $map['business'] = array('eq', $_GET['business']);
        }
        //默认排序
        if ($_GET['orderByNew'] == 'M') {
            $order = 'input_date desc';
        }
        //评价
        if ($_GET['orderByNew'] == 'S') {
            $order = 'star_count desc';
        }
        //人气
        if ($_GET['orderByNew'] == 'C') {
            $order = 'commentCount desc';
        }
        //价格
        if ($_GET['orderByNew'] == 'P') {
            $order = 'person_cost desc';
        }
        import('ORG.Util.Page');
        $model = D('VVenue');
        $count = $model->where($map)->order($order)->count();
        $Page = new Page($count, 3);
        $Page->setConfig("theme", "%first% %upPage%  %linkPage%  %downPage% %end% 共%totalPage% 页");
        $Page->rollPage = 10;
        $list = $model->where($map)->limit($Page->firstRow . ',' . $Page->listRows)->order($order)->select();
        $show = $Page->show();
        $this->assign('page', $show);
        $this->assign('venue', $list);
        $this->assign('count', $count);
        $this->assign('buss', $buss);
        $this->assign('region',D('Public/Index')->region());
        $this->assign('venue_sport',$this->venue_sport());
        $this->assign('new_comment',$this->new_comment());
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
        $model = New Model();
        return $model->query('select v.name,c.content,u.name,c.input_date from op_comment c,db_user u ,db_venue v where c.user_id= u.id and c.source_id = v.id and c.source_type=3 limit 5');
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
        $amount = $_POST['amount']+$_POST['last'];
        $order = 'input_date desc';
        $list = D('OpComment')->where($where)->order($order)->limit($last, $amount)->select();
        echo json_encode($list);
    }
    /*
     * @时间：20150412
     * @功能：场馆详细页其他热门场馆
     */
    public function OtherVenueChange(){
        $where['id'] = array('neq',$_POST['id']);
        $ids = D('DbVenue')->where($where)->getField('id',true);
        $limit =array_rand($ids,4);
        $map['id'] =array('in',$limit);
        $list = D('DbVenue')->where($map)->select();
        echo json_encode($list);
    }
    /*
     * @时间：20150412
     * @功能：场馆首页其他热门场馆
     */
    public function HotVenue(){
        $ids = D('DbVenue')->getField('id',true);
        $limit =array_rand($ids,4);
        $map['id'] =array('in',$limit);
        $list = D('DbVenue')->where($map)->select();
        echo json_encode($list);
    }
    /*
     * @时间：20150413
     * @功能：收藏场馆
     */
    public function collection(){
        //首先判断用户是否登录
        $mark = I('session.mark_id');
        if ($mark) {
            $date['user_id'] = deCode($mark);
            $date['source_id'] = $_POST['id'];
            $date['source_type']=3;
            $date['input_date'] = date('Y-m-d H:i:s');
            $result = D('OpFocus')->add($date);
            if(false!==$result){
                echo $result;
            }else{
                echo -2;
            }
        } else {
            echo -1;
        }
    }

}