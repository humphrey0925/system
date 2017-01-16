$.ajaxSetup({
    processData: false,
    contentType: false,
    dataType: 'json',
    method: 'POST'
});
(function($) {
    if ($.cookie('key') == undefined) {
        _initLoginForm();
    } else {
        $("ul.nav li.dropdown").hover(function() {
            $(this).find(".dropdown-menu").stop(!0, !0).delay(50).fadeIn(100), $(this).find("a").attr("aria-expanded", "true"), $(this).addClass("open")
        }, function() {
            $(this).find(".dropdown-menu").stop(!0, !0).delay(50).fadeOut(100), $(this).find("a").attr("aria-expanded", "false"), $(this).removeClass("open")
        });
    }
})(jQuery);

var msg = {
    'btn-default': '<i class="fa fa-chevron-right"></i>',
    'btn-loading': '<i class="fa fa-spinner fa-pulse"></i>',
    'btn-success': '<i class="fa fa-check"></i>',
    'btn-error': '<i class="fa fa-remove"></i>',
    'msg-success': 'All Good! Redirecting...',
    'msg-error': 'ID or Password Wrong',
};

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

function _search() {
    var data = new FormData();
    data.append('logout', $.cookie('key'));
    $.ajax({
            data: data
        })
        .done(function(data) {
            $('body').text('');
            $('body').append(data.html);
            _initLoginForm();
            console.log(data);
        })
        .fail(function(data) {
            console.log("error", data);
        })
        .always(function(data) {
            console.log("complete");
        });

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

function _login(form) {
    if ($(form).valid()) {
        var data = new FormData(form);
        $.ajax({
                data: data
            }).done(function(data) {
                if (data.status == 1) {
                    $('#login').remove();
                    $('body').append(data.html);
                    console.log("success", data);
                } else {
                    $(form).find('[type=submit]').prop('disabled', false).removeClass('error success clicked').html(msg['btn-default']);
                    $(form).find('.login-form-main-message').addClass('show error').html(msg['msg-error']);
                }
            })
            .fail(function(data) {
                console.log("error", data);
            })
            .always(function() {
                console.log("complete");
            });
        form_loading($(form));
    }
    return false;
}
