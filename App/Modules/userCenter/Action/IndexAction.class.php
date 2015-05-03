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
        $date['higt'] = $_POST['higt'];
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
}