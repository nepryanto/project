
<div class="panel panel-primary">
	  <div class="panel-heading">
			<h3 class="panel-title"><span class="glyphicon glyphicon-shopping-cart"></span>Keranjang Belanja</h3>
	  </div>
	  <div class="panel-body">
<?php 
  $sid = session_id();
  $sql = $db->query("SELECT * FROM orders_temp, produk WHERE id_session='$sid' AND orders_temp.id_produk=produk.id_produk");
  $ketemu=$sql->num_rows;
  if($ketemu < 1){
  echo "<script>window.alert('Keranjang Belanja anda masih kosong. Silahkan Anda berbelanja terlebih dahulu.');
        window.location=('index.php')</script>";
  }
  else{  

  echo "<div class='alert alert-info'><strong><h3 align='center'><span class='glyphicon glyphicon-shopping-cart'></span> Keranjang Belanja</h3></strong></div>


  <form method='post' action='?page=updatekeranjang'>

  <table class='table table-bordered'>
  <thead>
  <th>No</th>
  <th>Nama Produk</th>
  <th>Berat(Kg)</th>
  <th>Qty</th>
  <th>Harga</th>
  <th>Sub Total</th>
  <th>Aksi</th></tr></thead><tbody>";  

  $no=1;
  while($r=$sql->fetch_array()){
    $disc        = ($r[diskon]/100)*$r[harga];
    $hargadisc   = number_format(($r[harga]-$disc),0,",",".");
    $subtotal    = ($r[harga]-$disc) * $r[jumlah];
    $total       = $total + $subtotal;  
    $subtotal_rp =  number_format(($subtotal),0,",",".");
	$total_rp    =  number_format(($total),0,",",".");
    $harga       =  number_format(($r[harga]),0,",",".");
    
  echo "<tr align=center>
  			<input type='hidden' name='id[$no]' value='$r[id_orders_temp]'>
  			<td>$no</td>
			<td>$r[nama_produk]</td>
  			<td align=center>$r[berat]</td>
		    <td><select name='jml[$no]' value=$r[jumlah] onChange='this.form.submit()'>";

  for ($j=1;$j <= $r[stok];$j++){

	  if($j == $r[jumlah]){
	  echo "<option selected>$j</option>";
	}else{
	  echo "<option>$j</option>";}}
	  echo"</select>
			<td>$hargadisc</td>
	  <td>$subtotal_rp</td>
	  <td><a class='btn btn-danger' href='?page=hapuskeranjang&id=$r[id_orders_temp]'><span class='glyphicon glyphicon-trash'></span></a></td></tr>";

	  $no++; 
	} 

  echo "<tr><td colspan='5' align='right'>Total Harga: </td>
  <td align='center'><b>Rp. $total_rp,-</b></td><td></td></tr>
  <tr><td colspan=2><a class='btn btn-success' href=javascript:history.go(-1)>LANJUTKAN BELANJA</a></td>
        
  <td colspan='6' align='right'><a class='btn btn-warning' href='?page=selesaibelanja'>Selesai Belanja</a></td></tr>
  </tbody></table></form>";

  echo "**  Total harga di atas belum termasuk ongkos kirim yang akan dihitung saat <b>
  Selesai Belanja</b>";}
?>
  </div>
</div>