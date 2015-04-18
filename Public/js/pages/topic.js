/**
 * Created by wei_jc on 15-4-8.
 */
$(function () {
    // 注册body id
    $('body').attr('id', 'topic-detail');
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
});