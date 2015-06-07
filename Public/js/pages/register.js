$(function () {
    // 注册body id
    $('body').attr('id', 'signup-page');

    var $form = $('#registerForm');

    jQuery.validator.addMethod("isMobile", function (value, element) {
        var length = value.length;
        var mobile = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|(17[0-9]{1})|(14[0-9]{1}))+\d{8})$/;
        return this.optional(element) || (length == 11 && mobile.test(value));
    }, "请正确填写您的手机号码"),

    jQuery.validator.addMethod("stringCheck", function (value, element) {
            return this.optional(element) || /^[\u0391-\uFFE5\w]+$/.test(value);
        }, "只能包括中文字、英文字母、数字和下划线");

    jQuery.validator.addMethod("byteRangeLength", function (value, element, param) {
        var length = value.length;
        for (var i = 0; i < value.length; i++) {
            if (value.charCodeAt(i) > 127) {
                length++;
            }
        }
        return this.optional(element) || ( length >= param[0] && length <= param[1] );
    }, "请确保输入的值在3-15个字节之间(一个中文字算2个字节)");
    $form.validate({
        rules: {
            nick_name: {
                required: true,
                stringCheck: true,
                byteRangeLength: [3, 15],
                remote: {
                    url: "/Register/isExistNc",       //后台处理程序
                    type: "post",                      //数据发送方式
                    dataType: "json",                 //接受数据格式
                    data: {                           //要传递的数据
                        nickName: function () {
                            return $("#nick_name").val();
                        }
                    }

                }
            },
            mobile: {required: true,
                isMobile: true
            },
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
            signupAgr: {
                required: true
            }
        },
        messages: {
            nick_name: {
                required: "请填写昵称",
                stringCheck: "昵称只能包括中文字、英文字母、数字和下划线",
                byteRangeLength: "请确保昵称在3-15个字节之间(一个中文字算2个字节)",
                remote: $.validator.format("该昵称已存在！")
            },
            mobile: {
                required: "手机号码不能为空",
                isMobile: "请输入正确的手机号码"
            },
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
            signupAgr: {
                required: "必须同意服务条款"
            }
        },
        submitHandler: function (form) {
            jQuery.ajax({
                type: "post",
                url: "Register/ValidateInfo",
                data: {nick_name: $("#nick_name").val(),mobile: $("#mobile").val(), picCode: $('#picCode').val(), password: $('#password').val(), confirmPass: $('#confirmPass').val()},
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
                    } else if (result == 6) {
                        window.location.href = "/Register/profile";
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