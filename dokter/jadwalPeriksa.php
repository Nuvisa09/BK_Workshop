
<?php
include '../template/topmenu.php';
include '../template/sidemenu_dokter.php';
include '../conf/koneksi.php';
?>
<?php
include '../conf/koneksi.php';
if (isset($_GET['aksi'])) {
  if ($_GET['aksi'] == 'hapus') {
      $hapus = mysqli_query($koneksi, "DELETE FROM jadwal_periksa WHERE id = '" . $_GET['id'] . "'");

      if ($hapus) {
          echo "
                  <script> 
                      alert('Berhasil menghapus data.');
                      document.location='jadwalPeriksa.php';
                  </script>
              ";
      } else {
          echo "
                  <script> 
                      alert('Gagal menghapus data: " . mysqli_error($koneksi) . "');
                      document.location='jadwalPeriksa.php;
                  </script>
              ";
      }
  }else{
    $id = $_GET['id'];
    $status = $_GET['status'];
    $query = "UPDATE jadwal_periksa SET status = $status WHERE id = $id";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        header('location:jadwalPeriksa.php');
    } else {
        header('location:jadwalPeriksa.php');
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
            <h1>Jadwal periksa</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Jadwal Periksa</li>
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
                <h3 class="card-title">Jadwal Periksa</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->

              <form method="POST" action="jadwalPeriksa_act.php" onsubmit="return(validate());">
              <?php
                    $id_dokter = '';
                    $hari = '';
                    $jam_mulai = '';
                    $jam_selesai = '';
                    if (isset($_GET['id'])) {
                        $ambil = mysqli_query($koneksi, "SELECT * FROM jadwal_periksa 
                                WHERE id='" . $_GET['id'] . "'");
                        while ($row = mysqli_fetch_array($ambil)) {
                            $id_dokter = $row['id_dokter'];
                            $hari = $row['hari'];
                            $jam_mulai = $row['jam_mulai'];
                            $jam_selesai = $row['jam_selesai'];
                        }
                    ?>
          <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
          <?php
                    }
                    ?>  
              <div class="card-body">
                  <div class="form-group">
                    <label for="id_dokter">Dokter</label>
                    <select class="form-control select2" style="width: 100%;" name="id_dokter" aria-label="id_dokter">
                    <option value="" selected>Pilih Dokter...</option>
                    <?php
                                  $result = mysqli_query($koneksi, "SELECT * FROM dokter");

                                  while ($data = mysqli_fetch_assoc($result)) {
                                      echo "<option value='" . $data['id'] . "'>" . $data['nama'] . "</option>";
                                  }
                                  ?>

                  </select>
                </div>
                <div class="form-group">
                    <label for="hari">Hari</label>
                    <select class="form-control select2" style="width: 100%;" name="hari" aria-label="hari" placeholder="Hari" required>>
                      <option value="" selected>Pilih Hari...</option>
                      <option value="Senin">Senin</option>
                      <option value="Selasa">Selasa</option>
                      <option value="Rabu">Rabu</option>
                      <option value="Kamis">Kamis</option>
                      <option value="Jumat">Jum'at</option>
                      <option value="Sabtu">Sabtu</option>
                    </select>
                </div>
                  <div class="form-group">
                    <label for="jam_mulai">Jam Mulai</label>
                    <input type="time" class="form-control" id="exampleInputHarga" name="jam_mulai" placeholder="Jam Mulai" required value="<?php echo $jam_mulai ?>">
                  </div>
                  <div class="form-group">
                  <label for="jam_selesai">Jam Selesai</label>
                    <input type="time" class="form-control" id="exampleInputHarga" name="jam_selesai" placeholder="Jam Selesai" required  required value="<?php echo $jam_selesai ?>">
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

        <!-- /.content -->
  </div>

<div class="col-md-12">
     <div class="card card-primary">
     <div class="card-header">
         <h3 class="card-title">List Jadwal Dokter</h3>
       </div>
       <!-- /.card-header -->
       <div class="card-body">
         <table id="example2" class="table table-bordered table-hover">
           <thead>
           <tr>
             <th>No</th>
             <th>Nama Dokter</th>
             <th>Hari</th>
             <th>Jam Mulai</th>
             <th>Jam Selesai</th>
             <th>Aksi</th>
             <th>Status</th>
           </tr>
           </thead>
           <tbody>
           <?php
             $result = mysqli_query($koneksi, "SELECT dokter.nama, jadwal_periksa.id, jadwal_periksa.hari, 
             jadwal_periksa.jam_mulai, jadwal_periksa.jam_selesai, jadwal_periksa.status FROM dokter JOIN 
             jadwal_periksa ON dokter.id = jadwal_periksa.id_dokter");
             $no = 1;
             while ($data = mysqli_fetch_array($result)) :
           ?>
           <tr>
             <td><?php echo $no++ ?></td>
             <td><?php echo $data['nama'] ?></td>
             <td><?php echo $data['hari'] ?></td>
             <td><?php echo $data['jam_mulai'] ?> WIB</td>
             <td><?php echo $data['jam_selesai'] ?> WIB</td>
             <td>
             
               <a href="?page=jadwalPeriksa&aksi=edit&id=<?php echo $data['id'];?>" class="btn btn-success"><i class="fas fa-edit"></i> Edit</a>
               <a href="?page=jadwalPeriksa&aksi=hapus&id=<?php echo $data['id'];?>" class="btn btn-danger"><i class="fas fa-trash"></i> Delete</a>   
             </td>
             <td>
               <?php
               if ($data['status'] == 0) {
                   echo '<a class="btn btn-sm btn-success" href="status.php?id=' . $data['id'] . '&status=1">Belum</a>';
               } else {
                   echo '<a class="btn btn-sm btn-danger" href="status.php?id=' . $data['id'] . '&status=0">Sudah</a>';
               }
               ?>
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

        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>

    
    


<?php
include '../template/footer.php';
?>
