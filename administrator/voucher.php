<?php

include("conn.php");

function getVoucher($id){
  global $conn;
  global $secretKey;

  $id = $_GET["id"];

  $s = "SELECT
  ev_id, rv_name, rv_svg FROM e_voucher
  LEFT JOIN ref_voucher ON rv_id = ev_rv_id
  WHERE SHA2(ev_id,256) = '$id' ";

  $arr = [];
  $result = $conn->query($s);
  while ($row = $result->fetch_assoc())
  {
    $arr[] = $row;
  }

  return $arr[0];
}

$ev = getVoucher($_GET["id"]);

// var_dump($ev);exit;

$svgfile = $ev["rv_svg"];
$name = $ev["rv_name"];
$code = "ECQ".sprintf("%011d", $ev["ev_id"]);

//============================================================+
// File name   : example_058.php
// Begin       : 2010-04-22
// Last Update : 2013-05-14
//
// Description : Example 058 for TCPDF class
//               SVG Image
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
 * @abstract TCPDF - Example: SVG Image
 * @author Nicola Asuni
 * @since 2010-05-02
 */

// Include the main TCPDF library (search for installation path).
require_once('../tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('eCaque Enterprise');
$pdf->SetTitle("$name $code");
$pdf->SetSubject("$name $code");
$pdf->SetKeywords('ecaque, voucher');

// set default header data
// $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 058', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(0, 0, 0);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 0);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

$pdf->setBarcode(date('Y-m-d H:i:s'));
// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 10);

// add a page
// $pdf->SetAutoPageBreak(TRUE, 40);
// $pdf->setPrintHeader(TRUE);
$pdf->SetPrintHeader(false);

$page_format = array(
    'MediaBox' => array ('llx' => 0, 'lly' => 0, 'urx' => 108, 'ury' => 200),
    'CropBox' => array ('llx' => 0, 'lly' => 0, 'urx' => 108, 'ury' => 200),
    'BleedBox' => array ('llx' => 0, 'lly' => 0, 'urx' => 108, 'ury' => 200),
    'TrimBox' => array ('llx' => 0, 'lly' => 0, 'urx' => 108, 'ury' => 200),
    'ArtBox' => array ('llx' => 0, 'lly' => 0, 'urx' => 108, 'ury' => 200),
    'Dur' => 3,
    'trans' => array(
        'D' => 1.5,
        'S' => 'Split',
        'Dm' => 'V',
        'M' => 'O'
    ),
    'Rotate' => 0,
    'PZ' => 1,
);

// Check the example n. 29 for viewer preferences

// add first page ---
$pdf->AddPage('P', $page_format, false, false);

$style = array(
    'position' => '',
    'align' => 'C',
    'stretch' => false,
    'fitwidth' => false,
    'cellfitalign' => '',
    'border' => false,
    'hpadding' => '1',
    'vpadding' => '1',
    'fgcolor' => array(0,0,0),
    'bgcolor' => false,//array(255,255,255),
    'text' => true,
    'font' => 'helvetica',
    'fontsize' => 6,
    'stretchtext' => 4
);

// $pdf->AddPage();
$pdf->SetPrintFooter(false);
// $pdf->setPrintFooter(TRUE);

// NOTE: Uncomment the following line to rasterize SVG image using the ImageMagick library.
// $pdf->setRasterizeVectorImages(true);

$pdf->ImageSVG($file="assets/voucher/$svgfile", $x=-46, $y=0, $w='1000', $h='1000', $link='https://www.ecaque.my', $align='left', $palign='', $border=10, $fitonpage=false);

// $code = "EQSYAWAL00000003";
// $code = "0985f353e3fe90152041440f36869d1d";

// $pdf->Cell(0, 0, $code, 0, 1);
$pdf->SetY(111);
$pdf->SetX(0);
$pdf->write1DBarcode($code, 'C128', '', '', '', 12, 0.5, $style, 'N');

$pdf->SetFont('helvetica', '', 8);
// $pdf->SetY(195);
// $txt = '© The copyright holder of the above Tux image is Larry Ewing, allows anyone to use it for any purpose, provided that the copyright holder is properly attributed. Redistribution, derivative work, commercial use, and all other use is permitted.';
// $pdf->Write(0, $txt, '', 0, 'L', true, 0, false, false, 0);

// ---------------------------------------------------------

//Close and output PDF document
// $pdf->Output('example_058.pdf', 'D');

ob_end_clean();
$pdf->Output("test.pdf", 'I');

//============================================================+
// END OF FILE
//============================================================+
?>
