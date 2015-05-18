<?php

/**
 *@功能:注册
 */
class RegisterAction extends BaseAction
{

    /**
     *@功能:显示注册页面
     */
    public function index()
    {

        $this->display();

    }

    /*
    *@注册用户详细页面
    */
    public function profile()
    {
        $model = New Model();
        $list  = $model->query('select dz_sport.id ,name ,(select local_url from db_images where db_images.id = image) image from dz_sport where sport_type=1 and level =2 ');
        $this->assign('fav',$list);
        $this->display();
    }

    /*
     * @功能：注册用户详细信息
     * @时间：20150501
     */
    public function  AddProfile()
    {
        $data['user_head'] = $_POST['user_head'];
        $data['nick_name'] = $_POST['nick_name'];
        $data['gender'] = $_POST['gender'];
        $data['address'] = $_POST['address'];
        $data['interest'] = substr($_POST['interest'], 0, -1);
        $data['signature'] = $_POST['signature'];
        if (session('mark_id')) {
            $result = M('DbUser')->where('id ='.deCode(session('mark_id')))->save($data);
            if (false !== $result) {
                echo 1;
            } else {
                echo 2;
            }
        } else {
            echo 0;
        }
    }

    /*@功能：用户注册校验
     *@时间：20150324
     */
    public function ValidateInfo()
    {
        $mobile = I('post.mobile');
        $picCode = I('post.picCode');
        $password = I('post.password');
        $confirmPass = I('post.confirmPass');
        if ((!empty($mobile)) && (!empty($picCode)) && (!empty($password)) && (!empty($confirmPass))) {
            if ($_SESSION['verify'] != md5($picCode)) {
                //验证码错误
                echo 1;
                return false;
            }
            $where['mobile'] = $mobile;
            $data = M('DbUser')->where($where)->find();
            if ($data) {
                //手机号码已经注册过
                echo 2;
            } else if (!preg_match("/13\d{9}|14\d{9}|15[0123456789]\d{8}|18\d{9}/", $mobile)) {
                //手机号码格式不正确
                echo 3;
            } else {
                //注册用户
                if ($this->isPost()) {
                    $date['mobile'] = trim(I('post.mobile'));
                    $date['password'] = base64_encode(strtoupper(md5(I('post.password'))));
                    $date['input_date'] = date('Y-m-d H:i:s');
                    $result = D('DbUser')->data($date)->add();
                    $id = enCode($result);
                    session('mark_id', "$id");
                    if (false !== $result) {
                        //  $this->display('profile');
                        $_SESSION['SyPhone'] = trim(I('post.mobile'));
                        $this->TimeLine('','','加入松原运动网','');
                        echo 6;
                    }
                } else {
                    $this->error('非法请求');
                }
            }
        } else {
            //基本注册信息全部不能为空
            echo 5;
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
       $list  = $model->query('select dz_sport.id ,name ,(select local_url from db_images where id = image) image from dz_sport,db_images');
       $this->assign('fav',$list);
    }
}