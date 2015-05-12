/**
 * Created by liuliting on 15-3-31.
 */
$(function () {
    // 注册body id
    $('body').attr('id', 'match-post');

    $('#acPublish').validate({
        rules: {
            sportTypeName: "required",
            name: 'required',
            regBeginDate:'required',
            regEndDate:'required',
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
            regBeginDate:'报名开始时间不能为空',
            regEndDate:'报名结束时间不能为空',
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
        //    form.submit();
        }
    });
    //活动免费-付费
    $(':radio').click(function(){
        if(this.value==2){
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