<?php 

include '../../conf/koneksi_dua.php';

if (isset($_POST ['simpan'])){

    $nama_obat = $_POST['nama_obat'];
    $kemasan = $_POST['kemasan'];
    $harga = $_POST['harga'];
    // $level = $_POST['level'];

    $sql = $koneksi->query("INSERT INTO obat (nama_obat, kemasan, harga) VALUES ('$nama_obat', '$kemasan','$harga')");

?>

<script type="text/javascript">
    alert ("Data Berhasil Disimpan");
    window.location.href="home.php?page=list_obat";
</script>

<?php
}
?>