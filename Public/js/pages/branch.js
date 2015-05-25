/**
 * Created by liuliting on 15-5-25.
 */
$(function () {
    // 注册body id
    $('body').attr('id', 'topic_detail');
    if($("#hot_topic").is(":visible")){
        replay($('#topicData'), $('#seeMore'), 'hot_list', {sportTypeId:$('#topicData').data('sporttypeid')});
    }
    $('#hottopic').click(function(){
        $('#All_topic').css('display','none');
        $('#alltopics').removeClass('current');
        $('#hottopic').addClass('current');
        $('#hot_topic').css('display','block');
    })
    $('#alltopics').click(function(){
        $('#hot_topic').css('display','none');
        $('#hottopic').removeClass('current');
        $('#alltopics').addClass('current');
        $('#All_topic').css('display','block');
        replay($('#AllTopicData'), $('#all_more'), 'list', {sportTypeId:$('#topicData').data('sporttypeid')});
    })
});