<?php
//Page_BeforeInitialize @1-F0087DD0
function Page_BeforeInitialize(& $sender)
{
  $Page_BeforeInitialize = true;
  $Component = & $sender;
  $Container = & CCGetParentContainer($sender);
  global $gestion_parcela_titulares; //Compatibility
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

  $parcelaId = CCGetParam('parcela_id');

  if ( !empty( $parcelaId ) ) {

    $db = new clsDBtdf_nuevo();

    $data = CCQueryToArray('
	SELECT persona_parcela_num_int, tipo_instrumento_abrev, persona_nro_doc, persona_cuit, persona_denominacion, persona_conyuge, tipo_documento_abrev, tipo_persona_descrip 
    FROM personas
    INNER JOIN personas_parcelas ON personas_parcelas.persona_id = personas.persona_id
    LEFT JOIN tipos_documentos ON personas.tipo_documento_id = tipos_documentos.tipo_documento_id
    INNER JOIN tipos_personas ON personas.tipo_persona_id = tipos_personas.tipo_persona_id
    LEFT JOIN tipos_instrumentos ON personas_parcelas.tipo_instrumento_id = tipos_instrumentos.tipo_instrumento_id
    WHERE personas_parcelas.parcela_id = ' . $parcelaId . ' AND personas_parcelas.tipo_estado_id = 1 
    ORDER BY persona_denominacion', $db);

    if ( empty( $data ) ) {
      $response['message'] = 'Sin titulares para la parcela';
    } else {
      $response['message'] = 'Consulta exitosa';
      $response['data'] = $data;
    }

    $db->close();

  } else {

    $response['status'] = 'error';
    $response['message'] = 'No hay parametro para traer datos';
  
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
