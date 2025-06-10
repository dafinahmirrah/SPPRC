<?php include('inc_header.php');
$username = $password = "";

if(isset($_POST['username'])&& isset($_POST['password'])){

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM pengguna
    WHERE username='$username' AND password='$password' LIMIT 1";
    $result = query($db,$sql);

    if(mysqli_num_rows($result)>0){
        $row = mysqli_fetch_array($result);
        $_SESSION['idpengguna'] = $row['idpengguna'];
        $_SESSION['nama'] = $row['nama'];
        $_SESSION['level']= $row['level'];

        exit("<script>alert('Log Masuk berjaya.');window.location.replace('index.php');</script>");
    }else{
        echo "<script>alert('Log Masuk gagal. Akaun pengguna tidak ditemui.');</script>";
    }
}
?>
<h2>Log Masuk.</h2>
<form method="POST" action="login.php" class="w-50 m-auto">
    <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" class="form-control" name="username" value="<?=$username?>" required>
</div>
<div class="mb-3">
    <label class="form-label">Password</label>
    <input type="password" class="form-control" name="password" value="" required>
</div>
<div class="d-grid gap-2">
    <button class="btn btn-primary d-block" type="submit">Log Masuk</button>
</div>
</form>
<?php include('inc_footer.php'); ?>
