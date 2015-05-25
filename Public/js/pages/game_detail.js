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
            if ($(this).text() == '赛友圈') {
                alert('跳转到赛友圈！');
                return;
            }
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

    $('#relevantTabs').find('a').each(function (index) {
        $(this).click(function () {
            $(this).parent().find('a').removeClass('current');
            $(this).addClass('current');
            if (index == 0) {
                $('#gameTopic').show();
                $('#gameFlow').hide();
            } else {
                $('#gameTopic').hide();
                $('#gameFlow').show();
            }
        });
    });
    //我要报名
    $('#i_game_apply').click(function () {
        dialog({
            id: 'id-demo',
            content: $('#game_declare').html(),
            okValue: '已阅读,我同意',
            ok: function () {
                window.location.href = '/Game/apply/' + $('#game_id').val();
            }
        })
            .width(820)
            .show();
        dialog.get('id-demo').title('参赛声明');
    });
    //关注
    $("#game_focus").click(function () {
        if ($("#game_focus").html() == '关注') {
            jQuery.ajax({
                type: "post",
                url: "/Game/GameFocus",
                data: {source_id: $("#game_id").val()},
                success: function (result) {
                    if (result == 1) {
                        $("#game_focus").html('取消关注');
                        $('#game_focus').removeClass('btn-danger');
                    } else {
                        $.dialog.error('关注失败,请刷新页面重新尝试');
                    }
                }
            });
        } else {
            jQuery.ajax({
                type: "post",
                url: "/Game/GameFocusCancel",
                data: {source_id: $("#game_id").val()},
                success: function (result) {
                    if (result == 1) {
                        $("#game_focus").html('关注');
                        $('#game_focus').addClass('btn-danger');
                    } else {
                        $.dialog.error('取消关注失败,请刷新页面重新尝试');
                    }
                }
            });
        }
    });

    //赛友换一换
    /*    change();
     $('#change').click(change);
     function change() {
     jQuery.ajax({
     type: "post",
     url: "/Game/index/UserFriend",
     data: {game_id: $("#game_id").val()},
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
     }*/

    // 回复
    function onCommentClick() {
        var $panel = $(this).parent().parent();
        var $pop = $panel.find('.comment-pop');
        $pop.toggle();
        var $commentList = $panel.find('.comment-list');
        var topicId = $(this).data('id');
        if(!$pop.is(':hidden')) {
            getTopicComment($commentList, topicId);
        }
    }

    // 检索当前话题的评论
    function getTopicComment($commentList, topicId) {
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
                            if($('#free').val()){
                            jQuery.ajax({
                                type: "post",
                                url: "/Game/index/CommentReply",
                                data: data,
                                success: function ($result) {
                                    if ($result==1) {
                                        $commentList.parent().find('#content').val('');
                                        getTopicComment($commentList, topicId);
                                    } else {
                                        $.dialog.error('回复失败');
                                    }
                                }
                            });
                        }else{
                                window.location.href='/login/login';
                            }
                            //   $(form).parent().hide();
                        }
                    });
                }
            }
        });
    }

    var $commentBtn = $('.comment-btn');
    $commentBtn.click(onCommentClick);
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
            if($('#free').val()){
            jQuery.ajax({
                type: "post",
                url: "/Game/index/CommentReply",
                data: data,
                success: function ($result) {
                    if ($result==1) {
                        var $commentList = $(form).parent().parent().find('.comment-list');
                        $commentList.parent().find('#content').val('');
                        getTopicComment($commentList, data['source_id'])
                    } else {
                        $.dialog.error('回复失败');
                    }
                }
            });
            }else{
                window.location.href='/login/login';
            }
        //   $(form).parent().hide();
        }
    };
    $commentBtn.find('.topic-right form').validate(replyPanelValidateOption);

    //赛事话题加载
    var game_id = $('#game_id').val();
    // 加载更多
    var $topicData = $('#topicData');
    var $more = $('#more');
    function more() {
        var last = $more.data('last');
        if (last == -1) {
            return;
        }
        $more.text('正在加载数据......');
        $.post('index/GameCommentLoad', {
            last: last * 10,
            amount: 10,
            game_id: game_id
        }, function (data) {
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
                var $dl = $(template('list', data[i]));
                console.log($dl);
                $topicData.append($dl);
                $dl.find(".topic-img-wrap").yoxview({
                    lang: "zh-cn",
                    backgroundColor: 'Blue',
                    playDelay: 5000,
                    autoPlay: true
                });
                // 注册事件
                 $dl.find('.comment-btn').click(onCommentClick);
                 $dl.find('.comment-pop form').validate(replyPanelValidateOption);
            }
        });
    }

    $more.click(more);
    // 第一次加载
    more();
//图片墙
    var $imagewall = $('#imagewall');
    var $semore = $('#seeMoreList');

    function seemorelist() {
        var last = $semore.data('last');
        if (last == -1) {
            return;
        }
        $semore.text('正在加载数据......');
        $.post('index/GameImageLoad', {
            last: last * 2,
            amount: 2,
            game_id: game_id
        }, function (data) {
            if (!data || data == 'null') {
                $semore.text('没有更多内容').data('last', -1);
                return;
            }
            data = eval(data);

            if (data.length < 10) {
                $semore.text('没有更多内容').data('last', -1);
            } else {
                $semore.text('点击加载更多内容').data('last', ++last);
            }
            for (var i = 0; i < data.length; i++) {
                var $dl = $(template('seemore', data[i]));
                $imagewall.append($dl);
                $dl.find(".topic-img-wrap").yoxview({
                    lang: "zh-cn",
                    backgroundColor: 'Blue',
                    playDelay: 5000,
                    autoPlay: true
                });
                // 注册事件
               $dl.find('.comment-btn').click(onCommentClick);
               $dl.find('.comment-pop form').validate(replyPanelValidateOption);
            }
        });
    }

    $semore.click(seemorelist);
    // 第一次加载
    seemorelist();

});