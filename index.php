<?php include('inc_header.php'); ?>
<banner>
    <div class="p-4 mb-4 text-white rounded bg-dark text-center">
        <h1 class="display-4 fst-italic">Tasty Food For Every Mood</h1>
        <p class="text-light my-3">sekali cuba, pasti suka ⋆｡°✩ </p>
</div>
</banner>
<h2>Menu Istimewa</h2>
<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
    <?php
    $sql = "SELECT*FROM item WHERE status_item = 'istimewa' ORDER BY iditem DESC LIMIT 6";
    $result = query($db, $sql);

    if(mysqli_num_rows($result) > 0){

        while($row = mysqli_fetch_array($result)){
        $iditem = $row['iditem'];
        $namaitem = $row['namaitem'];
        $harga = $row['harga'];
        $imej = $row['imej'];

        if( !empty($imej) ){
            $img = $image_folder."/".$imej;
        }else{
            $img = $image_folder."/item_placeholder.jpg";
        }
        echo "<div class='col'> <div class='card shadow-sm'>
        <img src='$img' class='bd-placeholder-img card-img-top' width='100%' height='225'>
        <div class='card-body'>
        <div class='d-flex justify-content-between align-items-center'>$namaitem
        <a class='btn btn-success btn-sm' href='cart.php?iditem=$iditem&action=add'>
        <i class='bi bi-basket text-light'></i></a>
        </div></div>
        </div>
        </div>";
    }
}else{
    echo "<div class='col'>Belum ada menu istimewa dimasukkan.</div>";
}
    ?>
    </div>
    <div class="text-center border-bottom mt-4">
    <h5 class="fw-bold">Mmmm... sungguh menyelerakan.</h5>
    <a href="item.php" class="btn btn-primary btn-lg mt-4 mb-4">Semua Menu</a>
    </div>
    <?php include('inc_footer.php'); ?>