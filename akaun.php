<?php include('inc_header.php');
semaklevel('user-admin');

if($level == 'user'){
    $idpengguna = $_SESSION['idpengguna'];
}elseif(isset($_GET['idpengguna'])){
    $idpengguna = $_GET['idpengguna'];
}else{
    echo"<script>alert('Parameter tidak lengkap.');
    window.location.replace('admin_pengguna_senarai.php'); </script>";
}
$sql = "SELECT * FROM pengguna WHERE idpengguna = $idpengguna LIMIT 1";
$result = query($db,$sql);
if(mysqli_num_rows($result)>0){
    $row = mysqli_fetch_array($result);

    $nama = $row['nama'];
    $username = $row['username'];
    $nohp = $row['nohp'];
    $email = $row['email'];
}else{
    exit("Maklumat pengguna tidak ditemui.");
}
echo "<h2>Akaun : $nama</h2>";
echo "<p>$username, $nohp, $email</p>";

$sql = "SELECT pe.*, SUM(pi.kuantiti) AS kuantiti FROM pesanan AS pe
JOIN pesanan_item AS pi ON pe.idpesanan = pi.idpesanan
WHERE pe.idpengguna = $idpengguna
GROUP BY pe.idpesanan ORDER BY masa DESC;";

$result = query($db,$sql);

$total = mysqli_num_rows($result);
if($total > 0){

    echo "Senarai Pesanan: $total<br>";
    echo "<table class='table table-striped table-sm' border='1' cellspacing='0'>
    <tr> <th width='20'>No.</th>Tarikh</th> <th class='text-center'>Status</th>
    <th>Pesanan</th> </tr>";

    $counter = 1;

    while( $row = mysqli_fetch_array($result) ) {

        $idpesanan = $row['idpesanan'];
        $kuantiti = $row['kuantiti'];
        $masa = date("j M Y, g:i A", strtotime($row['masa']));
        $status_pesanan = semakstatus($row['status_pesanan']);

        echo "<tr>
        <td>$counter</td> <td>$masa : $kuantiti item</td>
        <td class='text-center'>$status_pesanan</td>
        <td><a class='btn btn-sm btn-outline-info' href='order.php?idpesanan=$idpesanan'>Lihat</a></td>
        </tr>";
        $counter = $counter + 1;
    }
    echo "</table>";
}else{
    echo "Belum ada rekod pesanan.";
}
include('inc_footer.php'); ?>