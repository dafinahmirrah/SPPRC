<?php include('inc_header.php');
if( isset($_GET['iditem']) && isset($_GET['action']) ) {
    // $iditem = $_GET['iditem'];
    $iditem = trim($_GET['iditem']); //updated version from above line
    $action = $_GET['action'];
    if($action == 'add'){
        $sql = "SELECT * FROM item WHERE iditem = $iditem AND status_item!='habis'";
        $result = query($db,$sql);
        if(mysqli_num_rows($result) > 0){
            if(isset($cart[$iditem])){
                $cart[$iditem] += 1;
            }else{
                $cart[$iditem] = 1;
                echo "<script> alert('Item berjaya ditambah ke dalam Cart.');</script>";
            }
        }else{
            exit("<script> alert('Sila pilih item yang lain.'); window.history.go(-1);</script>");
        }
    }elseif($action == 'minus'){
        $cart[$iditem] -= 1;
        if($cart[$iditem] <= 0){
            unset($cart[$iditem]);
            echo "<script>alert('Item dibuang dari Cart.');</script>";
        }
    }
    $_SESSION['cart'] = $cart;
    echo "<script>window.location.replace('cart.php'); </script>"; } ?>
<h2>Bakul Pesanan</h2>
<section class="h-100 h-custom"> 
    <div class="card shadow-2-strong mb-5 mb-lg-0" style="border-radius: 16px;"> 
        <div class="row card-body p-4"> <div class="col"> 
            <?php
            if( !empty($cart) ) {
                $all_iditem = implode(',', array_keys($cart));
                $sql = "SELECT * FROM item WHERE iditem IN ($all_iditem)";
                $result = query($db,$sql);
                ?>
                <div class="table-responsive mb-2"> <table class="table"> <thead> 
                    <tr> <th class="h5">Item</th> <th>Kuantiti</th> <th class="text-end">Jumlah</th> </tr>
            </thead> 
            <tbody>
                <?php
                $subtotal = 0;
                while($row = mysqli_fetch_array($result) ) {

                    // $iditem = $row['iditem'];
                    $iditem = trim($row['iditem']); //updated version from above
                    $namaitem = $row['namaitem'];
                    $harga = $row['harga'];
                    // $kuantiti = $cart[$row['iditem']];
                    $kuantiti = isset($cart[$iditem]) ? $cart[$iditem] : 0; //updated version from above

                    $item_total = $harga * $kuantiti;
                    $subtotal += $item_total;

                    $imej = $row['imej'];
                    if(!empty($imej)){
                        $img = $image_folder.'/'.$imej;
                    }else{
                        $img = $image_folder.'/item_placeholder.jpg';
                    }
                    echo "<tr> <th scope='row' class='border-bottom-0'>
                    <div class='d-flex align-items-center'>
                    <img src='$img' class='img-fluid rounded-3' style='width: 120px;' alt='Imej'>
                    <div class='flex-column ms-4'>
                    <p class='mb-2'>$namaitem</p> <p class='mb-0'>RM $harga</p>
                    </div>
                    </div>
                    </th>
                    <td class='align-middle border-bottom-0'>
                    <div class ='d-flex flex-row'>
                    <a href='?iditem=$iditem&action=minus'><i class='bi bi-dash-circle'></i></a>
                    &nbsp;<span class='btn btn-outline-primary btn-sm'>$kuantiti</span> &nbsp;
                    <a href='?iditem=$iditem&action=add'><i class='bi bi-plus-circle'></i></a>
                    </div>
                    </td>
                    <td class='text-end align-middle border-bottom-0'>
                    <p class='mb-0' style='font-weight:500;'> RM".number_format($item_total,2)."</p>
                    </td> </tr>";
                }
                    $jumlah_cukai = $subtotal * $cukai;
                    $final = $subtotal + $jumlah_cukai;
                    ?>
                    </tbody> </table> </div>

                    <div class="row">
                    <div class="col-md-6 mb-4 mb-md-0 order-2 order-sm-2 order-md-1">
                    <form action ="checkout.php" method="POST">
                    <div class="mb-3">
                    <label class="form-label">Take-away / Dine-in :</label>
                    <select class="form-select" name="meja" required title="Sila pilih bungkus atau nombor meja."
                    data-bs-toggle="tooltip" data-bs-placement="top">
                    <option disabled selected value></option>
                    <?php foreach ($meja_list as $value) { echo "<option value='$value'>$value</option>"; } ?>
                    </select> </div>
                    
                    <div class="mb-3"> <label class="form-label">Nota / Remark:</label>
                    <textarea class="form-control" name="nota" rows="3"
                    placeholder="Nota tambahan pesanan anda"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">
                    <div class="d-flex justify-content-between"> <span>Hantar Pesanan</span> </div>
                    </button>
            </form>
            </div>
            <div class="col-md-6 order-md-2 order-1 order-md-2"> 
                <div class="d-flex justify-content-between" style="font-weight:500;"> 
                    <p class="mb-2">Subtotal</p><p class="mb-2"> RM <?=number_format($subtotal,2)?> </p>
                </div> 
                <div class="d-flex justify-content-between" style="font-weight:500;"> 
                    <p class="mb-0">Cukai(6%)</p><p class="mb-0"> RM <?=number_format($jumlah_cukai,2)?></p>
                </div> 
                <hr class="my-4"> 
                <div class="d-flex justify-content-between mb-4" style="font-weight:500;"> 
                    <p class="mb-2">Final</p> <p class="mb-2"> RM <?=number_format($final,2)?></p>
                </div> 
            </div> 
                    </div> 

                    <?php }else{ echo 'Cart masih kosong. Sila layari halaman Menu untuk buat pilihan.'; } ?>
                    </div> </div> </div> </section>
                    <?php include('inc_footer.php'); ?>