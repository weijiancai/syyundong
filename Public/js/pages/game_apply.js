/**
 * Created by wei_jc on 2015/4/6.
 */
$(function () {
    // 注册body id
    $('body').attr('id', 'match-apply');

    //参赛报名
    // $('#group_id').val($('.current').data('id'));
    $(".radio-block").each(function() {
        if($(this).hasClass('radio-disabled')) {
            return true;
        } else {
            $(this).addClass('current');
            $('#group_id').val($(this).data('id'));
            return false;
        }
    });
    $(".radio-block").click(function () {
        if($(this).hasClass('radio-disabled')) {
            return;
        }
        $('.radio-block').removeClass('current');
        $(this).addClass('current');
        $('#group_id').val($(this).data('id'));
    });

    //报名校验
    jQuery.validator.addMethod("isMobile", function (value, element) {
        var length = value.length;
        var mobile = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|(17[0-9]{1})|(14[0-9]{1}))+\d{8})$/;
        return this.optional(element) || (length == 11 && mobile.test(value));
    }, "请正确填写您的手机号码"),

        jQuery.validator.addMethod("stringCheck", function (value, element) {
            return this.optional(element) || /^[\u4e00-\u9fa5]{2,4}$/.test(value);
        }, "只能包括中文字");

    $('#GameGroupForm').validate({
        rules: {
            true_name: {
                required: true,
                stringCheck: true
            },
            mobile: {
                required: true,
                isMobile: true
            },
            certificate_num: "required",
            gender: "required",
            em_contact: {
                required: true,
                stringCheck: true
            },
            em_tel: {
                required: true,
                isMobile: true
            }
        },
        messages: {
            true_name:{
                required:"真实姓名不能为空",
                stringCheck: "姓名不正确"
            },
            mobile: {
                required: "手机号码不能为空",
                isMobile: "请输入正确的手机号码"
            },
            certificate_num: "身份证号不能为空",
            gender: "性别不能为空",
            em_contact:{
                required:"紧急联系人不能为空",
                stringCheck: "联系人姓名不正确"
            },
            em_tel: {
                required: "紧急联系人电话不能为空",
                isMobile: "请输入正确的联系人号码"
            }
        },
        submitHandler: function (form) {
            jQuery.ajax({
                type: "post",
                url: "/Game/GameGroupAdd",
                data: $('#GameGroupForm').serialize(),
                success: function (result) {
                    if (result == 1) {
                        dialog({
                            content: '申请成功',
                            okValue: '确定',
                            ok: function () {
                                window.location.href='/Game/apply_success/';
                            }
                        }) .show();
                    }
                }
            });
        }
    });
});