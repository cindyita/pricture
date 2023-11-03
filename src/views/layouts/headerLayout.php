<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta property="description" content="Pripara idol land photo space gallery and friends" />
    <meta property="locale" content="es_ES" />
	<meta property="title" content="PRICTURE" />
    <meta property="site_name" content="PRICTURE" />
    <title>Pricture | Your pripara photo space</title>
    <link rel="shortcut icon" href="./assets/img/system/favicon.png" type="image/PNG">

    <script src="./assets/library/jquery/jquery-3.7.0.min.js"></script>

     <!-- Dark/light theme -->
    <script>
        var themeDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
    
        if (localStorage.getItem("theme") === 'dark') {
            themeDark = true;
        } else if (localStorage.getItem("theme") === 'light') {
            themeDark = false;
        }
        // DARK/LIGHT THEME
        function toggleMode() {
            if (themeDark) {
                localStorage.setItem('theme', 'dark');
                document.documentElement.setAttribute("data-theme", "dark");
                $("#imglogo").attr("src", "./assets/img/system/logo_dark.png");
                themeDark = false;
            } else {
                localStorage.setItem('theme', 'light');
                document.documentElement.setAttribute("data-theme", "light");
                $("#imglogo").attr("src", "./assets/img/system/logo.png");
                themeDark = true;
            }
        }
        toggleMode();
    </script>

    <!-------------required------------>

    <link href="./assets/library/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="./assets/library/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="./assets/library/fontawesome/css/solid.min.css" rel="stylesheet">

    <link href="./assets/library/bootstrap5/bootstrap.min.css" rel="stylesheet">

    <script src="./assets/library/momentjs/momentjs.js"></script>
    <script src="./assets/library/momentjs/momentjs-timezone.js"></script>

    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <!-----------ReCaptcha------------>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!-----------/ReCaptcha------------>

    <!-------------/required------------>

    <link href="./assets/css/app.css?version=<?php echo VERSION; ?>" rel="stylesheet">
    <link href="./assets/css/theme.css?version=<?php echo VERSION; ?>" rel="stylesheet">
    <link href="./assets/css/pages.css?version=<?php echo VERSION; ?>" rel="stylesheet">

    <?php 
        if($styles){
            foreach ($styles as $value) {
                echo '<link href="'.$value.'?version='.VERSION.'" rel="stylesheet">';
            }
        }
    ?>
    <!--------------------------------->
</head>
<body>

<div class="page-overlay">
    <div class="content">
        <div role="status">
            <div class="spinner-border"></div>
        </div>
    </div>
</div>

<div class="superior-banner">
    <span>This is a development version and many features are still missing. Please, if you find a bug or have a suggestion, <a href="contact">write to us.</a></span>
</div>