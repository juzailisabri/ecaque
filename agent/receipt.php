<?php
session_start();
// error_reporting(0);

include("../administrator/conn.php");
$oid = $_GET["oid"];

if(!isset($_SESSION['AGENT']['ID']) && empty($_SESSION['AGENT']['ID'])) {
  header("Location: ../login");
} else {
}


function getOrderDetail($id){
  global $conn;
  global $secretKey;
  $erid = $id;

  $s = "SELECT
  SHA2(er_id,256) as enc_id,
  er_id,
  er_date,
  DATE_FORMAT(er_date,'%Y') as invyear,
  DATE_FORMAT(er_date,'%m') as invmonth,
  er_fullname,
  er_address,
  er_phone,
  er_rjp_id,
  rjp_name,
  er_postage,
  er_totalprice,
  er_trackingNo,
  er_payment_date,
  er_packing_date,
  rdc_name,
  rdc_link
  FROM e_receipt
  LEFT JOIN ref_jenisPenghantaran ON rjp_id = er_rjp_id
  LEFT JOIN ref_deliveryCourier ON rdc_id = er_rdc_id
  WHERE MD5(CONCAT('$secretKey',er_id)) = '$erid' ";

  $arr1 = [];
  $result = $conn->query($s);
  while ($row = $result->fetch_assoc())
  {
    $arr1[] = $row;
  }

  $s = "SELECT
  SHA2(erd_id,256) as enc_id,
  erd_id,
  erd_er_id,
  erd_rp_id,
  erd_quantity,
  erd_rp_price,
  erd_datetime,
  rp_name
  FROM e_receipt_detail
  LEFT JOIN ref_product ON rp_id = erd_rp_id
  WHERE MD5(CONCAT('$secretKey',erd_er_id)) = '$erid'";

  $arr2 = [];
  $result = $conn->query($s);
  while ($row = $result->fetch_assoc())
  {
    $arr2[] = $row;
  }

  $arr["ER"] = $arr1;
  $arr["ERD"] = $arr2;

  return $arr;
}

function convertToTable($data){
    $trbody = "";
    global $er_deliveryCharges;
    $gt_erd_quantity = 0;
    $gt_erd_price = 0;
    $gt_erd_total = 0;

    foreach ($data as $key => $value) {
      $rp_name = $data[$key]['rp_name'];
      $erd_rp_id = $data[$key]['erd_rp_id'];
      $erd_quantity = $data[$key]['erd_quantity'];
      $erd_price = $data[$key]['erd_rp_price'];
      $erd_total = $data[$key]["erd_rp_price"] * $data[$key]["erd_quantity"];

      $gt_erd_quantity = $gt_erd_quantity + $erd_quantity;
      $gt_erd_price = $gt_erd_price + $erd_price;
      $gt_erd_total = $gt_erd_total + $erd_total;

      $trbody .=
      "<tr>
        <td width=\"50px\" align=\"center\">$erd_rp_id</td>
        <td width=\"270px\">$rp_name</td>
        <td width=\"100px\"align=\"center\">$erd_quantity</td>
        <td width=\"125px\" align=\"center\">RM $erd_price</td>
        <td width=\"100px\" align=\"center\">RM $erd_total</td>
      </tr>";
    }

    $gt_erd_total = $gt_erd_total + $er_deliveryCharges;

    $trbody .=
    "<tr>
      <td width=\"50px\" align=\"center\">D</td>
      <td width=\"370px\">Delivery Charges</td>
      <td width=\"125px\" align=\"center\">RM $er_deliveryCharges</td>
      <td width=\"100px\" align=\"center\">RM $er_deliveryCharges</td>
    </tr>
    <tr>
      <td width=\"50px\" align=\"center\"><b>T</b></td>
      <td width=\"270px\"><b>Jumlah</b></td>
      <td width=\"100px\"align=\"center\"><b>$gt_erd_quantity</b></td>
      <td width=\"125px\" align=\"center\"><b>-</b></td>
      <td width=\"100px\" align=\"center\"><b>RM $gt_erd_total</b></td>
    </tr>";

    return $trbody;
}

$data = getOrderDetail($_GET["oid"]);
$er_deliveryCharges = $data["ER"][0]["er_postage"];
$bodytable = convertToTable($data["ERD"]);

$footertable = "";
//============================================================+
// File name   : example_061.php
// Begin       : 2010-05-24
// Last Update : 2014-01-25
//
// Description : Example 061 for TCPDF class
//               XHTML + CSS
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: XHTML + CSSaa
 * @author Nicola Asuni
 * @since 2010-05-25
 */

// Include the main TCPDF library (search for installation path).
require_once('../tcpdf/tcpdf.php');
function colorFunction($var,$on,$off){
  if($var == ""){
    return $off;
  } else {
    return $on;
  }
}
class MYPDF extends TCPDF {

    //Page header


    public function Header() {
      global $data;
      global $oid;
      global $rootdir;
      $er_dateorder = $data["ER"][0]["er_date"];
      $rjp_name = $data["ER"][0]["rjp_name"];
      $rtp_name = "";
      if($rtp_name=="")$rtp_name="Client's Address";
      $er_deliveryCharges = $data["ER"][0]["er_postage"];
      $rs_name = $data["ER"][0]["er_fullname"];
      $er_address = $data["ER"][0]["er_address"];
      $er_phone = $data["ER"][0]["er_phone"];
      $rdc_name = $data["ER"][0]["rdc_name"];
      $rdc_link = $data["ER"][0]["rdc_link"];
      $er_trackingNo = $data["ER"][0]["er_trackingNo"];
      $er_payment_date = $data["ER"][0]["er_payment_date"];
      $er_packing_date = $data["ER"][0]["er_packing_date"];
      $er_payment_dateC = colorFunction($er_payment_date,"black","grey");
      $er_packing_dateC = colorFunction($er_packing_date,"black","grey");
      $er_payment_dateCA = colorFunction($er_payment_date,array(0, 0, 0),array(200, 200, 200));
      $er_packing_dateCA = colorFunction($er_packing_date,array(0, 0, 0),array(200, 200, 200));
      $er_payment_paid = colorFunction($er_payment_date,"PAID","UNPAID");

      $invyear = $data["ER"][0]["invyear"];
      $invmonth = $data["ER"][0]["invmonth"];
      $er_id = sprintf("%08d", $data["ER"][0]["er_id"]);

      $invcode = "INV-$invyear$invmonth$er_id";

      $style = array(
        'border' => 0,
        'fgcolor' => array(0,0,0),
        'bgcolor' => false, //array(255,255,255)
        'module_width' => 1, // width of a single module in points
        'module_height' => 1 // height of a single module in points
        );

        $qrlink = "http://".$_SERVER["HTTP_HOST"]."$rootdir/status?oid=$oid";


        $this->write2DBarcode($qrlink, 'QRCODE,L', 155, 10, 50, 50, $style, 'N');

        $this->SetFont('helvetica', 'R', 10);
        $this->SetY(60);
        $y = 106.5;

        $this->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => $er_payment_dateCA));
        $this->Polygon(array(44,$y,85,$y));
        $this->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => $er_packing_dateCA));
        $this->Polygon(array(126,$y,160,$y));
        $this->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(200, 200, 200)));
        // $this->Polygon(array(15,100,197,100));
        $htbl = "<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\">
            <tr>
                <td><b>PURCHASE ORDER</b></td>
                <td></td>
            </tr>
            <br>
            <tr>
                <td><sub>Customer Name:</sub></td>
                <td><sub>Invoice No:</sub></td>
            </tr>
            <tr>
                <td>$rs_name</td>
                <td>$invcode</td>
            </tr>
            <tr>
                <td><sub>Client Address:</sub></td>
                <td><sub>Delivery Method:</sub></td>
            </tr>
            <tr>
                <td>$er_address</td>
                <td>$rjp_name</td>
            </tr>
            <tr>
                <td><sub>Payment</sub></td>
                <td><sub>Tracking No.</sub></td>
            </tr>
            <tr>
                <td>$er_payment_paid</td>
                <td>$rdc_name - <a href=\"$rdc_link$er_trackingNo\">$er_trackingNo </a></td>
            </tr>
        </table>";

        $tbl =
        "
        <table cellspacing=\"0\" cellpadding=\"0\" border=\"0\">
          <tr>
            <td align=\"left\"><b>Order Placed</b></td>
            <td color=\"$er_payment_dateC\" align=\"center\"><b>Payment Verified</b></td>
            <td color=\"$er_packing_dateC\" align=\"right\"><b>Packing Process</b></td>
          </tr>
          <tr>
            <td align=\"left\"><small>$er_dateorder</small></td>
            <td color=\"$er_payment_dateC\" align=\"center\"><small>$er_payment_date</small></td>
            <td color=\"$er_packing_dateC\" align=\"right\"><small>$er_packing_date</small></td>
          </tr>
        </table>";
        $this->SetY(60);
        $this->writeHTML($htbl, true, false, false, false, '');
        $this->SetY(102);
        $this->writeHTML($tbl, true, false, false, false, '');
        $image_file = '../assets/images/Logo_2020_Black.png';
        $this->Image($image_file, 14, 10, 60, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-20);
        // // Set font
        $this->SetFont('helvetica', '', 8);
        //
        // $num = trim($this->getAliasNumPage());
        // // Page number
        // // $this->Cell(0, 10, ''.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        // $this->SetFont('helvetica', 'B', 12);
        $html =
        "
        <p align=\"center\">eCaque Enterprise SA 0361462-T | No.23 Jalan Purnama 2/3, Taman Purnama 2 45300 Sungai Besar, Selangor Darul Ehsan <br><b> +6012.354.3797 | fb: ecaque fruit cake | ig: ecaque.my</b></p>
        ";

          // $this->Cell(0, 10, "", 0, 1, 'C', 0, '', 0);

        $this->writeHTMLCell(0, 0, '', '', $html, 0, 0, false, "", true);
    }
}
// create new PDF document
$pdf = new MYPDF("P", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('eCaque');
$pdf->SetTitle('Purchase Order eCaque');
$pdf->SetSubject('Purchase Order eCaque');
$pdf->SetKeywords('TCPDF, PDF');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 120, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 70);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 9);

// add a page
$pdf->AddPage();

/* NOTE:
 * *********************************************************
 * You can load external XHTML using :
 *
 * $html = file_get_contents('/path/to/your/file.html');
 *
 * External CSS files will be automatically loaded.
 * Sometimes you need to fix the path of the external CSS.
 * *********************************************************
 */

// echo "<img src='data:image/$ext;base64,$image'>";
// exit;

// define some HTML content with style
$html = "
<!-- EXAMPLE OF CSS STYLE -->
<style>
    h1 {
        color: navy;
        font-family: times;
        font-size: 24pt;
        text-decoration: underline;
    }
    p.first {
        color: #003300;
        font-family: helvetica;
        font-size: 12pt;
    }
    p.first span {
        color: #006600;
        font-style: italic;
    }

    p {
      font-size: 9pt;
      line-height:20px;
    }

    table.first {
        border: none;
    }
    td {
        border: none;
        height: 40px;
    }
    td.second {
        border: 1;
    }

    table > tbody > tr.first {
      border: 1;
    }

    .lowercase {
        text-transform: lowercase;
    }
    .uppercase {
        text-transform: uppercase;
    }
    .capitalize {
        text-transform: capitalize;
    }

    .bold {
      font-weight: bolder;
    }
</style>


<table cellpadding=\"5\" border=\"0.1\">
  <tbody>
    <tr>
      <td width=\"50px\" align=\"center\"><b>#</b></td>
      <td width=\"270px\"><b>Nama Produk</b></td>
      <td width=\"100px\"align=\"center\"><b>Kuantiti</b></td>
      <td width=\"125px\" align=\"center\"><b>Harga Seunit</b></td>
      <td width=\"100px\" align=\"center\"><b>Jumlah</b></td>
    </tr>
    $bodytable

  </tbody>
  <tfooter>
    $footertable
  </tfooter>
</table>
<br><br><br>
<b>Notes</b><br>
Company Name : eCaque Enterprise <br>
Bank Name : CIMB Bank Berhad <br>
Current Account : 8603 2937 39 <br><br>

Thank you.<br><br>
<b>Faridah Borham</b><br>
eCaque Enterprise";

$pdf->writeHTML($html, true, false, true, false);
$pdf->Output('eCaque Stokist Invoice #0000.pdf', 'I');

?>
