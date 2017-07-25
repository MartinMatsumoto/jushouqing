$(function () {

    var indexShow = $('[id=index_show]');

    for (var i = 0; i < indexShow.length; i++) {
        $(indexShow[i]).mouseover(function () {
            $(this).find("#index_show_content").show();
        });

        $(indexShow[i]).mouseout(function () {
            $(this).find("#index_show_content").hide();
        });
    }
});