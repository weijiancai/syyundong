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

        replay($topicData, $more, 'hot_list', {source_type: $(this).data('value')}, true);
    });
    if ($('#topicData').data('topic') == 'hot_topic') {
        replay($topicData, $more, 'hot_list', {source_type: ''});
    }
    //关注话题
    if ($('#topicData').data('topic') == 'self_topic') {
        replay($topicData, $more, 'list', {source_type: ''});
    }


});
