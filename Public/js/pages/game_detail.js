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
        if (isLogin()) {
            if ($("#game_focus").html() == '关注') {
                jQuery.ajax({
                    type: "post",
                    url: "/Game/GameFocus",
                    data: {source_id: $("#game_id").val()},
                    success: function (result) {
                        if (result == 1) {
                            $("#game_focus").html('取消关注');
                            $('#game_focus').removeClass('btn-danger');
                            window.location.href='';
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
                            window.location.href='';
                        } else {
                            $.dialog.error('取消关注失败,请刷新页面重新尝试');
                        }
                    }
                });
            }
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

//图片墙
    var $imagewall = $('#imagewall');
    var $see_more = $('#seeMoreList');

    function seemorelist() {
        var last = $see_more.data('last');
        if (last == -1) {
            return;
        }
        $see_more.text('正在加载数据......');
        $.post('index/GameImageLoad', {
            last: last * 10,
            amount: 10,
            game_id: $('#game_id').val()
        }, function (data) {
            if (!data || data == 'null') {
                $see_more.text('没有更多内容').data('last', -1);
                return;
            }
            data = eval(data);

            if (data.length < 10) {
                $see_more.text('没有更多内容').data('last', -1);
            } else {
                $see_more.text('点击加载更多内容').data('last', ++last);
            }
            for (var i = 0; i < data.length; i++) {
                var $dl = $(template('see_more', data[i]));
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

    $see_more.click(seemorelist);
    // 第一次加载
    seemorelist();

    $('.add_friend').click(addFriend);

});