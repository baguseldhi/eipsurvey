<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h4 class="my-3"><?php echo $title; ?></h4>
            <div class="card my-3 w-100">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div>
                            <?php echo $title_table; ?>
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary" id="btnAddquestion">tambah</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="t_layanan" class="table table-striped table-hover">
                        <thead>
                            <tr class="text-center text-uppercase">
                                <th scope="col" style="width: 10px;">Urutan</th>
                                <th scope="col" width="70%">Pertayaan</th>
                                <th scope="col" width="10%">Tipe</th>
                                <th scope="col" width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
    </main>

    <!-- Modal -->
    <div class="modal fade" id="modalQuestion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Form Pertanyaan</h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formQuestion">
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="survey_id" id="survey_id" value="<?php echo $survey_id; ?>">
                        <div class="form-group">
                            <label>Label Pertanyaan</label>
                            <textarea name="label" id="label" class="form-control" required></textarea>
                        </div>

                        <div class="form-group">
                            <label>Tipe</label>
                            <select name="type" id="type" class="form-control" required>
                                <option value="text">Text</option>
                                <option value="textarea">Textarea</option>
                                <option value="radio">Radio</option>
                                <option value="checkbox">Checkbox</option>
                                <option value="select">Select</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label><input type="checkbox" id="isRequired"> Wajib diisi</label>
                        </div>

                        <div class="form-group" id="optionsContainer" style="display:none;">
                            <label>Opsi Jawaban</label>
                            <div id="optionList"></div>
                            <button type="button" class="btn btn-sm btn-secondary mt-2" id="addOption">+ Tambah
                                Opsi</button>
                        </div>

                        <div class="form-group">
                            <label>Posisi</label>
                            <input type="number" name="position" id="position" class="form-control" value="0">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button class="btn btn-primary" id="btnSavequestion">Simpan</button>
                </div>
            </div>
        </div>
    </div>