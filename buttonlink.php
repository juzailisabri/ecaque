<?php


function whatsappOrder($name,$address,$clientPhone,$s){
  $phone = "60123543797";
  $item[0] = "1 x Kek Buah Kukus eCaque 1Kg";
  $item[1] = "3 x Kek Buah Kukus eCaque 1Kg";
  $item[2] = "4 x Kek Buah Kukus eCaque 1Kg";
  $item[3] = "5 x Kek Buah Kukus eCaque 1Kg";

  $price[0] = "RM50 dan RM10 Postage";
  $price[1] = "RM150 dan Free Postage";
  $price[2] = "RM200 dan Free Postage";
  $price[3] = "RM250 dan Free Postage";

  $tprice[0] = "RM60";
  $tprice[1] = "RM150";
  $tprice[2] = "RM200";
  $tprice[3] = "RM250";



  $text = "
  Hi, eCaque %0D%0D
  Saye berminat untuk membeli kek dari pihak eCaque Enterprise. Butiran adalah seperti berikut %0D
  _______ %0D
  Nama: *$name* %0D
  Alamat: *$address* %0D
  No Telefon : *$clientPhone* %0D
  Item : *$item[$s]* %0D
  Price : *$price[$s]* %0D
  Total : *$tprice[$s]*
  ";

  $link1 = "https://api.whatsapp.com/send?phone=$phone&text=$text";

  echo $link1;
}

whatsappOrder("Juzaili Ahmad Sabri","A-18-07, Villawangsamas Condominium, Jalan Seri Wangsa 2, 53300, Kuala Lumpur","0192669420",0);


 ?>
