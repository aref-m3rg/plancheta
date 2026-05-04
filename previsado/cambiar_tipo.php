<?php
define("RelativePath", "..");
include(RelativePath . "/Common.php");
//$previsado_carga_id = CCGetParam("previsado_carga_id");
//$previsado_tipo_plano_id_futuro = CCGetParam("previsado_tipo_plano_id");

$db = new clsDBtdf_nuevo();
$previsado_carga_id = $_GET["previsado_carga_id"];
$previsado_tipo_plano_id_futuro = $_GET["previsado_tipo_plano_id"];

$previsado_tipo_plano_id_actual = CCDLookUp("previsado_tipo_plano_id","previsados_cargas","previsado_carga_id=$previsado_carga_id",$db);
$SQL = "SELECT previsados_relaciones_tipos_requisitos.previsado_requisito_id AS previsado_requisito_id
			FROM previsados_relaciones_tipos_requisitos
			INNER JOIN previsados_tipos_planos_requisitos ON previsados_relaciones_tipos_requisitos.previsado_requisito_id = previsados_tipos_planos_requisitos.previsado_requisito_id
			WHERE previsados_relaciones_tipos_requisitos.previsado_tipo_plano_id = $previsado_tipo_plano_id_actual 
			AND previsados_relaciones_tipos_requisitos.previsado_relacion_obligatorio = 1 
			AND previsados_tipos_planos_requisitos.tipo_estado_id = 1";
$db->query($SQL);
$tipo_plano_id_actual = array();
while($db->next_record()){//creo detalle de carga
	$tipo_plano_id_actual[] = $db->f('previsado_requisito_id');
}
$SQL = "SELECT previsados_relaciones_tipos_requisitos.previsado_requisito_id AS previsado_requisito_id
			FROM previsados_relaciones_tipos_requisitos
			INNER JOIN previsados_tipos_planos_requisitos ON previsados_relaciones_tipos_requisitos.previsado_requisito_id = previsados_tipos_planos_requisitos.previsado_requisito_id
			WHERE previsados_relaciones_tipos_requisitos.previsado_tipo_plano_id = $previsado_tipo_plano_id_futuro 
			AND previsados_relaciones_tipos_requisitos.previsado_relacion_obligatorio = 1 
			AND previsados_tipos_planos_requisitos.tipo_estado_id = 1";
$db->query($SQL);
$tipo_plano_id_futuro = array();
while($db->next_record()){//creo detalle de carga
	$tipo_plano_id_futuro[] = $db->f('previsado_requisito_id');
}
//-----------------------------------borro los que no estan-------------------------------------
for($i = 0;$i <  count($tipo_plano_id_actual);$i++){
	if(in_array($tipo_plano_id_actual[$i],$tipo_plano_id_futuro) === FALSE){
		$previsado_requisito_id = $tipo_plano_id_actual[$i];
		$previsado_detalle_carga_id = CCDLookUp("previsado_detalle_carga_id","previsados_detalles_cargas","previsado_carga_id=$previsado_carga_id AND previsado_requisito_id=$previsado_requisito_id",$db);
		$SQL="SELECT * FROM previsados_archivos_detalles WHERE previsado_detalle_carga_id=$previsado_detalle_carga_id";
		$db->query($SQL);
		while($db->next_record()){
			$previsado_detalle_carga_ubica = $db->f('previsado_detalle_carga_ubica');
			unlink($previsado_detalle_carga_ubica);//elimina archivo documento
		}
		$SQL="DELETE FROM previsados_archivos_detalles WHERE previsado_detalle_carga_id=$previsado_detalle_carga_id";
		$db->query($SQL);
		$SQL="DELETE FROM previsados_detalles_cargas WHERE previsado_detalle_carga_id=$previsado_detalle_carga_id";
		$db->query($SQL);		
	}
}
//-----------------------------------agrego los nuevos-------------------------------------
for($i = 0;$i <  count($tipo_plano_id_futuro);$i++){
	if(in_array($tipo_plano_id_futuro[$i],$tipo_plano_id_actual) === FALSE){
		$previsado_requisito_id = $tipo_plano_id_futuro[$i];
		$SQL="INSERT INTO previsados_detalles_cargas SET 
							previsado_carga_id = $previsado_carga_id, 
							previsado_requisito_id = $previsado_requisito_id";
		$db->query($SQL);
	}
}
$SQL="UPDATE previsados_cargas SET 
			previsado_tipo_plano_id = $previsado_tipo_plano_id_futuro 
			WHERE previsado_carga_id = $previsado_carga_id";
$db->query($SQL);
$db->close();
header('Location: previsados_cargas.php?previsado_carga_id='.$previsado_carga_id);
?>
