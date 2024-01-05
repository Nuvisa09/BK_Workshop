<?php

session_start();
if(isset($_GET['keluar'])){
  session_destroy();
  header('location:../index.php');
}
?>
<?php
include '../template/topmenu.php';
include '../template/sidemenu_admin.php';
include '../conf/koneksi.php';
?>

<?php
    error_reporting(0);
    switch ($_GET['page']){
        default:
            include 'dashboard.php';
            break;
            
        // case 'list_obat';
        //     include 'list_obat.php';
        //     break;
    }
?>

<?php
include '../template/footer.php';
?>