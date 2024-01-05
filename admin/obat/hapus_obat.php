<?php

include '../../conf/koneksi_dua.php';

$kode = $_GET['id'];

$sql = $koneksi->query("DELETE FROM obat WHERE id='$kode'");

if ($sql){
    
    ?>
    <script type='text/javascript'>
    alert ('Data Berhasil di Hapus');
    window.location.href='home.php?page=list_obat'; 
    </script>

    <?php

}

?>