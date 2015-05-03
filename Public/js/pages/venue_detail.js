/**
 * Created by wei_jc on 2015/4/6.
 */
$(function () {
    // 注册body id
    $('body').attr('id', 'venues-details');

    // 评分
    var $commentStar = $('#commentStar');
    $commentStar.find('i').each(function (index) {
        $(this).hover(function () {
            var $i = $commentStar.find('i');
            for (var i = 0; i <= index; i++) {
                $i.eq(i + 1).removeClass('icon16-starout').addClass('icon16-starin');
            }
            for (i = index; i < 5; i++) {
                $i.eq(i + 1).removeClass('icon16-starin').addClass('icon16-starout');
            }
        }).click(function () {
            $('#starTotal').val(index + 1);
        });
    });
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
                url: "publishReply",
                data: $('#commentform').serialize(),
                success: function ($result) {
                    if ($result==1) {
                        $commentData.empty();
                        $('#content').val('');
                        $more.data('last', 0);
                        more();
                    } else {
                        $.dialog.error('评论失败');
                    }
                }
            });
        }
    });
    // 回复
    function onReplyClick() {
        var $panel = $(this).parent().parent();
        $panel.find('.reply-form').toggle();
    }



    //详细页换一换
    detail_change();
    $('#change').click(detail_change);
    function detail_change() {
        jQuery.ajax({
            type: "post",
            url: "OtherVenueChange",
            data: {id: $("#s_id").val()},
            success: function ($result) {
                if ($result) {
                    var obj = eval($result);
                    $('#other').empty();
                    for (var i = 0; i < obj.length; i++) {
                        var $li = $(template('detail_list', obj[i]));
                        $('#other').append($li);
                    }
                }
            }
        })
    }

    //收藏
    $('.venues-action').find('a').click(function() {
        jQuery.ajax({
            type: "post",
            url: "collection",
            data: {source_id: $("#s_id").val()},
            success: function ($result) {
                if ($result==0) {
                    window.location.href='/login/login';
                }else if($result==2){
                    $.dialog.error('收藏失败');
                }else{
                    $.dialog.success('收藏成功');
                    window.location.href='';
                }
            }
        })
    });

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
            data['source_id'] = $('#source_id').val();
            jQuery.ajax({
                type: "post",
                url: "/Venue/index/CommentReply",
                data: data,
                success: function ($result) {
                    if ($result==1) {
                        $commentData.empty();
                        $more.data('last', 0);
                        more();
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
    var s_id = $('#s_id').val();
    // 加载更多
    var $commentData = $('#commentData');
    var $more = $('#more');

    function more() {
        var last = $more.data('last');
        if (last == -1) {
            return;
        }
        $more.text('正在加载数据......');
        $.post('VenueCommentLoad', {
            last: last * 10,
            amount: 10,
            source_id: s_id
        }, function (data) {
            if (!data || data == 'null') {
                $more.text('没有更多内容').data('last', -1);
                return;
            }
            $more.text('点击加载更多内容').data('last', ++last);
            data = eval(data);
            for (var i = 0; i < data.length; i++) {
                var $dl = $(template('list', data[i]));
                $commentData.append($dl);
                // 注册事件
                $dl.find('.reply-panel').find('a').click(onReplyClick);
                $dl.find('.reply-form form').validate(replyPanelValidateOption);
            }
        });
    }

    $more.click(more);
    // 第一次加载
    more();
});