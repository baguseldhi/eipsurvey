<nav style="background-color: #000033;">
    <ul class="nav justify-content-center">
        <li class="nav-item">
            <a class="nav-link " href="<?= base_url(); ?>umum"><i class="fa-regular fa-home"></i> Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url(); ?>user/myprofil"><i class="fa-solid fa-people-arrows"></i> My
                akun</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="<?= base_url(); ?>login/logout"><i class="fa-regular fa-sign-out"></i> Keluar</a>
        </li>
        <li class="nav-item mx-5">
            <a class="nav-link "><i class="fa-regular fa-user"></i> Hai, <?= $user['nama_user'] ?></a>
        </li>
    </ul>
</nav>