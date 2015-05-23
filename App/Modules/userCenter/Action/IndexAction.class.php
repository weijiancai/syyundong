<?php
/**
*@时间:20150408
*@功能:用户中心
*/
class IndexAction extends Action {
	/*
	 * 首页内容
	 */
	public function index(){
		$this->display();
	}
    /*
     * @时间：20150408
     * @功能：我的足迹
     */
    public function timeline(){
        $id = deCode(I('session.mark_id'));
        $timeline = D('DbTimeline')->where('input_user='.$id)->order('input_date desc')->select();
        $this->assign('timeline',$timeline);
        $this->assign('user',D('DbUser')->where('id='.$id)->find());
        $this->display();
    }
    /*
     * @时间:20150408
     * @功能：个人资料
     */
    public function Profile(){
        $id = deCode(I('session.mark_id'));
        $this->assign('user',D('DbUser')->where('id='.$id)->find());
        $this->display();
    }
    /*
    * @时间:20150408
    * @功能：个人资料编辑
    */
    public function ProfileEdit(){
        $id =$_GET['id'];
        $this->assign('user',D('DbUser')->where('id='.$id)->find());
        $this->display();
    }

    /*
    * @时间:20150408
    * @功能：个人资料编辑
    */
    public function profileEditSubmit(){
        $date['id'] = $_POST['id'];
        $date['name'] = $_POST['name'];
        $date['gender'] = $_POST['gender'];
        $date['blood_type'] = $_POST['blood_type'];
        $date['birthday'] = $_POST['birthday'];
        $date['company'] = $_POST['company'];
        $date['certificate_type'] = $_POST['certificate_type'];
        $date['certificate_num'] = $_POST['certificate_num'];
        $date['height'] = $_POST['height'];
        $date['weight'] = $_POST['weight'];
        $date['mobile'] = $_POST['mobile'];
        $date['email'] = $_POST['email'];
        $date['postal_code'] = $_POST['postal_code'];
        $date['address'] = $_POST['address'];
        $result = D('DbUser')->save($date);
        if(false!==$result){
            echo 1;
        }else{
            echo 2;
        }
    }
    /*
     * @功能：我的赛事：已报名
     * @时间:20150408
     */
    public function Game(){
        import('ORG.Util.Page');
        $model=D('VJoinGame');
        $map['user_id'] = deCode(I('session.mark_id'));
        $order='input_date desc';
        $count = $model->where($map)->count();
        $Page = new Page($count, 3);
        $Page->setConfig("theme", "%first% %upPage%  %linkPage%  %downPage% %end% 共%totalPage% 页");
        $Page->rollPage = 10;
        $list = $model->limit($Page->firstRow . ',' . $Page->listRows)->where($map)->order($order)->select();
        $show = $Page->show();
        $this->assign('page', $show);
        $this->assign('game', $list);
        $this->assign('count', $count);
        $this->assign('user',D('DbUser')->field('id,nick_name,signature,interest')->where('id='.deCode(I('session.mark_id')))->find());
        $this->display();
    }
    /*
     * @功能：我的赛事：已关注
     * @时间:20150408
     */
    public function follow(){
        import('ORG.Util.Page');
        $model=D('VFocusGame');
        $map['user_id'] = deCode(I('session.mark_id'));
        $order='input_date desc';
        $count = $model->where($map)->count();
        $Page = new Page($count, 3);
        $Page->setConfig("theme", "%first% %upPage%  %linkPage%  %downPage% %end% 共%totalPage% 页");
        $Page->rollPage = 10;
        $list = $model->limit($Page->firstRow . ',' . $Page->listRows)->where($map)->order($order)->select();
        $show = $Page->show();
        $this->assign('page', $show);
        $this->assign('follow', $list);
        $this->assign('count', $count);
        $this->assign('user',D('DbUser')->field('id,nick_name,signature,interest')->where('id='.deCode(I('session.mark_id')))->find());
        $this->display();
    }
    /*
    * @功能：我的赛事：取消报名
    * @时间:20150408
    */
    public function gamedel(){
        $date['game_id'] = $_GET['id'];
        $date['group_id'] = $_GET['group_id'];
        D('OpJoinGame')->where($date)->delete();
        echo ' <script> window.location.href="/userCenter/game"</script>';
    }

    /*
    * @功能：我的赛事：报名详情
    * @时间:20150408
    */
    public function gamedetail(){
        $date['game_id'] = $_GET['id'];
        $date['group_id'] = $_GET['group_id'];
        $this->assign('group_list',D('OpJoinGame')->where($date)->find());
        $this->assign('join_list',D('VJoinGame')->where($date)->find());
        $this->assign('user',D('DbUser')->field('id,nick_name,signature,interest')->where('id='.deCode(I('session.mark_id')))->find());
        $this->display();
    }

    /*
    * @功能：我的活动：参加的
    * @时间:20150408
    */
    public function activity(){
        import('ORG.Util.Page');
        $model=D('VJoinActivity');
        $map['user_id'] = deCode(I('session.mark_id'));
        $order='input_date desc';
        $count = $model->where($map)->count();
        $Page = new Page($count, 3);
        $Page->setConfig("theme", "%first% %upPage%  %linkPage%  %downPage% %end% 共%totalPage% 页");
        $Page->rollPage = 10;
        $list = $model->limit($Page->firstRow . ',' . $Page->listRows)->where($map)->order($order)->select();
        $show = $Page->show();
        $this->assign('page', $show);
        $this->assign('activity', $list);
        $this->assign('count', $count);
        $this->assign('user',D('DbUser')->field('id,nick_name,signature,interest')->where('id='.deCode(I('session.mark_id')))->find());
        $this->display();
    }
    /*
     * @功能：我的活动：我发起的
     * @时间:20150408
     */
    public function create(){
        import('ORG.Util.Page');
        $model = D('VGameActivity');
        $map['type'] = array('eq', 'activity');
        $map['input_user'] = array('eq',deCode(I('session.mark_id')));
        $order = 'input_date desc';
        $count = $model->where($map)->count();
        $Page = new Page($count, 3);
        $Page->setConfig("theme", "%first% %upPage%  %linkPage%  %downPage% %end% 共%totalPage% 页");
        $Page->rollPage = 10;
        $list = $model->limit($Page->firstRow . ',' . $Page->listRows)->where($map)->order($order)->select();
        $show = $Page->show();
        $this->assign('page', $show);
        $this->assign('list', $list);
        $this->assign('count', $count);
        $this->assign('user',D('DbUser')->field('id,nick_name,signature,interest')->where('id='.deCode(I('session.mark_id')))->find());
        $this->display();
    }
    /*
     * @功能：账号设置
     * @时间:20150408
     */
    public function account(){
        $user = D('DbUser')->field('id,user_head,nick_name,signature,interest')->where('id='.deCode(I('session.mark_id')))->find();
        $model = New Model();
        $sport = $model->query('select dz_sport.id,name,db_images.local_url from dz_sport left join db_images on dz_sport.image = db_images.id where dz_sport.sport_type =1 and dz_sport.level=2  and (dz_sport.id IN ('.$user['interest'].'))');
        $this->assign('fav',$sport);
        $this->assign('user',$user);
        $this->display();
    }
    /*
     * @功能：账号修改
     * @时间:20150408
     */
    public function accountEdit(){
        $user = D('DbUser')->field('id,nick_name,signature,interest,user_head')->where('id='.$_GET['id'])->find();
        $user['interest'] =$user['interest'].",";
        $this->assign('user',$user);
        $this->FavouriteGame();
        $this->display();
    }
    /*
     * @时间:20150408
     * @功能：个人资料编辑
     */
    public function accountEditSubmit(){

        $date['nick_name'] = $_POST['nick_name'];
        $date['user_head'] = $_POST['user_head'];
        $date['interest'] = substr($_POST['interest'], 0, -1);
        $date['signature'] = trim($_POST['signature']);
        $result = D('DbUser')->where('id='.$_POST['id'])->save($date);
        if(false!==$result){
            echo 1;
        }else{
            echo 2;
        }
    }
    /*
      * @功能：校验昵称是否存在
      * @时间：20150419
      */
    public function isExistNc()
    {
        if (IS_POST) {
            if (empty($_POST['nickName'])) {
                echo 'false';
            } else {
                $date['nick_name'] = array('eq', trim($_POST['nickName']));
                $date['id'] = array('neq', deCode(session('mark_id')));
                $result = D('DbUser')->where($date)->count();
                if ($result) {
                    echo 'false';
                } else {
                    echo 'true';
                }
            }
        } else {
            echo false;
        }
    }
    /*
     * @功能：用户喜好
     * @时间：20150501
     */
    public function FavouriteGame(){
        $model = New Model();
        $list  = $model->query('select dz_sport.id,name from dz_sport left join db_images on dz_sport.image = db_images.id where dz_sport.sport_type =1 and dz_sport.level=2 ');
        $this->assign('fav',$list);
    }
    /*
     * @功能：修改密码页面
     * @时间:20150408
     */
    public function ResetPwd(){
        $this->display();
    }
    /*
     * @功能：修改密码
     * @时间:20150408
     */
    public function ResetPwdSubmit(){

        $this->display();
    }
}