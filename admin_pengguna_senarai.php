<?php include('inc_header.php');semaklevel('admin');

$keyword = $q = $susunan = "";
$order_by = 'p.nama ASC';

if(isset($_POST['search'])){
    $keyword = $_POST['keyword'];
    if(!empty($keyword)){
        $q.= "WHERE p.nama LIKE '%$keyword%' ";
    }

    if(isset($_POST['susunan'])){
        $susunan = $_POST['susunan'];
        if($susunan == 'menaik'){
            $order_by= 'jumlahpesanan ASC';
        }elseif($susunan == 'menurun'){
            $order_by = 'jumlahpesanan DESC';
        }
    } 
}
?>

<h2>Urus Pengguna</h2>
<form method="POST" action=""> 
    <div class="row">
    <div class="col"> <div class="input-group">
    <input class="form-control" type='text' name='keyword'
    value='<?php echo $keyword; ?>' placeholder='Nama Pengguna'>
    <input class="btn btn-outline-secondary" type='submit' name='search' value='Cari'> 
    <input class="btn btn-outline-secondary" type='submit' name='reset' value='Reset'> 
</div>
<div>
    Jumlah pesanan:
    <input class="form-check-input" type="radio" id="asc" name="susunan" value="menaik">
    <label class="form-check-label" for="asc">Menaik</label>
    <input class="form-check-input" type="radio" id="desc" name="susunan" value="menurun"> 
    <label class="form-check-label" for="desc">Menurun</label>
</div>
</div>

<div class="col text-end"> 
    <a class='btn btn-primary' href="admin_pengguna_borang.php">Tambah Pengguna Baru</a>
</div>
</div>
</form>
<hr>
<?php
$sql = "SELECT p.*, COUNT(pe.idpengguna) as jumlahpesanan FROM pengguna p
LEFT JOIN pesanan pe ON p.idpengguna = pe.idpengguna
$q
GROUP BY idpengguna ORDER BY $order_by";

$result = query($db, $sql);
$total = mysqli_num_rows($result);
if($total > 0){
    echo "Jumlah: $total<br>";
    ?>

    <table class='table table-striped table-sm' border='1' cellpadding='4' cellspacing='0'>
        <tr> 
            <th>Bil.</th> <th>Username</th> <th>Nama Pengguna</th> <th>No HP</th>
            <th>Email</th> <th>Jumlah Pesanan</th> <th class='text-right'>Tindakan</th>
</tr>
<?php
$counter = 0;
while($row = mysqli_fetch_array($result) ) {

    $counter +=1;
    $idpengguna = $row['idpengguna'];
    $username = $row['username'];
    $nama = $row['nama'];
    $nohp = $row['nohp'];
    $email = $row['email'];
    $jumlahpesanan = $row['jumlahpesanan'];

    echo"<tr> <td>$counter</td>
    <td>$username</td> <td>$nama</td> <td>$nohp</td> <td>$email</td>
    <td align='center'>$jumlahpesanan</td>
    <td align='right'>
    <a class='btn btn-sm btn-info' href='akaun.php?idpengguna=$idpengguna'>Laporan</a>
    <a class='btn btn-sm btn-info' href='admin_pengguna_borang.php?idpengguna=$idpengguna'  >
    Edit</a>
    </td> </tr>";
}
?>
</table>
<?php
}else{
    echo "Belum ada rekod pengguna.";
}
include ('inc_footer.php'); ?>