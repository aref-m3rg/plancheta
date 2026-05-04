<?php
define("RelativePath", "..");
include(RelativePath . "/Common.php");

$db = new clsDBtdf_nuevo();
$db2 = new clsDBtdf_nuevo();

$target_dir = "archivos/";
$uploadOk = 1;
if($_FILES["fileToUploadCAD"]["error"] == 0){
	//----------------------------nombre de archivo-----------------------------------------
	$previsado_carga_id = $_POST["previsado_carga_id"];
	$user_id = CCDLookUp("user_id","previsados_cargas","previsado_carga_id = $previsado_carga_id",$db);
	$matricula_tdf = CCDLookUp("matricula_tdf","profesionales","user_id = $user_id",$db);	
	if(!$matricula_tdf){
		$matricula_tdf = '0';
	}
	$YYYYMMDD = CCDLookUp("DATE_FORMAT(NOW(),'%Y%m%d')","","",$db);
	//--------------------------------------------------------------------------------------
	
	$file_org = $_FILES["fileToUploadCAD"]["name"];
	$target_file_org = $target_dir . basename($file_org);//nombre real de carga del archivo
	$imageFileType = pathinfo($target_file_org,PATHINFO_EXTENSION);
	$file_dest = $previsado_carga_id."_".$matricula_tdf."_".$YYYYMMDD.".".$imageFileType;
	$target_file_reemp = $target_dir . basename($file_dest);//nombre reemplazo de carga del archivo
	
	if (file_exists($target_file_reemp)) {
		$mensaje = "<font color='RED'>El archivo ya existe.</font>";
		$uploadOk = 0;
	}
	if ($_FILES["fileToUploadCAD"]["size"] > 50000000) {
		$mensaje = "<font color='RED'>El archivo sobrepasa el tamaño permitido.</font>";
		$uploadOk = 0;
	}
	if(strtoupper($imageFileType) != "DXF" && strtoupper($imageFileType) != "DWG") {
		$mensaje = "<font color='RED'>El archivo solo debe ser de extension DXF o DWG.</font>";
		$uploadOk = 0;
	}
	if (!$uploadOk == 0) {
		if (move_uploaded_file($_FILES["fileToUploadCAD"]["tmp_name"], $target_file_reemp)) {//mover el temporal al destino
			$SQL="UPDATE previsados_cargas SET previsado_carga_proc = NOW(), previsado_nombre_archivo_org = '$file_org', previsado_carga_ubica_cat = '$target_file_reemp' WHERE previsado_carga_id = ".$_POST["previsado_carga_id"];
			$db->query($SQL);
			$mensaje = "El Archivo <font color='GREEN'><b>$file_org</b></font> fue cargado en el servidor.";
		} else {
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
header('Location: previsados_cargas.php?previsado_carga_id='.$_POST["previsado_carga_id"].'&mensaje='.$mensaje.'&uploadOk='.$uploadOk);
?>