$(function(){
    const user=$('#notif').data('userberhasil');
if(user){
  Swal.fire(
  'Selamat',
   user,
  'success'
)
}
    const login=$('#login').data('loginberhasil');
if(login){
  Swal.fire(
  login,
   'silahkan ambil nomer antrian.',
  'success'
)
}
});