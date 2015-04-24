/**
 * Created by liuliting on 15-4-23.
 */
$(document).ready(function () {
    //赛事类别ajax查询
    $("#province").change(function () {
        getActivityCity();
    });
    function getActivityCity() {
        $("#game_add_sid").empty();
        $.getJSON("/Syweblg2015/DbActivity/getActivityCity", {id: $("#game_add_id").val()}, function (data) {
            $("<option></option>").val("").text("请选择").appendTo($("#game_add_sid"));
            if (data != null) {
                $.each(data, function (i, item) {
                    $("<option></option>").val(item['id']).text(item['name']).appendTo($("#game_add_sid"));
                });
            }
        });
    }
});

