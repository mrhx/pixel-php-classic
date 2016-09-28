(function (w, d) {
    var widthEl = d.getElementById("width"), containerEl = d.getElementById("container");
    var loading = false, minBlockId = parseInt(containerEl.getAttribute('data-block-id'), 10);
    var image = new Image(), imagesEl = d.getElementById("images"), maxBlockId = minBlockId;
    var formEl = d.getElementById("form"), clickX, clickY, clickBlockId;
    var resizeFunc = function () {
        var width = d.documentElement.clientWidth || d.body.clientWidth;
        if (width <= 0) {
            width = 960;
        }
        widthEl.value = width;
        containerEl.style.width = width + "px";
    };
    var createImageInput = function (imageSrc) {
        var el = d.createElement("input");
        el.type = "image";
        el.name = "image";
        el.width = "60";
        el.height = "60";
        el.src = imageSrc;
        return el;
    };
    var submitFunc = function (event) {
        if (event.preventDefault) {
            event.preventDefault();
        }
        return false;
    };
    var clickFunc = function (event) {
        if (event.target.tagName.toLowerCase() == "input") {
            var width = d.documentElement.clientWidth || d.body.clientWidth;
            clickX = event.pageX;
            clickY = (event.pageY - 40) % width;
            clickBlockId = Math.floor((event.pageY - 40) / width) + minBlockId;
            if (clickBlockId > 278) {
                clickBlockId = clickBlockId - 278;
            }
        }
    };
    var prevImageFunc = function () {
        imagesEl.insertBefore(createImageInput(image.src), imagesEl.firstChild);
        w.scrollTo(0, d.documentElement.clientWidth || d.body.clientWidth);
        var images = imagesEl.getElementsByTagName("input");
        if (images.length > 3) {
            imagesEl.removeChild(images[images.length - 1]);
            maxBlockId = maxBlockId <= 1 ? 278 : maxBlockId - 1;
        }
        loading = false;
    };
    var nextImageFunc = function () {
        imagesEl.appendChild(createImageInput(image.src));
        var images = imagesEl.getElementsByTagName("input");
        if (images.length > 3) {
            imagesEl.removeChild(images[0]);
            minBlockId = minBlockId >= 278 ? 1 : minBlockId + 1;
            w.scrollBy(0, -(d.documentElement.clientWidth || d.body.clientWidth));
        }
        loading = false;
    };
    var scrollFunc = function () {
        if (loading) {
            return;
        }
        var top = d.documentElement.scrollTop || d.body.scrollTop;
        var maxTop = containerEl.clientHeight - (d.documentElement.clientHeight || d.body.clientHeight);
        if (top <= 0) {
            loading = true;
            minBlockId = minBlockId <= 1 ? 278 : minBlockId - 1;
            image.onload = prevImageFunc;
            image.src = "/image.php?id=" + minBlockId;
        } else if (top >= maxTop - 30) {
            loading = true;
            maxBlockId = maxBlockId >= 278 ? 1 : maxBlockId + 1;
            image.onload = nextImageFunc;
            image.src = "/image.php?id=" + maxBlockId;
        }
    };
    var loadMoreBlocks = function () {
        loading = true;
        maxBlockId = maxBlockId >= 278 ? 1 : maxBlockId + 1;
        image.onload = nextImageFunc;
        image.src = "/image.php?id=" + maxBlockId;
    };
    d.getElementById("page-up").style.display = "none";
    d.getElementById("page-down").style.display = "none";
    w.onresize = resizeFunc;
    w.onscroll = scrollFunc;
    containerEl.onclick = clickFunc;
    formEl.onsubmit = submitFunc;
    resizeFunc();
    loadMoreBlocks();
})(window, document);
