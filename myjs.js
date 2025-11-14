$(function(){
    $('#form_akun').on('submit', (e) => {
        e.preventDefault();
        let username = $('#username_a').val();
        let pass = $('#pass_a').val();
        let konf = $('#konf_a').val();
        let id = $('#id_a').val();
        let url = $('#url_a').val();
        if(username=="" || pass == "" || konf==""){
            notifikasi(false,'lengkapi akun anda');
            return;
        }

        if(pass==konf){
            $.ajax({
                type: "post",
                url: url,
                data: {id:id,username:username,pass:pass},
                dataType: "json",
                success: function (res) {
                    notifikasi(res.stat,res.msg);
                    $('username_a').val(res.username);
                    $('pass_a').val(res.pass);
                }
            });
        }else{
            notifikasi(false,'Password harus sama dengan konfirm password');
            return;
        }
        
    });
});