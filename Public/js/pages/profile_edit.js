$(function () {
    // 注册body id
    $('body').attr('id', 'ucenter-profile');

    var $form = $('#profileForm');

    jQuery.validator.addMethod("stringCheck", function (value, element) {
        return this.optional(element) || /^[\u0391-\uFFE5\w]+$/.test(value);
    }, "只能包括中文字");

    jQuery.validator.addMethod("isMobile", function (value, element) {
        var length = value.length;
        var mobile = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|(17[0-9]{1})|(14[0-9]{1}))+\d{8})$/;
        return this.optional(element) || (length == 11 && mobile.test(value));
    }, "请正确填写您的手机号码"),

        $form.validate({
            rules: {
                name: {
                    stringCheck: true
                },
                mobile: {
                    isMobile: true
                },
                email: {
                    email: true
                },
                height: {
                    number: true
                },
                weight: {
                    number: true
                }
            },
            messages: {
                name: {
                    stringCheck: "输入正确姓名"
                },
                mobile: {
                    isMobile: "请输入正确的手机号码"
                },
                email: "电子邮件格式不正确！",
                height: {
                    number: '请输入正确身高'
                },
                weight: {
                    number: '请输入正确身高'
                }
            },
            submitHandler: function (form) {
                jQuery.ajax({
                    type: "post",
                    url: "/userCenter/index/profileEditSubmit/",
                    data: $form.serialize(),
                    success: function (result) {
                        if (result == 1) {
                            $.dialog.success('修改成功！');
                        //    window.location.href="";
                        } else if (result == 2) {
                            $.dialog.error('修改失败！');
                        }
                    }
                });
            }
        });

    //我要参加
    $('#changePassword').on('click', function() {
        var $dialog = $('#modifyPasswordDialog');
        var validate, $form;

        var d = dialog({
            title: '修改密码',
            content: $dialog.html(),
            okValue: '提交',
            ok: function () {
                validate.form();
                return false;
            },
            onshow: function() {
                var $content = this._$('content');
                $form = $content.find('#validatePassForm');
                validate = $form.validate({
                    rules: {
                        oldPassword: 'required',
                        newPassword: {
                            required: true,
                            minlength: 6,
                            maxlength: 16
                        },
                        newPassword1: {
                            required: true,
                            minlength: 6,
                            maxlength: 16,
                            equalTo: '#newPassword1'
                        }
                    },
                    messages: {
                        oldPassword: '原始密码不能为空！',
                        newPassword: {   required: '密码不能为空！',
                            minlength: " 密码长度不能小于6个字符",
                            maxlength: " 密码长度不能大于15个字符"
                        },
                        newPassword1: {
                            required: '确认密码不能为空！',
                            minlength: " 密码长度不能小于6个字符",
                            maxlength: " 密码长度不能大于15个字符",
                            equalTo: '两次输入密码不一致！'
                        }
                    },
                    submitHandler: function (form) {
                        //    form.submit();
                        jQuery.ajax({
                            type: "post",
                            url: "/ResetPwd",
                            data: $form.serializeJson(),
                            success: function ($result) {
                                d.close();
                            }
                        });
                    }
                });
            }
        }).width(350).showModal();
    });
});