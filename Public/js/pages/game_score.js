/**
 * Created by wei_jc on 2015/4/6.
 */
$(function () {
    // 注册body id
    $('body').attr('id', 'match-page');
    //Tab切换
    var $detailTabs = $('#detailTabs');
    var $tabs = $('#tabs');
    $detailTabs.find('a').each(function (index) {
        $(this).click(function () {
            $detailTabs.find('a').removeClass('current');
            $(this).addClass('current');

            $tabs.find('.tab').hide().eq(index).show();
            if (index == 0) {
                $('#detail_bottom').show();
            } else {
                $('#detail_bottom').hide();
            }
        });
    });
    //成绩查询校验
    var $form = $('#scoreForm');
    $form.validate({
        rules: {
            playerId: {
                required: true,
                number:true
            }
        },
        messages: {
            playerId: {
                required: "选手编号不能为空",
                number:"请输入数字"
            }
        },
        submitHandler: function (form) {
              $form.submit();
        }
    });
});