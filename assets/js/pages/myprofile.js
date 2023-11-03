$(document).ready(function () {

    $('#saveProfile').submit(function (event) {
        
        event.preventDefault();
        if (!checkExist('username','username', $("#actual_username").val())) {
            message("error", "Error in username");
            return;
        }
        var formData = new FormData(this);
        $.ajax({
            url: './src/controllers/actionsController.php?action=saveprofile',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {
                if (res == 1 || res == 11) {
                    message("success", "Your profile has been saved");
                    updateData();
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

    if ($("#id_custom_brand").val() != "") {
        changeBrandPreview();
    }


});

function changeMode(mode) {
    if (mode == "edit") {
        $("#view-mode").hide();
        $("#edit-mode").show();
    } else if (mode == "view") {
        $("#edit-mode").hide();
        $("#view-mode").show();
    }
}

function checkExist(inputv,element, actual) {
    var input = $(inputv);
    var value = input.val();

    if (value && value != actual) {
        $.ajax({
            url: './src/controllers/actionsController.php?action=check'+element,
            type: 'POST',
            data: {input:value},
            success: function (res) {
                if (res == 1) {
                    $(input).css('color', 'red');
                    $(input).css('border', '1px solid red');
                    message("error", "That " + element + " already exists. Please choose another");
                    return false;
                } else if (res == 0) {
                    $(input).css('color', 'var(--pink)');
                    $(input).css('border', '1px solid var(--pink)');
                    return true;
                } else if (res == 2) {
                    $(input).css('color', 'red');
                    $(input).css('border', '1px solid red');
                    message("error", "That " + element + " is invalid.");
                    return false;
                }else {
                    $(input).css('color', 'red');
                    $(input).css('border', '1px solid red');
                    message("error", "Something went wrong");
                    console.log(res);
                    return false;
                }
                
            },
            error: function(xhr, status, error) {
                console.error('Request error. Status code: ' + xhr.status);
            }
        });
    } else {
        return true;
    }
}

function changeBrandPreview() {
    id = $("#id_favorite_brand").val() ? $("#id_favorite_brand").val() : 2;
    customBrand = $("#id_custom_brand").val();
    if (id == 2) {
        if (!customBrand) {
            $("#favorite_brand_preview").attr("src", "./assets/img/system/brands/1.webp");
            $("#custom_type_idol").val(7);
        }
        $("#view_custom_brand_name").show();
        $("#custom_type_idol").show();
        $("#idol_type_preview").hide();
        $("#custom_brand").show();
        $("#name_custom_brand").show();
    } else {
        $("#favorite_brand_preview").attr("src", "./assets/img/system/brands/" + id + ".webp");
        var selectedOption = $("#id_favorite_brand").find(":selected");
        var dataType = selectedOption.data("type");
        var dataTypeColor = selectedOption.data("typecolor");
        $("#idol_type_preview").html('<p style="color:' + dataTypeColor + '">' + dataType + '</p>');
        $("#custom_type_idol").hide();
        $("#custom_brand").hide();
        $("#idol_type_preview").show();
        $("#name_custom_brand").hide();
        $("#view_custom_brand_name").hide();
    }
}

function updateData() {
    $("#loading").fadeIn();
    $.ajax({
        url: './src/controllers/actionsController.php?action=updateProfile',
        type: 'POST',
        success: function (res) {
            var data = JSON.parse(res);
            user = data['user'];

            $("#view-username").html(user.username);
            $("#view-friendcode").html(user.friendcode);
            $("#view-birthday").html(user.birthday);
            if (data['custom_brand']) {
                $("#view-idol_type").html(data['custom_brand'].type_name).css("color", data['custom_brand'].type_color);
                var currentdate = new Date(); 
                $("#view-favorite-brand").attr("src", "./assets/img/user/custom-brands/" + data['custom_brand'].img + '?upd='+currentdate);
                $("#view_custom_brand_name").html("[" + data['custom_brand'].name + "]");
                $("#id_custom_brand").val(data['custom_brand'].id);
            } else {
                $("#view-idol_type").html(user.idol_type).css("color", user.color_idol_type);
                $("#view-favorite-brand").attr("src", "./assets/img/system/brands/" + user.id_favorite_brand + ".webp");
            }

            $("#view-biography").html(user.biography);

            if (user.img_profile) {
                $(".img-profile img").attr("src", "./assets/img/user/img-profile/" + user.img_profile+'?upd=<?php echo time(); ?>');
                $("#img-preview").attr("src", "./assets/img/user/img-profile/" + user.img_profile+'?upd=<?php echo time(); ?>');
            } else {
                $(".img-profile img").attr("src", "./assets/img/system/defaultprofile.jpg");
                $("#img-preview").attr("src", "./assets/img/system/defaultprofile.jpg");
            }

            $("#username").val(user.username);
            $("#actual_username").val(user.username);
            $("#friendcode").val(user.friendcode);
            $("#birthday").val(user.birthday);
            $("#id_favorite_brand").val(user.id_favorite_brand);
            changeBrandPreview();

            $("#loading").fadeOut();
        },
        error: function(xhr, status, error) {
            console.error('Error en la solicitud. Código de estado: ' + xhr.status);
        }
    });
}
