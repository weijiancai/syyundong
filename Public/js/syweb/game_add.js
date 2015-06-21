/**
 * Created by liuliting on 15-4-23.
 */
$(document).ready(function () {
    //赛事类别ajax查询
    getgameSportAjax();
    $("#game_add_id").change(function () {
        getgameSportAjax();
    });
    function getgameSportAjax() {
        $("#game_add_sid").empty();
        $.getJSON("/Syweblg2015/DbGame/getSportAjax", {id: $("#game_add_id").val()}, function (data) {
            $("<option></option>").val("").text("请选择").appendTo($("#game_add_sid"));
            if (data != null) {
                $.each(data, function (i, item) {
                    $("<option></option>").val(item['id']).text(item['name']).appendTo($("#game_add_sid"));
                });
            }
        });
    }
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
    $('#is_has_water').click(function(){
        if($('#is_has_water').is(":checked"))
        {
            $('#water').val('1');
        }else{
            $('#water').val('');
        }
    })
});

