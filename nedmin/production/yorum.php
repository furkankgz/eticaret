<?php 

include 'header.php'; 

//Belirli veriyi seçme işlemi
$yorumsor=$db->prepare("SELECT * FROM yorumlar order by yorum_onay ASC");
$yorumsor->execute(array());


?>


<!-- page content -->
<div class="right_col" role="main">
  <div class="">

    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Yorum Listeleme <small>,

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
          </div>
          <div class="x_content">


            <!-- Div İçerik Başlangıç -->

            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>S.No</th>
                  <th>Kullanıcı Ad</th>
                  <th>Ürün Ad</th>
                  <th>Yorum Detay</th>
                  <th>Yorum Zamanı</th>
                  <th>Onayla</th>
                </tr>
              </thead>

              <tbody>

                <?php 

                $say=0;

                while($yorumcek=$yorumsor->fetch(PDO::FETCH_ASSOC)) { $say++?>
                  <?php 
                  $ykullanici_id = $yorumcek['kullanici_id'];
                  $ykullanicisor=$db->prepare("SELECT * FROM kullanici where kullanici_id=:id");
                  $ykullanicisor->execute(array(
                    'id' => $ykullanici_id
                  ));
                  $ykullanicicek=$ykullanicisor->fetch(PDO::FETCH_ASSOC);
                  ?>


                  <tr>
                   <td width="20"><?php echo $say ?></td>
                   <td><?php echo $ykullanicicek['kullanici_adsoyad'] ?></td>
                   <td><?php
                   $urun_id=$yorumcek['urun_id'];

                   $urunsor=$db->prepare("SELECT * FROM urun where urun_id=:id");
                   $urunsor->execute(array(
                    'id' => $urun_id
                  ));

                   $uruncek=$urunsor->fetch(PDO::FETCH_ASSOC);
                   echo $uruncek['urun_ad'];
                   ?></td>
                   <td><?php echo $yorumcek['yorum_detay'] ?></td>
                   <td><?php echo $yorumcek['yorum_zaman'] ?></td>
                   <td><center><?php 
                   if ($yorumcek['yorum_onay']==0) { ?>
                    <a href="../netting/islem.php?yorum_id=<?php echo $yorumcek['yorum_id'] ?>&onay=1&yorum_onay=ok"><button class="btn btn-success btn-xs">Onayla</button></a>
                  <?php } elseif($yorumcek['yorum_onay']==1) { ?>
                    <a href="../netting/islem.php?yorum_id=<?php echo $yorumcek['yorum_id'] ?>&onay=0&yorum_onay=ok"><button class="btn btn-warning btn-xs">Kaldır</button></a>
                    <?php } ?></center></td>


                    <td><center><a href="yorum-duzenle.php?yorum_id=<?php echo $yorumcek['yorum_id']; ?>"><button class="btn btn-primary btn-xs">Düzenle</button></a></center></td>
                    <td><center><a href="../netting/islem.php?yorum_id=<?php echo $yorumcek['yorum_id']; ?>&yorumsil=ok"><button class="btn btn-danger btn-xs">Sil</button></a></center></td>
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
