/**
 * Created by wei_jc on 2015/4/6.
 */
$(function() {
    // 注册body id
    $('body').attr('id', 'activity');
    var $form = $('#searchForm');
    // 区域
    $('#regionList').find('a').click(function () {
        $(this).parent().find('a.current').removeClass('current');
        $(this).addClass('current');
        submit('region', $(this).data('value'));
    });
    // 召集中
    $('#statusReg').change(function () {
        submit('state_reg', $(this).get(0).checked ? 'T' : 'F');
    });
    // 进行中
    $('#statusIn').change(function () {
        submit('state_in', $(this).get(0).checked ? 'T' : 'F');
    });
    // 已结束
    $('#statusOver').change(function () {
        submit('state_over', $(this).get(0).checked ? 'T' : 'F');
    });

    // 省
/*    $('#provinceId').change(function () {
        var province = $(this).val();
        if (province != '') {
            submit('province', province);
        }
    });*/

    // 排序
    $('.order-group').find('li a').click(function() {
        var value = $(this).data('value');

        if(value == '2') {
            $('#orderByNew').val('C');
        } else if(value == '3') {
            $('#orderByNew').val('F');
        }else if(value == '1') {
            $('#orderByNew').val('S');
        }
        if($(this).find('i.icon-down')) {
            $('#order').val('down'); // 降序
        } else {
            $('#order').val('up'); // 升序
        }
        $form.submit();
    });

    // 运动项目
    var $sportTypePanel = $('#sportTypePanel');
    $sportTypePanel.find('dt a').click(function() {
        $($sportTypePanel).find('dt a.current').removeClass('current');
        $(this).addClass('current');
        submit('sportType', $(this).data('value'));
    });

    // 时间
    $('#dateList').find('a').click(function() {
        $(this).parent().find('a.current').removeClass('current');
        $(this).addClass('current');
        submit('date', $(this).data('value'));
    });

    // 关键字
    $('#btnSearchKeyword').click(function() {
        var value = $('#inputKeyword').val();

        if(value != '') {
            submit('keyword', value);
        }
    });

    // 提交
    function submit(id, value) {
        $('#' + id).val(value);
        $form.submit();
    }

    //我要参加
    $('.btnJoin').on('click', function() {
        var mark =$('#mark_id').val();
       if(!mark){
            window.location.href='/login/login';
        }else{
        var $dialog = $('#joinActivityDialog');
        var validate, $form;
        var activityId = $(this).data('value');
        var d = dialog({
            title: '我要参加',
            content: $dialog.html(),
            okValue: '提交',
            ok: function () {
                if(validate.form()) {
                    jQuery.ajax({
                        type: "post",
                        url: "Activity/index/joinActivity",
                        data: $form.serializeJson(),
                        success: function ($result) {
                            if($result){
                                dialog.success('报名成功');
                                d.close();
                            }else{
                                dialog.error('报名失败');
                            }

                        }
                    });
                }
                return false;
            },
            onshow: function() {
                var $content = this._$('content');
                $form = $content.find('#joinActivityForm');
                $form.find('#activityId').val(activityId);
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
                    }
                });
            }
        }).width(480).show();
       };
    });
});