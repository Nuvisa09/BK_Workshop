<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data Obat</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Data Obat</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 >List Obat</h3>
                <a href="?page=tambah_obat" class="btn btn-primary"> Add obat</a>
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
                    include "../conf/koneksi_dua.php";
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
                            <a href="?page=edit_obat&aksi=edit&id=<?php echo $data['id'];?>" class="btn btn-success"><i class="fas fa-edit"></i> Edit</a>
                            <a href="?page=hapus_obat&aksi=hapus&id=<?php echo $data['id'];?>" class="btn btn-danger"><i class="fas fa-trash"></i> Delete</a>
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
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>