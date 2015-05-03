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
                            window.location.href="";
                        } else if (result == 2) {
                            $.dialog.error('修改失败！');
                        }
                    }
                });
            }
        });
});