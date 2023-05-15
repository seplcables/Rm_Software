<?php
require_once "fpdf182/fpdf.php";
class ConductPDF extends FPDF {
function vcell($c_width,$c_height,$x_axis,$text){
$w_w=$c_height/3;
$w_w_1=$w_w+2;
$w_w1=$w_w+$w_w+$w_w+3;
$len=strlen($text);// check the length of the cell and splits the text into 7 character each and saves in a array 

$lengthToSplit = 7;
if($len>$lengthToSplit){
$w_text=str_split($text,$lengthToSplit);
$this->SetX($x_axis);
$this->Cell($c_width,$w_w_1,$w_text[0],'','','');
if(isset($w_text[1])) {
    $this->SetX($x_axis);
    $this->Cell($c_width,$w_w1,$w_text[1],'','','');
}
$this->SetX($x_axis);
$this->Cell($c_width,$c_height,'','LTRB',0,'L',0);
}
else{
    $this->SetX($x_axis);
    $this->Cell($c_width,$c_height,$text,'LTRB',0,'L',0);}
    }
 }
$pdf = new ConductPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','',16);
$pdf->Ln();
$x_axis=$pdf->getx();
$c_width=20;// cell width 
$c_height=6;// cell height
$text="aim success ";// content 
$pdf->vcell($c_width,$c_height,$x_axis,'Hi1');// pass all values inside the cell 
$x_axis=$pdf->getx();// now get current pdf x axis value
$pdf->vcell($c_width,$c_height,$x_axis,'Hi2');
$x_axis=$pdf->getx();
$pdf->vcell($c_width,$c_height,$x_axis,'Hi3');
$pdf->Ln();
$x_axis=$pdf->getx();
$c_width=20;
$c_height=12;
$text="aim success ";
$pdf->vcell($c_width,$c_height,$x_axis,'Hi4');
$x_axis=$pdf->getx();
$pdf->vcell($c_width,$c_height,$x_axis,'Hi5');
$x_axis=$pdf->getx();
$pdf->vcell($c_width,$c_height,$x_axis,'Hi5');
$pdf->Ln();
$x_axis=$pdf->getx();
$c_width=20;
$c_height=12;
$text="All the best";
$pdf->vcell($c_width,$c_height,$x_axis,'Hai');
$x_axis=$pdf->getx();
$pdf->vcell($c_width,$c_height,$x_axis,'VICKY');
$x_axis=$pdf->getx();
$pdf->vcell($c_width,$c_height,$x_axis,$text);
$pdf->Ln();
$x_axis=$pdf->SetX(15);
$c_width=20;
$c_height=6;
$text="Good";
$pdf->vcell(20,6,$x_axis,'Hai');
$x_axis=$pdf->SetX(15);
$pdf->vcell(20,6,$x_axis,'vignesh');
$x_axis=$pdf->SetX(15);
$pdf->vcell(20,6,$x_axis,$text);
$pdf->Output();
?>