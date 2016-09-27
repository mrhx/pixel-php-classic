(function (w, d) {
    var widthEl = d.getElementById('width'), containerEl = d.getElementById('container'), windowHeight = 960;
    var resizeFunc = function () {
        var width = w.innerWidth || d.documentElement.clientWidth || d.body.clientWidth;
        if (width <= 0) {
            width = 960;
        }
        widthEl.value = width;
        containerEl.style.width = width + "px";
        windowHeight = w.innerHeight || d.documentElement.clientHeight || d.body.clientHeight;
    };
    var scrollFunc = function () {
        var top = d.body.scrollTop || d.documentElement.scrollTop;
        if (top <= 0) {
            console.log("top");
        }
        if (top >= windowHeight - 10) {
            console.log("bottom");
        }
    };
    w.onresize = resizeFunc;
    w.onscroll = scrollFunc;
    resizeFunc();
})(window, document);
