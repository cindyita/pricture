$(document).ready(function () {

    /*--remember login--*/
    if (localStorage.getItem('rememberedUsername')) {
        $('#username').val(localStorage.getItem('rememberedUsername'));
        $('#remember').prop('checked', true);
    }
    /*------------------*/

    $('#login').submit(function (event) {

        $('#error-login').hide();

        /*----Remember me---*/
        if ($('#remember').is(':checked')) {

            localStorage.setItem('rememberedUsername', $('#username').val());
        } else {
            localStorage.removeItem('rememberedUsername');
        }
        /*----------------------------*/

        event.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            url: './src/controllers/actionsController.php?action=login',
            type: 'POST',
            data: formData,
            success: function (res) {
                if (res == 1) {
                    window.location.href = 'home';
                } else if (res == 2) {
                    $('#error-login span').html("The captcha is invalid. Refresh the page and try again");
                    $('#error-login').fadeIn();
                } else if (res == 0) {
                    $('#error-login span').html("The username and/or password are incorrect");
                    $('#error-login').fadeIn();
                } else {
                    $('#error-login span').html("Login error");
                    $('#error-login').fadeIn();
                    console.log(res);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud. Código de estado: ' + xhr.status);
            }
        });
    });

});