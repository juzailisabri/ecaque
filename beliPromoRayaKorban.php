<?php
include("administrator/conn.php");

function getProductEncA($id){
  global $conn;
  global $secretKey;

  $select = "SELECT
  SHA2(CONCAT('$secretKey',rp_id),256) as productID FROM ref_product WHERE rp_id = $id";
  $arr = [];
  $result = $conn->query($select);
  while ($row = $result->fetch_assoc())
  {
    $arr[] = $row;
  }
  return $arr[0]["productID"];
}

$rp1 = getProductEncA(6);
$_GET["l"] = "true";
$_GET["rpid"] = $rp1;
include("index.php");

?>
