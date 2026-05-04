<?php
define("RelativePath", "..");
include(RelativePath . "/Common.php");
$db = new clsDBtdf_nuevo();
$previsado_carga_id = $_POST["previsado_carga_id"];
$user_id = $_SESSION["user_id"];
$SQL="UPDATE previsados_cargas SET previsado_carga_proc = NOW(), previsado_tipo_estado_carga_id = 1, user_id=$user_id WHERE previsado_carga_id=$previsado_carga_id";
$db->query($SQL);
$mensaje = "Confirmacion de la carga por el profesional.";
$cant = CCDLookUp("COUNT(*)","previsados_respuestas","previsado_carga_id = $previsado_carga_id",$db);
if($cant){
	$mensaje = "Confirmacion de una nueva carga por el profesional.";
}
$SQL="INSERT INTO previsados_movimientos SET 
				previsado_carga_id = $previsado_carga_id,
				previsado_movimiento_fecha = NOW(),
				usuario_id = $user_id,
				previsado_movimiento_observacion = '$mensaje'";
$db->query($SQL);
$db->close();
header('Location: previsados_consola.php');
?>