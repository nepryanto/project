<div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title">Selesai Belanja</h3>
    </div>
    <div class="panel-body">
<?php 
$sid = session_id();
  $sql = $db->query("SELECT * FROM orders_temp, produk WHERE id_session='$sid' AND orders_temp.id_produk=produk.id_produk");
  $ketemu=$sql->num_rows;
  if($ketemu < 1){
  echo "<script> alert('Keranjang belanja masih kosong');window.location='index.php'</script>\n";
  exit(0);}
  else{
  echo "<h4 class='heading colr'>Data Pembeli</h4>
      <form name='form' action='?page=simpantransaksi' method='POST' onSubmit=\"return validasi(this)\">
      <table class='table'>
      <tr><td>Nama</td><td><input type=text name=nama size=30 class='form-control'></td></tr>
      <tr><td>Alamat Lengkap</td><td><input type=text name=alamat size=70 class='form-control'></td></tr>
      <tr><td>Telpon/HP</td><td><input type=text name=telpon class='form-control'></td></tr>
      <tr><td>Email</td><td><input type=text name=email class='form-control'></td></tr>
    
      <tr><td>Jasa Pengiriman</td><td>  
      <select name='jasa' id='jasa' class='form-control'>
      <option value='0' selected>- Pilih Jenis Jasa Pengiriman -</option>";
      $tampil=$db->query("SELECT * FROM shop_pengiriman ORDER BY nama_perusahaan");
      while($r=$tampil->fetch_array()){
      echo "<option value='$r[id_perusahaan]'>$r[nama_perusahaan]</option>";}
      echo "</select></td></tr>
      <tr><td>Kota Tujuan</td><td><span id='kota'>
      <select name='kota' id='kota' class='form-control'>
    <option value='0' selected>Tentukan Jenis Jasa Pengiriman Dahulu</option></select></td></tr>
    
    <tr><td>&nbsp;</td><td><br /><img src='captcha.php'></td></tr>
      <tr><td>&nbsp;</td><td>(masukkan 6 kode di atas)<br />
    <input type=text class='form-control' name=kode size=10 maxlength=6><br /></td></tr>
      <tr><td colspan=2><input class='btn btn-primary' type=submit value=PROSES></td></tr>
      </table><br/><br/>";
      
  echo "<h4 class='heading colr'>Konfirmasi Keranjang Belanja Anda</h4>
  <table class='table table-bordered'>
  <tbody>
    <tr align='center'  bgcolor='green'><th>No</th>
    <th>Nama Produk</th>
    <th>Berat(Kg)</th>
    <th>Qty</th>
    <th>Harga</th>
    <th>Sub Total</th></tr>";  
  
  $no=1;
  while($r=$sql->fetch_array()){
  //nampilkan diskon per produk 
    $disc        = ($r[diskon]/100)*$r[harga];
    $hargadisc   = number_format(($r[harga]-$disc),0,",","."); 
    $subtotal    = ($r[harga]-$disc) * $r[jumlah];
  
  //akhir nampilkan diskon per produk 
    $total       = $total + $subtotal;  
    $subtotal_rp =  number_format(($subtotal),0,",",".");
    $total_rp    =  number_format(($total),0,",",".");
    $harga       =  number_format(($r['harga']),0,",",".");
    $subtotalberat = $r['berat'] * $r['jumlah']; 
    $totalberat  = $totalberat + $subtotalberat;  

  echo "<tr align=center3>
  <td>$no</td>
  <input type=hidden name=id[$no] value=$r[id_orders_temp]>
  <td>$r[nama_produk]</td>
  <td align=center>$r[berat]</td>
  <td align=center>$r[jumlah]</td>
  <td>$harga</td>
  <td>$subtotal_rp</td></tr>";
  $no++; }
  echo "<tr><td colspan=2 align=right>Total Berat:</td>
  <td align=center>$totalberat kg</b></td>
  <td align=right colspan=2>Total Harga:</td>
  <td align=center>Rp. $total_rp,-</td></tr>
  </tbody></table>";
  echo "<br/><table width=520><tr><td>
  <input class='btn btn-warning' type=button value='KEMBALI' onclick=self.history.back()>
  <input class='btn btn-success' type='submit' value='PROSES ORDER'>  </td></tr></table>
  </form>";}
?>
  </div>
</div>