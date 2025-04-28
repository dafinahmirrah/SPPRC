<?php include('inc_header.php');
$namamenu = $q = "";

if(isset($_GET['idkategori'])){
    $idkategori = strtolower($_GET['idkategori']);
    $q = "WHERE item.idkategori LIKE  '%$idkategori%' ";
}

if(isset($_POST['search'])){
    $namamenu = $_POST['namamenu'];
    if(!empty($namamenu)){
        $q = "WHERE item.namaitem LIKE '%$namamenu%' ";
    }
}
?>
<div class="row">
    <div class="col"> <h2>Semua Menu</h2> </div>
    <?php
    if($level == 'admin'){
        echo "<div class='col text-end'> <a class='btn btn-primary' href='admin_item_borang.php'>
        <i class='bi bi-plus-lg'></i>Tambah Item</a> </div>";
    }
    ?>
    </div>
    <form method='POST' action="">
        <div class="input-group" style="width: 100%"> 
            <input class="form-control" type='text' name='namamenu'
            value='<?php echo $namamenu; ?>' placeholder='Nama menu'>
            <button class="btn btn-outline-success" type='submit' name='search' value='Cari'>Cari</button>
            <button class="btn btn-outline-success" type='submit' name='reset' value='Reset'>Reset</button>
</div>
</form>
<hr>
<div class="row"> 
    <a class='btn btn-sm btn-outline-primary me-2 ms-2 col' href='?all'>Semua</a>
    <?php 
    $sql = "SELECT * FROM kategori";
    $result = query($db,$sql);

    while($row = mysqli_fetch_array($result) ) {
        $idkategori = $row['idkategori'];
        $namakategori = $row['namakategori'];
        echo "<a class='btn btn-sm btn-outline-primary me-2 col'
        href='?idkategori=$idkategori'>$namakategori</a>";
    }
    ?>
    </div> <hr>
    <div class="table-responsive"> 
        <table class="table"> <tbody> 

        <?php
        $sql = "SELECT item.*, kategori.namakategori FROM item
        LEFT JOIN kategori on item.idkategori = kategori.idkategori
        $q 
        ORDER BY namaitem ASC";

        $result = query($db,$sql);
        if(mysqli_num_rows($result)>0){

            while($row = mysqli_fetch_array($result) ) {

            $iditem = $row['iditem'];
            $namaitem = $row['namaitem'];
            $detail = $row['detail'];
            $harga = $row['harga'];

            if(!empty($row['namakategori'])){
                $label_kategori = $row['namakategori'];
            }else{
                $label_kategori ='(Tiada Kategori)';
            }

            $imej = $row['imej'];
            if(!empty($imej)){
                $img = $image_folder.'/'.$imej;
            }else{
                $img = $image_folder.'/item_placeholder.jpg';
            }

            if($row['status_item'] == 'habis'){
                $button_order = "Sold Out";
            }else{
                $button_order = "<a class='btn btn-success' href='cart.php? iditem=$iditem & action=add'>
                <i class='bi bi-basket text-light'></i>Order</a>";
            }

            if($level =='admin'){
            $button_edit = "<a class='link-success' href='admin_item_borang.php? iditem=$iditem'>Edit</a>";
        }else{
        $button_edit = "";
            }
            echo "<tr class='border-bottom-1'> <td>
            <div class='d-flex align-items-center'>
            <img src='$img' class='img-fluid rounded-3' style='width: 120px;' alt='Imej'>
            <div class='flex-column ms-4 align-top' style='height: 80px;'>
            <p class='mb-2'><strong>$namaitem</strong> $button_edit</p>
            <p class='d-none d-sm-inline'>$label_kategori<br> $detail</p>
            </div>
            </div>
            </td>
            <td class='text-end align-middle'> RM$harga</td>
            <td class='text-end align-middle'>
            <p class='mb-0' style='font-weight:500;'> $button_order</p>
            </td> </tr>";
        }
    }else{
        echo "Tiada item ditemui.";
    } ?>
    </tbody> </table> </div>
    <?php include('inc_footer.php'); ?>