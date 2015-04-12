/**
 * Created by wei_jc on 15-4-8.
 */
$(function () {
    // 注册body id
    $('body').attr('id', 'venues');

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
});