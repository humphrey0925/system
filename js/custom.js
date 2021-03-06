(function($) {
    $(document)
        .on('dragstart', function(event) { event.preventDefault(); })
        .on('contextmenu', function(event) { event.preventDefault(); });
    if ($.cookie("_key") == undefined && $.cookie("session") == undefined)
        _initLoginForm();
    $('body').animate({ opacity: 1 }, 300);
    $(window).on('beforeunload', function() {
        var iamsadqwe = "qweqw1e12312";
        console.log(iamsadqwe);
        if (iamsadqwe == 'qweqwe12312') {
            return true
        }
    });
})(jQuery);

$.ajaxSetup({
    processData: false,
    contentType: false,
    dataType: "json",
    method: "POST"
});

function _initLoginForm() {
    $("#login").css("opacity", "1");
    $("#login-form").validate({
        rules: {
            username: "required",
            password: "required",
        },
        errorClass: "form-invalid"
    });
    $("#login-form").submit(function(event) {
        return _login(this);
    });
}

function _login(form) {
    if ($(form).valid()) {
        $(form).find(".login-form-main-message").removeClass("show error success");
        var ajaxData = { data: new FormData(form) };
        var ajaxFail = function() {
            $(form).find(".login-form-main-message").addClass("show error").html(msg["msg-server-error"]);
        };
        var ajaxSuccess = function(data) {
            $(form).find("[type=submit]").prop("disabled", false).removeClass("error success clicked").html(msg["btn-default"]);
            if (data.status == 1) {
                $("#login").animate({
                        opacity: 0
                    },
                    200,
                    function() {
                        $(this).remove();
                        $("body").css('opacity', '0').append(data.html);
                        eval((data.tmp));
                        _initMain();
                        if (data.key) {
                            $.cookie("_key", data.key, { expires: 365, path: "/" });
                        } else {
                            $.cookie("session", data.session, { path: "/" });
                            $(window).on('beforeunload', function() {
                                var data = new FormData();
                                data.append("logout", $.cookie("session"));
                                $.ajax({ data: data });
                                $.removeCookie("_key", { path: "/" });
                                $.removeCookie("session", { path: "/" });

                            });
                        }
                        $("body").animate({
                                opacity: 1
                            },
                            200,
                            function() {});
                    });
            } else {
                $(form).find(".login-form-main-message").addClass("show error").html(msg["msg-error"]);
            }
        };
        $.ajax(ajaxData).fail(ajaxFail).always(ajaxSuccess);
        form_loading($(form));
    }
    return false;
}

var msg = {
    "btn-default": "<i class=\"fa fa-chevron-right\"></i>",
    "btn-loading": "<i class=\"fa fa-spinner fa-pulse\"></i>",
    "btn-success": "<i class=\"fa fa-check\"></i>",
    "btn-error": "<i class=\"fa fa-remove\"></i>",
    "msg-success": "All Good! Redirecting...",
    "msg-error": "ID or Password Wrong",
    "msg-server-error": "Server Error",
};

function scrolltop() {
    $(document).scrollTop(0);
}

function _width() {
    return window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName("body")[0].clientWidth;
}

function _height() {
    return window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName("body")[0].clientHeight;
}

function remove_loading($form) {
    $form.find("[type=submit]").prop("disabled", false);
    $form.find("[type=submit]").removeClass("error success clicked").html(msg["btn-default"]);
    $form.find(".login-form-main-message").removeClass("show error success");
}

function form_loading($form) {
    $form.find("[type=submit]").prop("disabled", true);
    $form.find("[type=submit]").addClass("clicked").html(msg["btn-loading"]);
}

function form_success($form) {
    $form.find("[type=submit]").addClass("success").html(msg["btn-success"]);
    $form.find(".login-form-main-message").addClass("show success").html(msg["msg-success"]);
}

function form_failed($form) {
    $form.find("[type=submit]").addClass("error").html(msg["btn-error"]);
    $form.find(".login-form-main-message").addClass("show error").html(msg["msg-error"]);
}
$(document).ajaxStart(function() {
    $(".load-bar").css('display', 'initial');
    $(".load-bar").animate({ opacity: 1 }, 200);
});
$(document).ajaxStop(function() {
    $(".load-bar").animate({ opacity: 0 }, 200,
        function() {
            $(".load-bar").css('display', 'none');
        });
    $(".container-fluid").animate({ opacity: 1 }, 200);
});
