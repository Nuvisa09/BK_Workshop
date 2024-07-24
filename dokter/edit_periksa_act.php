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

if(isset($_POST['edit'])){
  
    $nama = $_POST['nama'];
    $hari = $_POST['hari'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_mulai = $_POST['jam_selesai'];
    $id = $_GET['id'];

    $query = mysqli_query($koneksi, "SELECT * FROM jadwal_periksa WHERE id='$id'");
    $data = mysqli_fetch_array($query);
    $cek = mysqli_num_rows($query);

    if ($cek > 0){
        $sql = $koneksi->query("UPDATE jadwal_periksa SET nama='$nama', hari='$hari',jam_mulai = '$jam_mulai', jam_selesai = '$jam_selesai' WHERE id=$id");
        echo "<script type='text/javascript'>
                alert ('Data Berhasil Di Edit');
                window.location.href='jadwalPasien.php'; 
                </script>";
    }else{
        echo "<script type='text/javascript'>
        alert ('Data Gagal Di Edit');
        window.location.href='jadwalPasien.php'; 
        </script>";
    }
}
?>