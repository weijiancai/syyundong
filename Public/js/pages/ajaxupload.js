$(function () {
    var files = $(".files");
    var btn = $(".btn span");
    var show = '';

    var $fileUpload = $('#fileupload');
    var $setHeadIcon = $('#btnSetHeadIcon');
    $setHeadIcon.click(function () {
        $fileUpload.trigger('click');
    });
    $("#fileupload").wrap("<form id='myupload' action='/Public/Public/upimg' method='post' enctype='multipart/form-data'></form>");
    console.log($("#fileupload"));
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
            console.log($("#myupload"))
            $("#myupload").ajaxSubmit({
                dataType: 'json',
                data: {path: $("#path").val()},
                beforeSend: function () {
                    $('#showimg').html("<img width:52px height=52px src='/Public/images/default/upimg_loading.gif'>");
                },
                success: function (data) {
                    var img = "/Public/Upload/" + data.path + "/" + data.pic;
                    $("#showimg").html("<span class='delimg' rel='" + data.pic + "'></span><img width:52px height=52px src='" + img + "'>");
                    $('#image').val(data.label);
                },
                error: function (xhr) {
                    var str = '<span>出错啦!</span>';
                    $("#show_mes").html(str);
                    $("#alert_box").css({display: "block"});
                }
            });
        }
    });
    $(".delimg").live('click', function () {
        var pic = $(this).attr("rel");
        $(this).parent().remove();
    });

    $("button").click(function () {
        $('#Pic').val('');
        $("ul li .delimg").each(function () {
            var id = $(this).parent().attr('id')
            $('#Pic').val($('#Pic').val() + $(this).attr('rel') + ',');
        });
    });
    $("#but01").click(function () {
        $("#alert_box").css("display", "none");

    });
});