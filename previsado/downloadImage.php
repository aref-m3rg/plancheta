<?php
error_reporting(E_ERROR);
define("RelativePath", "..");
include(RelativePath . "/Common.php");
$db = new clsDBtdf_nuevo();
$previsado_archivo_detalle_id = $_POST["previsado_archivo_detalle_id"];
if(!$previsado_archivo_detalle_id){
$previsado_archivo_detalle_id = $_GET["previsado_archivo_detalle_id"];
}
$cabecera_previsado_carga_id = $_POST["cabecera_previsado_carga_id"];
if(!$cabecera_previsado_carga_id){
$cabecera_previsado_carga_id = $_GET["cabecera_previsado_carga_id"];
}
$previsado_archivo_detalle_id=str_replace("#","",$previsado_archivo_detalle_id);
$cabecera_previsado_carga_id=str_replace("#","",$cabecera_previsado_carga_id);
if($previsado_archivo_detalle_id && $cabecera_previsado_carga_id){
	$SQL="SELECT * FROM previsados_archivos_detalles WHERE previsado_archivo_detalle_id=$previsado_archivo_detalle_id";
	$db->query($SQL);
	if($db->next_record()){
		$previsado_detalle_carga_ubica = $db->f('previsado_detalle_carga_ubica');
		unlink($previsado_detalle_carga_ubica);//elimina archivo documento
	}
	$SQL="DELETE FROM previsados_archivos_detalles WHERE previsado_archivo_detalle_id=$previsado_archivo_detalle_id";
	$db->query($SQL);
}
$db->close();
error_reporting(E_ERROR | E_WARNING);
$URL="previsados_cargas.php?previsado_carga_id=$cabecera_previsado_carga_id";
header("Location: $URL");
?>