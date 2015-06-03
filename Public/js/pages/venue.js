/**
 * Created by wei_jc on 15-4-8.
 */
$(function () {
    // 注册body id
    $('body').attr('id', 'venues');

    //搜索
    var $form = $('#searchForm');
    // 区域
    $('#v_region').find('a').click(function () {
        $(this).parent().find('a.current').removeClass('current');
        $(this).addClass('current');
        submit('region', $(this).data('value'));
    });
    // 商圈
    $('#v_business').find('a').click(function () {
        $(this).parent().find('a.current').removeClass('current');
        $(this).addClass('current');
        submit('business', $(this).data('value'));
    });
    // 项目
    $('#datalist').find('a').click(function () {
        $(this).parent().find('a.current').removeClass('current');
        $(this).addClass('current');
        submit('sportType', $(this).data('value'));
    });
    // 关键字
    $('#btnSearchKeyword').click(function () {
        var value = $('#inputKeyword').val();
        if (value != '') {
            submit('keyword', value);
        }
    });
    // 排序
    $('#order-group').find('li a').click(function () {
        var value = $(this).data('value');
        if (value == 'pv') {
            $('#orderByNew').val('M');
        } else if (value == 'star') {
            $('#orderByNew').val('S');
        } else if (value == 'comment') {
            $('#orderByNew').val('C');
        } else if (value == 'price') {
            $('#orderByNew').val('P');
        }
        if ($(this).find('i.icon-down')) {
            $('#order').val('down'); // 降序
        } else {
            $('#order').val('up'); // 升序
        }
        $form.submit();
    });
    // 提交
    function submit(id, value) {
        $('#' + id).val(value);
        $form.submit();
    }

    //首页换一换
    change();
    $('#change').click(change);
    function change() {
        jQuery.ajax({
            type: "post",
            url: "Venue/HotVenue",
            success: function ($result) {
                if ($result) {
                    var obj = eval($result);
                    $('#hot').empty();
                    for (var i = 0; i < obj.length; i++) {
                        var $li = $(template('list', obj[i]));
                        $('#hot').append($li);
                    }
                }
            }
        })
    }
    //收藏
    $('.item-list-bottom').find('a').click(function() {
        var self= $(this);
        jQuery.ajax({
            type: "post",
            url: "/Venue/collection",
            data: {source_id: $(this).data('value')},
            success: function ($result) {
                if ($result==0) {
                    window.location.href='/login/login';
                }else if($result==1){
                    $.dialog.error('已经收藏过啦');
                }else if($result==2){
                    $.dialog.error('收藏失败');
                }else{
                    $.dialog.success('收藏成功');
                    var $follow_count = self.find('.follow_count');
                    var follow_count = parseInt($follow_count.text());
                    $follow_count.text(follow_count + 1);
                    self.find('i').addClass('icon-faved');
                }
            }
        })
    });
});