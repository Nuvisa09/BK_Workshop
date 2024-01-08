<?php
include '../template/topmenu.php';
include '../template/sidemenu_admin.php';
include '../conf/koneksi.php';
?>

<?php

if (isset($_POST['simpan'])) {
    if (isset($_POST['id'])) {
        $ubah = mysqli_query($mysqli, "UPDATE obat SET 
                                            nama_obat = '" . $_POST['nama_obat'] . "',
                                            kemasan = '" . $_POST['kemasan'] . "',
                                            harga = '" . $_POST['harga'] . "'
                                            WHERE
                                            id = '" . $_POST['id'] . "'");
    } else {
        $tambah = mysqli_query($mysqli, "INSERT INTO obat (nama_obat, kemasan, harga) 
                                            VALUES (
                                                '" . $_POST['nama_obat'] . "',
                                                '" . $_POST['kemasan'] . "',
                                                '" . $_POST['harga'] . "'
                                            )");
    }
    echo "<script> 
                document.location='index.php?page=obat';
                </script>";
}
if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($mysqli, "DELETE FROM obat WHERE id = '" . $_GET['id'] . "'");
    }

    echo "<script> 
                document.location='index.php?page=obat';
                </script>";
}


?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>General Form</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">General Form</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Quick Example</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="obat_act.php" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Nama Obat</label>
                    <input type="teks" class="form-control" id="exampleInputNamaObat" name="nama_obat" placeholder="Nama Obat" required> 
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Kemasan</label>
                    <input type="tekx" class="form-control" id="exampleInputKemasan" name="kemasan" placeholder="Kemasan" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Harga</label>
                    <input type="teks" class="form-control" id="exampleInputHarga" name="harga" placeholder="Harga" required>
                  </div>
                  <div class="form-group">
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name="simpan" class="btn btn-primary">SAVE</button>
                </div>
              </form>
            </div>
          </div>
          <!--/.col (left) -->
          <!-- right column -->
          <!--/.col (right) -->
          
        </div>
        <!-- /.row -->
        <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 >List Obat</h3>
                <!-- <a href="?page=tambah_obat" class="btn btn-primary"> Add obat</a> -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Obat</th>
                    <th>Kemasan</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                    include "../conf/koneksi.php";
                    $no = 1;
                    $sql = $koneksi->query ("SELECT *FROM obat");
                    while ($data = $sql->fetch_assoc()){

                    ?>

                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $data['nama_obat']; ?></td>
                        <td><?php echo $data['kemasan']; ?></td>
                        <td><?php echo $data['harga']; ?></td>

                        <td>
                            <a href="?page=obat&aksi=edit&id=<?php echo $data['id'];?>" class="btn btn-success"><i class="fas fa-edit"></i> Edit</a>
                            <a href="?page=obat&aksi=hapus&id=<?php echo $data['id'];?>" class="btn btn-danger"><i class="fas fa-trash"></i> Delete</a>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

  <?php
include '../template/footer.php';
?>