<?php
define("RelativePath", "..");
include(RelativePath . "/Common.php");
define('FPDF_FONTPATH',RelativePath . '/fpdf/font/');
include(RelativePath . "/fpdf/fpdf.php");

// -------------------------
  /* Incluye el archivo de configuraciones generales
  ---------------------------------------------------------- */
include( RelativePath . '/configuracion_general.php');

function rptPlanchetaImageFit($pdf, $imagen, $margin = 5)
{
	$pageW = $pdf->w - 2 * $margin;
	$pageH = $pdf->h - 2 * $margin;
	$size = @getimagesize($imagen);
	if ($size) {
		list($imgW, $imgH) = $size;
		$w = $pageW;
		$h = $w * $imgH / $imgW;
		if ($h > $pageH) {
			$h = $pageH;
			$w = $h * $imgW / $imgH;
		}
		$x = ($pdf->w - $w) / 2;
		$y = ($pdf->h - $h) / 2;
		$pdf->Image($imagen, $x, $y, $w, $h);
	} else {
		$pdf->Image($imagen, $margin, $margin, $pageW);
	}
}

/*
$db = new clsDBtdf_nuevo();

$imagen = RelativePath . "/planchetas/archivos/" . CCDLookUp('plancheta_file','planchetas','plancheta_id = ' . CCGetParam(plancheta_id),$db);

if($imagen){
	$pdf = new FPDF('L','mm','Legal');
	$pdf->Open();
	$pdf->AddPage();
	$pdf->Image($imagen,5,5,300);
	$pdf->Output();
}
$db->close();
*/


$db = new clsDBtdf_nuevo();

$SQL="SELECT * FROM planchetas WHERE plancheta_id = ".CCGetParam(plancheta_id);
$db->query($SQL);

if($db->next_record()){
	$pdf = new FPDF('L','mm','Legal');
	$pdf->Open();
	$dpto_id=$db->f("tipo_depto_parc_id");
	$padron_id=$db->f("tipo_padron_parc_id");
	$plancheta_scc=$db->f("plancheta_scc");
	$plancheta_mzo=$db->f("plancheta_mzo");
	$parcela_par=$db->f("parcela_par");
}
if($plancheta_mzo != '' && $parcela_par == ''){
$SQL="SELECT * FROM planchetas WHERE tipo_depto_parc_id = '".$dpto_id."' AND tipo_padron_parc_id = '".$padron_id."' AND plancheta_scc = '".$plancheta_scc."' AND plancheta_mzo = '".$plancheta_mzo."' ORDER BY plancheta_hoja";
}elseif($plancheta_mzo == '' && $parcela_par != ''){
$SQL="SELECT * FROM planchetas WHERE tipo_depto_parc_id = '".$dpto_id."' AND tipo_padron_parc_id = '".$padron_id."' AND plancheta_scc = '".$plancheta_scc."' AND plancheta_par = '".$parcela_par."'ORDER BY plancheta_hoja";
}elseif($plancheta_mzo != '' && $parcela_par != ''){
$SQL="SELECT * FROM planchetas WHERE tipo_depto_parc_id = '".$dpto_id."' AND tipo_padron_parc_id = '".$padron_id."' AND plancheta_scc = '".$plancheta_scc."' AND plancheta_mzo = '".$plancheta_mzo."' AND plancheta_par = '".$parcela_par."'ORDER BY plancheta_hoja";
}
//echo $SQL;exit;
$db->query($SQL);
while($db->next_record()){
	$pdf->AddPage();
	$imagen = PLANCHETAS_PATH . "/" . $db->f("plancheta_file");
	rptPlanchetaImageFit($pdf, $imagen);
}
if($dpto_id != ''){
	$pdf->Output();
}
$db->close();
//echo "No hay imagen de plancheta a mostar";


?>