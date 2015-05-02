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
            if($(this).text() == '赛友圈') {
                alert('跳转到赛友圈！');
                return;
            }
            $detailTabs.find('a').removeClass('current');
            $(this).addClass('current');

            $tabs.find('.tab').hide().eq(index).show();
            if(index == 0) {
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
            if(index == 0) {
                $('#gameTopic').show();
                $('#gameFlow').hide();
            } else {
                $('#gameTopic').hide();
                $('#gameFlow').show();
            }
        });
    });
    //我要报名
    $('#i_game_apply').click(function(){
        dialog({
            id: 'id-demo',
            content: $('#game_declare').val(),
            okValue: '已阅读,我同意',
            ok: function () {
                window.location.href='/Game/apply/'+$('#game_id').val();
            }
        })
            .width(820)
            .show();
        dialog.get('id-demo').title('参赛声明');
    });
    //关注
   $("#game_focus").click(function(){
       if($("#game_focus").html()=='关注'){
           jQuery.ajax({
               type: "post",
               url: "/Game/GameFocus",
               data: {source_id: $("#game_id").val()},
               success: function (result) {
                   if (result == 1) {
                       $("#game_focus").html('取消关注');
                   }else {
                       $.dialog.error('关注失败,请刷新页面重新尝试');
                   }
               }
           });
       }else{
           jQuery.ajax({
               type: "post",
               url: "/Game/GameFocusCancel",
               data: {source_id: $("#game_id").val()},
               success: function (result) {
                   if (result == 1) {
                       $("#game_focus").html('关注');
                   }else {
                       $.dialog.error('取消关注失败,请刷新页面重新尝试');
                   }
               }
           });
       }
   });
    //加赛友
    $('.add_friend').click(function(){
        jQuery.ajax({
            type: "post",
            url: "/Game/GameAddFriend",
            data: {friend_id: $(this).data('value')},
            success: function (result) {
                if (result == 1) {
                    $.dialog.success('已添加');
                }else {
                    $.dialog.error('添加赛友失败,请稍后重试');
                }
            }
        });
    });
    //赛友换一换
    change();
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
    }
    //发布话题
    $('#TopicForm').validate({
        rules: {
            content: {
                required: true,
                minlength:10
            }
        },
        messages: {
            content: {
                required: "评论内容不能为空",
                minlength: "最少10个汉字"
            }
        },
        submitHandler: function (form) {
            jQuery.ajax({
                type: "post",
                url: "/register/AddProfile",
                data: $('#ProfileForm').serialize(),
                success: function (result) {
                    if (result == 1) {
                        window.location.href = '/register/done';
                    } else if (result == 2) {
                        $.dialog.error('用户信息添加失败');
                    } else if (result == 0) {
                        window.location.href = '/register';
                    }
                }
            });
        }
    });
});