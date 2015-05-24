/**
 * Created by wei_jc on 15-4-8.
 */
$(function () {
    // 注册body id
    $('body').attr('id', 'topic-detail');

    //topic:回复
    var $topicData = $('#topic_comment');
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

    replay($topicData, $more, 'topic', {source_type: '4',source_id:$topicData.data('source_id')});
});