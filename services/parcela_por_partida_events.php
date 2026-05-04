<?php
//Page_BeforeInitialize @1-CD1E6E0E
function Page_BeforeInitialize(& $sender)
{
  $Page_BeforeInitialize = true;
  $Component = & $sender;
  $Container = & CCGetParentContainer($sender);
  global $parcela_por_partida; //Compatibility
//End Page_BeforeInitialize

//Custom Code @2-2A29BDB7
// -------------------------

	// Incluye el archivo de funciones generales
	include_once(RelativePath . "/scripts/myFunctions.php");


  $response = array(
    'status' => 'ok',
    'message' => '',
    'data' => array()
  );

  $deptoID = CCGetParam('dpto_id');
  $partida = CCGetParam('partida');


  if ( !empty( $deptoID ) && !empty( $partida ) ) {

    $db = new clsDBtdf_nuevo();

    $data = CCQueryToArray('
    SELECT parcelas.tipo_depto_parc_id AS departamento, parcelas.parcela_seccion AS seccion, parcelas.parcela_macizo AS macizo, parcelas.parcela_parcela
    FROM parcelas
    WHERE parcelas.parcela_partida = ' . $partida . ' AND parcelas.tipo_depto_parc_id = ' . $deptoID, $db);

    if ( empty( $data ) ) {
      $response['message'] = 'No hay parcelas coincidentes';
    } else {
      $response['message'] = 'Consulta exitosa';
      $response['data'] = $data;
    }

    $db->close();

  } else {

    $response['status'] = 'error';
    $response['message'] = 'No hay parametros para traer datos';
  
  }

  header('Content-Type: application/json');
  echo json_encode( $response );

  exit(); die();

// -------------------------
//End Custom Code

//Close Page_BeforeInitialize @1-23E6A029
  return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize


?>
