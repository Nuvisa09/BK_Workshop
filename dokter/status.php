<?php
include '../conf/koneksi.php';

$id = $_GET['id'];
$status = $_GET['status'];
$query = "UPDATE jadwal_periksa SET status = $status WHERE id = $id";
$result = mysqli_query($koneksi, $query);

if ($result) {
    header('location:jadwalPeriksa.php');
} else {
    header('location:jadwalPeriksa.php');
}
?>
 