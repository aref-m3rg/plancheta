<?php
//este script tiene algunas funciones utiles

function auditar($log_tabla,$log_registro_id,$log_tipo_id){

	$dbAudit = new clsDBcatastro();
	$SQL = "INSERT INTO logs
			SET log_fecha = NOW(),
			    log_tabla = '$log_tabla',
				log_registro_id = '$log_registro_id',
			    log_tipo_id = '$log_tipo_id',
				log_ip = '" . $_SERVER['REMOTE_ADDR'] . "',
			    user_id = " . CCGetUserID();
	$dbAudit->query($SQL);
	$dbAudit->close();
}





?>