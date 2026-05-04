<?php
//Page_BeforeInitialize @1-00541755
function Page_BeforeInitialize(& $sender)
{
  $Page_BeforeInitialize = true;
  $Component = & $sender;
  $Container = & CCGetParentContainer($sender);
  global $parcela_por_nomenclatura; //Compatibility
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

  $depto = CCGetParam('departamento');
  $seccion = CCGetParam('seccion');
  $macizo = CCGetParam('macizo');
  $parcela = CCGetParam('parcela');
  $padron = CCGetParam('padron');


  if ( !empty( $depto ) && !empty( $seccion ) && !empty( $macizo ) && !empty( $parcela ) && !empty( $padron ) ) {

    $db = new clsDBtdf_nuevo();

    $data = CCQueryToArray('
    SELECT parcelas.* FROM parcelas
    WHERE tipo_depto_parc_id = ' . $depto . ' AND parcela_seccion = "' . $seccion . '" AND parcela_macizo = "' . $macizo . '" AND parcela_parcela = ' . $parcela . ' AND tipo_padron_parc_id = ' . $padron, $db);

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
