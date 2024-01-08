<?php
include '../conf/koneksi.php';

if (isset($_POST['simpanData'])) {
    $id_daftar_poli = $_POST['id']; // Get the id from the form
    $id_obat_array = $_POST['id_obat']; // Get the array of selected id_obat values from the form
    $base_biaya_periksa = 150000;
    $tgl_periksa = date('Y-m-d H:i:s'); // Get the current datetime
    $catatan = $_POST['catatan']; // Get the catatan value from the form

    // Calculate the total biaya_periksa
    $biaya_periksa = $base_biaya_periksa;

    $sql = "INSERT INTO periksa (id_daftar_poli, tgl_periksa, catatan, biaya_periksa) VALUES ('$id_daftar_poli', '$tgl_periksa', '$catatan', '$biaya_periksa')";
    $tambah = mysqli_query($koneksi, $sql);

    // Get the id_periksa of the record just inserted
    $id_periksa = mysqli_insert_id($koneksi);

    // Insert into detail_periksa table for each selected id_obat
    foreach ($id_obat_array as $id_obat) {
        $sql = "INSERT INTO detail_periksa (id_periksa, id_obat) VALUES ('$id_periksa', '$id_obat')";
        $tambah = mysqli_query($koneksi, $sql);
        
        // Query the obat table to get the harga for the selected id_obat
        $result = mysqli_query($koneksi, "SELECT harga FROM obat WHERE id = '$id_obat'");
        $data = mysqli_fetch_assoc($result);
        $harga_obat = $data['harga'];

        // Update the total biaya_periksa with the harga of each selected id_obat
        $biaya_periksa += $harga_obat;
    }

    // Update the total biaya_periksa in the periksa table
    $update_sql = "UPDATE periksa SET biaya_periksa = '$biaya_periksa' WHERE id = '$id_periksa'";
    $update_result = mysqli_query($koneksi, $update_sql);

    echo "
            <script> 
                alert('Berhasil menambah data.');
                window.location.href='dashboardDokter.php?page=periksa';
            </script>
        ";
    exit();
}

?>