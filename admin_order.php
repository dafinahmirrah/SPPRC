<?php include('inc_header.php');
semaklevel('admin'); ?>
<div class="row"> <div class="col"> <h2>Urus Pesanan</h2></div> 
<div class='col text-end'> 
    <a class='btn btn-primary btn-sm' href='?pending'>Pending</a>
    <a class='btn btn-primary btn-sm' href='?all'>Semua</a>
</div></div>

<?php if(isset($_GET['all'])){
    $filter_status= '';
}else{
    $filter_status ="WHERE pe.status_pesanan = 'pending' ";
}
$sql = "SELECT pe.*, SUM(pi.kuantiti) AS kuantiti,
GROUP_CONCAT(i.namaitem ORDER BY i.iditem SEPARATOR ',') AS items
FROM pesanan AS pe
JOIN pesanan_item AS pi ON pe.idpesanan = pi.idpesanan
JOIN item AS i ON pi.iditem= i.iditem
$filter_status
GROUP BY pe.idpesanan ORDER BY idpesanan DESC; ";

$result = query($db, $sql);
$total = mysqli_num_rows($result);
if($total > 0){
    echo "Senarai Pesanan: $total<br>
    <table class='table table-striped table-sm' border='1' cellspacing='0'>
    <tr><th width='20'>No.</th> <th>Pesanan</th> <th>Status</th> <th>Check</th> </tr>";

    $counter = 1;
    $jumlahmata = 0;
    while($row = mysqli_fetch_array($result)){
        $idpesanan = $row['idpesanan'];
        $items= $row['items'];
        $kuantiti = $row['kuantiti'];
        $masa= date("j M Y, g:i A", strtotime($row['masa']));
        $status_pesanan = semakstatus($row['status_pesanan']);

        echo "<tr><td>$counter</td> <td>$masa: $kuantiti - $items</td>
        <td align='center'>$status_pesanan</td>
        <td><a class='btn btn-sm btn-outline-info' href='order.php?idpesanan=$idpesanan'>Lihat</a></td>
        </tr>";
        $counter = $counter + 1;
    }
    echo "</table>";
}else{ echo "Belum ada rekod pesanan."; }
include('inc_footer.php'); ?>