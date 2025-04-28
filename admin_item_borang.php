<?php include('inc_header.php');
semaklevel('admin');
$namaitem = $detail = $harga = $status_item = $imej = $idkategori = "";
$edit_data = 0;

if(isset($_GET['delete'])){
    $iditem = $_GET['delete'];
    $sql = "DELETE FROM item WHERE iditem = '$iditem' ";
    $result = query($db,$sql);
exit("<script>alert('Item telah dibuang.'); window.location.replace('item.php'); </script>" );
}
if(isset($_GET['iditem'])){
    $iditem = $_GET['iditem'];
    $sql = "SELECT * FROM item WHERE iditem = $iditem LIMIT 1";
    $result = query($db, $sql);

    if(mysqli_num_rows($result) >0){
        $edit_data = mysqli_fetch_array($result);
        $namaitem = $edit_data['namaitem'];
        $detail = $edit_data['detail'];
        $imej = $edit_data['imej'];
        $harga = $edit_data['harga'];
        $idkategori = $edit_data['idkategori'];
        $status_item = $edit_data['status_item'];
        }else{
            echo"<script>alert('Item tidak ditemui.'); window.location.replace('item.php');</script>";
        }
    }
    if(isset($_POST['namaitem']) && !empty($_POST['namaitem'] ) ) {
       
        $namaitem = mysqli_real_escape_string($db, $_POST['namaitem']);
        $detail = mysqli_real_escape_string($db, $_POST['detail']);
        $harga = $_POST['harga'];
        $idkategori = $_POST['idkategori'];
        $status_item = $_POST['status_item'];

        if(isset($_FILES['imej']) && file_exists($_FILES['imej']['tmp_name'])){
            $i = $_FILES['imej'];
            $file_ext = pathinfo($i['full_path'],PATHINFO_EXTENSION);
            
            $ext = array('jpeg','jpg','png','bmp','gif');
            if(in_array($file_ext, $ext)){
                $location = __DIR__ . '/'.$image_folder.'/';
                if(!empty($imej) && file_exists($location.$imej)){
                    unlink($location.$imej);
                }
                $newname = uniqid('item_').'.'.$file_ext;
                if(move_uploaded_file($i['tmp_name'], $location.$newname)){
                    $imej = $newname;
                }
            }
        }

        if($edit_data){
            $sql = "UPDATE item SET namaitem='$namaitem', detail='$detail', imej='$imej', 
            harga='$harga', idkategori='$idkategori', status_item='$status_item' WHERE iditem=$iditem";
        }else{
            $sql = "INSERT INTO item (namaitem, detail, imej, harga, idkategori, status_item)
            VALUES ('$namaitem', '$detail', '$imej', '$harga', '$idkategori', 'ada')";
        }
        $result = query($db, $sql);
        echo "<script>alert('Item berjaya disimpan.'); window.location.replace('item.php'); </script>";
    } ?>
    <div class="row"> <div class="col"><h2>Borang Item</h2></div>
    <?php if($edit_data){
        echo "<div class='col text-end'> <a class='btn btn-sm btn-danger' onclick='deletethis($iditem)'>
        <i class='bi bi-trash'></i>Buang Item</a> </div>";
    } ?>
    </div>

    <form class="form-group" method="POST" action="" enctype="multipart/form-data">
        <div class="row"> <div class="col-lg-8 col-sm-12"> 
            <div class="mb-2"> <label class="form-label">Nama Item/Menu</label><br>
            <input class="form-control bd-cyan-100" type='text' name='namaitem'
            value='<?php echo $namaitem;?>' required>
</div>
<div class="mb-2"> <label class="form-label">Maklumat Detail</label><br>
            <textarea class="form-control" type='text' name='detail' rows="2" cols="30"><?php echo $detail; 
            ?></textarea>
</div>
<div class="row g-3"> <div class="col"> <label class="form-label">Harga</label><br>
<input class="form-control" type='number' step='.01' name='harga'
value='<?php echo $harga; ?>'>
</div>
<div class="col"> <label class="form-label">Kategori</label><br>
<select class="form-control" name='idkategori' required>

<?php
$sql = "SELECT * FROM kategori";
$result = query($db,$sql);

while($row = mysqli_fetch_array($result)){
    $kategori = $row['idkategori'];
    $namakategori = $row['namakategori'];
    if($kategori == $idkategori){
        $selected = "selected";
    }else{
        $selected = "";
    }
    echo "<option $selected value='$kategori'>$namakategori</option>";
} ?>
</select>
</div>
<div class="col"> <label class="form-label">Status Item<span data-bs-toggle="tooltip"
data-bs-placement="top" title="Item status Istimewa akan dipaparkan di laman utama.">
<i class="bi bi-question-circle"></i> </span> </label><br>
<select class="form-control" name='status_item' required>
    <option <?=$status_item == 'ada' ? 'selected' :'' ?> value='ada'>Ada</option>
    <option <?=$status_item == 'istimewa' ? 'selected' :'' ?> value='istimewa'>Istimewa</option>
    <option <?=$status_item == 'habis' ? 'selected' :'' ?> value='habis'>Habis</option>
    </select>
    </div> </div> </div>
    <div class="col-lg-4 col-sm-12">
    <?php if(!empty($imej)){
    echo "<img src='$image_folder/$imej' class='border rounded' alt='Gambar Item' width='100%'>";
}else{
    echo "<img src='$image_folder/item_placeholder.jpg' class='border rounded' alt='Gambar Item' 
width='100%'>";
}
    ?>
    <p class="mt-2"><label for='gambar'>Muat-naik Gambar</label><br>
    <input class="form-control" type="file" name='imej' id='imej'> </p>
    </div>
    <p><button class="btn btn-block btn-info" type='submit' value='Simpan'>Simpan</button></p>
    </div>
    </form> <?php include('inc_footer.php'); ?>