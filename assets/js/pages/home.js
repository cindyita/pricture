$(document).ready(function () {
    
});

function changeFavorite(element, id) {
    var action = $(element).hasClass("active") ? "unlikePost" : "likePost";

    $.ajax({
        url: './src/controllers/actionsController.php?action=' + action,
        type: 'POST',
        data: { id: id },
        success: function (res) {
            if (res == "1") {
                $(element).toggleClass("active");
                var numHearts = $(element).siblings(".numHearts");
                var currentHearts = parseInt(numHearts.text());
                if (action == "likePost") {
                    numHearts.text(currentHearts + 1);
                } else {
                    numHearts.text(currentHearts - 1);
                }
            } else if (res == "5") {
                message("warning", "You need to log in or register");
            } else {
                message("error", "There was an error");
                console.log(res);
            }
        },
        error: function (xhr, status, error) {
            console.error('Error en la solicitud. Código de estado: ' + xhr.status);
        }
    });
}

