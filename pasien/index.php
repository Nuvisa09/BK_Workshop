<?php
session_start();
if(isset($_GET['keluar'])){
  session_destroy();
  header('location:../index.php');
}
?>
<?php

include '../template/topmenu.php';
include '../template/sidemenu_pasien.php';
if(isset($_SESSION['login'])){
  $_SESSION['login'] = true;
}else{
  echo "<meta http-equiv='refresh' content = '0; url=../conf/login.php'>";
  die();
}

$nama = $_SESSION['username'];
$akses = $_SESSION['akses'];

if($akses != 'pasien'){
  echo "<meta http-equiv='refresh' content = '0; url=../..'>";
  die();
}



?>

<?php
    // error_reporting(0);
    $page = isset($_GET['page']) ? $_GET['page'] : 'default';
    switch ($page){
        default:
            include 'dashboard.php';
            break;
    }
?>

<?php
include '../template/footer.php';
?>