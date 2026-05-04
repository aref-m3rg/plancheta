<?php

//BindEvents Method @1-5E1C81D1
function BindEvents()
{
  global $planchetas;
  global $CCSEvents;
  $planchetas->CCSEvents["BeforeShowRow"] = "planchetas_BeforeShowRow";
}
//End BindEvents Method

//planchetas_BeforeShowRow @6-65281C6E
function planchetas_BeforeShowRow(& $sender)
{
  $planchetas_BeforeShowRow = true;
  $Component = & $sender;
  $Container = & CCGetParentContainer($sender);
  global $planchetas; //Compatibility
//End planchetas_BeforeShowRow

//Custom Code @67-2A29BDB7
// -------------------------

	$db = new clsDBtdf_nuevo();

	// obtenemos el ID de la plancheta
	$plancheta_id = $Component->ds->f('plancheta_id');


  /* Trae la imagen de la plancheta
  ------------------------------------------------------ */
	if ( !empty( $plancheta_id ) ) {
		$plancheta = obtenerPlancheta( $plancheta_id, $db, '/planchetas/archivos/', 35, 'plancheta' );
		$Component->html->SetValue( $plancheta );
	}


  $db->close();

// -------------------------
//End Custom Code

//Close planchetas_BeforeShowRow @6-5EC23EEC
  return $planchetas_BeforeShowRow;
}
//End Close planchetas_BeforeShowRow

//Page_BeforeInitialize @1-79C09AFF
function Page_BeforeInitialize(& $sender)
{
  $Page_BeforeInitialize = true;
  $Component = & $sender;
  $Container = & CCGetParentContainer($sender);
  global $planchetasGrid; //Compatibility
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
