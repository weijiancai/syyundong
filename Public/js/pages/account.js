/**
 * Created by liuliting on 15-5-23.
 */
$(function () {
    // 注册body id
    $('body').attr('id', 'ucenter-account');

    var $fileUpload = $('#fileupload');
    var $setHeadIcon = $('#btnSetHeadIcon');
    $setHeadIcon.click(function () {
        $fileUpload.trigger('click');
    });
    $("#fileupload").wrap("<form id='myupload' action='/Public/Public/upimg' method='post' enctype='multipart/form-data'></form>");
    $("#fileupload").change(function (event) {
        console.log($("#fileupload"));
        var size = event.target.files[0].size;
        var name = event.target.files[0].name;
        var format = name.substring(name.lastIndexOf(".") + 1, name.length).toLowerCase();
        if ((size >= 3145728)) {//3M
            var str = '图片尺寸超过3M';
            $("#show_mes").html(str);
        } else if ((format != 'jpg') && (format != 'jpeg') && (format != 'png')) {
            var str = '请上传 jpg/jpeg/png格式的图片！';
            $("#show_mes").html(str);
        } else {
            $("#myupload").ajaxSubmit({
                dataType: 'json',
                data: {path: $("#path").val()},
                beforeSend: function () {
                    $('#showimg').html("<img width:52px height=52px src='/Public/images/default/upimg_loading.gif'>");
                },
                success: function (data) {
                    var arr = data['savename'].split('/');
                    var img = "/Public/Upload/" + data.path + "/" + arr[0]+"/s_"+arr[1];
                    $("#nickthumb").html("<span class='delimg' rel='" + data.savename + "'></span><img width:52px height=52px src='" + img + "'>");
                    $('#user_head').val(data.label);
                },
                error: function (xhr) {
                    var str = '<span>出错啦!</span>';
                    $("#show_mes").html(str);
                    $("#alert_box").css({display: "block"});
                }
            });
        }
    });
    //修改密码
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
                            equalTo: $form.find('#newPassword').val()
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

});
