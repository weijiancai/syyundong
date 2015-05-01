<?php

/**
 *@功能:注册
 */
class RegisterAction extends Action
{

    /**
     *@功能:显示注册页面
     */
    public function index()
    {
        $this->display();

    }

    /*
    *@注册用户
    */
    public function adddata()
    {
        //验证验证码是否错误
        if ($this->isPost()) {
            $date['mobile'] = trim(I('post.mobile'));
            $date['password'] = base64_encode(strtoupper(md5(I('post.password'))));;
            $result = D('DbUser')->data($date)->add();
            dump($result);

            $id = enCode($result);
            session('mark_id', "$id");
            dump(session('mark_id'));
            /*if (false !== $result) {
                $this->display('profile');
                //   echo  1;
            }*/
        } else {
            $this->error('非法请求');
        }
    }

    /*
    * @ 注册用户详细信息
    */
    public function  AddProfile()
    {
        $data['user_head'] = $_POST['user_head'];
        $data['nick_name'] = $_POST['nick_name'];
        $data['gender'] = $_POST['gender'];
        $data['address'] = $_POST['address'];
        $data['interest'] = $_POST['interest'];
        $data['signature'] = $_POST['signature'];
        $data['id'] = array('eq', deCode(session('mark_id')));
        if (session('mark_id')) {
            $result = M('DbUser')->save($data);
            if (false !== $result) {
                echo 1;
            } else {
                echo 2;
            }
        } else {
            echo 0;
        }
    }

    /*
     *   重新发送验证码
     */
    function mobileCode()
    {
        $code = randnum(6, 0, 9);
        $where['uid'] = trim(I('post.uid'));
        $uid = trim(I('post.uid'));
        M('Users')->where($where)->setField('checkcode', $code);
        $tel = M('Users')->where("uid='" . getgb(trim(I('post.uid'))) . "'")->getField('tel');
        $this->assign('uid', trim(I('post.uid')));
        if ((empty($uid)) || ($uid == '')) {
            $str = '-12';
        } else {
            $yz = M('Users')->where("uid='" . getgb(trim(I('post.uid'))) . "'")->getField('yz');
            if ($yz == 1) {
                //已经验证过.直接返回成功，不发送短信码
                $str = '-13';
            } else {
                $result = sendcode($tel, $code);
                $str = substr($result, 0, 1);
            }
        }
        echo $str;

    }

    /*
     *	短信码校验比对
    */
    function checkcode()
    {
        $where['uid'] = iconv('utf-8', 'gbk', trim(I('post.uid')));
        $checkcode = M('Users')->where($where)->getField('checkcode');
        $send = I('post.validate');
        if ($send == $checkcode) {
            //修改会员注册状态
            $state = M('Users')->where("uid='" . trim(I('post.uid')) . "'")->setField('yz', 1);
            M('Users')->where("uid='" . trim(I('post.uid')) . "'")->setField('checkstate', 1);
            if ($state) {
                $this->success("注册成功,请使用注册账号、密码登录", 'http://www.songyuan163.com');
            } else {
                $this->success("注册失败,请在工作时间主动拨打客服电话开通", 'http://www.songyuan163.com');
            }
        } else {
            $this->error('校验码错误,请重新输入');
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
}