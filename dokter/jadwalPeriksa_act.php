<?php

include '../conf/koneksi.php';

if (isset($_POST['simpan'])) {
    $id_dokter = $_POST['id_dokter'];
    $hari = $_POST['hari'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];

    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $sql = "UPDATE jadwal_periksa SET id_dokter='$id_dokter', hari='$hari', jam_mulai='$jam_mulai', jam_selesai='$jam_selesai' WHERE id = '" . $_POST['id'] . "'";
        $edit = mysqli_query($koneksi, $sql);

        echo "
                <script> 
                    alert('Berhasil mengubah data.');
                    document.location='jadwalPeriksa.php';
                </script>
            ";
    } else {
        $sql = "INSERT INTO jadwal_periksa (id_dokter, hari, jam_mulai, jam_selesai) VALUES ('$id_dokter', '$hari', '$jam_mulai', '$jam_selesai')";
        $tambah = mysqli_query($koneksi, $sql);

        echo "
                <script> 
                    alert('Berhasil menambah data.');
                    document.location='jadwalPeriksa.php';
                </script>
            ";
    }
}

if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($koneksi, "DELETE FROM jadwal_periksa WHERE id = '" . $_GET['id'] . "'");

        if ($hapus) {
            echo "
                    <script> 
                        alert('Berhasil menghapus data.');
                        document.location='jadwalPeriksa.php';
                    </script>
                ";
        } else {
            echo "
                    <script> 
                        alert('Gagal menghapus data: " . mysqli_error($koneksi) . "');
                        document.location='jadwalPeriksa.php;
                    </script>
                ";
        }
    }
}

?>