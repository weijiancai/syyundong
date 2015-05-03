/**
 * Created by wei_jc on 2015/4/6.
 */
$(function () {
    // 注册body id
    $('body').attr('id', 'activity-details');

    //相似活动、换一换
    detail_change();
    $('#change').click(detail_change);
    function detail_change() {
        jQuery.ajax({
            type: "post",
            url: "SimilarActivity",
            data: {id: $("#activityId").val(),sport_id:$('#sport_id').val()},
            success: function ($result) {
                if ($result) {
                    var obj = eval($result);
                    $('#similar').empty();
                    for (var i = 0; i < obj.length; i++) {
                        var $li = $(template('detail_list', obj[i]));
                        $('#similar').append($li);
                    }
                }
            }
        })
    }
    // 活动详情、已报名
    $('#relevantTabs').find('a').each(function (index) {
        $(this).click(function () {
            var $parent = $(this).parent();
            $parent.find('a').removeClass('current');
            $(this).addClass('current');
            var $dd = $parent.parent().find('dd');
            if(index == 0) {
                $dd.eq(1).hide();
            } else {
                $dd.eq(0).hide();
            }
            $dd.eq(index).show();
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
                        //$.dialog.success('评论成功');
                        $commentData.empty();
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
                url: "/Activity/index/CommentReply",
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
        $.post('ActivityCommentLoad', {
            last: last * 10,
            amount: 10,
            source_id: s_id
        }, function (data) {
            if (!data || data == 'null') {
                $more.text('没有更多内容').data('last', -1);
                return;
            }
            data = eval(data);

            if(data.length < 10) {
                $more.text('没有更多内容').data('last', -1);
            } else {
                $more.text('点击加载更多内容').data('last', ++last);
            }
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

    // 我要参加
    $('#joinBtn').on('click', function() {
        var $dialog = $('#joinActivityDialog');
        var validate, $form;

        var d = dialog({
            title: '我要参加',
            content: $dialog.html(),
            okValue: '提交',
            ok: function () {
                validate.form();
                return false;
            },
            onshow: function() {
                var $content = this._$('content');
                $form = $content.find('#joinActivityForm');
                validate = $form.validate({
                    rules: {
                        true_name: 'required',
                        mobile: 'required',
                        certificate_num: 'required'
                    },
                    messages: {
                        true_name: '报名人姓名不能为空！',
                        mobile: '报名人手机不能为空！',
                        certificate_num: '身份证号码不能为空！'
                    },
                    submitHandler: function (form) {
                        //    form.submit();
                        jQuery.ajax({
                            type: "post",
                            url: "publishReply",
                            data: $form.serializeJson(),
                            success: function ($result) {
                                d.close();
                            }
                        });
                    }
                });
            }
        }).width(480).show();
    });
});