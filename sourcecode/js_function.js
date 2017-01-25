var ajaxSuccess = function(data) {
    if (data.status == 9) {
        $("body").animate({
                opacity: 0
            }, 200,
            function() {
                $("body").text("").append(data.html);
                _initLoginForm();
                $.removeCookie("key", {
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
    } else if (data.status >= 100 && data.status <= 102) {
        $(".container-fluid").text("");
        $(".container-fluid").append(data.html);
        if (data.status == 100) {
            _initMain();
        }
    } else if (data.status == 200) {
        $("#userimghover").remove();
        $("#userimgupload").remove();
        $("#userimg").css("background-image", "url(" + data.image_path + ")");
    }
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

$("a.dropdown-item,a.navbar-brand").click(function(){
    getData($(this).attr("href"))
})
$(window).resize(function(i) {
    ($.cookie("key") || $.cookie("session")) && _initMain()
});
function getData(el) {
    event.preventDefault();
    var ajaxData = {
        data: new FormData()
    }
    ajaxData.data.append("get", el);
    ajaxData.beforeSend = function() {
        $(".container-fluid").animate({
            opacity: 0
        }, 200);
    }
    $.ajax(ajaxData).done(ajaxSuccess);
}

function _logout() {
    var ajaxData = {
        data: new FormData()
    }
    ajaxData.data.append("logout", "");
    $.ajax(ajaxData).always(ajaxSuccess);
}
