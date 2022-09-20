function replace() {
    let temp = $("div.body-gen");
    let navigatorHeight = $("div.navbar").outerHeight();
    let footer = $("footer");
    let footerHeight = footer.outerHeight();
    let paginator = $("div.pagination");
    if (temp.outerHeight() < ($(window).height() - footerHeight) && footerHeight <= 121) {

        let nouveau = "" + ($(document).height() - footerHeight - navigatorHeight) + "px";

        paginator.css("position", "absolute");
        paginator.css("top", nouveau);
        temp.css("minHeight", nouveau);
        footer.css({"position": "absolute", "bottom": 0});
    } else {
        paginator.css("position", "static");
        footer.css("position", "static");
    }
}

$(document).ready(function () {
    replace();
});

$(window).resize(function () {
    replace();
});