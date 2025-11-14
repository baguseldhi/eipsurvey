<!DOCTYPE HTML>
<!--
	Iridium by TEMPLATED
    templated.co @templatedco
    Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html>

<head>
    <title><?= $title; ?></title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <link rel="icon" href="<?= base_url(); ?>assets/img/kemenperin.png">
    <link href="https://fonts.googleapis.com/css?family=Arimo:400,700" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?= base_url('assets/landing/'); ?>css/skel-noscript.css">
    <link rel="stylesheet" href="<?= base_url('assets/landing/'); ?>css/style.css">
    <link rel="stylesheet" href="<?= base_url('assets/landing/'); ?>css/style-desktop.css">
    <style>
    p {
        text-align: justify;
    }
    </style>
    <!--[if lte IE 8]><script src="js/html5shiv.js"></script><![endif]-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="<?= base_url('assets/landing/'); ?>js/skel.min.js"></script>
    <script src="<?= base_url('assets/landing/'); ?>js/skel-panels.min.js"></script>
    <script src="<?= base_url('assets/landing/'); ?>js/init.js"></script><noscript>
    </noscript>
    <!--[if lte IE 8]><link rel="stylesheet" href="css/ie/v8.css" /><![endif]-->
    <!--[if lte IE 9]><link rel="stylesheet" href="css/ie/v9.css" /><![endif]-->
</head>

<body class="no-sidebar">

    <!-- Header -->
    <div id="header">
        <div class="container">

            <!-- Logo -->
            <div id="logo">
                <h1><a>Eco-Industrial Park</a></h1>
                <span>Survey Praktik Lingkungan</span>
            </div>

            <!-- Nav -->
            <nav id="nav">
                <ul>
                    <li class="active"><a href="<?= base_url('welcome/form/' . $slug); ?>">Mulai Survey</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>