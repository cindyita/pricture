$(window).on("load", function () {
    $(".page-overlay").fadeOut(100);
    changeLogoTheme();
    changeToRelativeTime('relativedate');
    dateFormat('dateFormat');

    if (localStorage.getItem('notice-betaweb') !== 'true') {
        $('#superiorBanner').show();
    }
    $('#closeBanner').click(function () {
        $('#superiorBanner').hide();
        localStorage.setItem('notice-betaweb', 'true');
    });

});

function changeToRelativeTime(nameclass) {
    $("."+nameclass).each(function (index, element) {
        var dateValue = $(element).text();
        var formattedDate = processDatetime(dateValue,0,1);
        $(element).text(formattedDate);
    });
}

function dateFormat(nameclass) {
    $("."+nameclass).each(function (index, element) {
        var dateValue = $(element).text();
        var formattedDate = processDatetime(dateValue,'DD-MM-YYYY');
        $(element).text(formattedDate);
    });
}

function processDatetime(datetime, format = null, relative = false) {
    var userTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
    var newDatetime = moment.tz(datetime+'Z', userTimezone);

    if (format) {
        newDatetime = newDatetime.format(format);
    }

    if (relative) {
        newDatetime = newDatetime.fromNow();
    }

    return newDatetime;
}


function changeLogoTheme() {
    if (!themeDark) {
        $("#imglogo").attr("src", "./assets/img/system/logo_dark.png");
    } else {
        $("#imglogo").attr("src", "./assets/img/system/logo.png");
    }
}

function message(type, text) {
    var toast = (type === 'success') ? 'alert-success' : (type === 'error' ? 'alert-danger' : 'alert-warning');
    if (type == "warning") {
        var html = '<div class="alert-superior alert '+toast+'" id="error-login">'+text+'</div>';
    } else {
        var html = '<div class="alert-superior alert '+toast+'" id="error-login"><strong>'+type+':</strong> '+text+'</div>';
    }

    var $message = $(html);
    $message.hide().appendTo('body').fadeIn();
    
    setTimeout(function() {
        $message.fadeOut(function() {
            $(this).remove();
        });
    }, 4000);
    
}

function handleFileImage(files, previewId) {
    const allowedExtensions = ["jpg", "jpeg", "png", "gif","webp"];
    var preview = $("#" + previewId);
    var file = files[0];

    // Validations
    var maxSizeInBytes = 500 * 1024 * 1024; // 500 MB
    if (file.size > maxSizeInBytes) {
        message("error", "The file '" + file.name + "' exceeds the maximum size allowed");
        return;
    }
    var fileExtension = file.name.split(".").pop().toLowerCase();
    if (allowedExtensions.indexOf(fileExtension) === -1) {
        message("error", "The file '" + file.name + "' does not have an allowed extension");
        return;
    }

    var reader = new FileReader();
    reader.onload = function (e) {
        preview.attr("src", e.target.result);
    };
    reader.readAsDataURL(file);
}

function updatePosts() {
    var postsContent = $("#home-posts");
    if (postsContent.length > 0) {
        postsContent.empty();
        postsContent.html('<div class="spinner-border"></div>');
        $.ajax({
            url: './src/controllers/actionsController.php?action=updatePosts',
            type: 'POST',
            data: {},
            success: function (res) {
                if (res == "2" || res == "5") {
                    message("error", "There was an error");
                    console.log(res);
                } else {
                    postsContent.html(JSON.parse(res));
                    changeToRelativeTime('relativedate');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error en la solicitud. Código de estado: ' + xhr.status);
            }
        });
    } else {
        window.location = "home";
    }
}
