<?php include('inc_header.php');
semaklevel('admin');
$username = $password = $nama = $nohp = $email = $level = "";
$edit_data = 0;

if(isset($_GET['delete'])){
    $idpengguna = $_GET['delete'];
    $sql = "DELETE FROM pengguna WHERE idpengguna = '$idpengguna' ";
    $result = query($db, $sql);
    echo "<script> alert('Akaun pengguna berjaya dibuang.');
    window.location.replace('admin_pengguna_senarai.php'); </script>"; exit();
}
if(isset($_GET['idpengguna'])){

    $idpengguna = (int)$_GET['idpengguna'];
    $sql = "SELECT * FROM pengguna WHERE idpengguna = $idpengguna LIMIT 1";
    $result = query($db,$sql);
    if(mysqli_num_rows($result) >0){
        $edit_data = mysqli_fetch_array($result);

        $username = $edit_data['username'];
        $password = $edit_data['password'];
        $nama = $edit_data['nama'];
        $nohp = $edit_data['nohp'];
        $email = $edit_data['email'];
        $level = $edit_data['level'];
    }else{
        echo "<script>alert('ID tidak ditemui.'); </script>";
    }
}
if(isset($_POST['username'])){

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $nama = $_POST['nama'];
    $nohp = $_POST['nohp'];
    $email = $_POST['email'];
    $level = $_POST['level'];

    if($edit_data){
        $sql = "UPDATE IGNORE pengguna SET username='$username', password='$password',
        nama='$nama', nohp='$nohp', email='$email', level='$level' WHERE idpengguna=$idpengguna";
    }else{
        $sql = "INSERT IGNORE INTO pengguna (username, password, nama, nohp, email, level)
        VALUES ('$username','$password', '$nama', '$nohp', '$email', '$level')";
    }
    $result = query($db,$sql);

    echo"<script> alert('Berjaya disimpan.');
    window.location.replace('admin_pengguna_senarai.php'); </script>";
}
?>

<div class="row"> 
    <div class="col"><h2>Borang Pengguna</h2></div>
    <?php
    if($edit_data && $level!='admin'){
        echo "<div class='col text-end'>
        <a class='btn btn-sm btn-danger' onclick='deletethis($idpengguna)'>
        <i class='bi bi-trash'></i>Buang Akaun Pengguna</a></div>";
    }
    ?>
    </div>

    <form method="POST" action="">
        <p><label>Username</label><br>
        <input type='text' name='username' value='<?php echo $username; ?>' required><br>
</p>
<p><label>Katalaluan</label><br>
<input type='password' name='password' value='<?php echo $password; ?>' required><br>
</p>
<p><label>Nama</label><br>
<input type='text' name='nama' value='<?php echo $nama; ?>' required><br>
</p>
<p><label>No HP</label><br>
<input type='text' name='nohp' value='<?php echo $nohp; ?>' required><br>
</p>
<p><label>Email</label><br>
<input type='text' name='email' value='<?php echo $email; ?>' required><br>
</p>
<p>
    <label>Level</label><br>
    <select name='level'> 
        <option <?=$level=='user'?'selected':''?> value='user'>Pengguna</option>
        <option <?=$level=='admin'?'selected':''?> value='admin'>Admin</option>
    </select>
</p>

</p>
<p> <input type="submit" value="Simpan"></p>
</form>
<?php include('inc_footer.php'); ?>