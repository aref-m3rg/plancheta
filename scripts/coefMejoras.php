<?php
define("RelativePath", "..");
include(RelativePath . "/Common.php");

$tipo_mejora_conserva_id = CCGetParam(tipo_mejora_conserva_id);
$mejora_coeficiente_anio = CCGetParam(mejora_coeficiente_anio);
$tipo_mejora_cat_id = CCGetParam(tipo_mejora_cat_id);

$db = new clsDBtdf_nuevo();
$valor = CCDLookUp("mejora_coeficiente_valor","mejoras_coeficientes","tipo_mejora_conserva_id = '$tipo_mejora_conserva_id' AND mejora_coeficiente_anio = '$mejora_coeficiente_anio' AND tipo_mejora_cat_id = '$tipo_mejora_cat_id'",$db);
if($valor){
	echo $valor;
}else{
	echo 0.0;
}
$db->close();
?>