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
        /* --- General ---------------------------------------------------- */
        body {
            overflow-x: hidden;
        }

        p {
            text-align: justify;
        }

        /* --- RESPONSIVE FIX FOR MOBILE ---------------------------------- */
        @media (max-width: 768px) {

            /* Perkecil judul agar tidak pecah */
            #logo h1 a {
                font-size: 2rem;
                text-align: center;
                display: block;
            }

            #logo span {
                text-align: center;
                font-size: 0.9rem;
            }

            /* Nav jadi center dan tidak mepet */
            #nav ul {
                flex-direction: column;
                align-items: center;
                margin-top: 10px;
            }

            #nav ul li a {
                padding: 8px 16px;
                font-size: 1rem;
            }

            /* Atur container agar tidak melebar */
            #header .container {
                width: 90%;
                margin: auto;
            }
        }

        /* --- SCREEN EXTRA SMALL (hp 320-480px) --------------------------- */
        @media (max-width: 480px) {

            #logo h1 a {
                font-size: 1.6rem;
            }

            #logo span {
                font-size: 0.8rem;
            }

            /* Tombol survey */
            #nav ul li a {
                font-size: 0.9rem;
                padding: 10px 18px;
            }
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
                    <li class="active"><a id="btnsurvey">Mulai Survey</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>