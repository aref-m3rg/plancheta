<?php
define("RelativePath", "..");
include(RelativePath . "/Common.php");
require_once RelativePath . "/configuracion_general.php";
require_once RelativePath . "/scripts/plancheta_archivo_local.php";
define('FPDF_FONTPATH',RelativePath . '/fpdf/font/');
include(RelativePath . "/fpdf/fpdf.php");

function plancheta_pdf_image_fit($pdf, $fileReal, $margin = 5) {
	$pageW = $pdf->GetPageWidth() - 2 * $margin;
	$pageH = $pdf->GetPageHeight() - 2 * $margin;
	$size = @getimagesize($fileReal);
	if ($size && $size[0] > 0 && $size[1] > 0) {
		$ratio = $size[0] / $size[1];
		$w = $pageW;
		$h = $w / $ratio;
		if ($h > $pageH) {
			$h = $pageH;
			$w = $h * $ratio;
		}
		$x = ($pdf->GetPageWidth() - $w) / 2;
		$y = ($pdf->GetPageHeight() - $h) / 2;
		$pdf->Image($fileReal, $x, $y, $w, $h);
	} else {
		$pdf->Image($fileReal, $margin, $margin, $pageW);
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
$db->query($SQL);
while($db->next_record()){
	$archivoParam = basename($db->f("plancheta_file"));
	if ($archivoParam === '' || !preg_match('/^[A-Za-z0-9._-]+\.(jpe?g|png|gif)$/i', $archivoParam)) {
		continue;
	}
	$fileReal = plancheta_archivo_local_path_validated($archivoParam);
	if ($fileReal === false) {
		continue;
	}
	$pdf->AddPage();
	plancheta_pdf_image_fit($pdf, $fileReal);
}
if($dpto_id != ''){
	$pdf->Output();
	$db->close();
	exit;
}
$db->close();
echo "No hay imagen de plancheta a mostar";

?>