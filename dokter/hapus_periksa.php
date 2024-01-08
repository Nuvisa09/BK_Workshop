<?php

include '../conf/koneksi.php';

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