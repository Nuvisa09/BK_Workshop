<?php


if(isset($_GET['keluar'])){
  session_destroy();
  header('location:../index.php');
}
?>
<?php
session_start();
include '../template/topmenu.php';
include '../template/sidemenu_dokter.php';
// include '../conf/koneksi.php';
if(isset($_SESSION['login'])){
    $_SESSION['login'] = true;
  }else{
    echo "<meta http-equiv='refresh' content = '0; url=../conf/login_dokter.php'>";
    die();
  }
  
  $nama = $_SESSION['username'];
  $akses = $_SESSION['akses'];
  
  if($akses != 'dokter'){
    echo "<meta http-equiv='refresh' content = '0; url=../..'>";
    die();
  }
?>

<?php
    error_reporting(0);
    switch ($_GET['page']){
        default:
            include 'dashboard.php';
            break;
            
        case 'list_periksa';
            include 'list_periksa.php';
            break;
        
        case 'riwayat_pasien';
            include 'riwayat_pasien.php';
            break;

        case 'jadwal_periksa';
            include 'jadwal_periksa.php';
            break;

        case 'detail_periksa';
            include 'detail_periksa.php';
            break;

        case 'edit_periksa';
            include 'edit_periksa.php';
            break;

    }
?>

<?php
include '../template/footer.php';
?>