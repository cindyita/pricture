$(document).ready(function () {

    $("#contact").submit(function (event) {
        console.log("New Message");
        event.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: './src/controllers/actionsController.php?action=sendContactForm',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {
                if (res == 1) {
                    $("#contact")[0].reset();
                    message("success", "Your message has been sent");
                }else if (res == "5") {
                    message("warning", "you need to log in or register");
                }else if (res == "6") {
                    message("danger", "Invalid captcha error");
                } else {
                    message("error", "There was an error");
                    console.log(res);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud. Código de estado: ' + xhr.status);
            }
        });
    });

});