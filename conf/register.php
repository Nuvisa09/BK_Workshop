<?php
session_start();
include_once("../conf/koneksi.php");

if($_SERVER["REQUEST_METHOD"]=="POST"){

  // mendapatkan nilai dari form -- atribut name di input
  $nama = $_POST['nama'];
  $alamat = $_POST['alamat'];
  $no_ktp = $_POST['no_ktp'];
  $no_hp = $_POST['no_hp'];
  $pass = $_POST['password'];
  $pass = md5($pass);

  //..........situasi 1

  // cek apakah pasien udah terdaftar berdasarkan nomor KTP
$query_check_pasien ="SELECT id, nama, no_rm FROM pasien WHERE no_ktp='$no_ktp'";
$result_check_pasien = mysqli_query($koneksi, $query_check_pasien);

if(mysqli_num_rows($result_check_pasien)>0){
  $row = mysqli_fetch_assoc($result_check_pasien);

  if($row['nama'] !=$nama){
    // ketika nama tidak sesuai dengan no_ktp
    echo "<script> alert ('Nama pasien tidak sesuai dengan nomor KTP yang terdaftar.');</script>";
    echo "<meta http-equiv='refresh' content='0; url=register.php'>";
    die();
  }
  $_SESSION['signup'] = true;
  $_SESSION['id'] = $row['id'];
  $_SESSION['username'] = $nama;
  $_SESSION['no_rm'] = $row['no_rm'];
  // $_SESSION['akses'] = true;

  echo "<meta http-equiv='refresh' content='0; url=../pasien'>";
  die();
}

// ................SITUASI 2...............

//query untuk mendapatkan nomor antrian terakhir = YYYYMM-XXX - 202312-004
$queryGetRm = "SELECT MAX(SUBSTRING(no_rm, 8)) as last_queue_number FROM pasien";
$resultRm = mysqli_query($koneksi, $queryGetRm);

//periksa hasil query
if(!$resultRm){
  die("Query gagal: " .  mysqli_error($koneksi));  
}

//Ambil nomor antrian terakhir dari hasil query
$rowRm = mysqli_fetch_assoc($resultRm);
$lastQueueNumber  = $rowRm['last_queue_number'];

// Jika tabel kosong atur nomor antrian menjadi 0
$lastQueueNumber = $lastQueueNumber ? $lastQueueNumber : 0;

// mendapatkan tahun saat ini (misalnya, 202312)
$tahun_bulan = date("Ym");

//membuat nomor antrian baru dengan menambahkan 1 pada nomor antrian terakhir
$newQueueNumber = $lastQueueNumber + 1;

//menyusun nomor rekam medis dengan format YYYYMM-XXX
$no_rm = $tahun_bulan . "-" . str_pad($newQueueNumber, 3, '0', STR_PAD_LEFT);

//...

// lakukan operasi INSERT
$query = "INSERT INTO pasien (nama, alamat, no_ktp, no_hp, no_rm, password) VALUES ('$nama', '$alamat', '$no_ktp', '$no_hp', '$no_rm','$pass')";

//eksekusi query
if (mysqli_query($koneksi, $query)){
  //set session variables
  $_SESSION['signup'] = true;
  $_SESSION['id'] = mysqli_insert_id($koneksi);
  $_SESSION['username'] = $nama;
  $_SESSION['no_rm'] = $row['no_rm'];
  
  // Redirect ke halaman dashboard
  header('location:../pasien');
  exit();
}else{
  echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
}


}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Registration Page</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="../../index2.html"><b>Pasien</b>Register</a>
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Register a new account</p>

      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control"  placeholder="Nama" name="nama" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Alamat" name="alamat" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="no. KTP" name="no_ktp" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="No. HP" name="no_hp" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Password" name="password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
          <!-- /.col -->
        </div>
        <a href="login.php" class="text-center">I Already have an account</a>
      </form>
      
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="../assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../assets/dist/js/adminlte.min.js"></script>
</body>
</html>