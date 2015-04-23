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
});

