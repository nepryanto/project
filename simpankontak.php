<?php 
$pesan = strip_tags($_POST['pesan']);

$simpan = $db->query("insert into kontak set nama='$_POST[nama]',
	                                          email='$_POST[email]',
	                                          telpon='$_POST[telpon]',
	                                          pesan='$_POST[pesan]' ");

echo"<script>
		alert('Pesan Berhasil dikirimkan');
		window.location='?page=kontak';
	</script>";

?>
