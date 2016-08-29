<div class='panel panel-primary'>
<div class='panel-heading'>
	<h3 class='panel-title'>Produk Terbaru</h3>
</div>
<div class='panel-body'>
<?php 
$detail=$db->query("SELECT * FROM produk,kategori    
  WHERE kategori.id_kategori=produk.id_kategori AND id_produk='$_GET[id]'");
  $r = $detail->fetch_array();
  include "diskon_stok2.php";
  
  echo "
<div class='media'>
  <h4 class='heading'>Kategori: <a href='kategori-$r[id_kategori]-$r[kategori_seo].html'>
  $r[nama_kategori]</a></h4>";
  if ($d[gambar]!=''){
  echo "
  	<a class='pull-left' href=''>
	<img class='media-object' src='gambar/hp1.jpg' alt='Image'><br>
	</a>
	<div class='pull-left'>
	<b><h4 class='media-heading'>$r[nama_produk]</h4>
		<p>$divharga</p>
		<p>Stok : $r[stok] item</p>
		<p>$tombol </p></b>
	</div>
	";}
  echo"
  <div class='media-body'>
  		<p>$r[deskripsi]</p>
  </div>
  </div>";

  //=======================================================================================================
			
					  
  // REKOMENDASI PRODUK       
  $sql=$db->query("SELECT * FROM produk ORDER BY rand() LIMIT 4");
  echo"<div class='alert alert-danger'><h4 class='heading colr'>Rekomendasi Produk</h4></div>";
  while ($r=$sql->fetch_array()){
  include "diskon_stok.php";
  echo "
  <div class='col-md-3'>
 
  <div class='media'>
	<a class='pull-left' href=''>
		<img class='media-object' src='gambar/hp1.jpg' alt='Image'>
	</a>
	<div class='media-body'>
	<a class='media-heading' href='produk-$r[id_produk]-$r[produk_seo].html'>$r[nama_produk]</a>
	<p> $divharga<p>
	<p>
		 $tombol 
		 <a href='?page=detailproduk&id=$r[id_produk]' class='btn btn-warning'>Detail</a>
		 <a href='index.php' class='btn btn-primary'>Kembali</a>
 	</p>
  </div>
</div>
</div>";}
?>
</div>
</div>
