/**
 * Created by wei_jc on 15-4-8.
 */
$(function () {
    // 注册body id
    $('body').attr('id', 'topic-detail');

    //topic:回复
/*    var $topicData = $('#topic_comment');
    var $replyPanel = $('.reply-panel');
    var $more = $('#topic_more');
    $replyPanel.find('a').click(function() {
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
            replay($topicData, $more, 'topic', {source_type: '4',source_id:$topicData.data('source_id')});
        }
    });
    replay($topicData, $more, 'topic', {source_type: '4',source_id:$topicData.data('source_id')});*/
    //评论内容
    $('#topic_comment_form').validate({
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
                url: "/Friends/index/publishReplay",
                data: $('#topic_comment_form').serialize(),
                success: function ($result) {
                    if ($result==1) {
                        $('#topic_comment').empty();
                        $('#content').val('');
                        $('#seeMore').data('last', 0);
                        replay($('#topic_comment'), $('#seeMore'), 'tpl_topic_comment', {source_id:$('#topic_comment').data('source_id'),source_type:4});
                    } else {
                        $.dialog.error('评论失败');
                    }
                }
            });
        }
    });
    //图片墙
    var $imagewall = $('#imagewall');
    var $semore = $('#seeMoreList');
    var game_id = $('#imagewall').data('game_id');
    function seemorelist() {
        var last = $semore.data('last');
        if (last == -1) {
            return;
        }
        $semore.text('正在加载数据......');
        $.post('/Game/index/GameImageLoad', {
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
                /*$dl.find('.comment-btn').click(onCommentClick);
                $dl.find('.comment-pop form').validate(replyPanelValidateOption);*/
            }
        });
    }

    $semore.click(seemorelist);
    // 第一次加载
    seemorelist();
});