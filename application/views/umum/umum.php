<div id="layoutSidenav_content">
    <main>
        <div id="about" data-aos="zoom-out" data-aos-delay="600">
            <div id="login" data-loginberhasil="<?= $this->session->flashdata('login'); ?>"></div>
            <div class="container-fluid">
                <input type="hidden" id="nama_user" value="<?= $user['nama_user']; ?>">
                <input type="hidden" id="nik" value="<?= $user['nik']; ?>">
                <input type="hidden" id="alamat" value="<?= $user['alamat']; ?>">
                <?php if ($user['role'] == '400') : ?>
                <div class="row">
                    <!-- Kiri -->
                    <div class="col-sm-4 isi-kiri" align="center">
                        <h4>Tata Cara Melakukan Booking Online</h4>
                        <hr>
                        <p>Login > Pemohon mengisi Formulir Identitas Diri > Booking Antrian.</p>
                    </div>
                    <!-- Kanan -->
                    <div class="col-sm-5 isi-kanan">
                        <h4 align="center">Silahkan Isi Form Antrian</h4>
                        <hr>
                        <form id="formBooking">
                            <input type="hidden" id="user" value="<?= $user['id_user']; ?>">
                            <input type="hidden" id="nomer">
                            <div class="mb-2">
                                <label for="exampleFormControlInput1" class="form-label">Tanggal booking <small
                                        style="color:red">(tanggal antrian maks 1 hari sebelumnya)</small></label>
                                <input placeholder="masukkan tanggal antrian" type="text"
                                    class="form-control datepicker" name="tgl_awal" id="tgl_awal" autocomplete="off">
                            </div>
                            <div class="mb-2">
                                <label for="exampleFormControlInput1" class="form-label">Jenis Pelayanan</label>
                                <select id="ply" class="form-select" aria-label="Default select example">
                                    <option value="">pilih pelayanan</option>
                                    <?php foreach ($ply as $key) : ?>
                                    <option value="<?= $key['id_pelayanan']; ?>"> <?= $key['nama_pelayanan']; ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label for="exampleFormControlInput1" class="form-label">Nama Pengguna</label>
                                <input type="text" class="form-control" id="nm_pengguna">
                            </div>
                            <div class="mb-2">
                                <label for="exampleFormControlInput1" class="form-label">NIK</label>
                                <input type="text" class="form-control" id="nik_pengguna">
                            </div>
                            <div class="mb-2">
                                <label for="exampleFormControlTextarea1" class="form-label">Alamat</label>
                                <textarea class="form-control" id="alamat_pengguna" rows="3"></textarea>
                            </div>
                            <div class="agenda mt-2">
                                <h6 class="text-center">Nomer Antrian Anda</h6>
                                <div id="no_tiket">

                                </div>
                                <br>
                            </div>
                            <div class="modal-footer">
                                <div id="stat_booking"></div>
                                <div id="tombol">
                                    <button type="button" class="btn btn-danger" onclick="resetTiket()">reset</button>
                                    <button type="submit" class="btn btn-success">pesan
                                    </button>
                                </div>
                                <div id="loading" class="spinner-border text-dark" role="status">
                                </div>
                            </div>
                        </form>

                    </div> <!-- Div Kanan -->
                </div>
                <?php endif; ?>
                <?php if ($user['role'] == '100') : ?>
                <h4 class="my-3">Hai, <?= $user['nama_user']; ?></h4>
                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-primary text-white mb-4">
                            <div class="card-body d-flex justify-content-between">
                                <h6>Limit/hari</h6>
                                <div id="limited"></div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link"
                                    href="<?php echo base_url(); ?>umum">masuk</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-warning text-white mb-4">
                            <div class="card-body d-flex justify-content-between">
                                <h6>Antrian/Hari</h6>
                                <h1><?php echo $antri_hari; ?></h1>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link"
                                    href="<?php echo base_url(); ?>umum/berkas">masuk</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-success text-white mb-4">
                            <div class="card-body d-flex justify-content-between">
                                <h6>Belum Proses</h6>
                                <h1><?php echo $blm_proses; ?></h1>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link"
                                    href="<?php echo base_url(); ?>umum/berkas">masuk</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-danger text-white mb-4">
                            <div class="card-body d-flex justify-content-between">
                                <h6>Akun Pemohon</h6>
                                <h1><?php echo $tot_pemohon; ?></h1>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link"
                                    href="<?php echo base_url(); ?>umum/users">masuk</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xl-7">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-area me-1"></i>
                                DATA LIMIT
                            </div>
                            <div class="card-body">
                                <table id="t_batas" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Limit</th>
                                            <th scope="col">Tgl Perubahan</th>
                                            <th scope="col">PIC</th>
                                            <th scope="col">Keterangan</th>
                                            <th scope="col">aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-bar me-1"></i>
                                DATA LOKET
                            </div>
                            <div class="card-body">
                                <table id='loketuser' class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Loket</th>
                                            <th scope="col">PIC</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php foreach ($loketuser as $l) : ?>
                                        <tr>
                                            <th scope="row"><?= $no++; ?></th>
                                            <td><?= 'Loket ' . $l['nama_loket']; ?></td>
                                            <td><?= $l['nama_user']; ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </main>