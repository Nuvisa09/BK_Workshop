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
      $hapus = mysqli_query($koneksi, "DELETE FROM poli WHERE id = " . $_GET['id'] . "");

      if ($hapus) {
          echo "
                  <script> 
                      alert('Berhasil menghapus data.');
                      document.location='poli.php';
                  </script>
              ";
      } else {
          echo "
                  <script> 
                      alert('Gagal menghapus data: " . mysqli_error($koneksi) . "');
                      document.location='poli.php';
                  </script>
              ";
      }
  }
}
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Poli</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Poli</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Poli</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->

              <form method="POST" action="poli_act.php" onsubmit="return(validate());">
              <?php
                    $nama_poli = '';
                    $keterangan = '';
                    if (isset($_GET['id'])) {
                        $ambil = mysqli_query($koneksi, "SELECT * FROM poli 
                                WHERE id='" . $_GET['id'] . "'");
                        while ($row = mysqli_fetch_array($ambil)) {
                            $nama_poli = $row['nama_poli'];
                            $keterangan = $row['keterangan'];
                        }
                    ?>
                    <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                    <?php
                    }
                    ?>  
              <div class="card-body">
                  <div class="form-group">
                    <label for="inputNama">Nama Poli</label>
                    <input type="text" class="form-control" id="exampleInputHarga" name="nama_poli" placeholder="Nama Poli" required value="<?php echo $nama_poli ?>">
                  </div>
                  <div class="form-group">
                    <label for="inputKeterangan">Keterangan</label>
                    <input type="text" class="form-control" id="exampleInputHarga" name="keterangan" placeholder="Keterangan" required value="<?php echo $keterangan ?>">
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                </div>
              </form>
            </div>
          </div>
          <div class="col-12">
            <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">List poli</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                    $result = mysqli_query($koneksi, "SELECT * FROM poli");
                    $no = 1;
                    while ($data = mysqli_fetch_array($result)) :
                  ?>
                  <tr>
                    <td><?php echo $no++ ?></td>
                    <td><?php echo $data['nama_poli'] ?></td>
                    <td><?php echo $data['keterangan'] ?></td>
                    <td>                    
                      <a href="?page=poli&aksi=edit&id=<?php echo $data['id'];?>" class="btn btn-success"><i class="fas fa-edit"></i> Edit</a>
                      <a href="?page=poli_act&aksi=hapus&id=<?php echo htmlspecialchars($data['id'], ENT_QUOTES, 'UTF-8');?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this data?');">
                        <i class="fas fa-trash"></i> Delete
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
          
          <!--/.col (left) -->
          <!-- right column -->
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  



<?php
include '../template/footer.php';
?>
