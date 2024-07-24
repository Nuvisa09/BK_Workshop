<?php

session_start();

include '../conf/koneksi.php';
include '../template/topmenu.php';
include '../template/sidemenu_pasien.php';
// mysqli_query($koneksi,"SELECT * FROM pasien");
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

$url = $_SERVER['REQUEST_URI'];
$url = explode("?id=",$url);
$id_poli = $url[count($url)-1];
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Detail Poli</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Detail Poli</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
      <?php

        //tittle section
        ob_start();?>
        Detail poli
        <?php
        $main_title =ob_get_clean();
        ob_flush();

        // content section
        ob_start();?>

        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="card-title">Detail Poli</h3>
            </div>
        </div>
        <div class="card-body">
            <?php
                $poli_query = mysqli_query($koneksi, "SELECT  d.nama_poli as poli_nama,
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
                                                WHERE a.id = '$id_poli'");
                // $poli_result = mysqli_query($koneksi, $poli_query);
                if(!$poli_query){
                    die("Query error:" . mysqli_error($koneksi));
                }

                $no = 0;
                if(mysqli_num_rows($poli_query)==0){
                    echo "Tidak ada data";
                }else{
                    while($p = mysqli_fetch_assoc($poli_query)){
                ?>

                <center>
                    <h5>Nama Poli</h5>
                    <?= $p['poli_nama']?>
                    <hr>

                    <h5>Nama Dokter</h5>
                    <?= $p['dokter_nama']?>
                    <hr>

                    <h5>Hari</h5>
                    <?= $p['jadwal_hari']?>
                    <hr>

                    <h5>Mulai</h5>
                    <?= $p['jadwal_mulai']?>
                    <hr>

                    <h5>Selesai</h5>
                    <?= $p['jadwal_selesai']?>
                    <hr>

                    <h5>Nomor Antrian</h5>
                    <button class="btn btn-success"><?= $p['antrian']?></button>
                    <hr>
                </center>

                <?php

                    }
                }
             ?>
            
        </div>
        <a href="poli.php" class="btn btn-primary btn-block">Kembali</a>

    </section>
</div>

<?php
include '../template/footer.php';
?>