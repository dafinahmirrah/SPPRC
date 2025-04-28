<?php include ('inc_header.php');

$username = $nama = $password = $nohp = $email = $error = "";

if(isset($_POST['username'])&&isset($_POST['password'])){

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $nama = $_POST['nama'];
    $nohp = $_POST['nohp'];
    $email = $_POST['email'];
    
    if(preg_match('/[^a-zA-Z0-9]+/', $username)){
        $error.="Username tidak boleh menggunakan simbol.";
    }

    if(empty($nama)|| empty($username) || empty($password)){
        $error.="Sila isi semua ruang di borang pendaftaran.";
    }

    $id_lenght = strlen($username);
    if($id_lenght>15){
        $error.= "Username terlalu panjang. Maksima 15 aksara.";
    }

    if($id_lenght<4){
        $error.="Username terlalu pendek. Minima 4 aksara.";
    }

    $password_lenght = strlen($password);
    if($password_lenght<6){
        $error.="Katalaluan terlalu pendek. Minima 6 aksara.";
    }

    $sql = "SELECT * FROM pengguna WHERE username='$username' LIMIT 1";
    $result = query($db,$sql);
    
    if(mysqli_num_rows($result)>0){
        $error.= "Username($username)sudah digunakan,sila pilih Username berbeza.";
    }

    if(empty($error)){
        $sql = "INSERT INTO pengguna (username, password, nama, nohp, email, level)
        VALUES ('$username', '$password', '$nama', '$nohp', '$email', 'user')";

        $result = query($db,$sql);

        exit("<script>alert('Pendaftaran berjaya. Sila Log Masuk menggunakan Username ($username).');
        window.location.replace('login.php');</script>");
    }else{
        echo "<script>alert('$error');</script>";
    }
}
?>

<h2>Daftar Akaun</h2>
<form method="POST" action="signup.php" class="w-50 m-auto">

<div class="mb-3">
    <label class="form-label mt-2">Username</label>
    <input class="form-control" type="text" name="username"
    data-bs-toggle="tooltip" data-bs-placement="top"
    title="Username untuk log masuk sistem."
    value='<?php echo $username;?>'required>
    </div>

    <div class="mb-3">
    <label class="form-label mt-2">Katalaluan</label>
    <input class="form-control" type="password" name="password" value=''required>
    </div>

    <div class="mb-3">
    <label class="form-label">Nama</label>
    <input class="form-control" type="text" name="nama" value='<?php echo $nama;?>'required>
    </div>

    <div class="mb-3"
    <label class="form-label mt-2">No.Telefon</label>
    <input class="form-control" type="text" name="nohp" value='<?php echo $nohp;?>'required>
    </div>

    <div class="mb-3"
    <label class="form-label mt-2">Email</label>
    <input class="form-control" type="text" name="email" value='<?php echo $email;?>'required>
    </div>

    <div class="d-grid gap-2">
    <button class= "btn btn-success d-block" type="submit">Daftar</button>
    </div>
    </form>
    <?php include('inc_footer.php');?>