<?php
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "pasien_poli";

$koneksi = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if(!$koneksi){
    die("Koneksi Gagal");
}else{

}

// $pdo = new PDO('mysql:host=$db_host; db_name=pasien_poli;',$db_pass, $db_name); 

function query($query)
{
    global $koneksi;
    $result = mysqli_query($koneksi, $query);
    if (!$result) {
        die("Error in query: " . mysqli_error($koneksi));
    }
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }

    return $rows;
}

function daftarPoli($data)
{
    global $koneksi;
    try{
        $id_pasien = $data['id_pasien'];
        $id_jadwal = $data['id_jadwal'];
        $keluhan =$data['keluhan'];
        $no_antrian = getLatestNoAntrian($id_jadwal, $koneksi)+1;

        $query = "INSERT INTO daftar_poli (id_pasien, id_jadwal, keluhan, no_antrian) VALUES ( ?, ?, ?, ?)";

        $stmt = mysqli_prepare($koneksi, $query);
        if(!$stmt){
            die("Error Preparing statement: ".mysqli_error($koneksi));
        }
        mysqli_stmt_bind_param($stmt, 'iisi', $id_pasien, $id_jadwal, $keluhan, $no_antrian);

        if(mysqli_stmt_execute($stmt)){
            return mysqli_stmt_affected_rows($stmt);
        }else{
            echo "Error updating record :" . mysqli_error($koneksi);
            return -1;
        }
    } catch (\Exception $e){
        var_dump($e->getMessage());
    }
}

function getLatestNoAntrian($id_jadwal, $koneksi)
{
    $latestNoAntrian = mysqli_prepare($koneksi, "SELECT MAX(no_antrian) as max_no_antrian FROM daftar_poli WHERE id_jadwal = ?");
    mysqli_stmt_bind_param($latestNoAntrian, 'i', $id_jadwal);
    mysqli_stmt_execute($latestNoAntrian);
    mysqli_stmt_store_result($latestNoAntrian);
    // $latestNoAntrian->bindParam(':id_jadwal', $id_jadwal);
    // $latestNoAntrian->execute();

    mysqli_stmt_bind_result($latestNoAntrian, $max_no_antrian);
    mysqli_stmt_fetch($latestNoAntrian);

    // $row = $latestNoAntrian->fetch();
    // return $row['max_no_antrian'] ? $row['max_no_antrian'] : 0; 
    return $max_no_antrian ? $max_no_antrian : 0;
}
?>

