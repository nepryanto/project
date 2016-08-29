<?php 
$db->query("DELETE FROM orders_temp WHERE id_orders_temp='$_GET[id]'");
header('Location:?page=keranjang');	
?>