<?php
include '../template/topmenu.php';
include '../template/sidemenu_admin.php';
include '../conf/koneksi.php';
?>

<?php

if (isset($_GET['aksi'])) {
  if ($_GET['aksi'] == 'hapus') {
      $hapus = mysqli_query($koneksi, "DELETE FROM dokter WHERE id = '" . $_GET['id'] . "'");
  }

  echo "<script> 
             alert('Berhasil menghapus data.');
              document.location='dokter.php';
              </script>";
}

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Dokter</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dokter</li>
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
            
              <form method="POST" action="dokter_Act.php" onsubmit="return(validate());">
              <?php
                    $nama = '';
                    $alamat = '';
                    $no_hp = '';
                    $id_poli = '';
                    $password = '';
                    if (isset($_GET['id'])) {
                        $ambil = mysqli_query($koneksi, "SELECT * FROM dokter WHERE id='" . $_GET['id'] . "'");
                        while ($row = mysqli_fetch_array($ambil)) {
                            $nama = $row['nama'];
                            $alamat = $row['alamat'];
                            $no_hp = $row['no_hp'];
                            $id_poli = $row['id_poli'];
                            $password = $row['password'];
                            
                            // Retrieve the existing hashed password
                            $existingPassword = $row['password'];
                        }
                    ?>
              <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
              <?php
                    }
                    ?>  
              <div class="card-body">
                  <div class="form-group">
                    <label for="inputNama">Nama</label>
                    <input type="text" class="form-control" id="exampleInputHarga" name="nama" placeholder="Nama Dokter" required value="<?php echo $nama ?>">
                  </div>
                  <div class="form-group">
                    <label for="inputKeterangan">Alamat</label>
                    <input type="text" class="form-control" id="exampleInputHarga" name="alamat" placeholder="Alamat" required value="<?php echo $alamat ?>">
                  </div>
                  <div class="form-group">
                    <label for="inputNama">No. Handphone</label>
                    <input type="text" class="form-control" id="exampleInputHarga" name="no_hp" placeholder="Nomor Handphone" required value="<?php echo $no_hp ?>">
                  </div>
                  <div>
                  <div class="form-group">
                    <label for="id_dokter">Poli</label>
                    <select class="form-control select2" style="width: 100%;" name="id_poli" id="id_poli" aria-label="id_poli">
                    <option value="" selected>Pilih Poli</option>
                    <?php
                                  $result = mysqli_query($koneksi, "SELECT * FROM poli");

                                  while ($data = mysqli_fetch_assoc($result)) {
                                      echo "<option value='" . $data['id'] . "'>" . $data['nama_poli'] . "</option>";
                                  }
                                  ?>

                  </select>
                  <div class="form-group">
                    <label for="inputKeterangan">Password</label>
                    <input type="text" class="form-control" id="exampleInputHarga" name="password" placeholder="Password" required value="<?php echo isset($existingPassword) ? $existingPassword : ''; ?>">
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
                <h3 class="card-title">List Dokter</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover" >
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>No. Handphone</th>
                    <th>Nama poli</th>
                    <!-- <th>Password</th> -->
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                    $result = mysqli_query($koneksi, "SELECT dokter.*, poli.nama_poli AS nama_poli FROM dokter JOIN poli ON dokter.id_poli = poli.id");
                    $no = 1;
                    while ($data = mysqli_fetch_array($result)) {
                  ?>
                  <tr>
                  <td><?php echo $no++ ?></td>
                    <td><?php echo $data['nama'] ?></td>
                    <td><?php echo $data['alamat'] ?></td>
                    <td><?php echo $data['no_hp'] ?></td>
                    <td><?php echo $data['nama_poli'] ?></td>
                    
                    <td>
                    <a href="?page=dokter&id=<?php echo $data['id'];?>" class="btn btn-success"><i class="fas fa-edit"></i> Edit</a>
                    <a href="dokter.php?id=<?php echo $data['id'];?>&aksi=hapus" class="btn btn-danger"><i class="fas fa-trash"></i> Delete</a>   
                    </td>
                </tr>

                  <?php } ?>
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
