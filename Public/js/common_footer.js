/**
 * Created by wei_jc on 2015/4/6.
 */
/* 主页导航 */
$(function () {
    var $navigation = $('#navigation');

    if ($(document.body).attr('id') != 'index') {
        $navigation.hover(function () {
            $navigation.find('> ul').addClass('hover');
        }, function () {
            $navigation.find('> ul').removeClass('hover');
        });

        $navigation.find('ul').mouseleave(function () {
            $navigation.find('> ul').removeClass('hover');
        });
    } else {
        $navigation.find('ul').mouseleave(function () {
            $navigation.find('div.navigation-item-content').hide();
        });
    }

    $navigation.find('div.navigation-item-static').hover(function () {
        $navigation.find('div.navigation-item-content').hide();
        $(this).parent().find('div.navigation-item-content').show();
    });

    /*// 日期控件
    $('.date').daterangepicker({
        startDate: new Date(),
        format: 'YYYY-MM-DD HH:mm:ss',
        timePicker: true,
        timePickerSeconds: true,
        timePickerIncrement: 1,
        timePicker12Hour: false,
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-primary',
        cancelClass: 'btn-default',
        drops: 'down',
        locale: {
            applyLabel: '确定',
            cancelLabel: '取消',
            fromLabel: '从',
            toLabel: '到',
            weekLabel: '周',
            customRangeLabel: '自定义',
            daysOfWeek: ['日', '一', '二', '三', '四', '五', '六'],
            monthNames: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
            firstDay: 1
        }
    }, function(start, end, label) {
        var startDate = this.element.data('start_date');
        var endDate = this.element.data('end_date');
        $(startDate).val(start.format('YYYY-MM-DD HH:mm:ss'));
        $(endDate).val(end.format('YYYY-MM-DD HH:mm:ss'));
    });*/

    // 加载推荐赛友
    var $recommendFriend = $('#recommendFriend');
    if ($recommendFriend.length > 0) {
        function friendChange() {
            jQuery.ajax({
                type: "post",
                url: "/Friends/index/recommendFriend",
                success: function ($result) {
                    if ($result) {
                        var obj = eval($result);
                        $recommendFriend.empty();
                        for (var i = 0; i < obj.length; i++) {
                            var $li = $(template('tpl_friend', obj[i]));
                            $recommendFriend.append($li);
                            //加赛友
                            $li.find('.add_friend').click(addFriend);
                        }
                    }
                }
            })
        }

        $('#tpl_friend_change').click(friendChange);
        friendChange();
    }
    // 加载新加入赛友
    var $NewFriendsData = $('#NewFriendsData');
    if ($NewFriendsData.length > 0) {
        function NewfriendChange() {
            jQuery.ajax({
                type: "post",
                url: "/Friends/index/NewFriend",
                success: function ($result) {
                    if ($result) {
                        var obj = eval($result);
                        $NewFriendsData.empty();

                        for (var i = 0; i < obj.length; i++) {
                            var $li = $(template('tpl_new_friend', obj[i]));
                            $NewFriendsData.append($li);
                            //加赛友
                            $li.find('.add_friend').click(addFriend);
                        }
                    }
                }
            })
        }

        $('#tpl_new_friend_change').click(NewfriendChange);
        NewfriendChange();
    }
});

// 加赛友
function addFriend() {
    if(isLogin()) {
        var self = $(this);
        jQuery.ajax({
            type: "post",
            url: "/Game/GameAddFriend",
            data: {friend_id: $(this).data('value')},
            success: function (result) {
                if (result == 1) {
                    $.dialog.success('添加成功');
                    self.removeClass('btn-warning').attr('disabled', 'disabled');
                } else {
                    $.dialog.error('添加赛友失败,请稍后重试');
                }
            }
        });
    }
}

// 评论回复
function replay($container, $more, tpl_id, params, isReset) {
    var url = $container.data('url');
    var isReplay = $container.data('replay');
    // 重置
    if (isReset) {
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

            if (data.length < 10) {
                $more.text('没有更多内容').data('last', -1);
            } else {
                $more.text('点击加载更多内容').data('last', ++last);
            }

            for (var i = 0; i < data.length; i++) {
                var $row = $(template(tpl_id, data[i]));
                $container.append($row);

                (function ($row) {
                    var $commentPop = $row.find('.comment-pop');
                    var $commentList = $row.find('.comment-list');
                    var sourceId = $row.data('source_id');
                    var sourceType = $row.data('source_type');
                    // 注册事件
                    $row.find('a.comment-btn').click(function () {
                        if(isLogin()) {
                            $commentPop.toggle();
                            if (isReplay && !$commentPop.is(':hidden')) {
                                getTopicComment($commentList, sourceId, sourceType);
                            }
                        }
                    });
                    // 点赞
                    $row.find('a.doPraise').click(function () {
                        var self = $(this);
                        var i = $(this).find(i);
                        if (isLogin()) {
                            jQuery.ajax({
                                type: "post",
                                url: "/Friends/index/DoPraise",
                                data: {source_id: sourceId, source_type: sourceType},
                                success: function ($result) {
                                    if ($result=='true') {
                                        $.dialog.success('点赞成功');
                                        // 点赞数加1
                                        var $laud_count = self.find('.laud_count');
                                        var laud_count = parseInt($laud_count.text());
                                        $laud_count.text(laud_count + 1);
                                        self.find('i').addClass('icon20-praised');
                                       // self.removeClass('btn-warning').attr('disabled', 'disabled');
                                    }else if($result =='error'){
                                        $.dialog.error('点赞失败');
                                    } else {
                                        $.dialog.error('已赞过');
                                    }
                                }
                            });
                        }
                    });
                    // 图片
                    $row.find(".topic-img-wrap").imageView();
                    // 删除
                    $row.find('.deleteComment').click(function () {
                        var $id = $(this).data('replyid');
                        dialog({
                            content: '确定要删除该评论吗?',
                            okValue: '确定',
                            ok: function () {
                                if(isLogin()) {
                                    jQuery.ajax({
                                        type: "post",
                                        url: "/Friends/index/CommentDel",
                                        data: {id: $id},
                                        success: function ($result) {
                                            if ($result) {
                                                reset($commentList, $row);
                                            }
                                        }
                                    });
                                }
                            },
                            cancelValue: '取消',
                            cancel: function () {
                            }
                        }).show();
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
                                url: "/Public/public/CommentReply",
                                data: data,
                                success: function ($result) {
                                    if ($result == 1) {
                                        reset($commentList, $row);

                                        // 输出框清空
                                        $row.find('input[name="content"]').val('');

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

    function reset($commentList, $row) {
        if (isReplay) {
            // 评论数加1
            var $count = $row.find('.comment-count');
            var count = parseInt($count.text());
            $count.text(count + 1);
            // 重新检索
            getTopicComment($commentList, $row.data('source_id'), '4');
        } else {
            $container.empty();
            $more.data('last', 0);
            more();
        }
    }

    more();
    $more.unbind('click').bind('click', more);

    // 检索当前话题的评论
    function getTopicComment($commentList, topicId, sourceType) {
        $commentList.empty();
        jQuery.ajax({
            type: "post",
            url: "/Game/index/LoadReply",
            data: {topicId: topicId},
            success: function (data) {
                if (!data || data == 'null') {
                    return;
                }
                data = eval(data);


                for (var i = 0; i < data.length; i++) {
                    var $dl = $(template('tpl_topic_comment', data[i]));
                    $dl.find('input[name="source_id"]').val(topicId);
                    $commentList.append($dl);
                    // 注册事件
                    $dl.find('#replyLink').click(function () {
                        $(this).parent().parent().find('.reply-form').toggle();
                    });

                    // 删除
                    $dl.find('.deleteComment').click(function () {
                        var $id = $(this).data('replyid');
                        dialog({
                            content: '确定要删除该评论吗?',
                            okValue: '确定',
                            ok: function () {
                                if(isLogin()) {
                                    jQuery.ajax({
                                        type: "post",
                                        url: "/Friends/index/CommentDel",
                                        data: {id: $id},
                                        success: function ($result) {
                                            if ($result) {
                                                getTopicComment($commentList, topicId);
                                            }
                                        }
                                    });
                                }
                            },
                            cancelValue: '取消',
                            cancel: function () {
                            }
                        }).show();
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
                                url: "/Public/public/CommentReply",
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

/**
 * 是否登录，如果没有登陆，则跳转到登陆页面
 *
 * @returns {boolean}
 */
function isLogin() {
    if($('#top_head').data('value')) {
        return true;
    } else {
        window.location.href='/login/login';
        return false;
    }
}