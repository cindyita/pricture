var validemail = 0;
var validusername = 0;
$(document).ready(function () {


    $('#signup').submit(function (event) {

        event.preventDefault();

        if (!confirmpass()) {
            $("#error-login span").html("Please correct any errors before submitting your registration");
            $("#error-login").fadeIn();
            console.log("Error confirm pass");
            return;
        }

        if (!checkpass()) {
            $("#error-login span").html("Please correct any errors before submitting your registration");
            $("#error-login").fadeIn();
            console.log("Error pass");
            return;
        }

        if (!validemail) {
            $("#error-login span").html("Please correct any errors before submitting your registration");
            $("#error-login").fadeIn();
            console.log("Error email");
            return;
        }

        if (!validusername) {
            $("#error-login span").html("Please correct any errors before submitting your registration");
            $("#error-login").fadeIn();
            console.log("Error username");
            return;
        }

        $('#error-login').fadeOut();

        var formData = $(this).serialize();

        $.ajax({
            url: './src/controllers/actionsController.php?action=signup',
            type: 'POST',
            data: formData,
            success: function (res) {
                if (res == 1) {
                    $('#success-login').fadeIn();
                    setTimeout(function() {
                        window.location.href = 'login';
                    }, 1000);
                } else if (res == 2) {
                    $('#error-login span').html("The captcha is invalid. Refresh the page and try again");
                    $('#error-login').fadeIn();
                } else {
                    $('#error-login span').html("There was an error registering");
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

function checkpass() {
    var pass = $("#pass").val();
    var username = $('#username').val();
    var email = $('#email').val();

    if (pass == "") {
        $("#error-login span").html("Enter a password");
        $("#error-login").fadeIn();
        $("#pass").css('color', 'red');
        $("#pass").css('border', '1px solid red');
        return false;
    }
    
    if (pass.length < 6 || !/[a-zA-Z]/.test(pass) || !/\d/.test(pass)) {
        $("#error-login span").html("The password must be at least 6 characters and contain letters and numbers");
        $("#error-login").fadeIn();
        $("#pass").css('color', 'red');
        $("#pass").css('border', '1px solid red');
        return false;
    }
    
    if (pass === username || pass === email) {
        $("#error-login span").html("The password cannot be the same as the email or username");
        $("#error-login").fadeIn();
        $("#pass").css('color', 'red');
        $("#pass").css('border', '1px solid red');
        return false;
    }
    $("#pass").css('color', 'var(--pink)');
    $("#pass").css('border', '1px solid var(--pink)');
    $("#error-login").fadeOut();
    return true;
}

function confirmpass() {
    if ($("#cpass").val() == "") {
        return false;
    }
    if ($("#pass").val() === $("#cpass").val()) {
        $("#cpass").css('color', 'var(--pink)');
        $("#cpass").css('border', '1px solid var(--pink)');
        $("#error-login").fadeOut();
        return true;
    }
    $("#cpass").css('color', 'red');
    $("#cpass").css('border', '1px solid red');
    $("#error-login span").html("Passwords must be the same");
    $("#error-login").fadeIn();
    return false;
}

function checkExist(inputv,element) {
    var input = $(inputv);
    var value = input.val();

    if (element == "email") {
        validemail = 0;
    }
    if (element == "username") {
        validusername = 0;
    }

    if (value) {
        $.ajax({
            url: './src/controllers/actionsController.php?action=check'+element,
            type: 'POST',
            data: {input:value},
            success: function (res) {
                if (res == 1) {
                    $(input).css('color', 'red');
                    $(input).css('border', '1px solid red');
                    $("#error-login span").html("That "+element+" already exists. Please choose another");
                    $("#error-login").fadeIn();
                    return false;
                } else if (res == 0) {
                    $(input).css('color', 'var(--pink)');
                    $(input).css('border', '1px solid var(--pink)');
                    $("#error-login").fadeOut();
                    if (element == "email") {
                        validemail = 1;
                    }
                    if (element == "username") {
                        validusername = 1;
                    }
                    return true;
                } else if (res == 2) {
                    $(input).css('color', 'red');
                    $(input).css('border', '1px solid red');
                    $("#error-login span").html("That "+element+" is invalid.");
                    $("#error-login").fadeIn();
                    return false;
                }else {
                    $(input).css('color', 'red');
                    $(input).css('border', '1px solid red');
                    $("#error-login span").html("Something went wrong");
                    $("#error-login").fadeIn();
                    console.log(res);
                    return false;
                }
                
            },
            error: function(xhr, status, error) {
                console.error('Request error. Status code: ' + xhr.status);
            }
        });
    }
}

