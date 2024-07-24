<?php
session_start();
include '../conf/koneksi.php';
if(isset($_SESSION['login'])){
    $_SESSION['login'] = true;
  }else{
    echo "<meta http-equiv='refresh' content = '0; url=../conf/login.php'>";
    die();
  }
  
  $nama = $_SESSION['username'];
  $akses = $_SESSION['akses'];
  
  if($akses != 'admin'){
    echo "<meta http-equiv='refresh' content = '0; url=../..'>";
    die();
  }

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_ktp = $_POST['no_ktp'];
    $no_hp = $_POST['no_hp'];
    $no_rm = $_POST['no_rm'];
    $password = $_POST['password'];
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $sql = "UPDATE pasien SET nama='$nama', alamat='$alamat', no_ktp='$no_ktp', no_hp='$no_hp', no_rm='$no_rm', password='$password' WHERE id = '" . $_POST['id'] . "'";
        $edit = mysqli_query($koneksi, $sql);

        echo "
                <script> 
                    alert('Berhasil mengubah data.');
                    document.location='pasien.php';
                </script>
            ";
    } else {
        $sql = "INSERT INTO pasien (nama, alamat, no_ktp, no_hp, no_rm) VALUES ('$nama', '$alamat','$no_ktp', '$no_hp','$no_rm','$password')";
        $tambah = mysqli_query($koneksi, $sql);

        echo "
                <script> 
                    alert('Berhasil menambah data.');
                    document.location='pasien.php';
                </script>
            ";
    }
}
if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        echo "error.log";
        $hapus = mysqli_query($koneksi, "DELETE FROM pasien WHERE id = '" . $_GET['id'] . "'");
        

        if ($hapus) {
            echo "
                    <script> 
                        alert('Berhasil menghapus data.');
                        document.location='pasien.php';
                    </script>
                ";
        } else {
            echo "
                    <script> 
                        alert('Gagal menghapus data: " . mysqli_error($koneksi) . "');
                        document.location='pasien.php;
                    </script>
                ";
        }
    }
}
?>