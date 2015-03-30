$(function() {
    // 注册body id
    $('body').attr('id', 'signup-page');

    $('#registerForm').validate({
        rules: {
            mobile: "required",
            password: 'required',
            confirmPass: {
                required: true,
                equalTo: '#password'
            }
        },
        messages: {
            mobile: "手机号码不能为空！",
            password: '密码不能为空！',
            confirmPass: {
                required: '确认密码不能为空！',
                equalTo: '两次输入密码不一致！'
            }
        },
        submitHandler: function (form) {
            alert('aa');
//            form.submit();
        }
    });

    // 图片验证码
    $('#verifyImg').click(function() {
        $(this).attr('src', '__APP__/verify');
    })
});