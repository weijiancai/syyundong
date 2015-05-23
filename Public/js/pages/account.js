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
});
