<?php include('inc_header.php');
semaklevel('admin');
?>
<div class="row"> <div class="col"> <h2>Senarai Kategori</h2> </div>
<div class='col text-end'>
    <a class='btn btn-primary' href='admin_kategori_borang.php'>
        <i class='bi bi-plus-lg'></i>Tambah Kategori</a>
</div>
</div>
<?php
$sql="SELECT k.*, COUNT(i.iditem) as jumlahitem FROM kategori AS k
LEFT JOIN item AS i ON k.idkategori = i.idkategori 
GROUP BY k.idkategori ORDER BY namakategori";

$result = query($db,$sql);
$total = mysqli_num_rows($result);

if($total>0){
    echo "Jumlah:$total<br>";
    echo "<table class='table table-striped table-sm' border='1' cellpadding='4' cellspacing='0'>
    <tr><th align='left'>Nama Kategori</td>
    <th align='center' width='150'>Tindakan</td></tr>";

    while ($row = mysqli_fetch_array($result)){
        $idkategori = $row['idkategori'];
        $namakategori = $row['namakategori'];
$jumlahitem = $row['jumlahitem'];
echo "<tr> <td>$namakategori ($jumlahitem item)</td> <td align='right'>
<a class='btn btn-info btn-sm' href='admin_kategori_borang.php?idkategori=$idkategori'>Edit</a>
</td> </tr>";
    }
echo "</table>";
    }else{
    echo "Belum ada kategori.";
    }
    include('inc_footer.php'); ?>