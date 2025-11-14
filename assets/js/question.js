$(document).ready(function(){ 
let table = $('#t_layanan').DataTable({
    "processing": true,
    "serverSide": true,
    "order": [],
    "ajax": {
        "url": base+"questions/get_data_question",
        "type": "POST"
    },
    "columnDefs": [{
        "targets": [0],
        "orderable": false,
    }, ],
});

// === Toggle tampil opsi berdasarkan tipe ===
$('#type').change(function() {
    const val = $(this).val();
    if (['radio', 'checkbox', 'select'].includes(val)) {
        $('#optionsContainer').show();
    } else {
        $('#optionsContainer').hide();
        $('#optionList').empty();
    }
});

// === Tambah input opsi baru ===
$('#addOption').click(function() {
    $('#optionList').append(`
      <div class='input-group mb-2 option-item'>
        <input type='text' class='form-control option-value' placeholder='Tulis opsi...'>
        <div class='input-group-append'>
          <button class='btn btn-danger btn-sm remove-option' type='button'>&times;</button>
        </div>
      </div>
    `);
});

// === Hapus opsi ===
$(document).on('click', '.remove-option', function() {
    $(this).closest('.option-item').remove();
});

// === Tambah pertanyaan baru ===
$('#btnAddquestion').click(function() {
    $('#formQuestion')[0].reset();
    $('#optionList').empty();
    $('#id').val('');
    $('#optionsContainer').hide();
    $('#modalQuestion').modal('show');
});

// === Simpan pertanyaan ===
$('#btnSavequestion').click(function() {
    // Kumpulkan meta otomatis
    const survey_id = $('#survey_id').val();
    const meta = {};
    const type = $('#type').val();
    if ($('#isRequired').prop('checked')) meta.required = true;
    if (['radio', 'checkbox', 'select'].includes(type)) {
        meta.options = [];
        $('.option-value').each(function() {
            const val = $(this).val().trim();
            if (val) meta.options.push(val);
        });
    }

    // Buat form data untuk kirim ke backend
    const data = {
        id: $('#id').val(),
        survey_id: survey_id,
        type: type,
        label: $('#label').val(),
        meta: JSON.stringify(meta),
        position: $('#position').val()
    };

    $('#overlay').show();
    $.post(base + 'questions/save', data, function(res) {
        $('#modalQuestion').modal('hide');
        $('#overlay').hide();
        if (res.error) {
            Swal.fire('Gagal', res.message, 'error');
            return;
        }else{
            Swal.fire('Berhasil', 'Pertanyaan berhasil disimpan', 'success');
            table.ajax.reload();
        }
    }, 'json');
});

// === Edit pertanyaan ===
$(document).on('click', '#btnEditquestion', function() {
    const id = $(this).data('id');
    $.getJSON(base + 'questions/get/' + id, function(q) {
        $('#id').val(q.id);
        $('#label').val(q.label);
        $('#type').val(q.type).trigger('change');
        $('#position').val(q.position);
        $('#optionList').empty();

        try {
            const meta = JSON.parse(q.meta);
            if (meta.required) $('#isRequired').prop('checked', true);
            if (meta.options) {
                meta.options.forEach(opt => {
                    $('#optionList').append(`
              <div class='input-group mb-2 option-item'>
                <input type='text' class='form-control option-value' value='${opt}'>
                <div class='input-group-append'>
                  <button class='btn btn-danger btn-sm remove-option' type='button'>&times;</button>
                </div>
              </div>
            `);
                });
                $('#optionsContainer').show();
            }
        } catch (e) {}

        $('#modalQuestion').modal('show');
    });
});

// === Hapus pertanyaan ===
$(document).on('click', '#btnDelquestion', function() {
    Swal.fire({
                title: "apakah anda yakin?",
                text: "data yang dihapus tidak dapat dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, hapus!"
                }).then((result) => {
                if (result.isConfirmed) {
                    $.getJSON(base + 'questions/delete/' + $(this).data('id'), () => table.ajax.reload());
                }
                });
});
});
