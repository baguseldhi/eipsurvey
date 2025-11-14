<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title><?= $title; ?></title>
    <link rel="icon" href="<?= base_url(); ?>assets/img/kemenperin.png">
    <link href="<?= base_url(); ?>assets/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4"><?php echo $title; ?></h3>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-center py-3">
                                        <img src="<?= base_url(); ?>assets/img/kemenperin.png" alt="bpn" height="30%"
                                            width="30%">
                                    </div>
                                    <?php if ($this->session->flashdata('gagalLogin')): ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>peringatan!</strong> <?= $this->session->flashdata('gagalLogin'); ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                    <?php endif; ?>
                                    <form action="<?= base_url(); ?>login/aksiLogin" method="post">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputUsername" type="text"
                                                placeholder="Masukan Username" name="username" />
                                            <label for="inputEmail">Username</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputPassword" type="password"
                                                placeholder="Password" name="password" />
                                            <label for="inputPassword">Password</label>
                                        </div>
                                        <div class="d-flex align-items-center mt-4 mb-0">
                                            <button type="submit" class="btn btn-primary w-100"> Login</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="<?= base_url(); ?>assets/js/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?= base_url(); ?>assets/js/scripts.js"></script>
    <script src="<?= base_url(); ?>assets/js/notif.js"></script>
</body>

</html>