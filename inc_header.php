<?php include('inc_setup.php'); ?>
<!DOCTYPE html>
<html>
<head>
<title><?=$nama_sistem?></title>

<!-- imej icon di Title bar pelayar web -->
<link rel="icon" href="images/favicon.png" type="image/png" >

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- memanggil bootstrap framework dan library untuk icon -->
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/bootstrap-icons.min.css" rel="stylesheet">
<style> 
* { 
    font-family: <?=$jenisfont?>, Arial, Helvetica;
    font-size: <?=$saizfont?>% 
    color:rgb(0, 0, 0)
}

body{
    background-repeat: no-repeat; 
    background-size: cover;
    padding: 15px 0px 15px 0px;
    background-image: url('images/pic.jpg');
    background-color: #7dffcc;
}

/* Tambah jenis warna baru jika perlu */
.mybg-red { background-color: #ff3c2e !important; }
.mybg-purple { background-color: purple !important; }

input,textarea,select {
    background-color: #7dffcc !important;
    border: 2px solid #0c95fe;
    border-radius: 8px;
}
input:focus,textarea:focus {
    background-color: #add8e6 !important;
}
.wrapper {
    border-radius: 16px;
    background-color: #ffffff !important;
    max-width: 1000px;
    overflow: hidden;
    box-shadow: 0 1px 6px #222;
}
</style>
</head>
<body>
<div class="container wrapper min-vh-100 d-flex flex-column">

<header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">

    <img src="images/logo.jpg" height="100" class="d-flex me-lg-4 me-md-0 align-items-center text-decoration-none">
    <!-- <h1><?=$nama_sistem?></h1> -->

    <ul class="nav nav-pills mt-4">
        <li class="nav-item"><a href="index.php" class="btn btn-outline-success hover-success me-2">Utama</a></li>
        <li class='nav-item'><a href="item.php" class="btn btn-outline-success me-2">Menu</a></li>
        <li class='nav-item'><a href="cart.php" class="btn btn-outline-success me-2">
            Cart <?=!empty($cart) ? '['.array_sum($cart).']' : ''?></a>
        </li>
                <?php 
 if($level == 'user'){ 
  echo "<li class='nav-item'><a class='btn btn-outline-success me-2' href='akaun.php'>Akaun</a></li>";
 }
 if($level == 'admin'){ 
  echo "
  <li class='nav-item'><a class='btn btn-outline-success me-2' href='admin_order.php'>Urus Pesanan</a></li>
  <li class='nav-item'><a class='btn btn-outline-success me-2' href='admin_kategori_senarai.php'>Urus Kategori</a></li>
  <li class='nav-item'><a class='btn btn-outline-success me-2' href='admin_pengguna_senarai.php'>Urus Pengguna</a></li>
  <li class='nav-item'><a class='btn btn-outline-success me-2' href='admin_import.php'>Import</a></li>
  <li class='nav-item'><a class='btn btn-outline-success me-2' href='admin_laporan.php'>Laporan</a></li>
  ";
 } 
 if($level == 'guest'){ 
  echo "
  <li class='nav-item'><a class='btn btn-outline-danger me-2' href='login.php'>Log Masuk</a></li>
  <li class='nav-item'><a class='btn btn-outline-danger me-2' href='signup.php'>Daftar</a></li>";
 }else{
  echo "
  <li class='nav-item'><a class='btn btn-outline-danger me-2' href='logout.php'>Log Keluar</a></li>";
 } 
?>
</ul>
</header>