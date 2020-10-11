<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<!--<![endif]-->
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content= "<?php echo $keywords; ?>" />
<?php } ?>
<script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
 <!-- bootstrap -->
    <link href="catalog/view/theme/parallax/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <!-- ui -->
    <link href="catalog/view/theme/parallax/assets/plugins/jquery-ui-1.12.0/jquery-ui.min.css" rel="stylesheet" type="text/css">
    <!-- owl carousel -->
    <link href="catalog/view/theme/parallax/assets/plugins/owl-carousel/owl.carousel.css" rel="stylesheet" type="text/css">
    <link href="catalog/view/theme/parallax/stylesheet/stylesheet.css" rel="stylesheet">
    <!-- theme style -->
    <link href="catalog/view/theme/parallax/assets/css/themestyles.css" rel="stylesheet" type="text/css">
    <!-- nivo-slider  -->
    <link href="catalog/view/theme/parallax/assets/css/slider.css" rel="stylesheet" type="text/css">
    <link href="catalog/view/theme/parallax/assets/plugins/Nivo-Slider/nivo-slider.css" rel="stylesheet" type="text/css">
    <!-- animation -->
    <link href="catalog/view/theme/parallax/assets/css/animate.css" rel="stylesheet" type="text/css">
    <!-- media css -->
    <link href="catalog/view/theme/parallax/assets/css/responsive.css" rel="stylesheet" type="text/css">
    <!-- magnific popup -->
    <link href="catalog/view/theme/parallax/assets/plugins/magnific/magnific-popup.css" type="text/css" rel="stylesheet" media="screen" />
    <!-- font awesome -->
    <link href="catalog/view/theme/parallax/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!--[if lt IE 9]>
         <link href="24webgroup"/>
        <script src="catalog/view/theme/parallax/assets/html5shiv.js"></script>
        <script src="catalog/view/theme/parallax/assets/respond.js"></script>
        <![endif]-->
<?php foreach ($styles as $style) { ?>
<link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<script src="catalog/view/javascript/common.js" type="text/javascript"></script>
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<?php foreach ($scripts as $script) { ?>
<script src="<?php echo $script; ?>" type="text/javascript"></script>
<?php } ?>
</head>
<body>
    <!--  wrapper-->
    <div class="wrapper">
        <!-- page-->
        <div class="page">
