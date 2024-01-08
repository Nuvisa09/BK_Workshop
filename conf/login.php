<?php
session_start();
// if(isset($_SESSION['admin_username'])){
//     header("location:../pasien");
// }
include ("koneksi.php");
$username = "";
$password = "";
$err = "";
 
if(isset($_POST['login'])){
    $username = $_POST ['nama'];
    $password = $_POST ['password'];
    if($username == 'admin' or $password == 'admin'){
      $_SESSION['admin_username'] = 'admin';
      header('location:../admin/index.php');
      exit();
    // }else{
    //     $err .= "<li>Silakan Masukkan Username dan Password</li>";
    }
    else{
        $sql1 = "SELECT * FROM pasien WHERE nama = '$username'";
        $q1 = mysqli_query($koneksi, $sql1);
        $r1 = mysqli_fetch_array ($q1);
        $_session['no_rm'] = $r1['no_rm'];
        if($r1['password'] != md5($password)){
            $err .= "<li> Akun tidak ditemukan </li>";
        }else{

        }$_SESSION ['admin_username'] = $username;
        
        // $_session ['admin_akses'] = $akses;
        header ("location:../pasien");
        exit();
    }
    // if(empty($err)){
    //   $id = $r1['id'];
    //   $sql1 = "select * from admin_akses where id = '$id' ";
    //   $q1 = mysqli_query($koneksi, $sql1);
    //   while($r1 = mysqli_fetch_array($q1)){
    //     $akses[] = $r1['akses_id'];
    //   }
    //   if(empty($akses)){
    //     $err .= "<li>Kamu tidak memiliki akses ke halaman admin</li>";
    //    }
    // }
    // if(empty($err)){
    //     $_SESSION ['admin_username'] = $username;
    //     // $_session ['admin_akses'] = $akses;
    //     header ("location:../pasien/home.php");
    //     exit();
    // }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Rumah Sakit | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>Pasien</b>Login</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>
      <?php 
      if($err){
        echo "<ul>$err</ul>";      
      }
      ?>
      <form action="" method="POST">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="nama"  placeholder="Username" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password"  placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="mb-0">
                <a href="register.php" class="text-center">Register a new account</a>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button name="login" type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../assets/dist/js/adminlte.min.js"></script>
</body>
</html>


