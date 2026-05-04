<?php
error_reporting(E_ERROR);
define("RelativePath", "..");
include(RelativePath . "/Common.php");
$db = new clsDBtdf_nuevo();
$CheckBox = $_POST["CheckBox"];
if(!$CheckBox){
$CheckBox = $_GET["CheckBox"];
}
$previsado_carga_id = $_POST["previsado_carga_id"];
if(!$previsado_carga_id){
$previsado_carga_id = $_GET["previsado_carga_id"];
}
if($previsado_carga_id){
	$SQL="UPDATE previsados_cargas SET CheckBox_tfsm = '$CheckBox' WHERE previsado_carga_id=$previsado_carga_id";
	$db->query($SQL);
}
$db->close();
error_reporting(E_ERROR | E_WARNING);
header('Location: previsados_cargas.php?previsado_carga_id='.$previsado_carga_id);
?>