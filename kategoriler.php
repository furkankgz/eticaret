﻿<?php 

include 'header.php'; 

if (isset($_GET['sef'])) {


	$kategorisor=$db->prepare("SELECT * FROM kategori where kategori_seourl=:seourl");
	$kategorisor->execute(array(
		'seourl' => $_GET['sef']
	));

	$kategoricek=$kategorisor->fetch(PDO::FETCH_ASSOC);

	$kategori_id=$kategoricek['kategori_id'];


	$urunsor=$db->prepare("SELECT * FROM urun where kategori_id=:kategori_id order by urun_id DESC");
	$urunsor->execute(array(
		'kategori_id' => $kategori_id
	));

	$say=$urunsor->rowCount();

} else {

	$urunsor=$db->prepare("SELECT * FROM urun order by urun_id DESC");
	$urunsor->execute();

}




?>
<head>
	<title>
		<?php echo $kategoricek['kategori_ad'] ?>-Furkanexpress
	</title>
</head>


<div class="container">

	<div class="clearfix"></div>
	<div class="lines"></div>
</div>

<div class="container">
	
	<div class="row">
		<div class="col-md-9"><!--Main content-->
			<div class="title-bg">
				<div class="title">Ürünler</div>
				<div class="title-nav">
					<a href="javascripti:void(0);"><i class="fa fa-th-large"></i>grid</a>
					<a href="javascripti:void(0);"><i class="fa fa-bars"></i>List</a>
				</div>
			</div>
			<div class="row prdct"><!--Products-->


				<?php
				if ($say==0) { //eğer kategoride ürün yok ise bunu yazdır
					echo "Bu kategoride ürün bulunamadı";
				}
				


				while($uruncek=$urunsor->fetch(PDO::FETCH_ASSOC)) {
				 //tablomuzdaki ürün kadar div'i döndürüyoruz
				$urun_id=$uruncek['urun_id'];
				$urunfotosor=$db->prepare("SELECT * FROM urunfoto where urun_id=:urun_id order by urunfoto_sira ASC limit 1 ");
				$urunfotosor->execute(array( //urun fotografını getirmek için 
					'urun_id' => $urun_id
				));

				$urunfotocek=$urunfotosor->fetch(PDO::FETCH_ASSOC);
				?>

				<div class="col-md-6" style="height: 350px;">
					<div class="productwrap">
						<div class="pr-img">
							<div class=""></div>
							<center><a href="urun-<?=seo($uruncek["urun_ad"]).'-'.$uruncek["urun_id"]?>"><img  height="190" src="<?php echo $urunfotocek['urunfoto_resimyol'] ?>" alt="" class="urun"></a></center>
							<div class="pricetag on-sale"><div class="inner on-sale"><span class="onsale"><span class="oldprice"><?php echo $uruncek['urun_fiyat']*1.50 ?>₺</span><?php echo $uruncek['urun_fiyat'] ?>₺</span></div></div>
						</div>
						<span class="smalltitle"><a href="urun-<?=seo($uruncek["urun_ad"]).'-'.$uruncek["urun_id"]?>"><?php echo $uruncek['urun_ad'] ?></a></span>
						<span class="smalldesc">Ürün Kodu.: <?php echo $uruncek['urun_id'] ?></span>
					</div>
				</div>


			<?php } ?>





		</div><!--Products-->

<!-- 
				<ul class="pagination shop-pag">
					<li><a href="#"><i class="fa fa-caret-left"></i></a></li>
					<li><a href="#">1</a></li>
					<li><a href="#">2</a></li>
					<li><a href="#">3</a></li>
					<li><a href="#">4</a></li>
					<li><a href="#">5</a></li>
					<li><a href="#"><i class="fa fa-caret-right"></i></a></li>
				</ul> -->

			</div>

			<?php include 'sidebar.php' ?>
		</div>
		<div class="spacer"></div>
	</div>
	
	<?php include 'footer.php'; ?>