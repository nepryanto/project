<div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title">Selesai Belanja</h3>
    </div>
    <div class="panel-body">
<?php 
$kar1=strstr($_POST[email], "@");
$kar2=strstr($_POST[email], ".");

  if (empty($_POST[nama]) || empty($_POST[alamat]) || empty($_POST[telpon]) || empty($_POST[email]) || empty($_POST[kota])){
  echo "<span class='table3'>Data yang Anda isikan belum lengkap.<br /><br />
  <a href=javascript:history.go(-1)><input style='width: 100px; height: 25px;' type=submit  
  class= button value='ULANGI LAGI'></a>";}

  elseif (!ereg("[a-z|A-Z]","$_POST[nama]")){
  echo "<span class='table3'>Nama tidak boleh diisi dengan angka atau simbol.<br /><br />
  <a href=javascript:history.go(-1)><input style='width: 100px; height: 25px;' type=submit  
  class= button value='ULANGI LAGI'></a>";}

  elseif (strlen($kar1)==0 OR strlen($kar2)==0){
  echo "<span class='table3'>Alamat email Anda tidak valid, mungkin kurang tanda titik (.) atau tanda @.<br /><br />
  <a href=javascript:history.go(-1)><input style='width: 100px; height: 25px;' type=submit 
  class= button value='ULANGI LAGI'></a>";}

  else{
  // fungsi untuk mendapatkan isi keranjang belanja
  function isi_keranjang(){
  $isikeranjang = array();
  $sid = session_id();
  $sql = $db->query("SELECT * FROM orders_temp WHERE id_session='$sid'");
  
  while ($r=$sql->fetch_array()) 
  {$isikeranjang[] = $r;}
  return $isikeranjang;}
  $tgl_skrg = date("Ymd");
  $jam_skrg = date("H:i:s");

  if(!empty($_POST['kode'])){
  if($_POST['kode']==$_SESSION['captcha_session']){

  function antiinjection($data){
  $filter_sql = $db->real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter_sql;}

  $nama   = antiinjection($_POST['nama']);
  $alamat = antiinjection($_POST['alamat']);
  $telpon = antiinjection($_POST['telpon']);
  $no_orders = "#".rand(0,999999);
  //=====================================================================================================


  // PROSES TRANSAKSI SELESAI

  // simpan data pemesanan 
  $db->query("INSERT INTO orders(nama_kustomer, alamat, telpon, email, tgl_order, jam_order, id_kota,no_orders) 
  VALUES('$_POST[nama]','$_POST[alamat]','$_POST[telpon]','$_POST[email]','$tgl_skrg','$jam_skrg','$_POST[kota]','$no_orders')");
  
  // mendapatkan nomor orders
  $id_orders=$db->insert_id();

  // panggil fungsi isi_keranjang dan hitung jumlah produk yang dipesan
  $isikeranjang = isi_keranjang();
  $jml          = count($isikeranjang);

  // simpan data detail pemesanan  
  for ($i = 0; $i < $jml; $i++){
  $db->query("INSERT INTO orders_detail(id_orders, id_produk, jumlah) 
  VALUES('$id_orders',{$isikeranjang[$i]['id_produk']}, {$isikeranjang[$i]['jumlah']})");}
  
  // setelah data pemesanan tersimpan, hapus data pemesanan di tabel pemesanan sementara (orders_temp)
  for ($i = 0; $i < $jml; $i++) {
  $db->query("DELETE FROM orders_temp WHERE id_orders_temp = {$isikeranjang[$i]['id_orders_temp']}");}

  echo "<h4 class='heading colr'>Proses Transaksi Selesai</h4>";

  echo "<div class='prod_box_big'>

      <b><class style=\"color:#464646;font-size:14px;\">Data pemesan dan order anda adalah sebagai berikut:</b> <br /><br />
      <table class='table'>
      <tr><td><span class='pemesanan'>Nama</td>
      <td> : <b>$_POST[nama]</b> </td></tr>
      <tr><td>Alamat Lengkap </td><td> : <span class='pemesanan'>$_POST[alamat] </td></tr>
      <tr><td>Telpon         </td><td> : <span class='pemesanan'>$_POST[telpon] </td></tr>
      <tr><td>E-mail         </td><td> : <span class='pemesanan'>$_POST[email] </td></tr></table><br />
      
      Nomor Order: <b> $id_orders</b><br /><br />";

      $daftarproduk=$db->query("SELECT * FROM orders_detail,produk 
                                 WHERE orders_detail.id_produk=produk.id_produk 
                                 AND id_orders='$id_orders'");

  echo "<table class='table table-bordered'>
  <tr><th>No</th>
  <th>Nama Produk</th>
  <th>Berat(Kg)</th>
  <th>Qty</th>
  <th>Harga</th>
  <th>Sub Total</th></tr>";

  $pesan="Terimakasih telah melakukan pemesanan online di toko kami<br /><br />  
        Nama: $_POST[nama] <br />
        Alamat: $_POST[alamat] <br/>
        Telpon: $_POST[telpon] <br /><hr />
        Nomor Order: $id_orders <br />
        Data order Anda adalah sebagai berikut: <br /><br />";
    
  $no=1;
  while ($d=$daftarproduk->fetch_array()){
   $subtotalberat = $d[berat] * $d[jumlah]; 
   $totalberat  = $totalberat + $subtotalberat; 
   $disc        = ($d[diskon]/100)*$d[harga];
   $hargadisc   = number_format(($d[harga]-$disc),0,",","."); 
   $subtotal    = ($d[harga]-$disc) * $d[jumlah];
   $total       = $total + $subtotal;
   $subtotal_rp =  number_format(($subtotal),0,",",".");
   $total_rp    =  number_format(($total),0,",",".");
   $harga       =  number_format(($r['harga']),0,",",".");
   
  echo "<tr><td>$no</td>
        <td>$d[nama_produk]</td>
        <td align=center>$d[berat]</td>
        <td align=center>$d[jumlah]</td>
        <td>Rp. $harga,-</td>
        <td>Rp. $subtotal_rp,-</td></tr>";
$pesan.="$d[jumlah] $d[nama_produk] -> Rp. $harga -> Subtotal: Rp. $subtotal_rp <br />";
$no++;}
  $ongkos1 = $db->query("SELECT ongkos_kirim FROM kota WHERE id_kota='$_POST[kota]'");
  $ongkos=$ongkos1->fetch_array();
  $ongkoskirim1=$ongkos[ongkos_kirim];
  $ongkoskirim = $ongkoskirim1 * $totalberat;
  $grandtotal    = $total + $ongkoskirim; 
  $ongkoskirim_rp =  number_format(($ongkoskirim),0,",",".");
  $ongkoskirim1_rp =  number_format(($$ongkoskirim1),0,",",".");
  $grandtotal_rp =  number_format(($grandtotal),0,",",".");
  //=====================================================================================================
  
  
  //HARUS DIRUBAH (setting email) *periksa pula modul>mod_order>order.php
  $pesan.="Total : Rp. $total_rp,-
         <br />Ongkos Kirim untuk Tujuan Kota Anda : Rp. $ongkoskirim1_rp/Kg 
         <br />Total Berat : $totalberat Kg
         <br />Total Ongkos Kirim  : Rp. $ongkoskirim_rp     
         <br />Grand Total : Rp. $grandtotal_rp,-
         <br /><br />Silahkan lakukan pembayaran ke Bank Mandiri sebanyak Grand Total yang tercantum, 
     nomor rekeningnya <b>12345678</b> a.n. Dede Nurjanah";

  $subjek="Pemesanan Online Di Naura Komputer";

  // Kirim email dalam format HTML
  $dari = "From: admin@kursuskomputernaura.com \n";
  $dari .= "Content-type: text/html \r\n";

  // Kirim email ke kustomer
  mail($_POST[email],$subjek,$pesan,$dari);

  // Kirim email ke pengelola toko online
  mail("admin@kursuskomputernaura.com",$subjek,$pesan,$dari);


  echo "<tr><td colspan=5 align=right>Total : Rp. </td><td align=right><b>$total_rp</b></td></tr>
  <tr><td colspan=5 align=right>Ongkos Kirim untuk Tujuan Kota Anda: Rp. </td>
  <td align=right><b>$ongkoskirim1_rp</b>/Kg</td></tr>      
  <tr><td colspan=5 align=right>Total Berat : </td><td align=right><b>$totalberat Kg</b></td></tr>
  <tr><td colspan=5 align=right>Total Ongkos Kirim : Rp. </td><td align=right><b>$ongkoskirim_rp</b></td></tr>      
  <tr><td colspan=5 align=right>Grand Total : Rp. </td><td align=right><b>$grandtotal_rp</b></td></tr>
  </table>";

  echo "<br /><br /><p>&bull; Data order dan nomor rekening transfer sudah terkirim ke email Anda. <br />
  &bull; Apabila Anda tidak melakukan pembayaran dalam 3 hari, maka data order Anda akan terhapus (transaksi batal)</p>
  </div><p><a class='btn btn-warning' href=javascript:history.go(-2)>Kembali</a></p>"; }

  else{
  echo "<b>Kode yang Anda masukkan tidak cocok!</b><br />
  <a class='btn btn-danger' href=javascript:history.go(-1)>Ulangi Lagi</a>";}}

  else{
  echo "<span class='table3'><b>Anda belum memasukkan kode!</b><br /><br />
  <a href=javascript:history.go(-1)><input style='width: 100px; height: 25px;' type=submit  
  class= button value='ULANGI LAGI'></a>";}}
?>
</div></div>