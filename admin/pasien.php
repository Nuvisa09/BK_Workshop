<?php
session_start();
include '../template/topmenu.php';
include '../template/sidemenu_admin.php';
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
?>

<?php


if (isset($_GET['aksi'])) {
  if ($_GET['aksi'] == 'hapus') {
      $hapus = mysqli_query($koneksi, "DELETE FROM pasien WHERE id = '" . $_GET['id'] . "'");
  }

  echo "<script> 
              alert('Berhasil menghapus data.');
              document.location='pasien.php';
              </script>";
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

// $queryInsert = "INSERT INTO pasien (nama, alamat, no_ktp, no_hp, no_rm) VALUES ('$_POST[nama]', '$_POST[alamat]', '$_POST[no_ktp]', '$_POST[no_hp]', '$no_rm')";
// $resultInsert = mysqli_query($koneksi, $queryInsert);

// if ($resultInsert) {
//     echo "<script> 
//           alert('Berhasil menyimpan data. Nomor RM: $no_rm');
//           document.location='pasien.php';
//           </script>";
// } else {
//     echo "<script> 
//           alert('Gagal menyimpan data. Silakan coba lagi.');
//           </script>";
// }
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Pasien</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Pasien</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Dokter</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
            
              <form method="POST" action="pasien_Act.php" onsubmit="return(validate());">
              <?php
                    $nama = '';
                    $alamat = '';
                    $no_ktp = '';
                    $no_hp = '';
                    $password='';
                    if (isset($_GET['id'])) {
                        $ambil = mysqli_query($koneksi, "SELECT * FROM pasien WHERE id='" . $_GET['id'] . "'");
                        while ($row = mysqli_fetch_array($ambil)) {
                            $nama = $row['nama'];
                            $alamat = $row['alamat'];
                            $no_ktp = $row['no_ktp'];
                            $no_hp = $row['no_hp'];
                            $password = $row['password'];
                            
                        }
                    ?>
              <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
              <?php
                    }
                    ?>  
              <div class="card-body">
                  <div class="form-group">
                    <label for="inputNama">Nama Pasien</label>
                    <input type="text" class="form-control" id="exampleInputHarga" name="nama" placeholder="Nama Pasien" required value="<?php echo $nama ?>">
                  </div>
                  <div class="form-group">
                    <label for="inputKeterangan">Alamat</label>
                    <input type="text" class="form-control" id="exampleInputHarga" name="alamat" placeholder="Alamat" required value="<?php echo $alamat ?>">
                  </div>
                  <div class="form-group">
                    <label for="inputNama">Nomor KTP</label>
                    <input type="text" class="form-control" id="exampleInputHarga" name="no_ktp" placeholder="Nomor KTP" required value="<?php echo $no_ktp ?>">
                  </div>
                  <div>
                  <div class="form-group">
                    <label for="inputKeterangan">Nomor Hp</label>
                    <input type="text" class="form-control" id="exampleInputHarga" name="no_hp" placeholder="Nomor Hp" required value="<?php echo $no_hp ?>">
                  </div>
                  <div class="form-group">
                    <label for="inputKeterangan">Nomor RM</label>
                    <input type="text" class="form-control" id="exampleInputHarga" name="no_rm" required value="<?php echo $no_rm; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="inputKeterangan">Password</label>
                    <input type="password" class="form-control" id="exampleInputHarga" name="no_rm" placeholder="Password" required value="<?php echo $password; ?>">
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        </div>
          
          <div class="col-12">
            <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">List pasien</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>No. KTP</th>
                    <th>No. Handphone</th>
                    <th>No. RM</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                    $result = mysqli_query($koneksi, "SELECT * FROM pasien");
                    $no = 1;
                    while ($data = mysqli_fetch_array($result)) :
                  ?>
                  <tr>
                    <th scope="row"><?php echo $no++ ?></th>
                    <td><?php echo $data['nama'] ?></td>
                    <td><?php echo $data['alamat'] ?></td>
                    <td><?php echo $data['no_ktp'] ?></td>
                    <td><?php echo $data['no_hp'] ?></td>
                    <td><?php echo $data['no_rm'] ?></td>
                    <td>
                      <a href="?page=pasien&id=<?php echo $data['id'];?>" class="btn btn-success"><i class="fas fa-trash-alt"></i> Edit</a>
                      <a class="btn btn-danger"
                        href="?page=pasien&id=<?php echo $data['id'] ?>&aksi=hapus">Hapus
                      </a>
                    </td>
                </tr>

                  <?php endwhile; ?>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
</div>

<?php
include '../template/footer.php';
?>
