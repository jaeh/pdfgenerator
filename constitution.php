<?php 

function constitution($pdf) {
  $article_size = 12;
  $section_size = 10;
  $text_size = 8;
  
  $pdf->AddPage('P', 'A5');

  $pdf->SetY(20);

  $pdf->SetFont('OCRA', '', $article_size);
  $pdf->Cell(0, 10, "United States Constitution, Article I:", 0,0,'C');

  $pdf->SetY(30);
  $pdf->SetFont('OCRA', '', $text_size);
  $pdf->MultiCell(0, 5, "Congress shall make no law abridging the freedom of speech, or of the press; or the right of the people peaceably to assemble, and to petition the Government for a redress of grievances.");


  $pdf->SetY(60);
  $pdf->SetFont('OCRA', '', $article_size);
  $pdf->Cell(0, 10, "Declaration of human rights, preamble:", 0,0,'C');

  $pdf->SetY(70);
  $pdf->SetFont('OCRA', '', $text_size);
  $pdf->MultiCell(0,5, "The General Assembly, Proclaims this Universal Declaration of Human Rights as a common standard of achievement for all peoples and all nations, to the end that every individual and every organ of society, keeping this Declaration constantly in mind, shall strive by teaching and education to promote respect for these rights and freedoms and by progressive measures, national and international, to secure their universal and effective recognition and observance.");

  $pdf->MultiCell(0,5, "Whereas recognition of the inherent dignity and of the equal and inalienable rights of all members of the human family is the foundation of freedom, justice and peace in the world.");

  $pdf->MultiCell(0,5, "Whereas disregard and contempt for human rights have resulted in barbarous acts which have outraged the conscience of mankind, and the advent of a world in which human beings shall enjoy freedom of speech and belief and freedom from fear and want has been proclaimed as the highest aspiration of the common people");
}
