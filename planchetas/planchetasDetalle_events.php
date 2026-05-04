<?php

//BindEvents Method @1-DC3D085F
function BindEvents()
{
  global $planchetas;
  global $CCSEvents;
  $planchetas->CCSEvents["BeforeShow"] = "planchetas_BeforeShow";
}
//End BindEvents Method

//planchetas_BeforeShow @6-B2069D41
function planchetas_BeforeShow(& $sender)
{
  $planchetas_BeforeShow = true;
  $Component = & $sender;
  $Container = & CCGetParentContainer($sender);
  global $planchetas; //Compatibility
//End planchetas_BeforeShow

//Custom Code @32-2A29BDB7
// -------------------------

	$db = new clsDBtdf_nuevo();

	// obtenemos el ID de la plancheta
	$plancheta_id = CCGetParam('plancheta_id');


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

//Page_BeforeInitialize @1-AF5ED718
function Page_BeforeInitialize(& $sender)
{
  $Page_BeforeInitialize = true;
  $Component = & $sender;
  $Container = & CCGetParentContainer($sender);
  global $planchetasDetalle; //Compatibility
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
