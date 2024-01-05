<?php
    include '../template/topmenu.php';
    include '../template/sidemenu.php';
    include 'dashboard.php';
  if(!in_array("admin",$_SESSION['admin_akses'])){
      echo "kamu tidak punya akses";
    //   include 'dashboard.php';
      include '../template/footer.php';
      exit();
  }
  elseif(!in_array("dokter",$_SESSION['admin_akses'])){
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
// include '../template/topmenu.php';
// // include '../template/sidemenu.php';
// include '../conf/koneksi.php';
?>


<?php
include '../template/footer.php';
?>