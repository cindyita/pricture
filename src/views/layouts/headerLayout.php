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

    <style>
        .loading {
            display: none;
            width: 100%;
            height: 100%;
            z-index: 999;
            background-color: var(--font);
            position: absolute;
            top:0;
            left:0;
        }
        .loading .content {
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>

    <!-------------required------------>
    <link href="./assets/css/app.css?version=<?php echo VERSION; ?>" rel="stylesheet">

    <link href="./assets/required/fontawesome/css/fontawesome.min.css?version=<?php echo VERSION; ?>" rel="stylesheet">
    <link href="./assets/required/fontawesome/css/brands.min.css?version=<?php echo VERSION; ?>" rel="stylesheet">
    <link href="./assets/required/fontawesome/css/solid.min.css?version=<?php echo VERSION; ?>" rel="stylesheet">

    <script src="./assets/required/jquery/jquery-3.7.0.min.js?version=<?php echo VERSION; ?>"></script>

    <link href="./assets/css/theme.css?version=<?php echo VERSION; ?>" rel="stylesheet">

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

