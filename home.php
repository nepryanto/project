
<?php 
// PRODUK TERBARU 	  
  
  $sql=$db->query("SELECT * FROM produk WHERE diskon='0' ORDER BY rand() DESC LIMIT 12");
  while ($r=$sql->fetch_array()){

  include "diskon_stok.php";

  echo "
<div class='col-xs-12 col-sm-12 col-md-6 col-lg-3'>
  <div class='media'>
	<a class='pull-left' href=''>
		<img class='media-object img-responsive' src='gambar/produk/small_$r[gambar]' alt='$r[produk_seo]' width=250>
	</a>
<div class='media-body'>
<h4 class='media-heading'>$r[nama_produk]</h4>
<p>$divharga</p>
<p>
	$tombol
	<a href='?page=detailproduk&id=$r[id_produk]' class='btn btn-warning'>Detail</a>
</p>
</div>
</div>
</div>";}
  //=======================================================================================================
?>


<?php

// PRODUK DISKON  
  $sql=$db->query("SELECT * FROM produk WHERE diskon ORDER BY id_produk DESC LIMIT 4"); 
  while ($r=$sql->fetch_array()){

  include "diskon_stok.php";
   echo "
<div class='col-xs-12 col-sm-12 col-md-6 col-lg-3'>
  <div class='media'>
	<a class='pull-left' href=''>
		<img class='media-object img-responsive' src='gambar/produk/small_$r[gambar]' alt='Image'>
	</a>
<div class='media-body'>
<h4 class='media-heading'>$r[nama_produk]</h4>
<p>$divharga</p>
<p>$tombol <a href='?page=detailproduk&id=$r[id_produk]' class='btn btn-warning'>Detail</a></p>
</div>
</div>
</div>";}
?>



