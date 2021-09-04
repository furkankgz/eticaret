<?php 

include 'header.php'; 

@$siparis_id = $_GET['siparis_id'];
$siparisdetaysor=$db->prepare("SELECT * FROM siparis_detay where siparis_id=:id");
$siparisdetaysor->execute(array(
  'id' => $siparis_id
));



?>

<!-- page content -->
<div class="right_col" role="main">
  <div class="">

    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Sipariş Detayları <small>
            </small></h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="#">Settings 1</a>
                  </li>
                  <li><a href="#">Settings 2</a>
                  </li>
                </ul>
              </li>
              <li><a class="close-link"><i class="fa fa-close"></i></a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />
            <form action="" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
              <!-- / => en kök dizine çık ... ../ bir üst dizine çık -->
              <?php while($siparisdetaycek=$siparisdetaysor->fetch(PDO::FETCH_ASSOC)) {  ?>

                <div class="form-group">
                  <?php  
                  $urun_id = $siparisdetaycek['urun_id'];
                  $urunsor=$db->prepare("SELECT * FROM urun where urun_id=:id");
                  $urunsor->execute(array(
                    'id' => $urun_id
                  ));
                  $uruncek=$urunsor->fetch(PDO::FETCH_ASSOC); 
                  ?>
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ürün Ad <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="first-name" value="<?php echo $uruncek['urun_ad'] ?>" disabled="" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ürün Fiyat<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="first-name" name="siparis_ad" value="<?php echo $siparisdetaycek['urun_fiyat'] ?>" disabled="" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ürün Adet<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="first-name" name="siparis_ad" value="<?php echo $siparisdetaycek['urun_adet'] ?>" disabled="" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>
                <hr>
              <?php } ?>
            </form>
          </div>
        </div>
      </div>
    </div>



    <hr>
    <hr>
    <hr>



  </div>
</div>
<!-- /page content -->

<?php include 'footer.php'; ?>
