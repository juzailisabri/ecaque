<?php
include("administrator/conn.php");
// echo makePayment("eCaque Kek Kukus","eCaque Kek Kukus","INV-2020041022313","JUZAILI BIN AHMAD SABRI","juzaili.sabri@gmail.com","0192669420",1);
function makePayment($billname,$description,$invoiceNo,$clientName,$email,$phone,$amount){
  global $rootdir;

  $arr = [];
  $json = json_encode($arr);

  $callback = "http://".$_SERVER["HTTP_HOST"]."$rootdir/paycallback";
  $returnUrl = "http://".$_SERVER["HTTP_HOST"]."$rootdir/payreturn";
  $toyyiburl = "https://toyyibpay.com/";

  $some_data = array(
    'userSecretKey'=>'uklwto43-1pyw-ff2m-tytv-52fp4llf5eo4',
    'categoryCode'=>'4eqpy4gs',
    'billName'=> $billname,
    'billDescription'=> $description,
    'billPriceSetting'=>1,
    'billPayorInfo'=>1,
    'billAmount'=>$amount,
    'billReturnUrl'=>$returnUrl,
    'billCallbackUrl'=>$callback,
    'billExternalReferenceNo' => $invoiceNo, // INVNO
    'billTo'=> $clientName, // CLIENTNAME
    'billEmail'=> $email, // EMAIL
    'billPhone'=> $phone, // PHONE
    'billSplitPayment'=>0,
    'billSplitPaymentArgs'=>'',
    'billPaymentChannel'=>'0',
    'billDisplayMerchant'=>1,
    'billContentEmail'=>'Thank you for purchasing our product!',
    'billAdditionalField' => $json,
    'billChargeToCustomer'=>1
  );

  $curl = curl_init();
  curl_setopt($curl, CURLOPT_POST, 1);
  curl_setopt($curl, CURLOPT_URL, 'https://toyyibpay.com/index.php/api/createBill');
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $some_data);

  $result = curl_exec($curl);
  $info = curl_getinfo($curl);
  curl_close($curl);

  $obj = json_decode($result, true);
  $resstring = $obj[0]["BillCode"];
  $toyyiburl = $toyyiburl.$resstring;

  return $toyyiburl;
}

?>
