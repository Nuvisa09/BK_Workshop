
<?php
session_start();

include '../template/topmenu.php';
include '../template/sidemenu_admin.php';
include '../conf/koneksi.php';
if(isset($_SESSION['login'])){
    $_SESSION['login'] = true;
  }else{
    echo "<meta http-equiv='refresh' content = '0; url=../conf/login.php'>";
    die();
  }
  
  $nama = $_SESSION['username'];
  $akses = $_SESSION['akses'];
  
  if($akses != 'admin'){
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
            
        case 'list_obat';
            include 'list_obat.php';
            break;
      
        case 'tambah_obat';
            include 'tambah_obat.php';
            break;
      
        case 'edit_obat';
            include 'edit_obat.php';
            break;
      
        case 'hapus_obat';
            include 'hapus_obat.php';
            break;
      }
    
?>
<?php


if(isset($_GET['keluar'])){
  session_destroy();
  header('location:../index.php');
}
?>
<?php
include '../template/footer.php';
?>