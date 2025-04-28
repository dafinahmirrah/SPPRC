<?php include('inc_setup.php');
semaklevel('user-admin');

if(empty($cart)){
    exit("<script>alert('Bakul masih kosong'); window.location.replace('cart.php');</script>");
}
$nota = $_POST['nota'];
$meja = $_POST['meja'];
$idpengguna = $_SESSION['idpengguna'];

$sql = "INSERT INTO pesanan (idpengguna, nota, meja, status_pesanan)
VALUES ($idpengguna, '$nota', '$meja', 'pending')";
$result = query($db,$sql);
$idpesanan = mysqli_insert_id($db);

foreach ($cart as $iditem => $kuantiti) {
    $sql = "SELECT * FROM item WHERE iditem = $iditem AND status_item !='habis'";
    $result = query($db,$sql);

    $row = mysqli_fetch_array($result);
    $harga = $row['harga'];

    $sql ="INSERT INTO pesanan_item (idpesanan, iditem, harga, kuantiti)
    VALUES ($idpesanan, $iditem, $harga, $kuantiti)";
    $result = query($db,$sql);
}
$_SESSION['cart'] = array();
echo "<script> alert('Pesanan anda sudah dihantar. Terima Kasih.');
window.location.replace('akaun.php? idpengguna=$idpengguna');</script>";
?>