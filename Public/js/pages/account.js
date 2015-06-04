/**
 * Created by liuliting on 15-5-23.
 */
$(function () {
    // 注册body id
    $('body').attr('id', 'ucenter-account');


    //修改密码
    var $form = $('#pwdForm');
    $form.validate({
        rules: {
            oldPassword: {
                required: true,
                remote: {
                    url: "/userCenter/index/checkPwd",  //后台处理程序
                    type: "post",                      //数据发送方式
                    dataType: "json",                 //接受数据格式
                    data: {                           //要传递的数据
                        oldPassword: function () {
                            return $("#oldPassword").val();
                        }
                    }
                }
            },
            newPassword: {
                required: true,
                minlength: 6,
                maxlength: 16
            },
            newPassword1: {
                required: true,
                minlength: 6,
                maxlength: 16,
                equalTo: '#newPassword'
            }
        },
        messages: {
            oldPassword: {
                required: "原始密码不能为空",
                remote: $.validator.format("原始密码不正确！")
            },
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
            jQuery.ajax({
                type: "post",
                url: "/userCenter/index/ResetPwdSubmit",
                data: {'newPassword': $('#newPassword').val()},
                success: function ($result) {
                    if ($result) {
                        $.dialog.success('密码修改成功');

                        //    window.location.href='/login/login';
                    } else {
                        $.dialog.error('密码修改失败');
                    }
                }
            });
        }
    })
    //兴趣爱好取值
    $("li").click(function () {
        var name = $(this).data('name');
        if ($(this).hasClass('current')) {
            $(this).removeClass('current');
            var str = $('#interest').val()
            $('#interest').val(str.replace($(this).data('id') + ',', ""));
        } else {
            $(this).addClass('current');
            $('#interest').val($('#interest').val() + $(this).data('id') + ',');
        }
        $('#cked-num').html($('.interest-list .current').length);
    });

    //账户设置
    var $form = $('#accountForm');
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
                    url: "/userCenter/index/isExistNc",       //后台处理程序
                    type: "post",                      //数据发送方式
                    dataType: "json",                 //接受数据格式
                    data: {                           //要传递的数据
                        nickName: function () {
                            return $("#nick_name").val();
                        }
                    }

                }
            }
        },
        messages: {
            nick_name: {
                required: "请填写昵称",
                stringCheck: "昵称只能包括中文字、英文字母、数字和下划线",
                byteRangeLength: "请确保昵称在3-15个字节之间(一个中文字算2个字节)",
                remote: $.validator.format("该昵称已存在！")
            }
        },
        submitHandler: function (form) {
            jQuery.ajax({
                type: "post",
                url: "/userCenter/index/accountEditSubmit/",
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
//删除赛友
    $('#del_user_friend').click(function () {
        jQuery.ajax({
            type: "post",
            url: "/userCenter/index/del_friend/",
            data: {friend_id: $('#del_user_friend').data('friend')},
            success: function ($result) {
                if ($result) {
                    dialog({
                        content: '删除成功',
                        ok: function () {
                            window.location.href = '';
                        },
                        cancel: false
                    }).show();
                } else {
                    $.dialog.error('删除失败！');
                }
            }
        });
    })
    //删除评论
    $('.del_topic').click(function () {
        $url  =$(this).data('url');
        $id =$(this).data('value')
        dialog({
            content: '确定要删除吗',
            okValue: '确定',
            ok: function () {
                jQuery.ajax({
                    type: "post",
                    url: $url,
                    data: {common_id: $id},
                    success: function ($result) {
                        if ($result) {
                            window.location.href = ''
                        } else {
                            $.dialog.error('删除失败！');
                        }
                    }
                });
                return false;
            },
            cancelValue: '取消',
            cancel: function () {
            }
        }).show();
    })
});
