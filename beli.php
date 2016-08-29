<?php
	$sid = session_id();
	$sql2 = $db->query("SELECT stok FROM produk WHERE id_produk='$_GET[id]'");
	$r=$sql2->fetch_array();
	$stok=$r[stok];
  
  if ($stok == 0){
      echo "<b>Maaf, stok sudah habis. Silahkan pilih barang yang lain.</b>";
  }
  else{
	// check if the product is already
	// in cart table for this session
	$sql = $db->query("SELECT id_produk FROM orders_temp
			WHERE id_produk='$_GET[id]' AND id_session='$sid'");
	$ketemu=$sql->num_rows;
	if ($ketemu==0){
		// put the product in cart table
		$db->query("INSERT INTO orders_temp (id_produk, jumlah, id_session, tgl_order_temp, jam_order_temp, stok_temp)
				VALUES ('$_GET[id]', 1, '$sid', '$tgl_sekarang', '$jam_sekarang', '$stok')");
	} else {
		// update product quantity in cart table
		$db->query("UPDATE orders_temp 
		        SET jumlah = jumlah + 1
				WHERE id_session ='$sid' AND id_produk='$_GET[id]'");		
	}	
	/* hapus isi keranjang jika lebih dari satu hari */
	$kemarin = date('Y-m-d', mktime(0,0,0, date('m'), date('d') - 1, date('Y')));
	$db->query("DELETE FROM orders_temp WHERE tgl_order_temp < '$kemarin'");

	header('Location:?page=keranjang');
  }				



?>
