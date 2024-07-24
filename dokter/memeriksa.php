<?php
 session_start();
include '../template/topmenu.php';
include '../template/sidemenu_dokter.php';

if(isset($_SESSION['login'])){
  $_SESSION['login'] = true;
}else{
  echo "<meta http-equiv='refresh' content = '0; url=../conf/login_dokter.php'>";
  die();
}

$nama = $_SESSION['username'];
$akses = $_SESSION['akses'];

if($akses != 'dokter'){
  echo "<meta http-equiv='refresh' content = '0; url=../..'>";
  die();
}

include '../conf/koneksi.php';
$pasien = query("SELECT
                    periksa.id AS id_periksa,
                    pasien.id AS id_pasien,
                    periksa.catatan AS catatan,
                    daftar_poli.no_antrian AS no_antrian,
                    pasien.nama AS nama_pasien,
                    daftar_poli.keluhan AS keluhan,
                    daftar_poli.status_periksa AS status_periksa
                FROM pasien
                INNER JOIN daftar_poli ON pasien.id = daftar_poli.id_pasien
                LEFT JOIN periksa ON daftar_poli.id = periksa.id_daftar_poli");
$periksa = query("SELECT * from periksa");

$obat = query("SELECT * FROM obat");
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
          
        

        <!-- /.content -->
  

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
             <th>No.urut</th>
             <th>Nama Pasien</th>
             <th>Keluhan</th>
             <th>Aksi</th>
           </tr>
           </thead>
           <tbody>
           <?php
            //  $result = mysqli_query($koneksi, "SELECT dokter.nama, jadwal_periksa.id, jadwal_periksa.hari, jadwal_periksa.jam_mulai, jadwal_periksa.jam_selesai, jadwal_periksa.status FROM dokter JOIN jadwal_periksa ON dokter.id = jadwal_periksa.id_dokter");
            //  if (!$result) {
            //   die("Error executing query: " . mysqli_error($koneksi));
            //  }
             $no = 1;
            //  while ($data = mysqli_fetch_array($result)) :
              foreach($pasien as $data)
              
           ?>
              <tr>
                <td><?php echo $no++ ?></td>
                <td><?php echo $data['nama_pasien'] ?></td>
                <td><?php echo $data['keluhan'] ?></td>
                <td>
                      <a href="memeriksa_pasien.php?id=<?= $data['id_pasien']?>">
                            <button class="btn btn-success btn-sm"><i class="fas fa-eye"></i> Detail</button>
                      </a>
                </td>
              </tr>

           <?php 
          //  endwhile; 
           ?>
           </tbody>
         </table>
       </div>
       <!-- /.card-body -->
     </div>
     <!-- /.card -->
   </div>

        <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>

    </div>
    

    
    


<?php
include '../template/footer.php';
?>

