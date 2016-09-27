(function (w, d) {
    var widthEl = d.getElementById('width'), containerEl = d.getElementById('container');
    var resizeFunc = function (event) {
        var width = w.innerWidth || d.documentElement.clientWidth || d.body.clientWidth;
        if (width <= 0) {
            width = 960;
        }
        widthEl.value = width;
        containerEl.style.width = width + "px";
    };
    w.onresize = resizeFunc;
    resizeFunc();
})(window, document);
