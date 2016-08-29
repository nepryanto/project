<?php
    // diskon  
    $harga     =  number_format(($r[harga]),0,",",".");
    $disc      = ($r[diskon]/100)*$r[harga];
    $hargadisc = number_format(($r[harga]-$disc),0,",",".");

    $d=$r['diskon'];
    $hargatetap  = "Harga Rp. $hargadisc,-";
    $hargadiskon = "Harga &nbsp;&nbsp;Rp. $harga<br /> diskon $d% - Rp. $hargadisc,-";
    if ($d!=0){
      $divharga=$hargadiskon;
    }else{
      $divharga=$hargatetap;
    } 

    // tombol stok habis kalau stoknya 0
    $stok=$r['stok'];
    $tombolbeli="<a class='btn btn-success' href='?page=beli&&id=$r[id_produk]'>Beli</a> <a class='btn btn-warning' href='index.php'>Kembali</a>";
    $tombolhabis="<a class='btn btn-danger'>Habis</a>";
      if ($stok!= "0"){
      $tombol=$tombolbeli;
      }else{
      $tombol=$tombolhabis;
      } 
?>


   



