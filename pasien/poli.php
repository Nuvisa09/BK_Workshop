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
$id_pasien = $_SESSION['id'];
$no_rm = $_SESSION['no_rm'];

if($akses != 'pasien'){
  echo "<meta http-equiv='refresh' content = '0; url=../..'>";
  die();
}


include '../template/topmenu.php';
include '../template/sidemenu_pasien.php';

if(isset($_POST['submit'])){
  if ($_POST['id_jadwal']== "900"){
    echo "
        <script>
          alert('Jadwal tidak boleh kosong!');
        </script>
    ";
    echo "<meta http-equiv='refresh' content='0>";
  }
  
  if(daftarpoli($_POST) > 0){
    echo "
        <script>
          alert('berhasil mendaftar poli');
        </script>
    ";
  }else{
    echo "
        <script>
          alert('Gagal mendaftar poli');
        </script>
    ";
  }
}

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
          <div class="col-md-4">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Daftar Poli</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->

              <form method="POST" action="" >
              <input type="hidden" value="<?= $id_pasien?>" name="id_pasien"> 
              <div class="card-body">
                  <div class="form-group">
                    <label for="no_rm">Nomor rekam Medis</label>
                    <input type="texs" class="form-control" id="exampleInputNamaObat" name="no_rm" placeholder="Nomor Rekam Medis" value="<?=$no_rm?>" required> 
                    
                  </div>
                  <div class="form-group">
                    <label for="inputPoli">Nama Poli</label>
                    <select id="inputPoli" class="form-control select2" style="width: 100%;" aria-label="hari"  required>>
                      <option selected>Pilih Poli</option>
                      <?php
                        $data =mysqli_query($koneksi, "SELECT * FROM poli");
                        // $data->execute();
                        if(mysqli_num_rows($data)==0){
                          echo "<option> Tidak ada poli</option>";
                        }else{
                          while ($d = mysqli_fetch_assoc($data)){
                            ?>
                            <option value="<?=$d['id']?>"><?= $d['nama_poli']?></option>
                            <?php
                          }
                        }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="inputJadwal">Pilih Jadwal</label>
                    <select id="inputJadwal" class="form-control select2" style="width: 100%;" name="id_jadwal" required>
                        <option value="900">Open this select menu</option>
                    </select>
                    
                </div>
                  <div class="form-group">
                    <label for="inputKeterangan">Keluhan</label>
                    <textarea style="width:100%;" id="keluhan" name="keluhan" rows="3" ></textarea>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                </div>
              </form>
            </div>
          </div>
          <div class="col-8">
            <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Riwayat Daftar Poli</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th scope='col'>No</th>
                    <th scope='col'>Poli</th>
                    <th scope='col'>Dokter</th>
                    <th scope='col'>Hari</th>
                    <th scope='col'>Mulai</th>
                    <th scope='col'>Selesai</th>
                    <th scope='col'>Antrian</th>
                    <th scope='col'>Aksi</th>
                  </tr>
                  </thead>
                  <?php
                    $poli_query = mysqli_query ($koneksi,"SELECT  d.nama_poli as poli_nama,
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
                    $no = 0;
                    if(mysqli_num_rows($poli_query) == 0){
                      echo "<tr><td colspan='8'> Tidak ada data</td></rt>";
                    } else {
                        while ($p = mysqli_fetch_array($poli_query)) {
                          ++$no;
                          ?>
                      <tr>
                          <th scope="row">
                            <?php
                              if($no == 1)
                                if($no == 1){
                                  echo "<span class = 'badge badge-info'>New</span>";
                                }else{
                                  echo $no;
                                }
                              
                            ?>
                          </th>
                          <td><?= $p['poli_nama'] ?></td>
                          <td><?= $p['dokter_nama'] ?></td>
                          <td><?= $p['jadwal_hari'] ?></td>
                          <td><?= $p['jadwal_mulai'] ?></td>
                          <td><?= $p['jadwal_selesai'] ?></td>
                          <td><?= $p['antrian'] ?></td>
                          <td>                    
                            <a href="detail_poli.php?id=<?= $p['poli_id']?>">
                            <button class="btn btn-success btn-sm"><i class="fas fa-eye"></i> Detail</button>
                            </a>

                        </td>
                      </tr>
                    <?php
                       }
                     }     
                   ?>
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

        xhr.setRequestHeader('Content-Type', 'text/html');

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


