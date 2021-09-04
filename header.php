<?php
ob_start();
session_start();

//veritanabı bağladığımız kod
include 'nedmin/netting/baglan.php';
include 'nedmin/production/fonksiyon.php';
//Belirli veriyi seçme işlemi

$ayarsor=$db->prepare("SELECT * FROM ayar WHERE 
	ayar_id=:id"); // ayar tablosunu sayfaya çekme işlemi
$ayarsor->execute(
	array('id' => 0)
);

$ayarcek=$ayarsor->fetch(PDO::FETCH_ASSOC);

$kullanicisor=$db->prepare("SELECT * FROM kullanici where kullanici_mail=:mail");
$kullanicisor->execute(array(
	'mail' => @$_SESSION['userkullanici_mail']
));
$say=$kullanicisor->rowCount();
$kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="<?php echo $ayarcek['ayar_description'] ?>">
	<meta name="keywords" content="<?php echo $ayarcek['ayar_keywords'] ?>">
	<meta name="author" content="<?php echo $ayarcek['ayar_author'] ?>">

	<!-- Fonts -->
	<link href='http://fonts.googleapis.com/css?family=Ubuntu:400,400italic,700' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
	<link href='font-awesome\css\font-awesome.css' rel="stylesheet" type="text/css">
	<!-- Bootstrap -->
	<link href="bootstrap\css\bootstrap.min.css" rel="stylesheet">
	
	<!-- Main Style -->
	<link rel="stylesheet" href="style.css">
	
	<!-- owl Style -->
	<link rel="stylesheet" href="css\owl.carousel.css">
	<link rel="stylesheet" href="css\owl.transitions.css">
	

</head>
<body>
	<div id="wrapper">
		<div class="header"><!--Header -->
			<div class="container">
				<div class="row">
					<div class="col-xs-6 col-md-4 main-logo">
						<a href="index.php"><img width="230" src=" <?php echo $ayarcek['ayar_logo']; ?> " alt="Site Logosu" class="logo img-responsive"></a>
					</div>
					<div class="col-md-8">
						<div class="pushright">
							<div class="top">
								<?php 
								if(!isset($_SESSION['userkullanici_mail'])){ ?>
									<a href="#" id="reg" class="btn btn-default btn-dark">Giriş Yap<span>-- Ya Da --</span>Kayıt Ol</a>

								<?php } else { ?>
									<a href="#" class="btn btn-default btn-dark">Hoşgeldin<span>--</span><?php echo $kullanicicek['kullanici_adsoyad']; ?></a>	
								<?php } ?>
								<div class="regwrap">
									<div class="row">
										<div class="col-md-6 regform">
											<div class="title-widget-bg">
												<div class="title-widget">Kullanıcı Giriş</div>
											</div>

											<form action="nedmin/netting/islem.php" method="POST" role="form">
												<div class="form-group">
													<input type="text" class="form-control" id="username" name="kullanici_mail" placeholder="Kullanıcı Adı/Mail">
												</div>
												<div class="form-group">
													<input type="password" class="form-control" id="password" name="kullanici_password" placeholder="Şifre">
												</div>
												<div class="form-group">
													<button class="btn btn-default btn-red btn-sm" name="kullanicigiris">Giriş Yap</button>
												</div>
											</form>

										</div>
										<div class="col-md-6">
											<div class="title-widget-bg">
												<div class="title-widget">Kayıt Ol</div>
											</div>
											<p>
												Yeni kullanıcı mısınız? Hızlı ve güvenli alışveriş yapmak için bir hesap açın, Böylece siparişinizin durumunu takip edebilirsiniz...
											</p>
											<a href="register"><button class="btn btn-default btn-yellow">Hemen Kayıt Ol</button></a>
										</div>
									</div>
								</div>
								<div class="srch-wrap">
									<a href="#" id="srch" class="btn btn-default btn-search"><i class="fa fa-search"></i></a>
								</div>
								<div class="srchwrap">
									<div class="row">
										<div class="col-md-12">
											<form action="arama" method="POST" class="form-horizontal" role="form">
												<div class="form-group">
													<!--<label for="search" class="col-sm-2 control-label">Search</label>-->
													<button name="arama" class="btn btn-default btn-sm">Ara</button>
													<div class="col-sm-10">
														<input type="text" minlength="3" name="aranan" class="form-control" id="search">
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="dashed"></div>
		</div><!--Header -->
		<div class="main-nav"><!--end main-nav -->
			<div class="navbar navbar-default navbar-static-top">
				<div class="container">
					<div class="row">
						<div class="col-md-10">
							<div class="navbar-header">
								<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>
							</div>
							<div class="navbar-collapse collapse">
								<ul class="nav navbar-nav">
									<li><a href="index.php" class="active">Anasayfa</a><div class="curve"></div></li>
									<?php 
									$menusor=$db->prepare("SELECT * FROM menu WHERE menu_durum=:durum ORDER BY menu_sira ASC LIMIT 5");
									$menusor->execute(array(
										'durum' => 1
									));
									while ($menucek=$menusor->fetch(PDO::FETCH_ASSOC)){ ?>

										<li><a href="
											<?php  
											if(!empty($menucek['menu_url'])){
												echo $menucek['menu_url'];
												} else {
													echo "sayfa-".seo($menucek['menu_ad']);
												}
												?>
												"><?php echo $menucek['menu_ad']; ?></a></li>

											<?php } ?>
										</ul>
									</div>
								</div>
								<div class="col-md-2 machart">
										<button id="popcart" class="btn btn-default btn-chart btn-sm "><span class="mychart">Sepet</span>|<span class="allprice"></span></button>
										<div class="popcart">
											<table class="table table-condensed popcart-inner">
												<tbody>
													<?php 

													$kullanici_id=$kullanicicek['kullanici_id']; // sepete ekleyen kullanıcının idsini alabilmek için
													$sepetsor=$db->prepare("SELECT * FROM sepet where kullanici_id=:id"); // sepet tablosunu siteye bağlamak
													$sepetsor->execute(array(
														'id' => $kullanici_id
													));

													while($sepetcek=$sepetsor->fetch(PDO::FETCH_ASSOC)) {
														$urun_id=$sepetcek['urun_id'];
														$urunfotosor=$db->prepare("SELECT * FROM urunfoto where urun_id=:urun_id order by urunfoto_sira ASC limit 1 ");
														$urunfotosor->execute(array(
															'urun_id' => $urun_id
														));

														$urunfotocek=$urunfotosor->fetch(PDO::FETCH_ASSOC);
														$urun_id=$sepetcek['urun_id'];
														$urunsor=$db->prepare("SELECT * FROM urun where urun_id=:urun_id");
														$urunsor->execute(array(
															'urun_id' => $urun_id
														));

														$uruncek=$urunsor->fetch(PDO::FETCH_ASSOC);
														$toplam_tutar+=$uruncek['urun_fiyat']*$sepetcek['urun_adet']; // sepete eklenilen ürünlerin toplamını yazdırmak
														?>	
														<tr>
															<td>
																<center><a href="urun-<?=seo($uruncek["urun_ad"]).'-'.$uruncek["urun_id"]?>"><img height="50" src=" <?php echo $urunfotocek['urunfoto_resimyol'] ?> " alt="" class="urun"></a></center>
															</td>
															<td><a href="urun-<?=seo($uruncek["urun_ad"]).'-'.$uruncek["urun_id"]?>"><?php echo $uruncek['urun_ad'] ?></a><br><span></span></td>
															<td><?php echo $sepetcek['urun_adet']; ?>x</td>
															<td><?php echo $uruncek['urun_fiyat'] ?>₺</td>
															<td><a href=""><i class="fa fa-times-circle fa-2x"></i></a></td>
														</tr>
													<?php } ?>
												</tbody>
											</table>
											<br>
											<div class="btn-popcart">
												<a href="sepet" class="btn btn-default btn-red btn-sm">Sepetime Git</a>
											</div>
											<div class="popcart-tot">
												<p>
													Toplam Tutar  <br>
													<span><?php echo $toplam_tutar; ?> ₺</span>
												</p>
											</div>
											<div class="clearfix"></div>
										</div>
									</div>
									<?php 
									if(isset($_SESSION['userkullanici_mail'])){ ?>
										<ul class="small-menu">
											<li><a href="hesabim" class="myacc">Hesap Bilgilerim</a></li>
											<li><a href="siparislerim" class="myshop">Siparişlerim</a></li>
											<li><a href="logout" class="mycheck">Güvenli Çıkış</a></li>
										</ul>
									<?php } ?>
								</div>
							</div>
						</div>
	</div><!--end main-nav -->