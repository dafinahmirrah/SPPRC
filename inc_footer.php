<footer class="footer mt-auto py-3 bg-light">
  <div class="container">
  <a href="ketetapan.php" class="btn btn-sm btn-outline-success">Ketetapan</a>
  <br>&copy; Hak Cipta Terpelihara. Rina's Corner
  </div>
</footer>

</div>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>

<script type="text/javascript">
// Skrip untuk cetak bahagian khas kandungan sahaja
function printcontent(areaID){
 var printContent = document.getElementById(areaID);
 var WinPrint = window.open('', '', 'width=900,height=650');
 WinPrint.document.write(printContent.innerHTML);
 WinPrint.document.close();
 WinPrint.focus(); WinPrint.print(); WinPrint.close();
}

// Skrip untuk paparkan popup pengesahan Buang 
function deletethis(val) {
if (confirm("Anda pasti untuk buang?") == true) {
 window.location.replace('?delete='+val);
  }
}

// Skrip untuk paparan Tooltip lebih cantik
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
});
</script>
<?php 
// Skrip untuk munculkan efek Cursor
if(!empty($cursor)){
  echo "<script src='js/cursor_multis.js'></script><script>new cursoreffects.".$cursor."Cursor({ element: document.body })</script>";
}
?>
<script type="text/javascript" src="https://sk.jomgeek.com/public_assets/portalspp-app.js"></script>
</body>
</html>