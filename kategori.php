<div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title">Kategori Produk</h3>
    </div>
    <div class="panel-body">
        <?php 
  // PRODUK perkategori     
    
    $sql=$db->query("SELECT * FROM produk WHERE id_kategori='$_GET[id]' ORDER BY rand() DESC LIMIT 12");
    while ($r=$sql->fetch_array()){
    include "diskon_stok.php";

echo "
  <div class='col-lg-3'>
    <div class='media'>
    <a class='pull-left' href=''>
      <img class='media-object' src='gambar/produk/small_$r[gambar]' alt='Image' width='225'>
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
    </div>
</div>




<div class="panel panel-primary">
	<div class="panel-heading"><h3 class="panel-title">Produk Diskon Terbaru</h3></div>
<div class="panel-body">
<?php

// PRODUK DISKON  
  $sql=$db->query("SELECT * FROM produk WHERE diskon ORDER BY id_produk DESC LIMIT 4"); 
  while ($r=$sql->fetch_array()){

  include "diskon_stok.php";
   echo "
<div class='col-lg-3'>
  <div class='media'>
	<a class='pull-left' href=''>
		<img class='media-object' src='gambar/produk/small_$r[gambar]' alt='Image' width='225'>
	</a>
<div class='media-body'>
<h4 class='media-heading'>$r[nama_produk]</h4>
<p>$divharga</p>
<p>$tombol <a href='?page=detailproduk&id=$r[id_produk]' class='btn btn-warning'>Detail</a></p>
</div>
</div>
</div>";}
?>
</div>
</div>

