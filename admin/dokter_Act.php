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
    $no_hp = $_POST['no_hp'];
    $poli_id = $_POST['id_poli'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $sql = "UPDATE dokter SET nama='$nama', alamat='$alamat', no_hp='$no_hp', id_poli='$poli_id', password='$password' WHERE id = '" . $_POST['id'] . "'";
        $edit = mysqli_query($koneksi, $sql);

        echo "
                <script> 
                    alert('Berhasil mengubah data.');
                    document.location='dokter.php';
                </script>
            ";
    } else {
        $sql = "INSERT INTO dokter (nama, alamat, no_hp, id_poli, password) VALUES ('$nama', '$alamat','$no_hp', '$poli_id','$password')";
        $tambah = mysqli_query($koneksi, $sql);

        echo "
                <script> 
                    alert('Berhasil menambah data.');
                    document.location='dokter.php';
                </script>
            ";
    }
}
if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        echo "error.log";
        $hapus = mysqli_query($koneksi, "DELETE FROM dokter WHERE id = '" . $_GET['id'] . "'");
        

        if ($hapus) {
            echo "
                    <script> 
                        alert('Berhasil menghapus data.');
                        document.location='dokter.php';
                    </script>
                ";
        } else {
            echo "
                    <script> 
                        alert('Gagal menghapus data: " . mysqli_error($koneksi) . "');
                        document.location='dokter.php;
                    </script>
                ";
        }
    }
}
?>