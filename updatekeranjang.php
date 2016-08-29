<?php 
$id       = $_POST[id];
$jml_data = count($id);
$jumlah   = $_POST[jml]; // quantity
  for ($i=1; $i <= $jml_data; $i++){
	$sql2 = $db->query("SELECT stok_temp FROM orders_temp	WHERE id_orders_temp='".$id[$i]."'");
	while($r=$sql2->fetch_array()){
		if ($jumlah[$i] > $r[stok_temp]){
		echo "<script>window.alert('Jumlah yang dibeli melebihi stok yang ada');
		window.location=('keranjang-belanja.html')</script>";
		}
				elseif($jumlah[$i] == 0){
		echo "<script>window.alert('Anda tidak boleh menginputkan angka 0 atau mengkosongkannya!');
		window.location=('keranjang-belanja.html')</script>";
		} // tambahan update ada disini
		else{
		$db->query("UPDATE orders_temp SET jumlah = '".$jumlah[$i]."'
		WHERE id_orders_temp = '".$id[$i]."'");
		header('Location:?page=keranjang');
		    }
  }
  }
?>