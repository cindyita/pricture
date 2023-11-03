$(document).ready(function () {
    $("#comment").submit(function (event) {
        event.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: './src/controllers/actionsController.php?action=newCommentPost',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {
                if (res == 1) {
                    $("#comment").val("");
                    $("#num_comments").html($("#num_comments").val() + 1);
                    updateComments();
                }else if (res == "5") {
                    message("warning", "you need to log in or register");
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

    $("#deleteCommentPost").submit(function (event) {
        event.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: './src/controllers/actionsController.php?action=deleteCommentPost',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {
                if (res == 1) {
                    $("#num_comments").html($("#num_comments").val() - 1);
                    updateComments();
                }else if (res == "5") {
                    message("warning", "you need to log in or register");
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

function updateComments() {
    $("#comments-post").empty();
    $("#comments-post").html('<div class="spinner-border"></div>');
    const idpost = $("#idpost").val();
    $.ajax({
        url: './src/controllers/actionsController.php?action=updateCommentPost',
        type: 'POST',
        data: {idpost: idpost},
        success: function (res) {
            if (res == 2) {
                message("error", "There was an error");
                console.log(res);
            } else {
                res = JSON.parse(res);
                $("#comments-post").html(res);
                changeToRelativeTime('relativedate');
            }
        },
        error: function (xhr, status, error) {
            console.error('Error en la solicitud. Código de estado: ' + xhr.status);
        }
    });
}

function deleteComment(id_usercomm, id_comm,id_post) {
    $("#delete-idusercomm").val(id_usercomm);
    $("#delete-idcomm").val(id_comm);
    $("#delete-idpost").val(id_post);
}

function changeFavorite(element, id) {
    
    var action = $(element).hasClass("active") ? "unlikePost" : "likePost";
    console.log(action);

    $.ajax({
        url: './src/controllers/actionsController.php?action=' + action,
        type: 'POST',
        data: { id: id },
        success: function (res) {
            if (res == "1") {
                $(element).toggleClass("active");
                if (action == "likePost") {
                    $("#num_hearts").html(+$("#num_hearts").html() + 1);
                } else {
                    $("#num_hearts").html(+$("#num_hearts").html() - 1);
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

