<?php include('inc_header.php');
semaklevel('admin');

if(isset($_POST['date_from']) && isset($_POST['date_to'])) {
    $date_from = $_POST['date_from'];
    $date_to = $_POST['date_to'];
}else{
    $date_from = date("Y-m-d", strtotime('-1 week'));
    $date_to = date("Y-m-d", strtotime('now'));
}
$range = "BETWEEN '$date_from' AND '$date_to' ";

$sql = "SELECT COUNT(pi.idpesanan) AS jumlah_item, SUM(pi.harga) AS jumlah_jualan,
(SELECT COUNT(DISTINCT idpesanan) FROM pesanan WHERE masa $range ) AS jumlah_pesanan
FROM pesanan p
JOIN pesanan_item pi ON p.idpesanan = pi.idpesanan
WHERE masa $range ";

$result = query($db,$sql);
$row = mysqli_fetch_array($result);

$jumlah_pesanan = $row['jumlah_pesanan'];
$jumlah_item = $row['jumlah_item'];
$jumlah_jualan = $row['jumlah_jualan'];

//Laporan Item Terlaris
$sql = "SELECT pi.iditem, i.namaitem, COUNT(pi.iditem) AS jumlah_terjual
FROM pesanan AS p
JOIN pesanan_item AS pi ON p.idpesanan = pi.idpesanan
JOIN item AS i ON i.iditem = pi.iditem
WHERE masa $range GROUP BY pi.iditem ORDER BY jumlah_terjual DESC";

$item_terlaris = query($db, $sql);
?>
<div id='kandungan' class="card card-body padding-4"> <h2>Laporan</h2> 
<form method='POST' action=""> 
    <div class="input-group gap-4" style="width: 100%"> 
        <label>Dari</label>
        <input class="form-control" type='date' name='date_from'
        value='<?php echo $date_from; ?>' placeholder='Dari' required>
        <label>Hingga</label>
        <input class="form-control" type='date' name='date_to'
        value='<?php echo $date_to; ?>' placeholder='Sehingga' required>
<button class ="btn btn-secondary" type='submit'>Cari</button>
    </div>
</form>

<br>
<div class="row"> 
    <div class="col-xl-4 col-sm-12"><div class="card card-body text-center shadow border-0"> 
        <span class="h6 text-sm d-block mb-2">Jumlah Pesanan</span>
        <span class="h3"><?=$jumlah_pesanan?></span>
        </div></div>

        <div class="col-xl-4 col-sm-12"><div class="card card-body text-center shadow border-0"> 
        <span class="h6 text-sm d-block mb-2">Item Terjual</span>
        <span class="h3"><?=$jumlah_item?></span>
        </div></div>

        <div class="col-xl-4 col-sm-12"><div class="card card-body text-center shadow border-0"> 
        <span class="h6 text-sm d-block mb-2">Nilai Jualan</span>
        <span class="h3">RM<?=$jumlah_jualan?></span>
        </div>
    </div>
</div>
<hr>
<h3>Item Terlaris / Best-sellers</h3>
<table class='table table-striped table-sm' border='1' cellpadding='4' cellspacing='0'> 
    <tr> <td>Nama Item</td> <td>Jumlah Terjual</td> </tr>
    <?php
    while($row = mysqli_fetch_array($item_terlaris) ) {
        echo "<tr> <td>".$row['namaitem']."</td> <td>".$row['jumlah_terjual']."</td> </tr>";
    }
        ?>
        </table>

        <p><a class="btn btn-sm btn-primary" href='javascript:void(0);'
        onclick='printcontent("kandungan")'>Cetak</a></p>
</div>
<?php include('inc_footer.php'); ?>

