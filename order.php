<?php include('inc_header.php');
semaklevel('user-admin');
if(isset($_GET['idpesanan'])){
    $idpesanan = $_GET['idpesanan'];
}else{ exit("<script>alert('ID diperlukan.'); window.location.replace('index.php'); </script>"); }

$sql = "SELECT * FROM pesanan
LEFT JOIN pengguna on pengguna.idpengguna = pesanan.idpengguna
WHERE idpesanan = $idpesanan LIMIT 1";
$result = query($db,$sql);

if(mysqli_num_rows($result)>0){
    $row = mysqli_fetch_array($result);
    $idpengguna = $row['idpengguna'];
    $nama = $row['nama'];
    $nohp = $row['nohp'];
    $nota = $row['nota'];
    $meja = $row['meja'];
    $masa = date("j M Y , g:i A", strtotime($row['masa']));
    $status_pesanan = semakstatus($row['status_pesanan']);
}else{
    exit("<script>alert('ID Pesanan tidak wujud.');
    window.location.replace('index.php'); </script>");
}
if($level == 'user' && $idpengguna!=$_SESSION['idpengguna']){
    exit("<script>alert('Pesanan tidak wujud untuk akaun anda.');
    window.location.replace('akaun.php'); </script>");
}
if($level =='admin'){
    if(isset($_GET['status'])){
        $status=$_GET['status'];

        if(in_array($status,['ready', 'pending', 'paid', 'cancel'])){
            $sql = "UPDATE pesanan SET status_pesanan = '$status' WHERE idpesanan = $idpesanan";
            $result = query($db,$sql);
        }
        echo "<script> window.location.replace('order.php?idpesanan=$idpesanan'); </script>";
    } ?>
    <div class="row"> <div class="col text-center mb-4"> Tindakan :
        <a class="btn btn-success" href="?idpesanan=<?=$idpesanan?>&status=ready">
<i class="bi bi-check-circle"></i>Siap</a>
<a class="btn btn-sm btn-primary" href="?idpesanan=<?=$idpesanan?>&status=paid">Dibayar</a>
<a class="btn btn-sm btn-warning" href="?idpesanan=<?=$idpesanan?>&status=pending">Pending
</a>
<a class="btn btn-sm btn-danger" href="?idpesanan=<?=$idpesanan?>&status=cancel">Batal</a>
</div> </div> <?php } ?>
<div class='d-flex justify-content-center w-100 mb-2'> 
    <div class='card' id='kandungan'> <div class="card-header py-3 text-center"> 
<h4 class="my-0 fw-normal"><?=$status_pesanan?></h4> 
</div>
<div class='card-body mx-1'> <div class='container'> 
    <p class='my-2' style='font-size: 20px;'><?=$nama_sistem?></p>
    <div class='row'> <ul class='list-unstyled'> 
        <li>No.Pesanan : <?=$idpesanan?>(<?=$meja?>)</li>
        <li>Masa : <?=$masa?></li>
        <li>Pelanggan : <?=$nama?>(<?=$nohp?>)</li>
        <li class="mt-2"><b>Nota:</b> <?=$nota?></li>
</ul> <hr> </div>
<?php $sql = "SELECT pi.*, item.namaitem FROM pesanan_item AS pi
LEFT JOIN item on item.iditem = pi.iditem WHERE idpesanan = $idpesanan";
$result = query($db,$sql);
$subtotal = 0;
while($row = mysqli_fetch_array($result)){
    $namaitem = $row['namaitem'];
    $harga = $row['harga'];
    $kuantiti = $row['kuantiti'];
    $item_total = $harga * $kuantiti;
    $subtotal += $item_total;
    ?>
    <div class='row'> 
        <div class='col-10'> <p><?=$namaitem?>x<?=$kuantiti?></p> </div>
        <div class='col-2'> <p class='float-end'><?=number_format($item_total,2)?></p></div>
        <hr> </div>
<?php }
$jumlah_cukai = $subtotal * $cukai;
$final = $subtotal + $jumlah_cukai;
?>
<div class='row text-black'> <div class='col-xl-12'> <p class='text-end'> 
    Subtotal: RM<?=number_format($subtotal,2)?><br>
    Cukai: RM<?=number_format($jumlah_cukai,2)?>
</p> </div>
<hr style='border: 1px solid black;'>
<div class='col-xl-12 text-end'> 
    <p class='fw-bold'>Jumlah Akhir: RM<?=number_format($final,2)?></p>
</div>
<hr style='border: 1px solid black;'>
</div>
<div class='text-center'> <p>Terima Kasih! Sila datang lagi.</p>
<p><a class="btn btn-sm btn-primary" href='javascript:void(0);'
onclick='printcontent("kandungan")'>Cetak</a></p>
</div> </div> </div> </div> </div>
<?php include('inc_footer.php'); ?>