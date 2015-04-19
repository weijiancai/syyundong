$(function () {
    // 注册body id
    $('body').attr('id', 'signup-page');

    var $form = $('#registerForm');

    jQuery.validator.addMethod("isMobile", function (value, element) {
        var length = value.length;
        var mobile = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|(17[0-9]{1})|(14[0-9]{1}))+\d{8})$/;
        return this.optional(element) || (length == 11 && mobile.test(value));
    }, "请正确填写您的手机号码"),

        $form.validate({
            rules: {
                mobile: {required: true,
                    isMobile: true
                },
                /*mobile:"required",*/
                picCode: "required",
                password: {required: true,
                    minlength: 6,
                    maxlength: 16
                },
                confirmPass: {
                    required: true,
                    minlength: 6,
                    maxlength: 16,
                    equalTo: '#password'
                },
                signupAgr:{
                    required:true
                }
            },
            messages: {
                mobile: {
                    required: "手机号码不能为空",
                    isMobile: "请输入正确的手机号码"
                },
                /*mobile:"手机号码不能为空",*/
                picCode: "验证码不能为空！",
                password: {   required: '密码不能为空！',
                    minlength: " 密码长度不能小于6个字符",
                    maxlength: " 密码长度不能大于15个字符"
                },
                confirmPass: {
                    required: '确认密码不能为空！',
                    minlength: " 密码长度不能小于6个字符",
                    maxlength: " 密码长度不能大于15个字符",
                    equalTo: '两次输入密码不一致！'
                },
                signupAgr:{
                    required:"必须同意服务条款"
                }
            },
            submitHandler: function (form) {
                jQuery.ajax({
                    type: "post",
                    url: "Register/ValidateInfo",
                    data: {mobile: $("#mobile").val(), picCode: $('#picCode').val(), password: $('#password').val(), confirmPass: $('#confirmPass').val()},
                    success: function (result) {
                        if (result == 1) {
                            $.dialog.error('验证码错误啦！');
                        } else if (result == 2) {
                            $.dialog.error('手机号码注册过啦！');
                        } else if (result == 3) {
                            $.dialog.error('手机号码不正确哦！');
                        } else if (result == 4) {
                            $.dialog.error('注册失败啦！');
                        } else if (result == 5) {
                            $.dialog.error('注册信息全部不能为空！');
                        }else if(result ==6){
                            window.location.href="/Register/profile";
                        }
                    }
                });
             //   $form.submit();
            }
        });

    // 图片验证码
    $('#verifyImg').click(function () {
        $(this).attr('src', '/verify');
    })
});