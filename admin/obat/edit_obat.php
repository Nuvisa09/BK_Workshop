<?php
$kode = $_GET['id'];
$sql = $koneksi->query("SELECT * FROM obat WHERE id='$kode'");
$data = $sql->fetch_assoc();
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
              <form method="POST" action="edit_obat_act.php?id=<?=$data['id'];?>" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Nama Obat</label>
                    <input type="teks" class="form-control" id="exampleInputNamaObat" name="nama_obat" placeholder="Nama Obat" value="<?php echo $data['nama_obat'];?>" required> 
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Kemasan</label>
                    <input type="teks" class="form-control" id="exampleInputKemasan" name="kemasan" placeholder="Kemasan" value="<?php echo $data['kemasan'];?>" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Harga</label>
                    <input type="teks" class="form-control" id="exampleInputHarga" name="harga" placeholder="Harga" value="<?php echo $data['harga'];?>" required>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name="edit" class="btn btn-primary float-right"><i class="fas fa-save"></i>Edit</button>
                  <a href="?page=list_obat" class="btn btn-danger"><i class="fas fa-undo"></i> Cancel </a>
                </div>
              </form>
            </div>
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