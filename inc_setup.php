<?php 
$nama_sistem = "Sistem Pengurusan Pesanan Rina's Corner";

# Maklumat pangkalan data
$dbname = "spprc"; 
$dbuser = "root";
$dbpass = "";
$dbhost = "localhost";
# Buka sambungan ke pengkalan data 
$db = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) OR exit(mysqli_connect_error());

# Pastikan sama dengan nama folder untuk imej yang dalam folder projek
$image_folder = "images";

//nilai cukai dalam perpuluhan: 6% = 0.06
$cukai = 0.06;

# Senarai label meja di premis
$meja_list = array(
  'Bungkus',
  'Meja 1', 
  'Meja 2', 
  'Meja 3', 
  'Meja 4', 
  'Meja 5', 
  'Meja 6',
);


# function kembalikan label status pesanan
function semakstatus($status){

  if($status == 'ready'){
    return 'Siap';

  }elseif($status == 'pending'){
    return 'Sedang Disiapkan';

  }elseif($status == 'cancel'){
    return 'Dibatalkan';

  }elseif($status == 'paid'){
    return 'Sudah Dibayar';
  }else{
    return $status;
  }
}

# Session dimulakan
session_start();
// session simpan item dalam cart
if(!isset($_SESSION['cart'])){
  $_SESSION['cart'] = array();
}
$cart = $_SESSION['cart'];

// session simpan level pengguna
if(isset($_SESSION['level'])){
  $level = $_SESSION['level'];
}else{
  $level = $_SESSION['level'] = 'guest';
}

# function semak level pengguna dan tahap kebenaran akses
function semaklevel($akses){
  $level = $_SESSION['level'];
  $error = "";
 
  if($level == 'guest'){ 
    $error = 'Anda perlu log masuk untuk akses halaman ini.';
  }elseif($level == 'user'  &&  $akses == 'admin'){
   $error = 'Hanya akaun Admin boleh mengakses halaman ini.';
  }elseif($level == 'admin'  &&  $akses == 'user'){
   $error = 'Hanya akaun Pengguna biasa boleh mengakses halaman ini.';
  }
 
  if(!empty($error)){
   echo "<script> alert('$error'); window.location.replace('index.php'); </script>";
   exit();
  }
 }

// JANGAN EDIT Kod di bawah. Function ini untuk paparkan ralat MySQLi
function query($db, $sql = ''){
  try{ 
    $result = mysqli_query($db, $sql); 
  } catch (Exception $e) {
    $er = $e->getTrace()[1]; 
    $text = $e->getMessage();
    $file = $er['file']; 
    $line = $er['line']; 
    $url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $debugger = "https://sk.jomgeek.com/debugger?msg=".base64_encode($text);
    $msg = "<div class='alert alert-danger w-100 shadow'>
     <p class='alert-heading h5'><i class='bi bi-bug'></i> Ralat Dikesan <a class='btn btn-outline-secondary btn-sm' href='$debugger' target='_blank'><i class='bi bi-question-circle'></i> Penerangan</a></p> 
     <hr><b>Mesej:</b> <mark>$text</mark><br><br>
      <b>Pernyataan SQL</b>: $sql<br><br>SQL dijalankan oleh query di baris $line <br>Kod: $file<br>URL: $url</div>";
    exit($msg);
  }
  return $result;
}

// session simpan saiz font
if(!isset($_SESSION['saizfont'])){
  $_SESSION['saizfont'] = 100;
}
$saizfont = $_SESSION['saizfont'];

// session simpan jenis font
if(!isset($_SESSION['jenisfont'])){
  $_SESSION['jenisfont'] = 'Arial';
}
$jenisfont = $_SESSION['jenisfont'];

// session simpan jenis font
if(!isset($_SESSION['cursor'])){
  $_SESSION['cursor'] = "";
}
$cursor = $_SESSION['cursor'];

# set timezone Malaysia untuk sistem
date_default_timezone_set('Asia/Kuala_Lumpur');
?> 