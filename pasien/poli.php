<?php

session_start();

include '../conf/koneksi.php';
// mysqli_query($koneksi,"SELECT * FROM pasien");
// $no_rm = $_SESSION['no_rm'];

include '../template/topmenu.php';
include '../template/sidemenu_pasien.php';

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
            <h1>Daftar Poli</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Daftar Poli</li>
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
                <h3 class="card-title">Daftar Poli</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->

              <form method="POST" action="poli_act.php" onsubmit="return(validate());">
              <input type="hidden" value="<?= $id_pasien?>" name="id_pasien">
              <?php
                    $id_pasien = '';
                    $no_rm = '';
                    $id_jadwal = '';
                    $keluhan = '';
                    if (isset($_GET['id'])) {
                        $ambil = mysqli_query($koneksi, "SELECT * FROM daftar_poli 
                                WHERE id='" . $_GET['id'] . "'");
                        while ($row = mysqli_fetch_array($ambil)) {
                            $id_pasien = $row['id_pasien'];
                            $no_rm = $row['no_rm']
;                            $id_jadwal = $row['jadwal_periksa'];
                            $keluhan = $row['keluharn'];
                        }
                    ?>
                    <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                    <?php
                    }
                    ?>  
              <div class="card-body">
                  <div class="form-group">
                    <label for="no_rm">Nomor rekam Medis</label>
                    <input type="teks" class="form-control" id="exampleInputNamaObat" name="no_rm" placeholder="Nomor Rekam Medis" value="<?=$no_rm?>" required> 
                    
                  </div>
                  <div class="form-group">
                    <label for="inputNama">Nama Poli</label>
                    <select id="inputPoli" class="form-control select2" style="width: 100%;" aria-label="hari"  required>>
                      <option value="" selected>Pilih Poli</option>
                      <?php
                        $result = mysqli_query($koneksi, "SELECT * FROM poli");
                        while ($data = mysqli_fetch_assoc($result)) {
                          echo "<option value='" . $data['id'] . "'>" . $data['nama_poli'] . "</option>";
                        }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="hari">Jadwal Dokter</label>
                    <select id="inputJadwal" class="form-control select2" style="width: 100%;" name="id_jadwal" aria-label="hari"  required>>
                      <option value="900" selected>Pilih Jadwal</option>
                      <?php
                        $result = mysqli_query($koneksi, "SELECT * FROM dokter");
                        while ($data = mysqli_fetch_assoc($result)) {
                          echo "<option value='" . $data['id'] . "'>" . $data['nama'] . "</option>";
                        }
                      ?>
                    </select>
                </div>
                  <div class="form-group">
                    <label for="inputKeterangan">Keluhan</label>
                    <textarea style="width:100%;" name="keluhan" rows="5" cols="40"><?php echo $keluhan;?></textarea>
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
                    <th>Hari</th>
                    <th>Mulai</th>
                    <th>Selesai</th>
                    <th>Antrian</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                    $result = ("SELECT  d.nama_poli as poli_nama,
                                c.nama as dokter_nama,
                                b.hari as jadwal_hari,
                                b.jam_mulai as jadwal_mulai,
                                b.jam_selesai as jadwal_selesai,
                                a.no_antrian as antrian,
                                a.id as poli_id
                                
                                FROM daftar_poli as a
                                
                                INNER JOIN jadwal_periksa as b
                                  ON a.id_jadwal = b.id
                                INNER JOIN dokter as c
                                  ON b.id_dokter = c.id
                                INNER JOIN poli as d
                                  ON c.id_poli = d.id
                                WHERE a.id_pasien = '$id_pasien'
                                ORDER BY a.id desc");
                    $poli_result = mysqli_query($koneksi, $result);
                    if (!$poli_result) {
                      die("Query error: " . mysqli_error($koneksi));
                    }
                    $rowCount = mysqli_num_rows($poli_result);
                    $no = 1;
                    if($rowCount == 0){
                      echo "Tidak ada data";
                    } else {
                        while ($data = mysqli_fetch_array($poli_result)) {
                          ?>
                      <tr>;
                        <td><?php echo $no++ ?></td>
                        <td><?php echo $data['nama_poli'] ?></td>
                        <td><?php echo $data['nama'] ?></td>
                        <td><?php echo $data['hari'] ?></td>
                        <td><?php echo $data['jam_mulai'] ?></td>
                        <td><?php echo $data['jam_selesai'] ?></td>
                        <td><?php echo $data['antrian'] ?></td>
                        <td>                    
                          <a href="detail_poli.php/<?php echo $data['poli_id'];?>" class="btn btn-success"><i class="fas fa-edit"></i> detail</a>
                          </a>

                        </td>
                      </tr>
                      <?php
                        }
                        }
                             
                   ?>
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

  <script>
    document.getElementById('inputPoli').addEventListener('change',function (){
        var poliId = this.value; //Ambil nilai ID poli yang dipilih
        loadJadwal(poliId); // panggil fungsi untuk memuat jadwal dokter
    });

    function loadJadwal (poliId){
        //but objek XMLHttpRequest
        var xhr = new XMLHttpRequest();

        //konfigurasi permintaan Ajax
        xhr.open('GET','http://localhost/bk_workshop/pasien/get_Jadwal.php?poli_id=' +poliId, true);

        xhr.setrequestHeader('Content-Type', 'text/html');

        //atur fungsi callback ketika permintaan selesai
        xhr.onload = function(){
            if (xhr.status ===200){
                //jika permintaan berhasil, perbarui opsi pada select pilih jadwal
                document.getElementById('inputJadwal').innerHTML = xhr.responseText;
            }
        };
        //kirim permintaan
        xhr.send();
    }

</script> 
  



<?php
include '../template/footer.php';
?>
