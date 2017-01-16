$.ajaxSetup({
    processData: false,
    contentType: false,
    method: 'POST'
});
(function($) {
    $("#login-form").validate({
        rules: {
            lg_username: "required",
            lg_password: "required",
        },
        errorClass: "form-invalid"
    });
    $("#login-form").submit(function(event) {
        return _login(this);
    });
    if ($.cookie('key') == undefined) {
        $("#login").css('opacity', '1');
    }
})(jQuery);

var msg = {
    'btn-default': '<i class="fa fa-chevron-right"></i>',
    'btn-loading': '<i class="fa fa-spinner fa-pulse"></i>',
    'btn-success': '<i class="fa fa-check"></i>',
    'btn-error': '<i class="fa fa-remove"></i>',
    'msg-success': 'All Good! Redirecting...',
    'msg-error': 'Wrong login credentials!',
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

function _login(form) {
    if ($(form).valid()) {
        var data = new FormData(form);
        
        
        
        $.ajax({
            data: data
        }).done(function(data) {
            $('#login').remove();
            console.log("success",data);
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });

        form_loading($(form));
        // setTimeout(function() {
        //     form_success($form);
        //     setTimeout(function() {
        //         remove_loading($form);
        //     }, 2000);
        // }, 2000);
    }
    return false;
}
