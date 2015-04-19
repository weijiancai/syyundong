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
            nickName: {
                required: true,
                stringCheck: true,
                byteRangeLength: [3, 15],
                remote: {
                    url: "/Register/isExistNc",       //后台处理程序
                    type: "get",                      //数据发送方式
                    dataType: "json",                 //接受数据格式
                    data: {                           //要传递的数据
                        nickName: function () {
                            return $("#nickName").val();
                        }
                    }

                }
            },
            gender: "required"
        },
        messages: {
            nickName: {
                required: "请填写昵称",
                stringCheck: "昵称只能包括中文字、英文字母、数字和下划线",
                byteRangeLength: "请确保昵称在3-15个字节之间(一个中文字算2个字节)",
                remote: $.validator.format("该昵称已存在！")
            },
            gender: "请选择性别！"
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    var $fileUpload = $('#fileupload');
    var $setHeadIcon = $('#btnSetHeadIcon');
    $setHeadIcon.click(function() {
        //alert('aa');
        $fileUpload.trigger('click');
    });
    $fileUpload.change(function() {
        alert($(this).val());
    });
});