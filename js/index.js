$(function () {

    var liHovers = $('[id=index_li_hover]');
    var indexUl = $('[id=index_ul]');
    var indexShow = $('[id=index_show]');

    for (var i = 0; i < liHovers.length; i++) {

        $(liHovers[i]).mouseover(function () {
            $(this).addClass("choose");
            $(this).next().removeClass("hide");
        });

        $(liHovers[i]).mouseout(function () {
            $(this).removeClass("choose");
            $(this).next().addClass("hide");
        });
    }

    for (var i = 0; i < indexUl.length; i++) {

        $(indexUl[i]).mouseover(function () {
            $(this).removeClass("hide");
            $(this).prev().addClass("choose");
        });

        $(indexUl[i]).mouseout(function () {
            $(this).addClass("hide");
            $(this).prev().removeClass("choose");
        });
    }

    for (var i = 0; i < indexShow.length; i++) {
        $(indexShow[i]).mouseover(function () {
            $(this).find("#index_show_content").show();
        });

        $(indexShow[i]).mouseout(function () {
            $(this).find("#index_show_content").hide();
        });
    }
});