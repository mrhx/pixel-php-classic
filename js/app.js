(function (w, d) {
    var widthEl = d.getElementById("width"), containerEl = d.getElementById("container");
    var loading = false, minBlockId = parseInt(containerEl.getAttribute("data-block-id"), 10);
    var image = new Image(), imagesEl = d.getElementById("images"), maxBlockId = minBlockId;
    var formEl = d.getElementById("form"), clickX, clickY, clickBlockId, clickEl;
    var resizeFunc = function () {
        var width = d.documentElement.clientWidth || d.body.clientWidth;
        if (width <= 0) {
            width = 960;
        }
        widthEl.value = width;
        containerEl.style.width = width + "px";
    };
    var getColorValue = function () {
        var inputs = d.getElementById("toolbar").getElementsByTagName("input");
        for (var i = 0, n = inputs.length; i < n; ++i) {
            if (inputs[i].checked) {
                return inputs[i].value;
            }
        }
        return "2980b9";
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
    var makeImageSrc = function (blockId) {
        return "/image.php?id=" + blockId + "&rnd=" + (new Date()).getTime();
    };
    var requestFunc = function () {
        if (this.readyState === 4) {
            if (this.status >= 200 && this.status < 400) {
                if (this.responseText == "OK") {
                    clickEl.src = makeImageSrc(clickBlockId);
                }
            } else {
            }
        }
    };
    var submitFunc = function (event) {
        var request = new XMLHttpRequest();
        request.open("POST", "/click.php?ajax=1&id=" + clickBlockId, true);
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
        request.onreadystatechange = requestFunc;
        request.send("image.x=" + clickX + "&image.y=" + clickY + "&width=" + widthEl.value + "&color=" + getColorValue());
        request = null;
        if (event.preventDefault) {
            event.preventDefault();
        }
        return false;
    };
    var clickFunc = function (event) {
        if (event.target.tagName.toLowerCase() == "input" && event.target.type.toLowerCase() == "image") {
            var width = d.documentElement.clientWidth || d.body.clientWidth;
            clickX = event.pageX;
            clickY = (event.pageY - 40) % width;
            clickBlockId = Math.floor((event.pageY - 40) / width) + minBlockId;
            if (clickBlockId > 278) {
                clickBlockId = clickBlockId - 278;
            }
            clickEl = event.target;
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
            image.src = makeImageSrc(minBlockId);
        } else if (top >= maxTop - 30) {
            loading = true;
            maxBlockId = maxBlockId >= 278 ? 1 : maxBlockId + 1;
            image.onload = nextImageFunc;
            image.src = makeImageSrc(maxBlockId);
        }
    };
    var loadMoreBlocks = function () {
        loading = true;
        maxBlockId = maxBlockId >= 278 ? 1 : maxBlockId + 1;
        image.onload = nextImageFunc;
        image.src = makeImageSrc(maxBlockId);
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
