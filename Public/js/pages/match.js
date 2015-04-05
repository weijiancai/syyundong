/**
 * Created by liuliting on 15-3-31.
 */
$(function () {
    // 注册body id
    $('body').attr('id', 'match-page');

    var url = "Game/search?";
    var $form = $('#searchForm');
    var $stateReg = $('#state_reg');
    var $stateIn = $('#state_in');
    var $stateOver = $('#state_over');
    // 报名中
    $('#statusReg').change(function () {
        if ($(this).get(0).checked) {
            $stateReg.val('T');
        } else {
            $stateReg.val('F');
        }
        $form.submit();
    });
    // 比赛中
    $('#statusIn').change(function () {
        if ($(this).get(0).checked) {
            $stateIn.val('T');
        } else {
            $stateIn.val('F');
        }
        $form.submit();
    });
    // 已结束
    $('#statusOver').change(function () {
        if ($(this).get(0).checked) {
            $stateOver.val('T');
        } else {
            $stateOver.val('F');
        }
        $form.submit();
    });


    // 排序
    $('#order-group').find('li a').click(function() {
        var value = $(this).data('value');
        console.log(value);
        if(value == 'createDate') {
            $('#orderByNew').val('C');
        } else if(value == 'followCount') {
            $('#orderByNew').val('F');
        }else if(value == 'startDate') {
            $('#orderByNew').val('S');
        }
        if($(this).find('i.icon-down')) {
            $('#order').val('down'); // 降序
        } else {
            $('#order').val('up'); // 升序
        }
        $form.submit();
    });

/*    $('.order-group li a').click(function () {
        $(this).attr('data-value');
    });
    //provinceId=all&sportTypeId=all&timeType=all&keyword=&statusIn=0
    // &statusOver=0&statusReg=0&criteria=startDate
    $('#statusReg').click(function () {
        if ($('#statusReg').prop("checked") == true) {
            var url = "Game/search?statusReg="+statusReg+"&statusIn=0&statusOver=0";
        }
        window.location.href = url;
    });
    $('#statusIn').click(function () {
        if ($('#statusReg').prop("checked") == true) {
            url += "&statusReg=" + statusIn;
        }
        window.location.href = url;
    });
    $('#statusOver').click(function () {
        if ($('#statusReg').prop("checked") == true) {
            url += "&statusReg=" + statusOver;
        }
        window.location.href = url;
    });*/

    if (url != 'Game/search?') {
        window.location.href = url;
    }

});