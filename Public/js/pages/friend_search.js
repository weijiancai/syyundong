/**
 * Created by wei_jc on 15-4-8.
 */
$(function () {
    // 注册body id
    $('body').attr('id', 'social-home');

    //赛友圈搜索
    $('#fmSearch').validate({
        rules: {
            keyword: 'required'
        },
        messages: {
            keyword: '搜索内容不能为空'
        },
        submitHandler: function (form) {
           form.submit();
        }
    });

});