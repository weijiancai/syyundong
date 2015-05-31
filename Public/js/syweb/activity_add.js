/**
 * Created by liuliting on 15-4-23.
 */
$(document).ready(function () {
    //活动城市ajax查询
    $("#province").change(function () {
        getActivityCity();
    });
    function getActivityCity() {
        $("#city").empty();
        if ($("#province").val()) {
            $.getJSON("/Syweblg2015/DbActivity/getCity", {id: $("#province").val()}, function (data) {
                $("<option></option>").val("").text("请选择").appendTo($("#city"));
                if (data != null) {
                    $.each(data, function (i, item) {
                        $("<option></option>").val(item['id']).text(item['name']).appendTo($("#city"));
                    });
                }
            });
        }
    }

    //活动区域ajax查询
    $("#city").change(function () {
        getActivityRegion();
    });
    function getActivityRegion() {
        $("#region").empty();
        if ($("#city").val()) {
            $.getJSON("/Syweblg2015/DbActivity/getCity", {id: $("#city").val()}, function (data) {
                $("<option></option>").val("").text("请选择").appendTo($("#region"));
                if (data != null) {
                    $.each(data, function (i, item) {
                        $("<option></option>").val(item['id']).text(item['name']).appendTo($("#region"));
                    });
                }
            });
        }
    }
    //活动需要报名信息

    $.getJSON("/Syweblg2015/DbActivity/getCheck", {id: $("#id").val()}, function (data) {
        for (var i = 0; i < data.length; i++) {
            $('input[value=' + data[i] + ']').attr('checked', 'checked');
        }
    });
});

