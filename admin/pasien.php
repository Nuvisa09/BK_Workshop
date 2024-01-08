<?php
include '../template/topmenu.php';
include '../template/sidemenu_admin.php';
include '../conf/koneksi.php';
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
                    <a class="btn btn-danger rounded-pill px-3"
                        href="?page=pasien&id=<?php echo $data['id'] ?>&aksi=hapus">Hapus</a>
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
</div>

<?php
include '../template/footer.php';
?>
