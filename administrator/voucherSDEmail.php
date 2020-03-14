<?php
// session_start();

// if(!isset($_SESSION['USERNAME']) && empty($_SESSION['USERNAME']) && !$_SESSION['BEUSER']) {
//    header("Location: login");
// }
//
// if(isset($_REQUEST["id"])){
//   $id = $_REQUEST["id"];
// } else {
//   exit;
// }
//
// include("conn.php");

function gettable($id){
  global $conn;

  $sql = "SELECT aap_id, pt2_nama_pemohon, pt2_no_kp_pemohon, pt2_no_akaun, rbnk_short, pt2_no_telefon_pemohon,
  DATE_FORMAT(tarikh_permohonan, '%d-%m-%Y') as tarikh_permohonan, kaunter_application_stat,
  rs_color, rs_name, rs_icon, pt2_no_kp_pemohon as enc_id, ppbsd_rate
  FROM a_applicant_permohonan
  LEFT JOIN ref_status ON penyemak_stat = rs_id
  LEFT JOIN ref_bank ON rbnk_id = pt2_nama_bank
  LEFT JOIN p_payment_baucar_sd ON ppbsd_id = pembayaran_ppbsd_id
  WHERE SHA2(pembayaran_ppbsd_id,256) = '$id'";

  $result = $conn->query($sql);
  $html = "";
  $totalrate = 0;
  $x = 1;
  while ($row = $result->fetch_assoc()) {
    $pt2_nama_pemohon = $row["pt2_nama_pemohon"];
    $pt2_no_kp_pemohon = $row["pt2_no_kp_pemohon"];
    $pt2_no_akaun = $row["pt2_no_akaun"];
    $rbnk_short = $row["rbnk_short"];
    $pt2_no_telefon_pemohon = $row["pt2_no_telefon_pemohon"];
    $ppbsd_rate = $row["ppbsd_rate"];
    $html .=
    "<tr>
      <td align=\"center\">$x</td>
      <td>$pt2_nama_pemohon</td>
      <td align=\"center\">$pt2_no_kp_pemohon</td>
      <td align=\"center\">$rbnk_short</td>
      <td align=\"center\">$pt2_no_akaun</td>
      <td align=\"center\">$pt2_no_telefon_pemohon</td>
      <td align=\"center\">RM $ppbsd_rate</td>
    </tr>";
    $totalrate = $totalrate + $ppbsd_rate;
    $x++;
  }

  $footer =
  "<tr>
    <td></td>
    <td colspan=\"5\"><strong>Jumlah</strong></td>
    <td align=\"center\">RM $totalrate</td>
  </tr>";

  $ret["body"] = $html;
  $ret["footer"] = $footer;

  return $ret;
}

function getppb($id){
  global $conn;

  $s1 = "SELECT DATE_FORMAT(ppbsd_datetime,'%d/%m/%Y') as ppbsd_datetime, ppbsd_pngesah1_uu_id, ppbsd_pngesah2_uu_id, ppbsd_pngesah3_uu_id FROM p_payment_baucar_sd WHERE SHA2(ppbsd_id,256) = '$id'";
  $result = $conn->query($s1);
  $row = $result->fetch_assoc();

  $ppbsd_pngesah1_uu_id = $row["ppbsd_pngesah1_uu_id"];
  $ppbsd_pngesah2_uu_id = $row["ppbsd_pngesah2_uu_id"];
  $ppbsd_pngesah3_uu_id = $row["ppbsd_pngesah3_uu_id"];
  $date = $row["ppbsd_datetime"];

  $s = "SELECT uu_id, uu_fullname, rpkt_name FROM u_user LEFT JOIN ref_pangkat ON rpkt_id = uu_rpkt_id WHERE uu_id IN ('$ppbsd_pngesah1_uu_id','$ppbsd_pngesah2_uu_id','$ppbsd_pngesah3_uu_id')";

  $ppbsd_pngesah1arr = array();
  $ppbsd_pngesah2arr = array();
  $ppbsd_pngesah3arr = array();
  $result = $conn->query($s);
  while ($row = $result->fetch_assoc()) {
    if($ppbsd_pngesah1_uu_id == $row["uu_id"]){ $ppbsd_pngesah1arr[] = $row; }
    if($ppbsd_pngesah2_uu_id == $row["uu_id"]){ $ppbsd_pngesah2arr[] = $row; }
    if($ppbsd_pngesah3_uu_id == $row["uu_id"]){ $ppbsd_pngesah3arr[] = $row; }
  }

  $ret = array (
    "p1" => $ppbsd_pngesah1arr[0],
    "p2" => $ppbsd_pngesah2arr[0],
    "p3" => $ppbsd_pngesah3arr[0],
    'date' => $date
  );

  return $ret;
}

$ppb = getppb($id);

$ppb_pngesah1name = $ppb["p1"]["uu_fullname"];
$ppb_pngesah2name = $ppb["p2"]["uu_fullname"];
$ppb_pngesah3name = $ppb["p3"]["uu_fullname"];

$ppb_pngesah1pkt = $ppb["p1"]["rpkt_name"];
$ppb_pngesah2pkt = $ppb["p2"]["rpkt_name"];
$ppb_pngesah3pkt = $ppb["p3"]["rpkt_name"];
$ppb_date = $ppb["date"];

$rows = gettable($id);
$bodytable = $rows["body"];
$footertable = $rows["footer"];
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
        // Logo
        // $image_file = K_PATH_IMAGES.'logo_example.jpg';
        // $this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetY(20);

        $this->SetFont('helvetica', 'B', 12);
        // Title
        $this->Cell(0, 10, 'PENYATA BAYARAN HADIAH PENGAJIAN IPT (SARA DIRI)', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->SetY(25);
        $this->Cell(0, 10, 'KERAJAAN NEGERI SELANGOR', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        global $ppb_pngesah1name;
        global $ppb_pngesah2name;
        global $ppb_pngesah3name;
        global $ppb_pngesah1pkt;
        global $ppb_pngesah2pkt;
        global $ppb_pngesah3pkt;
        // Position at 15 mm from bottom
        $this->SetY(-60);
        // // Set font
        $this->SetFont('helvetica', '', 9.5);
        //
        // $num = trim($this->getAliasNumPage());
        // // Page number
        // // $this->Cell(0, 10, ''.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        // $this->SetFont('helvetica', 'B', 12);
        $html =
        "";

          // $this->Cell(0, 10, "", 0, 1, 'C', 0, '', 0);

        $this->writeHTMLCell(0, 0, '', '', $html, 0, 0, false, "", true);
    }
}
// create new PDF document
$pdf = new MYPDF("L", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

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
$pdf->SetMargins(PDF_MARGIN_LEFT, 35, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 23);

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
    }
    td.second {
        border: none;
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


<p>Tarikh: $ppb_date</p>

<table cellpadding="5" border="1">
  <tbody>
  <tr>
    <td width="50px" align="center"><b>#</b></td>
    <td width="250px"><b>Nama Pemohon</b></td>
    <td width="160px"align="center"><b>No. Kad Pengenalan</b></td>
    <td width="125px" align="center"><b>Nama Bank</b></td>
    <td width="125px" align="center"><b>No. Akaun</b></td>
    <td width="125px" align="center"><b>No. Telefon</b></td>
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
$attachfile = $pdf->Output('Voucher.pdf', 'S');

//============================================================+
// END OF FILE
//============================================================+
