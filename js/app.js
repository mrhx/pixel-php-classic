(function (w, d) {
    var widthEl = d.getElementById("width"), containerEl = d.getElementById("container");
    var resizeFunc = function () {
        var width = d.documentElement.clientWidth || d.body.clientWidth;
        if (width <= 0) {
            width = 960;
        }
        widthEl.value = width;
        containerEl.style.width = width + "px";
    };
    var scrollFunc = function () {
        var top = d.documentElement.scrollTop || d.body.scrollTop;
        var maxTop = containerEl.clientHeight - (d.documentElement.clientHeight || d.body.clientHeight);
        if (top <= 0) {
        }
        if (top >= maxTop - 30) {
        }
    };
    w.onresize = resizeFunc;
    w.onscroll = scrollFunc;
    resizeFunc();
    d.getElementById("page-up").style.display = "none";
    d.getElementById("page-down").style.display = "none";
})(window, document);
