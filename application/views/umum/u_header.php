<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title><?php echo $title; ?></title>
    <link rel="icon" href="<?= base_url(); ?>assets/img/kemenperin.png">
    <style>
    /* ===== Overlay Bayangan ===== */
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        /* bayangan hitam transparan */
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    /* ===== Loader ===== */
    .loader {
        width: fit-content;
        font-weight: bold;
        font-family: monospace;
        font-size: 30px;
        background: linear-gradient(90deg, #000 50%, #0000 0) right/200% 100%;
        animation: l21 2s infinite linear;
    }

    .loader::before {
        content: "Loading...";
        color: #0000;
        padding: 0 5px;
        background: inherit;
        background-image: linear-gradient(90deg, #fff 50%, #000 0);
        -webkit-background-clip: text;
        background-clip: text;
    }

    @keyframes l21 {
        100% {
            background-position: left;
        }
    }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="<?= base_url(); ?>assets/css/styles.css" rel="stylesheet" />
    <link href="<?= base_url(); ?>assets/css/bootstrap-datepicker3.min.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <div class="overlay" id="overlay" style="display: none;">
        <div class="loader"></div>
    </div>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-secondary">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.html"><img src="<?= base_url(); ?>assets/img/kemenperin.png" alt="bpn"
                height="25%" width="25%">EIP Survey</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link fw-bold" id="navbarDropdown" href="#" aria-expanded="false"><i
                        class="fas fa-user fa-fw"></i>
                    <?= $user['name']; ?></a>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">menu</div>
                        <a class="nav-link" href="<?php echo base_url(); ?>surveys">
                            <div class="sb-nav-link-icon"><i class="fas fa-phone-alt"></i></div>
                            Survey Questions
                        </a>
                        <a class="nav-link" href="<?= base_url(); ?>login/logout">
                            <div class="sb-nav-link-icon"><i class="fas fa-sign-out"></i></div>
                            Keluar
                        </a>
                    </div>
                </div>
            </nav>

        </div>