<?php
session_start();
error_reporting(0);
if(!isset($_SESSION['ID']) && empty($_SESSION['ID'])) {
   header("Location: ../login");
}
//
// if(isset($_REQUEST["id"])){
//   $id = $_REQUEST["id"];
// } else {
//   exit;
// }

include("conn.php");

function getStokistOrderDetail($id){
  global $conn;
  $eosid = $id;

  $s = "SELECT
  SHA2(eos_id,256) as enc_id,
  eos_es_id,
  DATE_FORMAT(eos_dateorder,'%d-%m-%Y %W') as eos_dateorder,
  DATE_FORMAT(eos_datepickup,'%d-%m-%Y %W') as eos_datepickup,
  rjp_name,
  rtp_name,
  eos_otherPlace,
  eos_deliveryCharges,
  rs_name,
  es_name,
  es_address,
  es_bandar,
  rngri_name,
  es_poskod,
  es_phone,
  es_email
  FROM e_orderstock
  LEFT JOIN e_stockist ON es_id = eos_es_id
  LEFT JOIN ref_negeri ON rngri_id = es_rngri_id
  LEFT JOIN ref_jenisPenghantaran ON rjp_id = eos_rjp_id
  LEFT JOIN ref_tempatPenghantaran ON rtp_id = eos_rtp_id
  LEFT JOIN ref_status ON rs_id = eos_status
  WHERE SHA2(eos_id,256) = '$eosid' ";

  $arr1 = [];
  $result = $conn->query($s);
  while ($row = $result->fetch_assoc())
  {
    $arr1[] = $row;
  }

  $s = "SELECT
  SHA2(eosp_id,256) as enc_id,
  eosp_rp_id,
  eosp_quantity,
  eosp_price,
  rp_name
  FROM e_orderstockproduct
  LEFT JOIN ref_product ON rp_id = eosp_rp_id
  WHERE SHA2(eosp_eos_id,256) = '$eosid'";

  $arr2 = [];
  $result = $conn->query($s);
  while ($row = $result->fetch_assoc())
  {
    $arr2[] = $row;
  }

  $arr["EOS"] = $arr1;
  $arr["EOSP"] = $arr2;

  return $arr;
}

function convertToTable($data){
    $trbody = "";
    global $eos_deliveryCharges;
    $gt_eosp_quantity = 0;
    $gt_eosp_price = 0;
    $gt_eosp_total = 0;

    foreach ($data as $key => $value) {
      $rp_name = $data[$key]['rp_name'];
      $eosp_rp_id = $data[$key]['eosp_rp_id'];
      $eosp_quantity = $data[$key]['eosp_quantity'];
      $eosp_price = $data[$key]['eosp_price'];
      $eosp_total = $data[$key]["eosp_price"] * $data[$key]["eosp_quantity"];

      $gt_eosp_quantity = $gt_eosp_quantity + $eosp_quantity;
      $gt_eosp_price = $gt_eosp_price + $eosp_price;
      $gt_eosp_total = $gt_eosp_total + $eosp_total;

      $trbody .=
      "<tr>
        <td width=\"50px\" align=\"center\">$eosp_rp_id</td>
        <td width=\"270px\">$rp_name</td>
        <td width=\"100px\"align=\"center\">$eosp_quantity</td>
        <td width=\"125px\" align=\"center\">RM $eosp_price</td>
        <td width=\"100px\" align=\"center\">RM $eosp_total</td>
      </tr>";
    }

    $gt_eosp_total = $gt_eosp_total + $eos_deliveryCharges;

    $trbody .=
    "<tr>
      <td width=\"50px\" align=\"center\">D</td>
      <td width=\"370px\">Delivery Chargers</td>
      <td width=\"125px\" align=\"center\">RM $eos_deliveryCharges</td>
      <td width=\"100px\" align=\"center\">RM $eos_deliveryCharges</td>
    </tr>
    <tr>
      <td width=\"50px\" align=\"center\"><b>T</b></td>
      <td width=\"270px\"><b>Jumlah</b></td>
      <td width=\"100px\"align=\"center\"><b>$gt_eosp_quantity</b></td>
      <td width=\"125px\" align=\"center\"><b>-</b></td>
      <td width=\"100px\" align=\"center\"><b>RM $gt_eosp_total</b></td>
    </tr>";

    return $trbody;
}

$data = getStokistOrderDetail($_GET["id"]);
$eos_deliveryCharges = $data["EOS"][0]["eos_deliveryCharges"];
$bodytable = convertToTable($data["EOSP"]);

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

class MYPDF extends TCPDF {

    //Page header
    public function Header() {
      global $data;
      $eos_dateorder = $data["EOS"][0]["eos_dateorder"];
      $eos_datepickup = $data["EOS"][0]["eos_datepickup"];
      $rjp_name = $data["EOS"][0]["rjp_name"];
      $rtp_name = $data["EOS"][0]["rtp_name"];
      if($rtp_name=="")$rtp_name="Client's Address";
      $eos_otherPlace = $data["EOS"][0]["eos_otherPlace"];
      $eos_deliveryCharges = $data["EOS"][0]["eos_deliveryCharges"];
      $rs_name = $data["EOS"][0]["rs_name"];
      $es_name = $data["EOS"][0]["es_name"];
      $es_address = $data["EOS"][0]["es_address"];
      $es_bandar = $data["EOS"][0]["es_bandar"];
      $rngri_name = $data["EOS"][0]["rngri_name"];
      $es_poskod = $data["EOS"][0]["es_poskod"];
      $es_phone = $data["EOS"][0]["es_phone"];
      $es_email = $data["EOS"][0]["es_email"];
        // Logo
        // $image_file = K_PATH_IMAGES.'logo_example.jpg';
        // $this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetY(20);

        $this->SetFont('helvetica', 'B', 18);
        $this->Cell(0, 10, 'STOCK ORDER', 0, false, 'R', 0, '', 0, false, 'M', 'M');
        $this->SetY(26);
        $this->SetFont('helvetica', 'R', 10);
        $this->Cell(0, 10, 'Invoice No: ECQ-HQ-000001', 0, false, 'R', 0, '', 0, false, 'M', 'M');

        $this->SetY(46);

        $tbl = <<<EOD
        <table cellspacing="0" cellpadding="0" border="0">
            <tr>
                <td><sub>Client Name:</sub></td>
                <td><sub>Order Date:</sub></td>
            </tr>
            <tr>
                <td>$es_name</td>
                <td>$eos_dateorder</td>
            </tr>
            <tr>
                <td><sub>Delivery Method:</sub></td>
                <td><sub>Pickup Date:</sub></td>
            </tr>
            <tr>
                <td>$rjp_name</td>
                <td>$eos_datepickup</td>
            </tr>
            <tr>
                <td><sub>Client Address:</sub></td>
                <td><sub>Pickup Location:</sub></td>
            </tr>
            <tr>
                <td>$es_address, $es_bandar, $es_poskod $rngri_name</td>
                <td>$rtp_name</td>
            </tr>
            <tr>
                <td><sub>Delivery Method:</sub></td>
                <td><sub></sub></td>
            </tr>
            <tr>
                <td>$rjp_name</td>
                <td></td>
            </tr>
        </table>
        EOD;

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
$pdf->SetAuthor('HPIPT Kerajaan Negeri Selangor');
$pdf->SetTitle('Penyata Bayaran HPIPT');
$pdf->SetSubject('Penyata Bayaran HPIPT');
$pdf->SetKeywords('TCPDF, PDF');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 90, PDF_MARGIN_RIGHT);
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
$html = <<<EOF
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


<table cellpadding="5" border="0.1">
  <tbody>
    <tr>
      <td width="50px" align="center"><b>#</b></td>
      <td width="270px"><b>Nama Produk</b></td>
      <td width="100px"align="center"><b>Kuantiti</b></td>
      <td width="125px" align="center"><b>Harga Seunit</b></td>
      <td width="100px" align="center"><b>Jumlah</b></td>
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
eCaque Enterprise



EOF;

// output the HTML content
$pdf->writeHTML($html, true, false, true, false);

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// add a page


// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('eCaque Stokist Invoice #0000.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
