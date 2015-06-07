/**
 * Created by liuliting on 15-3-31.
 */
$(function () {
    // 注册body id
    $('body').attr('id', 'match-post');

    // 日期控件
    $('.dateRange').daterangepicker({
        startDate: new Date(),
        format: 'YYYY-MM-DD HH:mm:ss',
        timePicker: true,
        timePickerSeconds: true,
        timePickerIncrement: 1,
        timePicker12Hour: false,
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-primary',
        cancelClass: 'btn-default',
        drops: 'down',
        locale: {
            applyLabel: '确定',
            cancelLabel: '取消',
            fromLabel: '从',
            toLabel: '到',
            weekLabel: '周',
            customRangeLabel: '自定义',
            daysOfWeek: ['日', '一', '二', '三', '四', '五', '六'],
            monthNames: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
            firstDay: 1
        }
    }, function(start, end, label) {
        var startDate = this.element.data('start_date');
        var endDate = this.element.data('end_date');
        $(startDate).val(start.format('YYYY-MM-DD HH:mm:ss'));
        $(endDate).val(end.format('YYYY-MM-DD HH:mm:ss'));
    });

    $('#acPublish').validate({
        debug: true,
        rules: {
            sportTypeName: "required",
            name: 'required',
            regDateRange:'required',
            dateRange:'required',
            regionId: "required",
            address: 'required',
            limitCount:
            {required:"true",
            digits:"true"},
            content: "required",
            cost:{required:"true",number:"true"}
        },
        messages: {
            sportTypeName: "比赛项目不能为空！",
            name: '活动名称不能为空！',
            regDateRange:'报名时间不能为空',
            dateRange:'活动时间不能为空',
            regionId: "请选择活动地点!",
            address: '请填写详细地址',
            limitCount: {
                required:"人数限制不能为空！",
                digits:"只能输入整数"
            },
            content: "请填写活动简介",
            cost:{
                required:"金额不能为空",
                number:"请输入正确的金额,只能为数字"
            }
        },
        submitHandler: function (form) {
            jQuery.ajax({
                type: "post",
                url: "/Activity/index/AddActivity",
                data: $('#acPublish').serialize(),
                success: function (result) {
                    if (result) {
                        dialog({
                            content: '发布活动成功',
                            okValue: '确定',
                            ok: function () {
                                window.location.href = '/Activity/'+result;
                            }
                        }).show();
                    } else {
                        $.dialog.error('发布活动失败');
                    }
                }
            });
        //    form.submit();
        }
    });
    //活动免费-付费
    $(':radio').click(function(){
        if(this.value==1){
            $('#cost').removeAttr('disabled');
        }
    });
    // 活动 - 运动项目
    var $activityItem = $('#activityItem');
    var $activityContent = $activityItem.find('div.datadropdown-content');
    $activityItem.find('input[type="text"]').focus(function () {
        $activityContent.show();
    });
    $activityItem.find('.datadropdown-close').click(function () {
        $activityContent.hide();
    });
    $activityContent.find('dd a').click(function () {
        $activityContent.find('dd a').removeClass('current');
        $(this).addClass('current');
        $activityContent.hide();
        $activityItem.find('input[name="sportTypeId"]').val($(this).data('value'));
        $activityItem.find('input[type="text"]').val($(this).text());
    });
});