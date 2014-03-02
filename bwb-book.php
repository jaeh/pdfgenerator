<?php

$fontpath = getcwd() . '/font/';

define('FPDF_FONTPATH', $fontpath);

require_once('fpdf/fpdf.php');
require_once('constitution.php');

class PDF extends FPDF {

  function _beginpage($orientation, $size) {
    $this->page++;

    if(!isset($this->pages[$this->page])) : // solves the problem of overwriting a page if it already exists
      $this->pages[$this->page] = '';
    endif;

    $this->state  =2;
    $this->x = $this->lMargin;
    $this->y = $this->tMargin;
    $this->FontFamily = '';
    // Check page size and orientation
    if($orientation=='')
        $orientation = $this->DefOrientation;
    else
        $orientation = strtoupper($orientation[0]);
    if($size=='') :
      $size = $this->DefPageSize;
    else :
      $size = $this->_getpagesize($size);
    endif;

    if($orientation!=$this->CurOrientation || $size[0]!=$this->CurPageSize[0] || $size[1]!=$this->CurPageSize[1]) :
        // New size or orientation
      if($orientation=='P') :
        $this->w = $size[0];
        $this->h = $size[1];
      else :
        $this->w = $size[1];
        $this->h = $size[0];
      endif;
      $this->wPt = $this->w*$this->k;
      $this->hPt = $this->h*$this->k;
      $this->PageBreakTrigger = $this->h-$this->bMargin;
      $this->CurOrientation = $orientation;
      $this->CurPageSize = $size;
    endif;
    if($orientation!=$this->DefOrientation || $size[0]!=$this->DefPageSize[0] || $size[1]!=$this->DefPageSize[1]) :
      $this->PageSizes[$this->page] = array($this->wPt, $this->hPt);
    endif;
  }

  // Page header
  function Header() {
    //ugly hack to create the frontpage. no time to rtfm...
    if ( $this->PageNo() == 1 ) :
      $this->SetFont('OCRA', '', 18);
      $this->SetY(20);
      $this->Cell(0, 10, "Bitcoind - The Book", 0, 0, 'C');

      $this->SetY(40);
      $this->Image('img/KeepCalm.png', 25, null, 100);

    elseif ( $this->PageNo() > 1 ) :
      $this->SetFont('OCRA', '', 12);

      $this->Cell(0, 10, "Bitcoind - The Book", 0, 0, 'C');
      $this->Ln(15);
    endif;
  }

  // Page footer
  function Footer() {
    //~ if ( $this->PageNo() > 1 ) :
      // Position at .7 cm from bottom
      $this->SetY(-7);
      $this->Image('img/BWB-avatar.png', 135, null, 5);

      // OCRA italic 8
      $this->SetFont('OCRA', '', 6);
      // Page number
      $this->SetY(-5);
      $this->Cell(0, 0,'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');

      $this->SetY(-7);
      $this->Image('img/BTCF-avatar.png', 7, null, 5);
    //~ endif;
  }
}



// Instanciation of inherited class
$pdf = new PDF('P', 'mm', 'A5');
$pdf->AddFont('OCRA','','OCRA.php');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('OCRA','', 12);

constitution($pdf);

$dir = getcwd() . '/src';

$file_array = array();

$lines_per_page = 60;
$columns_per_page = 2;

if ($handle = opendir($dir)) {
  /* loop over the directory. */
  while (false !== ($filename = readdir($handle))) {

    $file_dir = $dir . '/' .$filename;

    //this gives us the content with multiple newlines. good for readability, bad for page size. 
    // todo: add bool to switch.
    $dcontent = file_get_contents($file_dir);

    //remove all multiple newlines:
    $content_array = explode("\n", $dcontent);
    $content = '';
    foreach ( $content_array as $c ) :
      if ( is_string($c) && $c != '' && $c != ' ' ) :
        $content .= "\n" . $c;
      endif;
    endforeach;

    $pdf->AddPage();

    $pdf->SetFont('OCRA', '', 10);

    $pdf->SetY(20);

    $pdf->Cell(0, 10, "File: " . $filename, 0, 0, 'C');

    $pdf->Ln(10);

    $pdf->SetFont('OCRA', '', 3);

    $pdf->MultiCell(0, 1.8, $content, 0, 1);

  }
  closedir($handle);
}

$pdf->Output('bitcoind.pdf', 'I');
?>
