<?php

include '../conf/koneksi.php';

$kode = $_GET['id'];

$sql = $koneksi->query("DELETE FROM obat WHERE id='$kode'");

if ($sql){
    
    ?>
    <script type='text/javascript'>
    alert ('Data Berhasil di Hapus');
    window.location.href='poli.php'; 
    </script>

    <?php

}

?>