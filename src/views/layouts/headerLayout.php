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

    <!-------------required------------>

    <link href="./assets/library/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="./assets/library/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="./assets/library/fontawesome/css/solid.min.css" rel="stylesheet">

    <script src="./assets/library/jquery/jquery-3.7.0.min.js"></script>

    <link href="./assets/library/bootstrap5/bootstrap.min.css" rel="stylesheet">

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
