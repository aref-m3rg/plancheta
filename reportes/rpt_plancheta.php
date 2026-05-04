<?php
define("RelativePath", "..");
include(RelativePath . "/Common.php");
define('FPDF_FONTPATH',RelativePath . '/fpdf/font/');
include(RelativePath . "/fpdf/fpdf.php");

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
	$pdf->AddPage();
	$imagen = RelativePath . "/planchetas/archivos/" . $db->f("plancheta_file");
	$pdf->Image($imagen,5,5,300);
}
if($dpto_id != ''){
	$pdf->Output();
}
$db->close();
echo "No hay imagen de plancheta a mostar";

?>