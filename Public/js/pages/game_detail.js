/**
 * Created by wei_jc on 2015/4/6.
 */
$(function () {
    // 注册body id
    $('body').attr('id', 'match-page');
    //
    var $detailTabs = $('#detailTabs');
    var $tabs = $('#tabs');
    $detailTabs.find('a').each(function (index) {
        $(this).click(function () {
            $detailTabs.find('a').removeClass('current');
            $(this).addClass('current');

            $tabs.find('.tab').hide().eq(index).show();
        });
    });
});