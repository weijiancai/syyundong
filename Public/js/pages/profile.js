$(function () {
    // 注册body id
    $('body').attr('id', 'signup-page');

    var $form = $('#ProfileForm');

    $form.validate({
        rules: {
            gender: "required"
        },
        messages: {
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