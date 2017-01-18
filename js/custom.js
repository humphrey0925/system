$.ajaxSetup({
    processData: false,
    contentType: false,
    dataType: 'json',
    method: 'POST'
});
(function($) {
    if ($.cookie('key') == undefined && $.cookie('session') == undefined) {
        _initLoginForm();
    } else {
        _initMain();
    }
})(jQuery);

var msg = {
    'btn-default': '<i class="fa fa-chevron-right"></i>',
    'btn-loading': '<i class="fa fa-spinner fa-pulse"></i>',
    'btn-success': '<i class="fa fa-check"></i>',
    'btn-error': '<i class="fa fa-remove"></i>',
    'msg-success': 'All Good! Redirecting...',
    'msg-error': 'ID or Password Wrong',
    'msg-server-error': 'Server Error',
};

function scrolltop() {
    $(document).scrollTop(0)
}

function _width() {
    return window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName("body")[0].clientWidth
}

function _height() {
    return window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName("body")[0].clientHeight
}

function remove_loading($form) {
    $form.find('[type=submit]').prop('disabled', false)
    $form.find('[type=submit]').removeClass('error success clicked').html(msg['btn-default']);
    $form.find('.login-form-main-message').removeClass('show error success');
}

function form_loading($form) {
    $form.find('[type=submit]').prop('disabled', true)
    $form.find('[type=submit]').addClass('clicked').html(msg['btn-loading']);
}

function form_success($form) {
    $form.find('[type=submit]').addClass('success').html(msg['btn-success']);
    $form.find('.login-form-main-message').addClass('show success').html(msg['msg-success']);
}

function form_failed($form) {
    $form.find('[type=submit]').addClass('error').html(msg['btn-error']);
    $form.find('.login-form-main-message').addClass('show error').html(msg['msg-error']);
}

function navMaxHeight() {
    $('.navbar-toggleable-xs').css('max-height', _height() - 54);
}
$(window).resize(function(event) {
    if ($.cookie('key') || $.cookie('session')) {
        _initMain();
    }
});

function _initMain() {
    navMaxHeight();
    if ($('#userimg').length) {
        $('#userimg').css('height', $('#userimg').css('width'))
    }
}

function _initLoginForm() {
    $("#login").css('opacity', '1');
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

function getData(type) {
    var data = new FormData();
    data.append('get', type);
    $.ajax({
            data: data
        })
        .done(function(data) {
            if (data.status == 9) {
                $('body').text('').append(data.html);
                _initLoginForm();
                $.removeCookie('key', { path: '/' })
                $.removeCookie('session', { path: '/' })
            } else if (data.status == 100) {
                $('.container-fluid').remove();
                $('body').append(data.html);
                _initMain();
            }

        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });

}

function _logout() {
    var data = new FormData();
    data.append('logout', $.cookie('key'));
    $.ajax({
            data: data
        })
        .done(function(data) {
            $('body').text('').append(data.html);
            _initLoginForm();
            $.removeCookie('key', { path: '/' })
            $.removeCookie('session', { path: '/' })
        })
        .fail(function(data) {
            console.log(data);
        })
        .always(function(data) {
            console.log("complete");
        });

}

function _login(form) {
    if ($(form).valid()) {
        $(form).find('.login-form-main-message').removeClass('show error success');
        var data = new FormData(form);
        $.ajax({
                data: data
            }).done(function(data) {})
            .fail(function() {
                $(form).find('.login-form-main-message').addClass('show error').html(msg['msg-server-error']);
            })
            .always(function(data) {
                $(form).find('[type=submit]').prop('disabled', false).removeClass('error success clicked').html(msg['btn-default']);
                if (data.status == 1) {
                    $('#login').remove();
                    $('body').append(data.html);
                    _initMain();
                    if (data.key) {
                        $.cookie('key', data.key, { expires: 365, path: '/' })
                    } else {
                        $.cookie('session', data.session, { path: '/' })
                        window.onbeforeunload = function(evt) {
                            $.removeCookie('session', { path: '/' })
                        }
                    }
                } else {
                    $(form).find('.login-form-main-message').addClass('show error').html(msg['msg-error']);
                }
            });
        form_loading($(form));
    }
    return false;
}
