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

if (isset($_POST ['simpan'])){

    $nama_obat = $_POST['nama_obat'];
    $kemasan = $_POST['kemasan'];
    $harga = $_POST['harga'];
    // $level = $_POST['level'];

    $sql = $koneksi->query("INSERT INTO obat (nama_obat, kemasan, harga) VALUES ('$nama_obat', '$kemasan','$harga')");

?>

<script type="text/javascript">
    alert ("Data Berhasil Disimpan");
    window.location.href="list_obat.php";
</script>

<?php
}
?>