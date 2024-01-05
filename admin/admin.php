<?php
// session_start();
    include '../template/topmenu.php';
    include '../template/sidemenu.php';
    include 'dashboard.php';
    include '../conf/koneksi.php';
    if(!in_array("admin",$_SESSION['admin_akses'])){
        echo "kamu tidak punya akses";
        include 'dashboard.php';
        include '../template/footer.php';
        exit();
    }elseif(!in_array("dokter",$_SESSION['admin_akses'])){
        echo "kamu tidak punya akses";
        // include '../dokter/dashboard.php';
        include '../template/footer.php';
        exit();
    }elseif(!in_array("pasien",$_SESSION['admin_akses'])){
        echo "kamu tidak punya akses";
        // include '../dokter/dashboard.php';
        include '../template/footer.php';
        exit();
    }
?> 

<?php
session_start();
// include '../conf/koneksi.php';
if(isset($_GET['keluar'])){
  session_destroy();
  header('location:../conf/login.php');
}
?>


<?php
include '../template/footer.php';
?>