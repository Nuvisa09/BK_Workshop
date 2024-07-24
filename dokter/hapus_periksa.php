<?php

include '../conf/koneksi.php';

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

$kode = $_GET['id'];

$sql = mysqli_query($koneksi,"DELETE FROM jadwal_periksa WHERE id = '" . $_GET['id'] . "'");

if ($sql){
    
    ?>
    <script type='text/javascript'>
    alert ('Data Berhasil di Hapus');
    window.location.href='jadwalPeriksa.php'; 
    </script>

    <?php

}

?>