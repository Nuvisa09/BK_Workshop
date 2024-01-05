<?php
include '../../conf/koneksi_dua.php';

if(isset($_POST['edit'])){
  
    $nama_obat = $_POST['nama_obat'];
    $kemasan = $_POST['kemasan'];
    $harga = $_POST['harga'];
    $id = $_GET['id'];

    $query = mysqli_query($koneksi, "SELECT * FROM obat WHERE id='$id'");
    $data = mysqli_fetch_array($query);
    $cek = mysqli_num_rows($query);

    if ($cek > 0){
        $sql = $koneksi->query("UPDATE obat SET nama_obat='$nama_obat', kemasan='$kemasan',harga = '$harga' WHERE id=$id");
        echo "<script type='text/javascript'>
                alert ('Data Berhasil Di Edit');
                window.location.href='home.php?page=list_obat'; 
                </script>";
    }else{
        echo "<script type='text/javascript'>
        alert ('Data Gagal Di Edit');
        window.location.href='home.php?page=list_obat'; 
        </script>";
    }
}
?>


