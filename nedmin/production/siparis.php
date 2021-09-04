<?php 

include 'header.php'; 

//Belirli veriyi seçme işlemi
$siparissor=$db->prepare("SELECT * FROM siparis");
$siparissor->execute();


?>


<!-- page content -->
<div class="right_col" role="main">
  <div class="">

    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Sipariş Listeleme <small>,

              <?php 
              if(isset($_GET['durum'])){
                if ($_GET['durum']=="ok") {?>

                  <b style="color:green;">İşlem Başarılı...</b>

                <?php } elseif ($_GET['durum']=="no") {?>

                  <b style="color:red;">İşlem Başarısız...</b>

                <?php }
              }
              ?>


            </small></h2>

            <div class="clearfix"></div>

            <div align="right">
             

            </div>
          </div>
          <div class="x_content">


            <!-- Div İçerik Başlangıç -->

            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>S.No</th>
                  <th>Ad Soyad</th>
                  <th>Sipariş id</th>
                  <th>Sipariş Zaman</th>
                  <th>Sipariş Toplam Fiyat</th>
                  <th>Sipariş Tip</th>
                  <th>Sipariş Banka</th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>

              <tbody>

                <?php 

                $say=0;

                while($sipariscek=$siparissor->fetch(PDO::FETCH_ASSOC)) { $say++; ?>
                  <?php 
                  $kullanici_id = $sipariscek['kullanici_id'];
                  $kullanicisor=$db->prepare("SELECT * FROM kullanici where kullanici_id=:id");
                  $kullanicisor->execute(array(
                    'id' => $kullanici_id
                  ));
                  $kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC); 
 ?>
                  <tr>
                   <td width="20"><?php echo $say ?></td>
                   <td><?php echo @$kullanicicek['kullanici_adsoyad'] ?></td>
                   <td><?php echo $sipariscek['siparis_id'] ?></td>
                   <td><?php echo $sipariscek['siparis_zaman'] ?></td>
                   <td><?php echo $sipariscek['siparis_toplam'] ?> ₺</td>
                   <td><?php echo $sipariscek['siparis_tip'] ?></td>
                   <td><?php echo $sipariscek['siparis_banka'] ?></td>




                   <td><center><a href="siparis-detay.php?siparis_id=<?php echo $sipariscek['siparis_id']; ?>"><button class="btn btn-primary btn-xs">Göster</button></a></center></td>
                   <td><center><a href="../netting/islem.php?siparis_id=<?php echo $sipariscek['siparis_id']; ?>&siparissil=ok"><button class="btn btn-danger btn-xs">Sil</button></a></center></td>
                 </tr>



               <?php  }

               ?>


             </tbody>
           </table>

           <!-- Div İçerik Bitişi -->


         </div>
       </div>
     </div>
   </div>




 </div>
</div>
<!-- /page content -->

<?php include 'footer.php'; ?>
