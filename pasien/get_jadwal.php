

<?php
include_once("../conf/koneksi.php");
if(isset($_SESSION['login'])){
    $_SESSION['login'] = true;
  }else{
    echo "<meta http-equiv='refresh' content = '0; url=../conf/login.php'>";
    die();
  }
  
  $nama = $_SESSION['username'];
  $akses = $_SESSION['akses'];
  $id_pasien = $_SESSION['id'];
  $no_rm = $_SESSION['no_rm'];
  
  if($akses != 'pasien'){
    echo "<meta http-equiv='refresh' content = '0; url=../..'>";
    die();
  }

// Ambil ID poli dari parameter GET
$poliId = isset($_GET['poli_id']) ? $_GET['poli_id'] : null;

// Query untuk mendapatkan jadwal dokter berdasarkan ID poli
$query = "SELECT a.nama as nama_Dokter,
                 b.hari as hari,
                 b.id as id_jp,
                 b.jam_mulai as jam_mulai,
                 b.jam_selesai as jam_selesai
          FROM dokter as a
          INNER JOIN jadwal_periksa as b ON a.id = b.id_dokter
          WHERE a.id_poli = ?";

$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, 'i', $poliId);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

// Bangun opsi-opsi jadwal dokter
if (mysqli_stmt_num_rows($stmt) == 0) {
    echo '<option>Tidak ada jadwal</option>';
} else {
    mysqli_stmt_bind_result($stmt, $namaDokter, $hari, $idJp, $jamMulai, $jamSelesai);

    while (mysqli_stmt_fetch($stmt)) {
        echo '<option value="' . $idJp . '">Dokter ' . $namaDokter . ' | ' . $hari . ' | ' . $jamMulai . ' - ' . $jamSelesai . '</option>';
    }
}

mysqli_stmt_close($stmt);
mysqli_close($koneksi);
?>
