<?php
include '../conf/koneksi_dua.php';

if(isset($_POST['edit'])){
  
    $id_periksa = $_POST['id_periksa'];
    $id_obat = $_POST['id_obat'];
    $id = $_GET['id'];

    $query = mysqli_query($koneksi, "SELECT * FROM detail_periksa WHERE id='$id'");
    $data = mysqli_fetch_array($query);
    $cek = mysqli_num_rows($query);

    if ($cek > 0){
        $sql = $koneksi->query("UPDATE detail_periksa SET id_periksa='$id_periksa', id_obat='$id_obat' WHERE id=$id");
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


