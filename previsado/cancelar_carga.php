<?php
error_reporting(E_ERROR);
define("RelativePath", "..");
include(RelativePath . "/Common.php");
$db = new clsDBtdf_nuevo();
$db2 = new clsDBtdf_nuevo();
$previsado_carga_id = $_POST["previsado_carga_id"];
if(!$previsado_carga_id){
$previsado_carga_id = $_GET["previsado_carga_id"];
}
$user_id = $_SESSION["user_id"];
if($previsado_carga_id){
	$SQL="SELECT * FROM previsados_detalles_cargas WHERE previsado_carga_id=$previsado_carga_id";
	$db->query($SQL);
	while($db->next_record()){
		$SQL="SELECT * FROM previsados_archivos_detalles WHERE previsado_detalle_carga_id=".$db->f('previsado_detalle_carga_id');
		$db2->query($SQL);
		while($db2->next_record()){
			$previsado_detalle_carga_ubica = $db2->f('previsado_detalle_carga_ubica');
			unlink($previsado_detalle_carga_ubica);//elimina archivo documentos			
		}
		$SQL="DELETE FROM previsados_archivos_detalles WHERE previsado_detalle_carga_id=".$db->f('previsado_detalle_carga_id');
		$db->query($SQL);
	}
	$SQL="DELETE FROM previsados_detalles_cargas WHERE previsado_carga_id=$previsado_carga_id";
	$db->query($SQL);
	$previsado_carga_ubica_cat = CCDLookUp("previsado_carga_ubica_cat","previsados_cargas","previsado_carga_id=$previsado_carga_id",$db);
	unlink($previsado_carga_ubica_cat);//elimina archivo cad		
	$SQL="DELETE FROM previsados_cargas WHERE previsado_carga_id=$previsado_carga_id";
	$db->query($SQL);
	$SQL="DELETE FROM previsados_parcelas_destinos WHERE previsado_carga_id=$previsado_carga_id";
	$db->query($SQL);
	$SQL="DELETE FROM previsados_parcelas_origenes WHERE previsado_carga_id=$previsado_carga_id";
	$db->query($SQL);
	$SQL="DELETE FROM previsados_titulares WHERE previsado_carga_id=$previsado_carga_id";
	$db->query($SQL);
	$SQL="INSERT INTO previsados_movimientos SET 
				previsado_carga_id = $previsado_carga_id,
				previsado_movimiento_fecha = NOW(),
				usuario_id = $user_id,
				previsado_movimiento_observacion = 'Carga eliminada por el usuario.'";
	$db->query($SQL);
}
$db->close();
$db2->close();
error_reporting(E_ERROR | E_WARNING);
header('Location: previsados_consola.php');
?>