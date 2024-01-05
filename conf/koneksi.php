<?php
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "pasien_poli";

$koneksi = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if(!$koneksi){
    die("Koneksi Gagal");
}else

// $pdo = new PDO('mysql:host=$db_host; db_name=pasien_poli;',$db_pass, $db_name); 

?>