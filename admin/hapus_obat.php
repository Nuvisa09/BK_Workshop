<?php
session_start();
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

$kode = $_GET['id'];

$sql = $koneksi->query("DELETE FROM obat WHERE id='$kode'");

if ($sql){
    
    ?>
    <script type='text/javascript'>
    alert ('Data Berhasil di Hapus');
    window.location.href='list_obat.php'; 
    </script>

    <?php

}

?>