/**
 * Created by wei_jc on 15-4-8.
 */
$(function () {
    // 注册body id
    $('body').attr('id', 'tourism');

    //搜索
    var $form = $('#searchForm');
    // 省市
    $('#tplCity').change(function () {
        var cityId = $(this).val();
        if (cityId != '') {
            submit('cityId', cityId);
        }
    });
    // 区域
    $('#v_region').find('a').click(function () {
        $(this).parent().find('a.current').removeClass('current');
        $(this).addClass('current');
        submit('region', $(this).data('value'));
    });

    // 关键字
    $('#btnSearchKeyword').click(function () {
        var value = $('#inputKeyword').val();
        if (value != '') {
            submit('keyword', value);
        }
    });
    // 提交
    function submit(id, value) {
        $('#' + id).val(value);
        $form.submit();
    }
});