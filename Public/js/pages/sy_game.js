/**
 * Created by liuliting on 15-4-23.
 */
$(document).ready(function () {
    getSportAjax();
    $("#sport_id").change(function () {
        getSportAjax();
    });
    function getSportAjax() {
        $("#sport_sid").empty();
        $.getJSON("/Syweblg2015/DbGame/getSportAjax", {id: $("#sport_id").val()}, function (data) {
            $("<option></option>").val("").text("请选择").appendTo($("#sport_sid"));
            if (data != null) {
                $.each(data, function (i, item) {
                    $("<option></option>").val(item['id']).text(item['name']).appendTo($("#sport_sid"));
                });
            }
        });
    }
});

