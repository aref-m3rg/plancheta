<?php
define("RelativePath", "..");
include(RelativePath . "/Common.php");

$tipo_mejora_cat_id = CCGetParam(tipo_mejora_cat_id);

$db = new clsDBtdf_nuevo();
$valor = CCDLookUp("mejoras_valores.mejora_valor_valor","mejoras_valores INNER JOIN mejoras_formularios ON mejoras_valores.mejora_formulario_id = mejoras_formularios.mejora_formulario_id INNER JOIN tipos_mejoras_cat ON mejoras_valores.tipo_mejora_cat_id = tipos_mejoras_cat.tipo_mejora_cat_id","mejoras_formularios.mejora_formulario_abrev = 'E1' AND mejoras_valores.mejora_valor_f_ini <= NOW() AND tipos_mejoras_cat.tipo_mejora_cat_id = '$tipo_mejora_cat_id' AND mejoras_valores.mejora_construccion_id = 2",$db);
$db->close();
if($valor){
	echo $valor;
}else{
	echo 0.0;
}
?>