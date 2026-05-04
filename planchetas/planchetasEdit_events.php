<?php

//BindEvents Method @1-2C280B81
function BindEvents()
{
    global $planchetas;
    global $CCSEvents;
    $planchetas->FileUpload1->CCSEvents["AfterProcessFile"] = "planchetas_FileUpload1_AfterProcessFile";
    $planchetas->CCSEvents["BeforeShow"] = "planchetas_BeforeShow";
}
//End BindEvents Method

//planchetas_FileUpload1_AfterProcessFile @23-7E931A4B
function planchetas_FileUpload1_AfterProcessFile(& $sender)
{
    $planchetas_FileUpload1_AfterProcessFile = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $planchetas; //Compatibility
//End planchetas_FileUpload1_AfterProcessFile

//Custom Code @24-2A29BDB7
// -------------------------

    // Cambia el nombre del archivo subido y lo actualiza en la ddbb
	$old = $Component->GetValue();
	$fileInfo = pathinfo($old);
	$oldName = $fileInfo['basename'];
	$new = date('Ymd_') . (double)microtime() * 1000000 . '.' . $fileInfo['extension'];
	rename(  RelativePath . "/planchetas/archivos/" . $oldName, RelativePath . "/planchetas/archivos/" . $new);
	$db = new clsDBtdf_nuevo();
	$db->query("UPDATE planchetas SET plancheta_file = '" . mysql_real_escape_string($new) . "', plancheta_old_file = '" . mysql_real_escape_string($oldName) . "' where plancheta_file = '" . mysql_real_escape_string($oldName) . "'");
	$db->close();

// -------------------------
//End Custom Code

//Close planchetas_FileUpload1_AfterProcessFile @23-77DFD03C
    return $planchetas_FileUpload1_AfterProcessFile;
}
//End Close planchetas_FileUpload1_AfterProcessFile

//planchetas_BeforeShow @6-B2069D41
function planchetas_BeforeShow(& $sender)
{
    $planchetas_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $planchetas; //Compatibility
//End planchetas_BeforeShow

//Custom Code @27-2A29BDB7
// -------------------------

	// Guarda la fecha de actualización
	$Component->plancheta_f_act->SetValue(date('Y-m-d H:i:s'));


	// Trae la plancheta
	$db = new clsDBtdf_nuevo();

	// obtenemos el ID de la plancheta
	$plancheta_id = $Component->ds->f('plancheta_id');


    /* Trae la imagen de la plancheta
    ------------------------------------------------------ */
	if ( !empty( $plancheta_id ) ) {
		$plancheta = obtenerPlancheta( $plancheta_id, $db, '/planchetas/archivos/', 180, 'plancheta' );
		$Component->html->SetValue( $plancheta );
	}


    $db->close();

// -------------------------
//End Custom Code

//Close planchetas_BeforeShow @6-490D4B80
    return $planchetas_BeforeShow;
}
//End Close planchetas_BeforeShow

//Page_BeforeInitialize @1-2AC14517
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $planchetasEdit; //Compatibility
//End Page_BeforeInitialize

//Custom Code @5-2A29BDB7
// -------------------------

	// Incluye el archivo de funciones generales
	include_once(RelativePath . "/scripts/myFunctions.php");


	// Incluye la gestión de permisos
	include_once(RelativePath . "/scripts/permisos1.php");

// -------------------------
//End Custom Code

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize
?>
