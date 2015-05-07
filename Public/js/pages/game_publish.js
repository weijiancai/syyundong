/**
 * Created by liuliting on 15-3-31.
 */
$(function () {
    // 注册body id
    $('body').attr('id', 'match-post');

    //费用
    var chkObjs = document.getElementsByName("radio");
    for (var i = 0; i < chkObjs.length; i++) {
        if (chkObjs[i].checked) {
            alert(this);
            chk = i;
            break;
        }
    }

    $('#fmPublish').validate({
        rules: {
            sportTypeId: "required",
            name: 'required',
            provinceId: "required",
            sponor: 'required',
            phone: "required",
            limit_count: 'required',
            description: "required",
            applyName: 'required',
            applyPhone: 'required',
            applyEmail: 'required'
        },
        messages: {
            sportTypeId: "比赛项目不能为空！",
            name: '比赛名称不能为空！',
            provinceId: "举办城市不能为空！",
            sponor: '赛事发起方不能为空！',
            phone: "联系方式不能为空！",
            limit_count: "活动人数不能为空！",
            description: "赛事介绍不能为空！",
            applyName: "申请人姓名不能为空！",
            applyPhone: "申请人电话不能为空！",
            applyEmail: "申请人邮箱不能为空！"
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
});