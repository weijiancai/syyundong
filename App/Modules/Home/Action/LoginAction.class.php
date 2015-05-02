<?php

/**
 * @功能：用户登录
 */

class LoginAction extends Action
{
    public function index()
    {
        $this->display();
    }

    /*
     * @功能：用户登录
     * @时间：20150419
     */
    public function load()
    {
        extract($_POST);
        extract($_GET);
        if (IS_POST) {
            if (empty($_POST['loginName']) && empty($_POST['loginPass'])) {
                echo 5;
            } else {
                $loginName = I('post.loginName');
                $loginPass = I('post.loginPass');
                $wz = I('post.jump_url');
                $data = D('Login')->login($loginName, $loginPass);
                if ($data == 1) {
                    if ($wz == '') {
                        //登录成功,跳转到首页
                        echo 1;
                        // $this->success('登录成功', '/Index/');
                    } else {
                        //登录成功,跳转到浏览页
                        echo 2;
                        //  $this->success('登录成功', $wz);
                    }
                } else {
                    //登录失败,账号或密码错误
                    echo 3;
                    //   $this->error('登陆失败，账号或密码错误！');
                }
            }
        } else {
            echo 4;
            //  $this->error('出错了');
        }
    }

    /*
     * @功能：登录页面跳转
     * @时间：20150419
     */
    public function login()
    {
        $this->display();
    }

    /*
     * @功能：校验登录用户是否存在
     * @时间：20150419
     */
    public function IsExistUser()
    {
        if (IS_POST) {
            $where['mobile'] = trim(I('post.loginName'));
            $model = D('DbUser');
            $date = $model->where($where)->count();
            if ($date) {
                echo 'true';
            } else {
                echo 'false';
            }
        }
    }
    /*
     * @功能：退出网站
     * @时间：20150419
     */
    public function quit()
    {
        session('mark_id',null);
        $this->redirect(U('@www.syyundong.com'));
    }

    public function logintel()
    {
        header("Content-Type:text/html; charset=utf-8");
        if (IS_POST) {
            if (empty($_POST['name']) AND empty($_POST['param'])) {
                echo '{"info":"数据验证失败！","status":"n"}';
            } else {
                $where['name'] = gettel(I('post.param'));
                $where['lx'] = 'haoduan';
                $date = D('zj_types')->where($where)->count();
                if ($date) {
                    $val = I('post.param');
                    $tel = $this->Repeattel($val);
                    if ($tel) {
                        echo '{"info":"该手机号码已经被注册！","status":"n"}';
                    } else {
                        echo '{"info":"恭喜您该手机号码可以注册！","status":"y"}';
                    }
                } else {
                    echo '{"info":"请使用松原号码注册！","status":"n"}';
                }
            }
        } else {
            echo '{"info":"数据验证失败！","status":"n"}';
        }
    }

}
