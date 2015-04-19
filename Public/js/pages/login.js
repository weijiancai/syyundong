$(function () {
    // 注册body id
    $('body').attr('id', 'login-page');

    $('#loginForm').validate({
        rules: {
            loginName: {
                required: true,
                remote: {
                    url: "/Login/IsExistUser",       //后台处理程序
                    type: "post",                    //数据发送方式
                    dataType: "json",                //接受数据格式
                    data: {                          //要传递的数据
                        loginName: function () {
                            return $("#loginName").val();
                        }
                    }

                }
            },
            loginPass: "required"
        },
        messages: {
            loginName: {required: "手机号/邮箱/用户名不能为空！",
                remote: $.validator.format("用户不存在！")
            },
            loginPass: "登录密码不能为空！"
        },
        submitHandler: function (form) {
            jQuery.ajax({
                type: "post",
                url: "Load",
                data: $('#loginForm').serialize(),
                success: function (result) {
                    if (result == 1) {
                        window.location.href = 'http://www.syyundong.com';
                    } else if (result == 2) {
                        //跳转到浏览页面
                        $.dialog.error('手机号码注册过啦！');
                    } else if (result == 3) {
                        $.dialog.error('登录失败,账号或密码错误');
                    } else if (result == 4) {
                        $.dialog.error('出错啦');
                    } else if (result == 5) {
                        $.dialog.error('账号密码不能为空');
                    }
                }
            });
        }
    });
});