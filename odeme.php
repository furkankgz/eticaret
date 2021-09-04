<?php include 'header.php' ?>

<div class="container">

	<div class="clearfix"></div>
	<div class="lines"></div>
</div>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			
		</div>
	</div>
	<div class="title-bg">
		<div class="title">Alışveriş Sepetim</div>
	</div>

	<div class="table-responsive">
		<table class="table table-bordered chart">
			<thead>
				<tr>
					
					<th>Ürün Resim</th>
					<th>Ürün ad</th>
					<th>Ürün Kodu</th>
					<th>Adet</th>
					<th>Toplam Fiyat</th>
				</tr>
			</thead>
			<form action="nedmin/netting/islem.php" method="POST">

			<tbody>
				
				<?php 
				$kullanici_id=$kullanicicek['kullanici_id']; // sepete ekleyen kullanıcının idsini alabilmek için
				$sepetsor=$db->prepare("SELECT * FROM sepet where kullanici_id=:id"); // sepet tablosunu siteye bağlamak
				$sepetsor->execute(array(
					'id' => $kullanici_id
				));

				while($sepetcek=$sepetsor->fetch(PDO::FETCH_ASSOC)) {

					$urun_id=$sepetcek['urun_id'];
					$urunsor=$db->prepare("SELECT * FROM urun where urun_id=:urun_id");
					$urunsor->execute(array(
						'urun_id' => $urun_id
					));

					$uruncek=$urunsor->fetch(PDO::FETCH_ASSOC);
					$toplam_fiyat+=$uruncek['urun_fiyat']*$sepetcek['urun_adet']; // sepete eklenilen ürünlerin toplamını yazdırmak
					$urun_id=$uruncek['urun_id'];
					$urunfotosor=$db->prepare("SELECT * FROM urunfoto where urun_id=:urun_id order by urunfoto_sira ASC limit 1 ");
					$urunfotosor->execute(array( //urun fotografını getirmek için 
						'urun_id' => $urun_id
					));

					$urunfotocek=$urunfotosor->fetch(PDO::FETCH_ASSOC);
					?>
					<!--<input type="hidden" name="urun_id[]" value=" <?php echo $uruncek['urun_id'] ?> "> -->

					<tr>
						
						<td><img src="<?php echo $urunfotocek['urunfoto_resimyol'] ?>" class="urun" width="50" alt=""></td>
						<td><?php echo $uruncek['urun_ad'] ?></td>
						<td><?php echo $uruncek['urun_id'] ?></td>
						<td><?php echo $sepetcek['urun_adet'] ?></td>
						<td><?php echo $uruncek['urun_fiyat'] ?>₺</td>
					</tr>
				<?php } ?>

			</tbody>
		</table>
	</div>
	<div class="row">
		<div class="col-md-6">

		</div>
		<div class="col-md-3 col-md-offset-3">
			<div class="subtotal-wrap">
					<!--<div class="subtotal">
						<<p>Toplam Fiyat : $26.00</p>
						<p>Vat 17% : $54.00</p>
					</div>-->
					<div class="total">Toplam Fiyat : <span class="bigprice"><?php echo $toplam_fiyat ?>₺</span></div>
					<div class="clearfix"></div>
					<a href="" class="btn btn-default btn-yellow">Ödeme Sayfası</a>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="tab-review">
			<ul id="myTab" class="nav nav-tabs shop-tab">
				<li class="active"><a href="#desc" data-toggle="tab">Kredi Kartı</a></li>

				<li><a href="#rev" data-toggle="tab">Banka Havale</a></li> 
			</ul>
			<div id="myTabContent" class="tab-content shop-tab-ct">
				<div class="tab-pane fade active-in" id="desc">
					<p>Iyzico hesabı bulunmadığından bu kısıma iyzico dosyaları import edilemedi</p>
					<?php include 'iyzico/buyer.php'; ?>
					<div id="iyzipay-checkout-form" class="responsive"></div>
				</div>
				<div class="tab-pane fade active-in" id="rev">
					
						<p>Ödeme yapacağınız hesap numarasını seçiniz.</p>
						<?php
						$bankasor=$db->prepare("SELECT * FROM banka order by banka_id ASC");
						$bankasor->execute();
						while($bankacek=$bankasor->fetch(PDO::FETCH_ASSOC)) { ?>
							<input type="radio" name="siparis_banka" value=" <?php echo $bankacek['banka_ad'] ?> ">
							<?php echo $bankacek['banka_ad']; echo " "; echo $bankacek['banka_iban'];?> <br>
						<?php }  
						?>
						<input type="hidden" name="kullanici_id" value="<?php echo $kullanicicek['kullanici_id'] ?>">
						<input type="hidden" name="siparis_toplam" value=" <?php echo $toplam_fiyat; ?> ">
						<hr>
						<button type="submit" name="bankasiparisekle" class="btn btn-success">Sipariş Ver</button>
					</form>
				</div>
			</div>
		</div>
		<div class="spacer"></div>
	</div>

	<?php include 'footer.php' ?>