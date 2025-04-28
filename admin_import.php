<?php include('inc_header.php');
semaklevel('admin');
if(isset($_FILES["import"])){
if( !file_exists($_FILES['import']['tmp_name'])){
    echo "<script>alert('Sila pilih fail.'); window.location.replace('urus_import.php'); </script>";
}
$berjaya = $gagal = 0;
$file = fopen($_FILES["import"]["tmp_name"], 'rb');

while(($line = fgetcsv($file,50,",")) !==FALSE) {
    if(count($line) >=3){
        $username = trim($line[0]);
        $password = trim($line[1]);
        $nama = trim($line[2]);
        $nohp = isset($line[3]) ? trim($line[3]):"";
        $email = isset($line[4]) ? trim($line[4]):"";

        $sql = "INSERT IGNORE INTO pengguna (username, password, nama, nohp, email, level)
        VALUES ('$username', '$password', '$nama', '$nohp', '$email', 'user')";
        $result = query($db, $sql);
        if(mysqli_insert_id($db)){
            $berjaya +=1;
        }else{
            $gagal +=1;
        } } }
        $total = $berjaya + $gagal;
        fclose($file);
        echo "<script> alert('$total baris diproses. $berjaya rekod baru. $gagal rekod diabaikan.');
        window.location.replace('admin_import.php'); </script>";
    } ?>
    <h1 style="font-size:30px">Import Data Pengguna</h1>
    <form method="POST" action="" enctype="multipart/form-data"> 
        <p>
            <label for='import'>Pilih fail untuk di import (Format TXT atau CSV sahaja)</label><br>
            <input class="form-control" type="file" name='import' accept='.csv,.txt' required>
</p>
<p> <button class="btn btn-success" type="submit" value="submit">Import Data</button></p>
    </form>
    <?php include('inc_footer.php'); ?>