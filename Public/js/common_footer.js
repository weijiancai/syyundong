/**
 * Created by wei_jc on 2015/4/6.
 */
/* 主页导航 */
$(function() {
    var $navigation = $('#navigation');

    if($(document.body).attr('id') != 'index') {
        $navigation.hover(function() {
            $navigation.find('> ul').addClass('hover');
        }, function() {
            $navigation.find('> ul').removeClass('hover');
        });

        $navigation.find('ul').mouseleave(function () {
            $navigation.find('> ul').removeClass('hover');
        });
    } else {
        $navigation.find('ul').mouseleave(function() {
            $navigation.find('div.navigation-item-content').hide();
        });
    }

    $navigation.find('div.navigation-item-static').hover(function () {
        $navigation.find('div.navigation-item-content').hide();
        $(this).parent().find('div.navigation-item-content').show();
    });

    // 日期控件
    $('.date').datetimepicker({
        autoclose: true,
        todayBtn: true,
        pickerPosition: "bottom-left",
        language: 'zh-CN'
    });
});
