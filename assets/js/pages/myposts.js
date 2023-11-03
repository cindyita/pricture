$(document).ready(function () {
    
});

function deletePost(id) {

    $.ajax({
        url: './src/controllers/actionsController.php?action=deletePost',
        type: 'POST',
        data: {id:id},
        success: function (res) {
            if (res == 1 || res == 11) {
                message("success", "Post has been successfully deleted");
                updateMyPosts();
            } else {
                message("error", "There was an error");
                console.log(res);
            }
            
        },
        error: function(xhr, status, error) {
            console.error('Error en la solicitud. Código de estado: ' + xhr.status);
        }
    });
}

function updateMyPosts() {
    $.ajax({
        url: './src/controllers/actionsController.php?action=updateMyPosts',
        type: 'POST',
        data: {},
        success: function (res) {
            res = JSON.parse(res);
            $("#myposts").html(res);
        },
        error: function(xhr, status, error) {
            console.error('Error al actualizar. Código de estado: ' + xhr.status);
        }
    });
}