$(function () {
    // 注册body id
    $('body').attr('id', 'signup-page');

    var $form = $('#ProfileForm');

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
            gender: "required"
        },
        messages: {
            nick_name: {
                required: "请填写昵称",
                stringCheck: "昵称只能包括中文字、英文字母、数字和下划线",
                byteRangeLength: "请确保昵称在3-15个字节之间(一个中文字算2个字节)",
                remote: $.validator.format("该昵称已存在！")
            },
            gender: "请选择性别！"
        },
        submitHandler: function (form) {
            jQuery.ajax({
                type: "post",
                url: "/register/AddProfile",
                data: $('#ProfileForm').serialize(),
                success: function (result) {
                    if (result == 1) {
                        window.location.href = '/register/done';
                    } else if (result == 2) {
                        $.dialog.error('用户信息添加失败');
                    } else if (result == 0) {
                        window.location.href = '/register';
                    }
                }
            });
        }
    });
    //兴趣爱好取值
    $("li").click(function () {
        var name = $(this).data('name');
        if($(this).hasClass('current')){
            $(this).removeClass('current');
            var str  = $('#interest').val()
            $('#interest').val(str.replace($(this).data('id')+',',""));
        }else{
            $(this).addClass('current');
            $('#interest').val($('#interest').val()+ $(this).data('id') + ',');
        }
        $('#cked-num').html($('.interest-list .current').length);
    });

});