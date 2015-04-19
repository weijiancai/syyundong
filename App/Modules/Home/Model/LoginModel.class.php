<?php

/**
 *@功能:登录model
 */
class loginModel extends Model
{

    /**
     *  @功能:返回登录结果
     */
    public function login($name = NULL, $pwd = NULL)
    {
        $date['mobile'] = trim($name);
        $date['password'] = base64_encode(strtoupper(md5($pwd)));
        $model = D('DbUser');
        $data = $model->field('id,mobile,password')->where($date)->find();
        if ($data == null) {
            return 3;
        } else {
            $id = enCode($data['id']);
            session('mark_id', "$id");
            return 1;
        }
    }

    /**
     * @功能:调用用户登陆信息
     */
    public function getuser()
    {
        $mark = I('session.mark_id');
        $id = deCode($mark);
        $user = D('DbUser')->where("id = '%d'", $id)->find();
        return $user;
    }
}