/**
 * Created by wei_jc on 15-4-8.
 */
$(function () {
    // 注册body id
    $('body').attr('id', 'topic-detail');

    //赛友圈搜索
    $('#branchform').validate({
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

    var $topicData = $('#topicData');
    var $more = $('#more');

    //热门话题
    $('#hotTopicTabs').find('a').click(function () {
        $(this).parent().find('a.current').removeClass('current');
        $(this).addClass('current');

        replay($topicData, $more, 'list', '/Friends/hotTopicLoad', {source_type: $(this).data('value')}, true);
    });

    replay($topicData, $more, 'list', '/Friends/hotTopicLoad', {source_type: ''});

    //关注
    $("#topic_focus").click(function () {
        if ($("#topic_focus").html() == '关注') {
            jQuery.ajax({
                type: "post",
                url: "/Friends/index/topicFocus",
                data: {source_id: $("#topic_id").val()},
                success: function (result) {
                    if (result == 1) {
                        $("#topic_focus").html('取消关注');
                        $('#topic_focus').removeClass('btn-danger');
                    } else {
                        $.dialog.error('关注失败,请刷新页面重新尝试');
                    }
                }
            });
        } else {
            jQuery.ajax({
                type: "post",
                url: "/Friends/index/topicFocus",
                data: {source_id: $("#topic_id").val()},
                success: function (result) {
                    if (result == 1) {
                        $("#topic_focus").html('关注');
                        $('#topic_focus').addClass('btn-danger');
                    } else {
                        $.dialog.error('取消关注失败,请刷新页面重新尝试');
                    }
                }
            });
        }
    });
    //推荐赛友
    change();
    $('#change').click(change);
    function change() {
        jQuery.ajax({
            type: "post",
            url: "/Friends/index/recommendFriend",
            success: function ($result) {
                if ($result) {
                    var obj = eval($result);
                    $('#recommend').empty();
                    for (var i = 0; i < obj.length; i++) {
                        var $li = $(template('lists', obj[i]));
                        $('#recommend').append($li);
                    }
                }
            }
        })
    }
    //关注话题

});
