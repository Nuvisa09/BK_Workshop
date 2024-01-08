<?php

include '../conf/koneksi.php';

if (isset($_POST['simpan'])) {
    $nama_poli = $_POST['nama_poli'];
    $keterangan = $_POST['keterangan'];
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $sql = "UPDATE poli SET nama_poli='$nama_poli', keterangan='$keterangan' WHERE id = '" . $_POST['id'] . "'";
        $edit = mysqli_query($koneksi, $sql);

        echo "
                <script> 
                    alert('Berhasil mengubah data.');
                    document.location='poli.php';
                </script>
            ";
    } else {
        $sql = "INSERT INTO poli (nama_poli, keterangan) VALUES ('$nama_poli', '$keterangan')";
        $tambah = mysqli_query($koneksi, $sql);

        echo "
                <script> 
                    alert('Berhasil menambah data.');
                    document.location='poli.php';
                </script>
            ";
    }
}
if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        echo "error.log";
        $hapus = mysqli_query($koneksi, "DELETE FROM poli WHERE id = '" . $_GET['id'] . "'");
        

        if ($hapus) {
            echo "
                    <script> 
                        alert('Berhasil menghapus data.');
                        document.location='poli.php';
                    </script>
                ";
        } else {
            echo "
                    <script> 
                        alert('Gagal menghapus data: " . mysqli_error($koneksi) . "');
                        document.location='poli.php;
                    </script>
                ";
        }
    }
}
?>