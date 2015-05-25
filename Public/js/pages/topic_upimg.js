/**
 * Created by liuliting on 15-5-25.
 */
//上传图片
var $fileUpload = $('#fileupload');
var imgUpBtn = $('#imgUpBtn');
imgUpBtn.click(function () {
    $fileUpload.trigger('click');
});
$("#fileupload").wrap("<form id='myupload' action='/Public/Public/upimg' method='post' enctype='multipart/form-data'></form>");
$("#fileupload").change(function (event) {
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
                $('#store-wrap').append("<div class='uplist'><img width:52px height=52px src='/Public/images/default/upimg_loading.gif'></div>");
            },
            success: function (data) {
                var img = "/Public/Upload/" + data.path + "/" + data.savename;
                $(".publish-box .store-wrap").show();
                var $delUplist = $("<div><img width:52px height=52px src='" + img + "'><a  href='javascript:void(0);' class='delUplist'>删除</a></div>");
                $("#store-wrap .uplist:last-child").html($delUplist);
                $delUplist.find('a').data('id', data.label).on('click', function () {
                    $(this).parent().parent().remove();
                    var array = [];
                    $("#store-wrap a").each(function () {
                        array.push($(this).data('id'));
                    });
                    $('#imgMsg').val(array.join(',') + (array.length > 0 ? ',' : ''));
                });
                $('#imgMsg').val($('#imgMsg').val() + data.label + ',');
            },
            error: function (xhr) {
                var str = '<span>出错啦!</span>';
                $("#show_mes").html(str);
                $("#alert_box").css({display: "block"});
            }
        });
    }
});
//发布话题
$('#TopicForm').validate({
    rules: {
        content: {
            required: true,
            minlength: 5
        }
    },
    messages: {
        content: {
            required: "评论内容不能为空",
            minlength: "最少5个汉字"
        }
    },
    submitHandler: function (form) {
        jQuery.ajax({
            type: "post",
            url: "/Game/index/AddTopic",
            data: $('#TopicForm').serialize(),
            success: function (result) {
                if (result == 1) {
                    $('#imgMsg').val('');
                    $.dialog.success('发布成功');
                    window.location.href = "";
                }else if(result ==3){
                    $.dialog.error('赛友圈或赛事不存在');
                  //  window.location.href="/login/login"
                }else if(result ==4){
                    $.dialog.error('您尚未登录');
                }else{
                    $.dialog.error('发布失败');
                }
            }
        });
    }
});