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


// 评论回复
function replay($container, $more, tpl_id, url, params, isReset) {
    // 重置
    if(isReset) {
        $container.empty();
        $more.data('last', 0);
    }

    function more() {
        var last = $more.data('last');
        if (last == -1) {
            return;
        }
        $more.text('正在加载数据......');
        var options = {
            last: last * 10,
            amount: 10
        };
        $.post(url, $.extend(options, params), function (data) {
            if (!data || data == 'null') {
                $more.text('没有更多内容').data('last', -1);
                return;
            }
            data = eval(data);

            if(data.length < 10) {
                $more.text('没有更多内容').data('last', -1);
            } else {
                $more.text('点击加载更多内容').data('last', ++last);
            }

            for (var i = 0; i < data.length; i++) {
                var $row = $(template(tpl_id, data[i]));
                $container.append($row);

                (function($row) {
                    var $commentPop = $row.find('.comment-pop');
                    var $commentList = $row.find('.comment-list');
                    // 注册事件
                    $row.find('a.comment-btn').click(function() {
                        $commentPop.toggle();
                        var sourceType = $row.data('source_type');
                        if(sourceType == '4' && !$commentPop.is(':hidden')) {
                            getTopicComment($commentList, $row.data('source_id'), sourceType);
                        }
                    });
                    $commentPop.find('form').validate({
                        rules: {
                            content: 'required'
                        },
                        messages: {
                            content: '回复内容不能为空！'
                        },
                        submitHandler: function (form) {
                            var data = $(form).serializeJson();
                            data.source_type = $row.data('source_type');
                            data.source_id = $row.data('source_id');
                            jQuery.ajax({
                                type: "post",
                                url: "/Friends/index/CommentReply",
                                data: data,
                                success: function ($result) {
                                    if ($result == 1) {
                                        /*$container.empty();
                                         $more.data('last', 0);
                                         more();*/
                                        // 评论数加1
                                        var $count = $row.find('.comment-count');
                                        var count = parseInt($count.text());
                                        $count.text(count + 1);
                                        // 输出框清空
                                        $row.find('input[name="content"]').val('');
                                        // 重新检索
                                        getTopicComment($commentList, $row.data('source_id'), '4');
                                    } else {
                                        $.dialog.error('回复失败');
                                    }
                                }
                            });
                            //$commentPop.hide();
                        }
                    });
                })($row);
            }
        });
    }

    more();
    $more.unbind('click').bind('click', more);

    // 检索当前话题的评论
    function getTopicComment($commentList, topicId, sourceType) {
        jQuery.ajax({
            type: "post",
            url: "/Game/index/LoadReply",
            data: {topicId: topicId},
            success: function (data) {
                if (!data || data == 'null') {
                    return;
                }
                data = eval(data);
                $commentList.empty();

                for (var i = 0; i < data.length; i++) {
                    var $dl = $(template('tpl_topic_comment', data[i]));
                    $dl.find('input[name="source_id"]').val(topicId);
                    $commentList.append($dl);
                    // 注册事件
                    $dl.find('#replyLink').click(function() {
                        $(this).parent().parent().find('.reply-form').toggle();
                    });
                    $dl.find('.reply-form form').validate({
                        rules: {
                            content: 'required'
                        },
                        messages: {
                            content: '回复内容不能为空！'
                        },
                        submitHandler: function (form) {
                            var data = $(form).serializeJson();
                            data.source_type = sourceType;
                            data.source_id = topicId;
                            jQuery.ajax({
                                type: "post",
                                url: "/Friends/index/CommentReply",
                                data: data,
                                success: function ($result) {
                                    if ($result == 1) {
                                        $commentList.parent().find('#content').val('');
                                        getTopicComment($commentList, topicId);
                                    } else {
                                        $.dialog.error('回复失败');
                                    }
                                }
                            });
                        }
                    });
                }
            }
        });
    }
}
