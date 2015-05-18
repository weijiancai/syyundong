/**
 * Created by wei_jc on 15-4-8.
 */
$(function () {
    // 注册body id
    $('body').attr('id', 'social-home');
    //评论
    $('#commentform').validate({
        rules: {
            content: 'required'
        },
        messages: {
            content: '评论内容不能为空'
        },
        submitHandler: function (form) {
            //    form.submit();
            jQuery.ajax({
                type: "post",
                url: "/Friends/index/publishReply",
                data: $('#commentform').serialize(),
                success: function ($result) {
                    if ($result==1) {
                        //$.dialog.success('评论成功');
                        $commentData.empty();
                        $more.data('last', 0);
                        more();
                    } else {
                        $.dialog.error('评论失败');
                    }
                }
            });
        }
    });
    function onReplyClick() {
        var $panel = $(this).parent().parent();
        $panel.find('.reply-form').toggle();
    }

    var $replyPanel = $('.reply-panel');
    $replyPanel.find('a').click(onReplyClick);
    // 验证，提交回复
    var replyPanelValidateOption = {
        rules: {
            content: 'required'
        },
        messages: {
            content: '回复内容不能为空！'
        },
        submitHandler: function (form) {
            var data = $(form).serializeJson();
            data['source_id'] = $('#game_id').val();
            jQuery.ajax({
                type: "post",
                url: "/Friends/index/CommentReply",
                data: data,
                success: function ($result) {
                    if ($result==1) {
                        $topiccomment.empty();
                        $topic_more.data('last', 0);
                        topicmore();
                    } else {
                        $.dialog.error('回复失败');
                    }
                }
            });
            $(form).parent().hide();
        }
    };
    $replyPanel.find('.reply-form form').validate(replyPanelValidateOption);
    //加载评论数据
    var s_id = $('#game_id').val();
    // 加载更多
    var $topiccomment = $('#topiccomment');
    var $topic_more = $('#topic_more');

    function topicmore() {
        var last = $topic_more.data('last');
        if (last == -1) {
            return;
        }
        $topic_more.text('正在加载数据......');
        $.post('/Friends/index/TopicCommentLoad', {
            last: last * 10,
            amount: 10,
            source_id: s_id
        }, function (data) {
            if (!data || data == 'null') {
                $topic_more.text('没有更多内容').data('last', -1);
                return;
            }
            data = eval(data);

            if(data.length < 10) {
                $topic_more.text('没有更多内容').data('last', -1);
            } else {
                $topic_more.text('点击加载更多内容').data('last', ++last);
            }
            for (var i = 0; i < data.length; i++) {
                var $dl = $(template('topic', data[i]));
                $topiccomment.append($dl);
                // 注册事件
                $dl.find('.reply-panel').find('a').click(onReplyClick);
                $dl.find('.reply-form form').validate(replyPanelValidateOption);
            }
        });
    }
    $topic_more.click(topicmore);
    // 第一次加载
    topicmore();

    // 回复
    var $replyPanel = $('.reply-panel');
    $replyPanel.find('a').click(function () {
        var $panel = $(this).parent().parent();
        $panel.find('.reply-form').toggle();
    });
    // 验证，提交回复
    $replyPanel.find('.reply-form form').validate({
        rules: {
            content: 'required'
        },
        messages: {
            content: '回复内容不能为空！'
        },
        submitHandler: function (form) {
            form.submit();
            $(form).parent().hide();
        }
    });
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

    //热门话题
    $('#hotTopicTabs').find('a').click(function () {
        $(this).parent().find('a.current').removeClass('current');
        $(this).addClass('current');
        more();
    });

    var $commentData = $('#commentData');
    var $more = $('#more');

    function more() {
        if ($('#hotTopicTabs').find('a.current').data('value') != $('#source_type').val()) {
            var flag = 1;
            var last = 0;
            $commentData.empty();
            $('#source_type').val($('#hotTopicTabs').find('a.current').data('value'));
        } else {
            var last = $more.data('last');
        }
        if (last == -1) {
            return;
        }
        $more.text('正在加载数据......');
        $.post('/Friends/hotTopicLoad', {
            last: last * 10,
            amount: 10,
            source_type: $('#hotTopicTabs').find('a.current').data('value')
        }, function (data) {
            if (!data || data == 'null') {
                if (flag == 1) {
                    $commentData.empty();
                }
                $more.text('没有更多内容').data('last', -1);
                return;
            }
            $more.text('点击加载更多内容').data('last', ++last);
            data = eval(data);
            for (var i = 0; i < data.length; i++) {
                var $dl = $(template('list', data[i]));
                $commentData.append($dl);
                // 注册事件
                /* $dl.find('.reply-panel').find('a').click(onReplyClick);
                 $dl.find('.reply-form form').validate(replyPanelValidateOption);*/
            }
        });
    }

    $more.click(more);
    // 第一次加载
    more();

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
                    } else {
                        $.dialog.error('取消关注失败,请刷新页面重新尝试');
                    }
                }
            });
        }
    });
});