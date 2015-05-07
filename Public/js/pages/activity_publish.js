/**
 * Created by liuliting on 15-3-31.
 */
$(function () {
    // 注册body id
    $('body').attr('id', 'match-post');

    $('#acPublish').validate({
        rules: {
            sportTypeId: "required",
            name: 'required',
            provinceId: "required",
            sponor: 'required',
            phone: "required",
            limitCount: 'required',
            description: "required",
            applyName: 'required',
            applyPhone: 'required',
            applyEmail: 'required'
        },
        messages: {
            sportTypeId: "比赛项目不能为空！",
            name: '活动名称不能为空！',
            provinceId: "举办城市不能为空！",
            sponor: '赛事发起方不能为空！',
            phone: "联系方式不能为空！",
            limitCount: "人数限制不能为空！",
            description: "赛事介绍不能为空！",
            applyName: "申请人姓名不能为空！",
            applyPhone: "申请人电话不能为空！",
            applyEmail: "申请人邮箱不能为空！"
        },
        submitHandler: function (form) {
            form.submit();
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