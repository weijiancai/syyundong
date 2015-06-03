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
            jQuery.ajax({
                type: "post",
                url: "publishReply",
                data: $('#commentform').serialize(),
                success: function ($result) {
                    if ($result==1) {
                        $('#commentData').empty();
                        $('#content').val('');
                        $('#more').data('last', 0);
                        replay($('#commentData'), $('#more'), 'tpl_topic_comment', {source_id:$('#commentData').data('value')});
                    } else {
                        $.dialog.error('评论失败');
                    }
                }
            });
        }
    });


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