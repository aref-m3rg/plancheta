<?php
define("RelativePath", "..");
include(RelativePath . "/Common.php");

$db = new clsDBtdf_nuevo();
$db2 = new clsDBtdf_nuevo();

$target_dir = "archivos/";
$previsado_detalle_carga_id = $_POST["previsado_detalle_carga_id"];
$previsado_carga_id = CCDLookUp("previsado_carga_id","previsados_detalles_cargas","previsado_detalle_carga_id = $previsado_detalle_carga_id",$db);
$uploadOk = 1;
if($_FILES["fileToUploadImagen_$previsado_detalle_carga_id"]["error"] == 0){
	//----------------------------nombre de archivo-----------------------------------------
	$user_id = CCDLookUp("user_id","previsados_cargas","previsado_carga_id = $previsado_carga_id",$db);
	$matricula_tdf = CCDLookUp("matricula_tdf","profesionales","user_id = $user_id",$db);
	if(!$matricula_tdf){
		$matricula_tdf = '0';
	}
	$YYYYMMDD = CCDLookUp("DATE_FORMAT(NOW(),'%Y%m%d')","","",$db);
	$previsado_requisito_id = CCDLookUp("previsado_requisito_id","previsados_detalles_cargas","previsado_detalle_carga_id = $previsado_detalle_carga_id",$db);
	//--------------------------------------------------------------------------------------
	
	$file_org = $_FILES["fileToUploadImagen_$previsado_detalle_carga_id"]["name"];
	$target_file_org = $target_dir . basename($file_org);//nombre real de carga del archivo
	$imageFileType = pathinfo($target_file_org,PATHINFO_EXTENSION);
	$file_dest = $previsado_carga_id."_".$matricula_tdf."_".$YYYYMMDD."_".$previsado_requisito_id.".".$imageFileType;

	if (file_exists($target_file_reemp)) {
		$mensaje = "<font color='RED'>El archivo ya existe.</font>";
		$uploadOk = 0;
	}
	if ($_FILES["fileToUploadImagen_$previsado_detalle_carga_id"]["size"] > 50000000) {
		$mensaje = "<font color='RED'>El archivo sobrepasa el tamaño permitido.</font>";
		$uploadOk = 0;
	}
	if(strtoupper($imageFileType) != "JPG" && strtoupper($imageFileType) != "PNG" && strtoupper($imageFileType) != "GIF" && strtoupper($imageFileType) != "XLS" && strtoupper($imageFileType) != "XLSX"){
		$mensaje = "<font color='RED'>El archivo solo debe ser de extension util para el previsado</font>";
		$uploadOk = 0;
	}
	if (!$uploadOk == 0) {
		$SQL="INSERT INTO previsados_archivos_detalles SET previsado_detalle_nombre_arch_org = '$file_org', previsado_detalle_carga_id = $previsado_detalle_carga_id";
		$db->query($SQL);
		$previsado_archivo_detalle_id = mysql_insert_id();
		$target_file_reemp = $target_dir . basename($previsado_archivo_detalle_id."_".$file_dest);//nombre reemplazo de carga del archivo	
		if(move_uploaded_file($_FILES["fileToUploadImagen_$previsado_detalle_carga_id"]["tmp_name"], $target_file_reemp)) {//mover el temporal al destino
			$SQL="UPDATE previsados_archivos_detalles SET previsado_detalle_carga_ubica = '$target_file_reemp' WHERE previsado_archivo_detalle_id = $previsado_archivo_detalle_id";
			$db->query($SQL);
			$mensaje = "El Archivo <font color='GREEN'><b>$file_org</b></font> fue cargado en el servidor.";
		}else{
			$SQL="DELETE FROM previsados_archivos_detalles WHERE previsado_archivo_detalle_id = $previsado_archivo_detalle_id";
			$db->query($SQL);			
			$mensaje = "<font color='RED'>Lo sentimos, hay un error de carga del archivo al servidor. Intentar en otro momento</font>";
			$uploadOk = 0;
		}
	}
}else{
	$mensaje = "<font color='RED'>Error de carga del archivo.</font>";
	$uploadOk = 0;
}
$db->close();
$db2->close();
header('Location: previsados_cargas.php?previsado_carga_id='.$previsado_carga_id.'&mensaje='.$mensaje.'&uploadOk='.$uploadOk);
?>