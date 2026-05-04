<?php
// Notificar todos los errores de PHP (ver el registro de cambios)
//error_reporting(E_ALL);

define("RelativePath", "..");
include(RelativePath . "/Common.php");
define('FPDF_FONTPATH',RelativePath . '/fpdf/font/');
include(RelativePath . "/fpdf/fpdf.php");
//include(RelativePath . "/scripts/separar_num.php");

$db = new clsDBtdf_nuevo();
$db2 = new clsDBtdf_nuevo();
$autor = CCDLookUp('usuario_nombre','_usuarios','usuario_id = ' . CCGetUserID(),$db);

class PDF extends FPDF{
	function Header(){
		//Title
		$this->SetXY(8,15);
		$this->Cell(200,18,'',1,1,'C');
		$this->Image(RelativePath . '/imagenes/header_rpt_2.jpg',8,15,200,18);
		$this->SetFont('Arial','',8);
		//$this->Cell(200,6,'Fecha: ' . date('d/m/Y H:i:s'),0,1,'R');
		//$this->Ln(3);
		//Ensure table header is output
		parent::Header();
	}
	function Footer(){
		//Posición: a 1,5 cm del final
		$this->SetY(-15);
		//Arial italic 8
		$this->SetFont('Arial','I',8);
		//Número de página
		$this->Cell(0,4,"“Las Islas Malvinas, Georgias y Sándwich del sur, son y serán argentinas”",0,1,'C');
		//$this->SetFont('Arial','I',6);
		//$this->Cell(0,4,'Pagina '.$this->PageNo().' de {nb}',0,1,'C');
	}
	
}

$SQL = "SELECT previsado_capa_cad_desc, previsado_capa_cad_orden FROM previsados_capas_cad ORDER BY previsado_capa_cad_orden";	
	
$db->query($SQL);

if($db->num_rows(previsado_capa_cad_desc)){	
	$pdf = new PDF('P','mm','A4');
	$pdf->AliasNbPages();
	$pdf->SetMargins(8,15);
	$pdf->Open();
	
	$pdf->AddPage();	
	$pdf->SetFont('Arial','B',10);
	$pdf->SetY(33);
	$pdf->MultiCell(195,6,"FORMATO DE ARCHIVO DE CARGA",1,'C');
	$texto1 = "Como complemento de la Circular 01/12, Inciso 2 y a los fines de agilizar el trámite de estudio de los planos en ésta Dirección General, se solicita a los Sres Profesionales que en la presentación de archivos digitales deberá respetarse cada una de las capas y sus 	características según cuadro de referencia indicando al pie.";
	$pdf->MultiCell(195,5,$texto1,1,'I');
	$pdf->MultiCell(195,5," ",0,'C');
	
	$pdf->MultiCell(195,5,"Listado de capas",1,'C');
		
	$pdf->Cell(15,5,"Orden",1,'I');
	$pdf->MultiCell(180,5,"Descripción",1,'I');
	$pdf->SetFont('Arial','',10);
	while ($db->next_record())
	{		
		$pdf->Cell(15,5,$db->f(previsado_capa_cad_orden),1,'C');
		$pdf->MultiCell(180,5,$db->f(previsado_capa_cad_desc),1,'I');
		//$pdf->MultiCell(65,5,$db->f(previsado_capa_cad_orden)." - ".$db->f(previsado_capa_cad_desc),1,'I');
	}
	$pdf->MultiCell(195,5," ",0,'C');
	$pdf->SetFont('Arial','B',10);
	$texto2 = "En caso de incumplir este requerimiento NO se procederá al estudio del plano.\n Toda documentación presentada deberá ajustarse a la reglamentación vigente.";
	$pdf->MultiCell(195,6,$texto2,1,'C');
	$pdf->Output();
}

$db->close();
$db2->close();

?>