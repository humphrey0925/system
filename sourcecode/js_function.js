var dataStorage = {};
var ajaxSuccess = function(data, b, c) {
    console.log(dataStorage, data, b, c)
    if (data.status != undefined) {
        if (data.status == 1000) {
            data = dataStorage[data.el].cache;
        }

        if (data.status == 9) {
            $("body").animate({
                    opacity: 0
                }, 200,
                function() {
                    $("body").text("").append(data.html);
                    _initLoginForm();
                    $.removeCookie("_key", {
                        path: "/"
                    });
                    $.removeCookie("session", {
                        path: "/"
                    });
                    $(this).animate({
                            opacity: 1
                        },
                        200);
                });
        } else if ((data.status >= 100 && data.status <= 104)) {
            $(".container-fluid").text("");
            $(".container-fluid").append(data.html);
            if (data.status == 100) {
                _initMain();
            }
        } else if (data.status >= 200 && data.status <= 205) {
            if (data.status == 200) {
                $("#userimg").css("background-image", "url(" + data.image_path + ")");
            } else {
                alert(data.msg);
            }
        } else if ((data.status >= 900 && data.status <= 999)) {}
        scrolltop()
    } else {}
}

function _initMain() {
    if ($("#userimg").length) {
        $("#userimg").css("height", $("#userimg").css("width"));
    }
}

function imageUpload(el) {
    var ajaxData = {
        data: new FormData()
    }
    ajaxData.data.append("image", el.files[0]);
    ajaxData.data.append("upload", "userimage");
    $.ajax(ajaxData).always(ajaxSuccess);
}

$("nav.navbar a.dropdown-item,nav.navbar a.navbar-brand,nav.navbar li.nav-item>a[class=\"nav-link\"]").click(function() {
    if (_width() < 768 && $(".navbar-collapse").hasClass("show")) {
        $(".navbar-toggler").click();
    }
    getData($(this).attr("href"));
})
$(window).resize(function(i) {
    ($.cookie("_key") || $.cookie("session")) && _initMain()
});

function getData(el) {
    event.preventDefault();
    var ajaxData = {
        data: new FormData()
    }
    if (dataStorage[el] === undefined) dataStorage[el] = {};
    if (dataStorage[el].cacheTime === undefined) dataStorage[el].cacheTime = 0;
    ajaxData.data.append("cacheTime", dataStorage[el].cacheTime);
    ajaxData.data.append("get", el);
    ajaxData.beforeSend = function() {
        $(".container-fluid").animate({
            opacity: 0
        }, 200);
    }
    $.ajax(ajaxData).always(ajaxSuccess).done(function(data) {
        if (data && data.status != 1000) {
            dataStorage[el].cache = data;
            dataStorage[el].cacheTime = data.cacheTime;
        }
    });
}

function _logout() {
    var ajaxData = {
        data: new FormData()
    }
    ajaxData.data.append("logout", "");
    $.ajax(ajaxData).always(ajaxSuccess);
    dataStorage = {};
}
