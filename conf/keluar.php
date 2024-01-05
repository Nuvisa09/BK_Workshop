<?php
session_start();
// include '../conf/koneksi.php';
// if(isset($_GET['keluar'])){
//   session_destroy();
//   header('location:../conf/login.php');
// }

session_destroy();
  header('location:../index.php');