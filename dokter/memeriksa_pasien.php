<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>

    <script src="jquery.min.js"></script>
    <!-- <link href="select2/dist/css/select2.min.css" rel="stylesheet" />
    <script src="select2/dist/js/select2.min.js"></script> -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
</head>
<script>
    $(document).ready(function(){
        $('#id_obat').select2();
        $('#id_obat').on('change', function (e){
            var selectedValuesArray = $(this).val();
            
            var sum = 150000;
            if (selectedValuesArray){
                for (var i = 0; i <selectedValuesArray.length; i++){

                    var parts = selectedValuesArray[i].split("|");
                    if (parts.length === 2){
                        sum += parseFloat(parts[1]);
                    }
                }
            }
            $('#harga').val(sum);
        });
    });
</script>
</html>

<?php
session_start();
// include '../template/topmenu.php';
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

?>
<?Php


    include '../conf/koneksi.php';
    $url = $_SERVER['REQUEST_URI'];
    $url = explode("?id=", $url);
    $id = $url[count($url)-1];
    // $id = intval($id);
    $obat = query("SELECT * FROM obat");

    $pasiens = query("SELECT
                        p.nama AS nama_pasien,
                        dp.id AS id_daftar_poli
                    FROM pasien p
                    INNER JOIN daftar_poli dp ON p.id = dp.id_pasien
                    WHERE p.id = '$id'")[0];
    
    $biaya_periksa = 150000;
    $total_biaya_obat = 0;
    
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Periksa Pasien</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Periksa Pasien</li>
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
                <h3 class="card-title">Periksa Pasien</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
            
              <form method="POST" action="" >
             
                 <div class="card-body">
                    <div class="form-group">
                      <label for="nama_pasien">Nama Pasien</label>
                      <input type="text" class="form-control" id="nama_pasien" name="nama_pasien" placeholder="Nama Pasien" required value="<?php echo $pasiens['nama_pasien']; ?>">
                    </div>
                    <div class="form-group">
                      <label for="tgl_periksa">Tanggal Periksa</label>
                      <input type="datetime-local" class="form-control" id="tgl_periksa" name="tgl_periksa" placeholder="Tanggal Periksa">
                    </div>
                    <div class="form-group">
                      <label for="catatan">Catatan</label>
                      <input type="text" class="form-control" id="catatan" name="catatan" placeholder="Catatan" required >
                    </div>
                    
                    <div class="form-group">
                      <label for="nama_pasien">Obat</label>
                      <select class="form-control" style="width: 100%;" name="obat[]" multiple id="id_obat"  >
                          <?php foreach ($obat as $obats):?>
                              <option value="<?= $obats['id']; ?>|<?= $obats['harga']?>"><?= $obats['nama_obat']; ?> - <?= $obats['kemasan']; ?> - <?= number_format($obats['harga']);?></option>
                          <?php endforeach;?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="harga">Total Harga</label>
                      <input type="text" class="form-control" id="harga" name="harga" readonly>
                    </div>
                  
                   <!-- /.card-body -->

                    <div class="d-flex justify-content-end">
                      <button type="submit" class="btn btn-primary" id="simpan_periksa" name="simpan_periksa">
                      <i class="fa fa-save"></i>Simpan</button>
                    </div>
                 </div>
              </form>
              <?php
                  if (isset($_POST['simpan_periksa'])){
                    $tgl_periksa = $_POST['tgl_periksa'];
                    $catatan = $_POST['catatan'];
                    $obat = $_POST['obat'];
                    $id_daftar_poli = $pasiens['id_daftar_poli'];
                    $id_obat = [];
                    for($i = 0; $i < count($obat); $i++){
                        $data_obat = explode("|", $obat[$i]);
                        $id_obat[] = $data_obat[0];
                        $total_biaya_obat += $data_obat[1];
                    }
                    $total_biaya = $biaya_periksa + $total_biaya_obat;

                    $query = "INSERT INTO periksa(id_daftar_poli, tgl_periksa, catatan, biaya_periksa) VALUES
                            ('$id_daftar_poli', '$tgl_periksa', '$catatan', '$total_biaya' )";
                    $result = mysqli_query($koneksi, $query);

                    $query2 = "INSERT INTO detail_periksa (id_obat, id_periksa) VALUES ";
                    $periksa_id = mysqli_insert_id($koneksi);
                    for ($i = 0; $i < count($id_obat); $i++){
                        $query2 .= "($id_obat[$i], $periksa_id),";
                    }
                    $query2 = substr($query2, 0, -1);
                    $result2 = mysqli_query($koneksi, $query2);

                    $query3 = "UPDATE daftar_poli SET status_periksa = '1'
                                WHERE id = $id_daftar_poli";
                    $result3 = mysqli_query($koneksi, $query3);

                    if($result && $result2 && $result3){
                        echo "
                        <script>
                            alert('Data berhasil diubah');
                            document.location.href = 'memeriksa.php';
                        </script>
                        ";
                    }
                  }
                ?>
              </div>
              </div>
            </div>
          </div>
          
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    
</div>


