<?php include('inc_header.php');
semaklevel('admin');
$edit_data = 0;
$namakategori = "";

if(isset($_GET['delete'])){
    $idkategori = $_GET['delete'];
    $sql = "DELETE FROM kategori WHERE idkategori = $idkategori";
    $result = query($db,$sql);

    exit("<script> alert('Kategori berjaya dibuang.');
    window.location.replace('admin_kategori_senarai.php');</script>");
}

if(isset($_GET['idkategori'])){
    $idkategori = (int)$_GET['idkategori'];

    $sql = "SELECT * FROM kategori WHERE idkategori = $idkategori LIMIT 1";
    $result = query($db,$sql);

    if(mysqli_num_rows($result)>0){
        $edit_data = mysqli_fetch_array($result);
        $namakategori = $edit_data['namakategori'];
    }else{
        echo "<script>alert('ID tidak ditemui.');</script>";
    }
}
if(isset($_POST['namakategori'])&&!empty($_POST['namakategori'])){
    $namakategori = mysqli_real_escape_string($db,$_POST['namakategori']);

    if($edit_data){
        $sql = "UPDATE IGNORE kategori SET namakategori ='namakategori'
        WHERE idkategori=$idkategori";
    }else{
        $sql = "INSERT IGNORE INTO kategori (namakategori) VALUES ('$namakategori')";
    }
    $result = query($db,$sql);
    echo "<script>alert('Berjaya disimpan.');
    window.location.replace('admin_kategori_senarai.php');</script>";
}
?>
<div class="row"> <div class="col"> <h2>Borang Kategori</h2> </div>
<?php 
if($edit_data){
    echo "<div class='col text-end'>
    <a class='btn btn-sm btn-danger' onclick='deletethis($idkategori)'>
    <i class='bi bi-trash'></i>Buang Kategori</a></div>";
}
?>
</div>
<form method="POST"action="">
    <p><label>Nama Kategori</label><br>
    <input type='text' name='namakategori' value='<?php echo $namakategori;?>'><br></p>
    <p><button class="btn btn-success" type="submit" value="Simpan">Simpan"</button></p>
</form>
<?php include('inc_footer.php'); ?>