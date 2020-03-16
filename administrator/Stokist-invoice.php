<?php
session_start();

// if(!isset($_SESSION['USERNAME']) && empty($_SESSION['USERNAME']) && !$_SESSION['BEUSER']) {
//    header("Location: login");
// }
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
  DATE_FORMAT(eos_dateorder,'%d-%m-%Y') as eos_dateorder,
  DATE_FORMAT(eos_datepickup,'%d-%m-%Y') as eos_datepickup,
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
  WHERE eos_id = '$eosid' ";

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
  WHERE eosp_eos_id = '$eosid'";

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
    foreach ($data as $key => $value) {
      $rp_name = $data[$key]['rp_name'];
      $eosp_rp_id = $data[$key]['eosp_rp_id'];
      $eosp_quantity = $data[$key]['eosp_quantity'];
      $eosp_price = $data[$key]['eosp_price'];
      $eosp_total = $data[$key]["eosp_price"] * $data[$key]["eosp_quantity"];

      $trbody .= "<tr>
        <td width=\"50px\" align=\"center\">$eosp_rp_id</td>
        <td width=\"270px\">$rp_name</td>
        <td width=\"100px\"align=\"center\">$eosp_quantity</td>
        <td width=\"125px\" align=\"center\">RM $eosp_price</td>
        <td width=\"100px\" align=\"center\">RM $eosp_total</td>
      </tr>";
    }

    return $trbody;
}

$data = getStokistOrderDetail(13);
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

        $m = 46;
        $d = 5;
        $this->SetFont('helvetica', 'R', 9);
        $this->SetY($m = $m+$d);
        $this->Cell(0, 5, 'Client Name: '.$es_name, 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $this->SetY($m = $m+$d);
        $this->Cell(0, 5, 'Client Address: '." $es_address, $es_bandar, $es_poskod $rngri_name", 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $this->SetY($m = $m+$d);
        $this->Cell(0, 5, 'Delivery Method: '." $rjp_name", 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $this->SetY($m = $m+$d);
        $this->Cell(0, 5, 'Delivery Charges:'." RM $eos_deliveryCharges", 0, false, 'L', 0, '', 0, false, 'M', 'M');

        $image_file = '../assets/images/Logo_2020_Black.png';
        $this->Image($image_file, 14, 10, 60, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    }

    // Page footer
    public function Footer() {


        // global $ppb_pngesah1name;
        // global $ppb_pngesah2name;
        // global $ppb_pngesah3name;
        // global $ppb_pngesah1pkt;
        // global $ppb_pngesah2pkt;
        // global $ppb_pngesah3pkt;
        // // Position at 15 mm from bottom
        // $this->SetY(-60);
        // // // Set font
        // $this->SetFont('helvetica', '', 9.5);
        // //
        // // $num = trim($this->getAliasNumPage());
        // // // Page number
        // // // $this->Cell(0, 10, ''.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        // // $this->SetFont('helvetica', 'B', 12);
        // $html =
        // "<p align=\"left\">Adalah disahkan bahawa penama di atas layak menerima Bayaran Hadiah Pengajian IPT Kerajaan Negeri Selangor selaras dengan keputusan Majlis Mesyuarat Kerajaan Negeri ke 4/2018</p>
        //
        // <div><hr></div>
        //
        // <table>
        //   <tr>
        //     <td></td>
        //     <td></td>
        //     <td align=\"left\">Bayaran Hadiah Pengajian IPT Kerajaan Negeri Selangor di atas adalah diluluskan.<br><br>
        //     </td>
        //   </tr>
        //     <tr>
        //       <td align=\"left\">($ppb_pngesah1name) <br> $ppb_pngesah1pkt <br> Tarikh: </td>
        //       <td align=\"left\">($ppb_pngesah2name) <br> $ppb_pngesah2pkt <br> Tarikh: </td>
        //       <td align=\"left\">($ppb_pngesah3name) <br> $ppb_pngesah3pkt <br> Tarikh: </td>
        //     </tr>
        // </table>";
        //
        //   // $this->Cell(0, 10, "", 0, 1, 'C', 0, '', 0);
        //
        // $this->writeHTMLCell(0, 0, '', '', $html, 0, 0, false, "", true);
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
$pdf->SetMargins(PDF_MARGIN_LEFT, 80, PDF_MARGIN_RIGHT);
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
