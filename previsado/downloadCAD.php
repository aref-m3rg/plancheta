<?php
error_reporting(E_ERROR);
define("RelativePath", "..");
include(RelativePath . "/Common.php");
$db = new clsDBtdf_nuevo();
$previsado_carga_id = $_POST["previsado_carga_id"];
if(!$previsado_carga_id){
$previsado_carga_id = $_GET["previsado_carga_id"];
}
if($previsado_carga_id){
	$SQL="SELECT * FROM previsados_cargas WHERE previsado_carga_id=$previsado_carga_id";
	$db->query($SQL);
	if($db->next_record()){
		$previsado_nombre_archivo_org = $db->f('previsado_nombre_archivo_org');
		$previsado_carga_ubica_cat = $db->f('previsado_carga_ubica_cat');
		unlink($previsado_carga_ubica_cat);//elimina archivo documento
	}
	$SQL="UPDATE previsados_cargas SET previsado_nombre_archivo_org = '', previsado_carga_ubica_cat = ''  WHERE previsado_carga_id=$previsado_carga_id";
	$db->query($SQL);
}
$db->close();
error_reporting(E_ERROR | E_WARNING);
header('Location: previsados_cargas.php?previsado_carga_id='.$previsado_carga_id);
?>