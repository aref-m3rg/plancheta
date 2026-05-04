<?php
/**
 * Funciones para el sistema de Catastro TDF
 */


function auditar($log_tabla,$log_registro_id,$log_tipo_id){

	//$dbAudit = new clsDBguaymallen();
	$dbAudit = new clsDBtdf_nuevo();
	$script = substr(strrchr($_SERVER['PHP_SELF'], "/"), 1);

	//a la tabla auditorias
	$SQL = "INSERT INTO auditorias
			SET auditoria_fecha = NOW(),
				auditoria_script = '$script',
				auditoria_tabla = '$log_tabla',
				auditoria_registro_id = '$log_registro_id',
				aud_tip_id = '$log_tipo_id',
				auditoria_host = '" . $_SERVER['REMOTE_ADDR'] . "',
				usuarios_id = " . CCGetUserID();
	$dbAudit->query($SQL);
	$dbAudit->close();
}

/**
* Prints out debug information about given variable.
*
* Only runs if debug level is greater than zero.
*
* @param boolean $var Variable to show debug information for.
* @param boolean $showHtml    If set to true, the method prints the debug data in a screen-friendly way.
* @param boolean $showFrom    If set to true, the method prints from where the function was called.
* @param boolean $description If set shows an description line above the outputed data.
* @link http://book.cakephp.org/view/1190/Basic-Debugging
* @link http://book.cakephp.org/view/1128/debug
*/
function debug($var = false, $showHtml = false, $showFrom = true, $description = false) {

	if ($showFrom) {
		$calledFrom = debug_backtrace();
		echo '<strong>' . substr(str_replace(ROOT, '', $calledFrom[0]['file']), 1) . '</strong>';
		echo ' (line <strong>' . $calledFrom[0]['line'] . '</strong>)';
	}

	if ( !empty($description) ) echo "\n<span style=\"font-weight:bold;display:block;\">" . $description . '</span>';

	echo "\n<pre class=\"cake-debug\">\n";

	$var = print_r($var, true);

	if ($showHtml) {
		$var = str_replace('<', '&lt;', str_replace('>', '&gt;', $var));
	}

	echo $var . "\n</pre>\n";
}

function tipo_medida($mesura,$tipo){
	//separa las Ha total con decimeles en A y Ca
	if($tipo == "m2" || $tipo == ""){
		$retorno=$mesura.' m2';
	}elseif($tipo == "Ha"){
			$ha = truncateFloat($mesura,0);
			$aa = truncateFloat(($mesura - $ha)*100,0);
			$tam = strlen($aa);
			$ca = truncateFloat(($mesura - ($ha + ($aa/100)))*10000,$tam);
			if($ha > 0){
					$retorno = $ha.' '.$tipo;
			}elseif(($aa > 0 || $ca > 0) && ($ha == 0 || $ha == '')){
					$retorno = '0 '.$tipo;
			}elseif(($ha == 0 || $ha == '') && ($aa == 0 || $aa == '') && ($ca == 0 || $ca == '')){
					$retorno = '';
			}
			if($aa > 0){
					$retorno = $retorno.' '.$aa.' As';
			}elseif($ca > 0 && ($aa == 0 || $aa == '')){
					$retorno = $retorno.' 0 As';
			}
			if($ca > 0){
					$retorno = $retorno.' '.$ca.' Cs';
			}
			//echo $retorno;exit;
	}elseif($tipo == "As"){
		$aa = truncateFloat($mesura,0);
		$tam = strlen($aa);
		$ca = truncateFloat((($mesura - $aa)*100.00), $tam);
		if($aa > 0){
			$retorno = $aa.' '.$tipo;
		}elseif($ca > 0 && ($aa == 0 || $aa == '')){
			$retorno = '0 '.$tipo;
		}else{
			$retorno = '';
		}
		if($ca > 0){
			$retorno = $retorno.' '.$ca.' Cs';
		}
	}elseif($tipo == "Cs"){
	   if($mesura > 0){
		$retorno=$mesura.' '.$tipo;
	   }else{
		$retorno='';
	   }
	}
	return $retorno;
}


function truncateFloat($number, $digitos){
	$raiz = 10;
	$multiplicador = pow ($raiz,$digitos);
	$resultado = ((int)($number * $multiplicador)) / $multiplicador;
	return number_format($resultado, $digitos);
}


function pasar_pieza($pieza_id,$fojas,$origen,$destino,$comentario,$conf_ext){

	$db = new clsDBmesa();

	// Limpiar pases activos para esta pieza, deja a todos inactivos
	$SQL_limpia = "UPDATE pases SET pase_activo = 0 WHERE pieza_id = '$pieza_id'"; // debug('limpia:' . $SQL_limpia);
	$db->query($SQL_limpia);

	// cuenta cantidad de pases de la pieza
	$pase_nro = CCDLookUp("COUNT(*)","pases","pieza_id = '$pieza_id'", $db); // debug('pase_nro:' . $pase_nro);
	$pase_nro++;

	$usuario_id = CCGetUserID(); // debug('usuario_id:' . $usuario_id);
	
	$ambito = CCDLookUp("entorno_id","unidades","unidad_id = '$destino'", $db); //debug('ambito:' . $ambito);

	$unidad_autorizada = CCDLookUp("unidad_id","unidades","unidad_pase_externo = '1'", $db); // debug('unidad_autorizada:' . $unidad_autorizada);
	
	if($fojas == 0){//viene un adjunto
		$fojas = CCDLookUp("pase_n_fojas","pases","pieza_id = '$pieza_id' ORDER BY pase_id DESC LIMIT 1", $db);
	}

	//si es una unidad externa, la confirmacion es de una
	switch($ambito){
		case 1:
			$pase_confirmado = 0; //el ambito es interno, espero que lo confirmen
			$pase_f_confirma = '';
			break;
		case 2:
			$pase_confirmado = 1; //el ambito es externo, se confirma
			$pase_f_confirma = "pase_f_confirma = NOW(),";
			break;
	}

	if($ambito == 1){

		//insertar el pase
		$SQL_pase = "INSERT INTO pases
				SET pieza_id = '$pieza_id',
					pase_nro = '$pase_nro',
					ori_unidad_id = '$origen',
					des_unidad_id = '$destino',
					pase_comentario = '$comentario',
					pase_n_fojas = '$fojas',
					pase_f_pase = NOW(),
					pase_confirmado = $pase_confirmado,
					$pase_f_confirma
					pase_activo = 1,
					pase_confir_ext = $conf_ext,
					ori_usuario_id = '$usuario_id'";
		$db->query($SQL_pase); // debug('SQL_pase -> Ambito = 1: ' . $SQL_pase);

		$pase_id = mysql_insert_id(); // debug('pase_id:' . $pase_id);
		auditar("pases",$pase_id,6);


	}elseif( $ambito == 2 ){

		if($origen != $unidad_autorizada){

			//insertar el pase
			$SQL_pase = "INSERT INTO pases
					SET pieza_id = '$pieza_id',
						pase_nro = '$pase_nro',
						ori_unidad_id = '$origen',
						des_unidad_id = '$unidad_autorizada',
						pase_comentario = '$comentario',
						pase_n_fojas = '$fojas',
						pase_f_pase = NOW(),
						pase_confirmado = '0',
						pase_f_confirma = '',
						pase_activo = 1,
						pase_confir_ext = $conf_ext,
						pendiente_unidad_id  = '$destino',
						ori_usuario_id = '$usuario_id'";
			$db->query($SQL_pase); // debug('SQL_pase -> Ambito = 2, $orig != unidad autorizada: ' . $SQL_pase);


			$pase_id = mysql_insert_id(); // debug('pase_id:' . $pase_id);
			auditar("pases",$pase_id,6);

		} elseif ($origen == $unidad_autorizada) {
			//insertar el pase
			$SQL_pase = "INSERT INTO pases
					SET pieza_id = '$pieza_id',
						pase_nro = '$pase_nro',
						ori_unidad_id = '$origen',
						des_unidad_id = '$destino',
						pase_comentario = '$comentario',
						pase_n_fojas = '$fojas',
						pase_f_pase = NOW(),
						$pase_f_confirma
						pase_confirmado = $pase_confirmado,
						pase_activo = 1,
						pase_confir_ext = $conf_ext,
						pendiente_unidad_id  = '$destino',
						ori_usuario_id = '$usuario_id'";
			$db->query($SQL_pase); // debug('SQL_pase -> Ambito = 2, $orig == unidad autorizada: ' . $SQL_pase);


			$pase_id = mysql_insert_id(); // debug('pase_id:' . $pase_id);
			auditar("pases",$pase_id,6);

		}
	}


	//Pasar los adjuntos tambien, de la misma manera que esta pieza
	$ppal = CCDLookUp("CONCAT_WS('-',pieza_nro,pieza_letra,pieza_anio)","piezas","pieza_id = '$pieza_id'", $db);
	$SQL_adjuntos = "SELECT * FROM adjuntos WHERE ppal_pieza_id = '$pieza_id'";
	$db->query($SQL_adjuntos);
	while($db->next_record()){
		pasar_pieza($db->f('adj_pieza_id'),0,$origen,$destino,"Pasa Adjunta a $ppal");
	}


	$db->close();

}


function cancelar_pase($pieza_id){
	//borrar el pase activo, y activar el ultimo
	$db = new clsDBmesa();
	$SQL_cancela = "DELETE FROM pases WHERE pase_activo = 1 AND pieza_id = '$pieza_id'";
	$db->query($SQL_cancela);
	//dejar activo solo el ultimo pase de esta pieza.
	$pase_id = CCDLookUp("MAX(pase_id)","pases","pieza_id = '$pieza_id'",$db);
	$SQL_upd1 = "UPDATE pases SET pase_activo = 0 WHERE pieza_id = '$pieza_id'";
	$db->query($SQL_upd1);
	$SQL_upd1 = "UPDATE pases SET pase_activo = 1 WHERE pieza_id = '$pieza_id' AND pase_id = '$pase_id'";
	$db->query($SQL_upd1);
	//cancelar los adjuntos tambien, de la misma manera que esta pieza
	$SQL_adjuntos = "SELECT * FROM adjuntos WHERE ppal_pieza_id = '$pieza_id'";
	$db->query($SQL_adjuntos);
	while($db->next_record()){
		cancelar_pase($db->f('adj_pieza_id'));
	}
	$db->close();
}


function confirmar_pase($pieza_id,$receptor){
	$db = new clsDBmesa();
	$des_usuario_id = CCGetUserID();
	$SQL_conf  = "UPDATE pases
				SET pase_confirmado = 1,
				des_usuario_id = '$des_usuario_id',
				pase_receptor = '$receptor',
				pase_f_confirma = NOW()
				WHERE pieza_id = '$pieza_id'
				AND pase_activo = 1";
	//echo $SQL_conf;exit();
	$db->query($SQL_conf);
	//confirmar los adjuntos tambien, de la misma manera que esta pieza
	$SQL_adjuntos = "SELECT * FROM adjuntos WHERE ppal_pieza_id = '$pieza_id'";
	$db->query($SQL_adjuntos);
	while($db->next_record()){
		confirmar_pase($db->f('adj_pieza_id'),$receptor);
	}
	$db->close();

}


function confirmar_pase_ext($pieza_id,$receptor,$pase_id){
	$db = new clsDBmesa();
	$des_usuario_id = CCGetUserID();
	$des_unidad_id = CCDLookUp("des_unidad_id","pases","pieza_id = '$pieza_id' AND pase_id = $pase_id", $db);
	$org_unidad_id = CCDLookUp("ori_unidad_id","pases","pieza_id = '$pieza_id' AND pase_id = $pase_id", $db);
	$SQL_conf  = "UPDATE pases
				SET pase_confirmado = 1,
				des_usuario_id = '$des_usuario_id',
				pase_receptor = '$receptor',
				ori_unidad_id = $des_unidad_id,
				des_unidad_id = $org_unidad_id,
				pase_f_confirma = NOW(),
				pase_confir_ext = 0
				WHERE pieza_id = '$pieza_id'
				AND pase_activo = 1";
	//echo $SQL_conf;exit();
	$db->query($SQL_conf);
	//confirmar los adjuntos tambien, de la misma manera que esta pieza
	$SQL_adjuntos = "SELECT * FROM adjuntos WHERE ppal_pieza_id = '$pieza_id'";
	$db->query($SQL_adjuntos);
	while($db->next_record()){
		confirmar_pase($db->f('adj_pieza_id'),$receptor);
	}
	$db->close();

}


function desadjuntar_pieza($ppal_pieza_id,$adj_pieza_id){

	$db = new clsDBmesa();

	$SQL = "DELETE FROM adjuntos
			WHERE ppal_pieza_id = '$ppal_pieza_id' AND adj_pieza_id = '$adj_pieza_id'";

	$db->query($SQL);

	$db->close();

}


function archivar_pieza($pieza_id,$archivo){
	//activar el flag de archivada
	$db = new clsDBmesa();

	$SQL_archiva = "UPDATE piezas
					SET pieza_archivada = 1,
					pieza_archivo = '$archivo'
					WHERE pieza_id = '$pieza_id'";


	$db->query($SQL_archiva);

	//archivar los adjuntos tambien, de la misma manera que esta pieza
	$SQL_adjuntos = "SELECT * FROM adjuntos WHERE ppal_pieza_id = '$pieza_id'";
	$db->query($SQL_adjuntos);
	while($db->next_record()){
		archivar_pieza($db->f('adj_pieza_id'));
	}

	$db->close();

}


function desarchivar_pieza($pieza_id){
	//activar el flag de archivada
	$db = new clsDBmesa();

	$SQL_archiva = "UPDATE piezas
					SET pieza_archivada = 0,
					pieza_archivo = ''
					WHERE pieza_id = '$pieza_id'";


	$db->query($SQL_archiva);

	//archivar los adjuntos tambien, de la misma manera que esta pieza
	$SQL_adjuntos = "SELECT * FROM adjuntos WHERE ppal_pieza_id = '$pieza_id'";
	$db->query($SQL_adjuntos);
	while($db->next_record()){
		archivar_pieza($db->f('adj_pieza_id'));
	}

	$db->close();

}


/**
 * Busca en base al ID de plano o parcela devuelve el número de plano formateado
 * @param   integer     $plano_id           ID del plano
 * @param   integer     $parcela_id         ID de la parcela (tabla uniones_desgloses)
 * @param   integer     $parcela_prov_id    ID de la parcela (tabla planos_parc_prov)
 * @param   boolean     $connection         Objeto de la conexión de CCS
 * @return  mixed       Devuelve un string con el plano o false si no se encontró
 */
function obtenerPlano( $plano_id = false, $parcela_id = false, $parcela_prov_id = false, $connection = false ) {
	if (
		( !empty( $plano_id ) || !empty( $parcela_id ) || !empty( $parcela_prov_id ) )
		&& !empty( $connection)
	) {

		// Si se han pasado los parámetros necesarios busca el plano, arma el nro y lo devuelve
		if ( !empty( $plano_id ) ) {
			$SQL = "SELECT IF( plano_nro, CONCAT('T.F. ', CONCAT_WS('-', planos.tipo_depto_parc_id, CONCAT(tipo_plano_abrev, plano_nro ), RIGHT( plano_anio, 2 ) ) ), IFNULL( tmp_plano, 'Sin Mensura') ) AS planete
			FROM planos
			LEFT JOIN tipos_deptos_parcela ON tipos_deptos_parcela.tipo_depto_parc_id = planos.tipo_depto_parc_id
			LEFT JOIN tipos_planos ON tipos_planos.tipo_plano_id = planos.tipo_plano_id
			WHERE plano_id = " . $plano_id . "
			ORDER BY planos.plano_f_entrada DESC
			LIMIT 1";
		} else if ( !empty( $parcela_id ) ) {
			$SQL = "SELECT IF( plano_nro, CONCAT('T.F. ', CONCAT_WS('-', planos.tipo_depto_parc_id, CONCAT(tipo_plano_abrev, plano_nro ), RIGHT( plano_anio, 2 ) ) ), IFNULL( tmp_plano, 'Sin Mensura') ) AS planete
			FROM planos
			INNER JOIN uniones_desgloses ON uniones_desgloses.plano_id = planos.plano_id
			LEFT JOIN tipos_deptos_parcela ON tipos_deptos_parcela.tipo_depto_parc_id = planos.tipo_depto_parc_id
			LEFT JOIN tipos_planos ON tipos_planos.tipo_plano_id = planos.tipo_plano_id
			WHERE uniones_desgloses.parcela_destino_id = " . $parcela_id . " AND uniones_desgloses.plano_id IS NOT NULL
			ORDER BY planos.plano_f_entrada DESC
			LIMIT 1";
		} else if ( !empty( $parcela_prov_parc_parcela_id ) ) {
			$SQL = "SELECT IF( plano_nro, CONCAT('T.F. ', CONCAT_WS('-', planos.tipo_depto_parc_id, CONCAT(tipo_plano_abrev, plano_nro ), RIGHT( plano_anio, 2 ) ) ), IFNULL( tmp_plano, 'Sin Mensura') ) AS planete
			FROM planos
			INNER JOIN planos_parc_prov ON planos_parc_prov.plano_id = planos.plano_id
			LEFT JOIN tipos_deptos_parcela ON tipos_deptos_parcela.tipo_depto_parc_id = planos.tipo_depto_parc_id
			LEFT JOIN tipos_planos ON tipos_planos.tipo_plano_id = planos.tipo_plano_id
			WHERE planos_parc_prov.parcela_id = " . $parcela_prov_parc_parcela_id . "
			ORDER BY planos.plano_f_entrada DESC
			LIMIT 1";
		}


		$connection->query( $SQL );

		if ( $connection->next_record() ) {
			return $connection->f( 'planete' );
		} else {
			return false;
		}

	} else {

		// si no se han pasado los parámetros necesarios
		return false;

	}
}


/**
 * Devuelve el nombre del archivo del plano en base al ID, o el ID de la parcela
 * @param  array  $options        Opciones y parámetros para traer el plano
 * @param  object $connection     Objeto de la conexión de CCS
 * @return mixed                  Array con los datos del archivo del plano, false si no se encuentra
 */
function obtenerPlanoImg($options, $connection) {
	/**
	 * opciones por defecto:
	 *      plano_id:            ID del plano del cual se quiere traer la imagen
	 *      parcela_id:          ID de la parcela de la cual ser quiere traer la imagen del plano relacionado
	 *      parcela_prov_id:     ID de la parcela de la cual ser quiere traer la imagen del plano relacionado
	 *      files_path:          Path en el que se va a buscar el archivo, si no utiliza PLANOS_PATH (configuracion)
	 *      return_mode:         'full' for full path, 'relative' (default) for relative paths, or 'files' for only filenames
	 *      debug:               Habilita el modo debug
	 *
	 */
	$defaultOptions = array(
		'plano_id' => false,
		'parcela_id' => false,
		'parcela_prov_id' => false,
		'files_path' => WWW_ROOT . PLANOS_PATH,
		'return_mode' => 'relative',
		'debug' => false
	);

	$options = array_merge($defaultOptions, $options);
	if ($options['debug']) debug($options, false, false, 'Options:');

	// trae los datos de acuerdo al tipo de parámetro pasado
	if (!empty($options['plano_id'])) {
		$SQL = 'SELECT planos.* FROM planos WHERE planos.plano_id = ' . mysql_real_escape_string($options['plano_id']);
	} else if (!empty($options['parcela_id'])) {
		$SQL = '
		SELECT planos.* FROM planos
		INNER JOIN uniones_desgloses ON uniones_desgloses.plano_id = planos.plano_id
		WHERE uniones_desgloses.parcela_destino_id = ' . mysql_real_escape_string($options['parcela_id']) . ' AND uniones_desgloses.plano_id IS NOT NULL
		ORDER BY planos.plano_f_entrada DESC';
	} else if (!empty($options['parcela_prov_id'])) {
		$SQL = '
		SELECT planos.* FROM planos
		INNER JOIN planos_parc_prov ON planos_parc_prov.plano_id = planos.plano_id
		WHERE planos_parc_prov.parcela_id = ' . mysql_real_escape_string($options['parcela_prov_id']) . '
		ORDER BY planos.plano_f_entrada DESC';
	} else {
		return false;
	}
	if ($options['debug']) debug($SQL, false, false, 'SQL:');
	// ejecuta la consulta y trae los datos del plano
	$connection->query( $SQL );
	$connection->next_record();
	$data = CCArrayFromConnection($connection);
	if ($options['debug']) debug($data, false, false, 'Query data:');

	if ( !empty($data) ) {
		// obtiene el patrón de nombre de archivo
		$pattern = getPlanoFilename($data);
		if ( !empty( $pattern ) ) {
			// busca los archivos
			include("../configuracion_general.php");
			
			$folder = $GLOBALS['planosFolders'][(int) $data['tipo_depto_parc_id']];
			$search = $options['files_path'] . '/' . $folder . '/' . $pattern . '*.*';
			$files = glob($search);

			if ($options['debug']) debug($search, false, false, 'Patron búsqueda de archivos:');
			if ($options['debug']) debug($files, false, false, 'Archivos encontrados:');
			// devuelve los datos
			if ( !empty($files) ) {
				switch( $options['return_mode'] ) :
					case 'full':
						// devuelve directamente el resultado de glob()
						break;
					case 'files':
						// divide el path por el separador de directorios, recorre el array y trae el último elemento
						$newFiles = array();
						foreach ($files as $key => $value) {
							$file = explode(DS, $value);
							$newFiles[] = end($file);
						}
						break;
					case 'relative':
					default:
						// elimina del path de los archivos el webroot para traerlos relativos, cambia \ por /
						$newFiles = array();
						foreach ($files as $key => $value) {
							$newFiles[] = str_replace(WWW_ROOT, '', $value);
						}
				endswitch;

				if ($options['debug']) debug($newFiles, false, false, 'Archivos procesados:');
				return $newFiles;
			}
		}
	}

	return false;
}


/**
 * Forma el nombre del archivo del plano escaneado en base a los datos del plano
 * @param  array  $plano Array con lo datos del plano en la ddbb
 * @return string        Nombre del archivo del plano: ej. 2-2005-001
 */
function getPlanoFilename($plano) {
	// convierte a enteros los campos necesarios
	$plano['plano_anio'] = (int) $plano['plano_anio'];
	$plano['plano_nro'] = (int) $plano['plano_nro'];

	if (
		!empty($plano)
		&& ( !empty( $plano['plano_anio'] ) && !empty( $plano['plano_nro'] ) )
	) {
		// determina el departamento
		$output = (string) $plano['tipo_depto_parc_id'];
		// determina el año
		$output .= '-' . (string) $plano['plano_anio'];
		// determina el nùmero
		$output .= '-' . sprintf('%03d', $plano['plano_nro']);
		return $output;
	} else {
		return false;
	}
}


/**
 * Busca en base al ID de la parcela la plancheta y genera el HTML para mostrar
 * @param   integer     $id             ID de la parcela
 * @param   resource    $connection     Objeto de la conexión de CCS
 * @param   string      $path           Path a la carpeta de archivos de planchetas
 * @param   integer     $height         Altura de la miniatura generada
 * @param   string      $idType         Tipo de id que se pasa: 'parcela' o 'plancheta'
 * @return  mixed                       Devuelve un string con el plano o false si no se pudo generar
 */
function obtenerPlancheta( $id = false, $connection = false, $path = PLANCHETAS_PATH, $height = 25, $idType = 'parcela' ) {

	if ( !empty( $id ) && !empty( $connection ) ) {
		// si el ID es de tipo 'parcela'
		if ( $idType == 'parcela' ) {
			// obtiene la parcela
			$parcela = $connection->query("SELECT parcelas.* FROM parcelas WHERE parcela_id = " . mysql_real_escape_string( $id ) . " LIMIT 1" );
			$connection->next_record();
			// comienza a crear el string de condiciones para el query de plancheta
			$conditions = " 1";
			// guarda los parámetros en variables
			$tipo_depto_parc_id = $connection->f('tipo_depto_parc_id');
			$parcela_seccion = $connection->f('parcela_seccion');
			$parcela_macizo = $connection->f('parcela_macizo');
			$tipo_padron_parc_id = $connection->f('tipo_padron_parc_id');
			$parcela_parcela = $connection->f('parcela_parcela');
			$parcela_chacra = $connection->f('parcela_chacra');
			$parcela_quinta = $connection->f('parcela_quinta');

			if ( !empty( $tipo_depto_parc_id ) ) {
				$conditions .= " AND tipo_depto_parc_id = '" . $tipo_depto_parc_id . "'";
			}
			if ( !empty( $parcela_seccion ) ) {
				$conditions .= " AND plancheta_scc = '" . $parcela_seccion . "'";
			}
			if ( !empty( $parcela_macizo ) ) {
				$conditions .= " AND plancheta_mzo = '" . $parcela_macizo . "'";
			}

			// si el tipo de padrón es RURAL
			if ( $tipo_padron_parc_id == 2 ) {
				if ( !empty( $parcela_parcela ) ) {
					$conditions .= " AND TRIM(LEADING '0' FROM plancheta_par) = '" . $parcela_parcela . "'";
				}
			}
			if ( !empty( $parcela_chacra ) ) {
				$conditions .= " AND plancheta_cha = '" . $parcela_chacra . "'";
			}
			if ( !empty( $parcela_quinta ) ) {
				$conditions .= " AND plancheta_qta = '" . $parcela_quinta . "'";
			}

			// una vez que tenemos las condiciones buscamos la plancheta
			$planchetaId = CCDLookUp( 'plancheta_id', 'planchetas', $conditions . ' LIMIT 1', $connection );
			$planchetaImg = CCDLookUp( 'plancheta_file', 'planchetas', $conditions . ' LIMIT 1', $connection );
			$planchetaOldFile = CCDLookUp( 'plancheta_old_file', 'planchetas', $conditions . ' LIMIT 1', $connection );

		} else if ( $idType == 'plancheta' ) {
			$planchetaId = $id;
			$planchetaImg = CCDLookUp( 'plancheta_file', 'planchetas', 'plancheta_id = ' . $id . ' LIMIT 1', $connection );
			$planchetaOldFile = CCDLookUp( 'plancheta_old_file', 'planchetas', 'plancheta_id = ' . $id . ' LIMIT 1', $connection );
		}

		// si hay plancheta generamos el html de salida
		if ( !empty( $planchetaImg ) ) {
			$title = ( !empty($planchetaOldFile) ) ? 'Archivo original: ' . $planchetaOldFile : '';
			$planchetaThumbSrc = RelativePath . '/obtener_plancheta_archivo.php?archivo=' . rawurlencode($planchetaImg);
			$output  = '<a target="plancheta" href="' . RelativePath . '/reportes/rpt_plancheta.php?plancheta_id=' . $planchetaId . '" title="' . $title . '">';
			$output .= '<img border="0" alt="" style="max-height:' . (int) $height . 'px;height:auto;width:auto;" src="' . htmlspecialchars($planchetaThumbSrc, ENT_QUOTES, 'UTF-8') . '">';
			$output .= '</a>';
		} else {
			$output = '(no disponible)';
		}
		return $output;
	} else {
		return false;
	}
}


/**
 * Chequea si existe ya una persona con el tipo y nro. de documento indicado
 * @param  integer  $tipo_doc     id del tipo de documento a chequear
 * @param  string   $nro_doc      nro. de documento a chequear
 * @param  resource $connection   Objeto de la conexión de CCS
 * @param  integer  $exclude_id   ID a excluir en la búsqueda en el caso de edición
 * @param  boolean  $return_data  determina el tipo de datos a retornar
 * @return mixed                  devuelve true si existe, false si no o array c/datos
 */
function checkPersona( $tipo_doc, $nro_doc, $connection, $exclude_id = false, $return_data = false ) {
	// si están los parámetros necesarios
	if ( !empty( $tipo_doc ) && !empty( $nro_doc ) && !empty( $connection ) ) {

		// excluye el ID en la búsqueda
		$excludeCondition = '';
		if ( !empty( $exclude_id ) ) {
			$excludeCondition = ' AND persona_id != ' . mysql_real_escape_string( $exclude_id );
		}

		// busca la persona
		$persona = $connection->query('
			SELECT *
			FROM personas
			WHERE tipo_documento_id = ' . mysql_real_escape_string( $tipo_doc )
			. ' AND persona_nro_doc = ' . mysql_real_escape_string( $nro_doc )
			. $excludeCondition
		);

		if ( $connection->next_record() ) {
			// si encontró una persona
			if ( $return_data == true ) {
				// si se pidió devolver los datos prepara el array
				return( CCArrayFromConnection( $connection ) );
			} else {
				// si no se pidió devolver datos
				return true;
			}
		} else {
			// so no encontró una persona
			return false;
		}

	}
}


/**
 * CCArrayFromConnection: devuelve un array desde el objeto de conexión de CCS
 * @param  resource   $connection   Objeto de la conexión de CCS
 * @return array                    Array con los datos del registro actual
 */
function CCArrayFromConnection( $connection ) {
	foreach( $connection->Record as $key => $value ) {
		if ( is_string( $key ) ) {
			$data[$key] = $value;
		}
	}
	return $data;
}


/**
 * CCQueryToArray: devuelve un query SQL como un array
 * @param  resource   $connection   Objeto de la conexión de CCS
 * @return array                    Array con los datos del registro actual
 */
function CCQueryToArray( $sql, $connection ) {
	$result = false;
	$connection->query( $sql );

	$counter = 0;
	while( $connection->next_record() ) {
		foreach( $connection->Record as $key => $value ) {
			if ( is_string( $key ) ) {
				$result[$counter][$key] = $value;
			}
		}
		$counter++;
	}

	return $result;
}


/**
 * planoProvSelec: chequea si el plano tiene parcelas provisorias seleccionadas
 * @param  integer  $plano_id    Id del plano a chequear
 * @param  resource $connection  Objeto de la conexión de CCS
 * @return integer               Número de parcelas encontradas
 */
function planoProvSelec( $plano_id, $connection ) {
	$connection->query('
		SELECT COUNT(*) AS cant
		FROM `planos_parc_prov`
		INNER JOIN`planos` ON `planos`.`plano_id` = `planos_parc_prov`.`plano_id`
		WHERE `planos_parc_prov`.`planos_parc_prov_tipo` = "destino" AND ( parcela_id IS NOT NULL AND parcela_id != "" ) AND `planos`.plano_id = ' . mysql_real_escape_string( $plano_id )
	);

	$connection->next_record();

	return ( CCArrayFromConnection( $connection ) );
}


/**
 * planoProvCreadas: chequea si el plano tiene parcelas provisorias creadas
 * @param  integer  $plano_id    Id del plano a chequear
 * @param  resource $connection  Objeto de la conexión de CCS
 * @return integer               Número de parcelas encontradas
 */
function planoProvCreadas( $plano_id, $connection ) {
	$connection->query('
		SELECT COUNT(*) AS cant
		FROM `planos_parc_prov`
		INNER JOIN`planos` ON `planos`.`plano_id` = `planos_parc_prov`.`plano_id`
		WHERE `planos_parc_prov`.`planos_parc_prov_tipo` = "destino" AND ( parcela_id IS NULL OR parcela_id = "" ) AND `planos`.plano_id = ' . mysql_real_escape_string( $plano_id )
	);

	$connection->next_record();

	return ( CCArrayFromConnection( $connection ) );
}


/**
 * planoProvOrigen: chequea si el plano tiene parcelas de origen asignadas
 * @param  integer  $plano_id    Id del plano a chequear
 * @param  resource $connection  Objeto de la conexión de CCS
 * @return integer               Número de parcelas encontradas
 */
function planoProvOrigen( $plano_id, $connection ) {
	$connection->query('
		SELECT COUNT(*) AS cant
			FROM planos_parc_prov
			WHERE plano_id = ' . mysql_real_escape_string( $plano_id ) . ' AND planos_parc_prov_tipo = "origen";'
	);
	$connection->next_record();

	return ( CCArrayFromConnection( $connection ) );
}


/**
 * getUltimaPartida: devuelve el ID de la última partida existente
 * @param  resource $connection  Objeto de la conexión de CCS
 * @return integer               Número de la última partida
 */
function getUltimaPartida( $connection ) {
	$connection->query( 'SELECT MAX(parcela_partida) AS ultima_partida FROM parcelas;' );
	$connection->next_record();

	return $connection->f('ultima_partida');
}


/**
 * planoGetProvActive: devuelve los Ids de parcelas prov activas del plano
 * @param  integer  $plano_id    Id del plano a chequear
 * @param  string   $tipo        destino, origen, both
 * @param  resource $connection  Objeto de la conexión de CCS
 * @return integer               Número de parcelas encontradas
 */
function planoGetProvActive( $plano_id, $tipo = 'both' , $connection ) {
	// condición del tipo
	switch( $tipo ) {
		case 'origen':
			$condTipo = 'AND `planos_parc_prov`.`planos_parc_prov_tipo` = "origen"';
			break;

		case 'destino':
			$condTipo = 'AND `planos_parc_prov`.`planos_parc_prov_tipo` = "destino"';
			break;

		case 'both':
		default:
			$condTipo = '';
			break;
	}

	$connection->query('
		SELECT `planos_parc_prov`.`planos_prov_id`, `planos_parc_prov`.`planos_parc_prov_tipo`
		FROM `planos_parc_prov`
		INNER JOIN`planos` ON `planos`.`plano_id` = `planos_parc_prov`.`plano_id`
		WHERE 1 = 1 ' . $condTipo . ' AND `planos_parc_prov`.`tipo_estado_id` = 1 AND `planos`.plano_id = ' . mysql_real_escape_string( $plano_id ) . ' ORDER BY `planos_parc_prov`.`planos_prov_id` ASC;
	');

	while( $connection->next_record() ) :
		$records[] = CCArrayFromConnection( $connection );
	endwhile;

	return ( $records );
}


/**
 * Genera el HTML de los slideshows de parcelas
 * @param  integer  $parcela_id  El id de la parcela
 * @param  array    $options     Las opciones de generación del slideshow (explicadas en la función)
 * @param  resource $db          Objeto de la conexión con la DDDBB
 * @return mixed                 Devuelve un string o 'false' si no hay planchetas
 */
function generarPlanchetasSlides( $parcela_id, $options, $db ) {
	// procesa las opciones pasadas
	$defOptions = array(
		'dom_id' => 'slides',                                                       // ID a asignarle al contenedor de slides
		'width' => 640,                                                                 // Ancho de las miniaturas a generar
		'height' => 480,                                                                // Alto de las miniaturas a generar
		'wrapper' => false,                                                         // Wrapper para el slideshow (util para jquery ui)
		'wrapper_title' => false,                                               // Título del wrapper (util para jquery ui)
		'encode' => true,                                                               // Codifica como json para facilitar insersión con Javascript
		'multiple' => false,                                                        // Si es verdadero agrega el Nro. a cada DOM Id
		'additional_classes' => ''                                          // Clases adicionales para el contenedor
	);
	if ( is_array( $options ) ) {
		$options = array_merge( $defOptions, $options );
	}


	if ( !empty( $parcela_id ) ) {
		// determina si se pueden buscar las planchetas y va creando la condición de la consulta que las trae
		$SQL = 'SELECT * FROM parcelas WHERE parcela_id = ' . mysql_real_escape_string( $parcela_id );
		$parcelaData = CCQueryToArray( $SQL, $db );

		if ( !empty( $parcelaData ) ) {
			$pasa = false;
			$where = ' 1 ';
			if ( !empty( $parcelaData[0]['tipo_depto_parc_id'] ) ) {
				$where .= " AND tipo_depto_parc_id = '" . $parcelaData[0]['tipo_depto_parc_id'] . "'";
			}
			if ( !empty( $parcelaData[0]['tipo_padron_parc_id'] ) ) {
				$where .= " AND tipo_padron_parc_id = '" . $parcelaData[0]['tipo_padron_parc_id'] . "'";
			}
			if ( !empty( $parcelaData[0]['parcela_seccion'] ) ) {
				$where .= " AND plancheta_scc = '" . $parcelaData[0]['parcela_seccion'] . "'";
				$pasa = true;
			}
			if ( !empty( $parcelaData[0]['parcela_macizo'] ) ) {
				$where .= " AND plancheta_mzo = '" . $parcelaData[0]['parcela_macizo'] . "'";
				$pasa = true;
			}
			if ( !empty( $parcelaData[0]['parcela_parcela'] ) ) {
				$where .= " AND ( (TRIM(LEADING '0' FROM plancheta_par) = '" . $parcelaData[0]['parcela_parcela'] . "') OR (IFNULL(TRIM(LEADING '0' FROM plancheta_par),'')= ''))";
				$pasa = true;
			}
			if ( !empty( $parcelaData[0]['parcela_chacra'] ) ) {
				$where .= " AND plancheta_cha = '" . $parcelaData[0]['parcela_chacra'] . "'";
				$pasa = true;
			}
			if ( !empty( $parcelaData[0]['parcela_quinta'] ) ) {
				$where .= " AND plancheta_qta = '" . $parcelaData[0]['parcela_quinta'] . "'";
				$pasa = true;
			}

			// si se debe generar el slide
			if ( $pasa ) {
				$SQL = 'SELECT plancheta_id, plancheta_file, plancheta_hoja FROM planchetas WHERE ' . $where . ' GROUP BY plancheta_file ORDER BY plancheta_hoja';
				$planchetas = CCQueryToArray( $SQL, $db );
				$htm = '';
				$counter = 0;

				// si hay planchetas
				if ( !empty( $planchetas ) ) {
					// si debe crearse el wrapper
					$htm .= ( !empty( $options['wrapper'] ) ) ? '<div id="' . $options['wrapper'] . '" title="' . $options['wrapper_title'] . '">' : '';
					// si es múltiple
					if ( empty( $options['multiple'] ) ) {
						$htm .= '<div id="' . $options['dom_id'] . '" class="slides_section">';
					} else {
						$htm .= '<div id="' . $options['dom_id'] . '-' . uniqid() . '" class="slides_section">';
					}
					$htm .= '  <div class="slides_container ' . $options['additional_classes']  . '">';

					foreach( $planchetas as $plancheta ) {
						$counter++;
						$fn = isset($plancheta['plancheta_file']) ? $plancheta['plancheta_file'] : '';
						$proxyGet = RelativePath . '/obtener_plancheta_archivo.php?archivo=' . rawurlencode($fn);
						$htm .= '    <div>';
						$htm .= '      <form method="post" action="' . htmlspecialchars(RelativePath . '/obtener_plancheta_archivo.php', ENT_QUOTES, 'UTF-8') . '" target="_blank" style="display:inline;margin:0;padding:0;border:0;">';
						$htm .= '      <input type="hidden" name="archivo" value="' . htmlspecialchars($fn, ENT_QUOTES, 'UTF-8') . '" />';
						$htm .= '      <button type="submit" title="Plancheta #' . $counter . '" style="background:transparent;border:none;padding:0;cursor:pointer;">';
						$htm .= '      <img border="0" style="max-width:' . (int) $options['width'] . 'px;max-height:' . (int) $options['height'] . 'px;" src="' . htmlspecialchars($proxyGet, ENT_QUOTES, 'UTF-8') . '" alt="" />';
						$htm .= '      </button></form>';
						$htm .= '    </div>';
					}
					$htm .= '  </div>';
					$htm .= '</div>';
					// si debe crearse el wrapper
					$htm .= ( !empty( $options['wrapper'] ) ) ? '</div><!-- end: dialog -->' : '';
					// devuelve el código HTML codificado en JSON o no
					if ( $options['encode'] ) {
						return json_encode( $htm );
					} else {
						return $htm;
					}
				} else {
					$htm = '"";';
					return $htm;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
		$Component->plancheta->SetValue( json_encode( $htm ) );
	} else {
		return false;
	}
}


/**
 * Genera el HTML de los slideshows de planos
 * @param  integer  $plano_id    El Id del plano
 * @param  array    $options     Las opciones de generación del slideshow (explicadas en la función)
 * @param  resource $db          Objeto de la conexión con la DDDBB
 * @return mixed                 Devuelve un string con el código o 'false' si no hay planos
 */
function generarPlanoSlides( $plano_id, $options, $db ) {
	// procesa las opciones pasadas
	$defOptions = array(
		'dom_id' => 'slides',                                                   // ID a asignarle al contenedor de slides
		'width' => 640,                                                             // Ancho de las miniaturas a generar
		'height' => 480,                                                            // Alto de las miniaturas a generar
		'wrapper' => false,                                                         // Wrapper para el slideshow (util para jquery ui)
		'wrapper_title' => false,                                               // Título del wrapper (util para jquery ui)
		'encode' => true,                                                               // Codifica como json para facilitar insersión con Javascript
		'multiple' => false,                                                        // Si es verdadero agrega el Nro. a cada DOM Id
		'additional_classes' => ''                                          // Clases adicionales para el contenedor
	);
	if ( is_array( $options ) ) $options = array_merge( $defOptions, $options );

	if ( !empty( $plano_id ) ) {
		// trae la imagen atachada al plano
		$image = CCDLookUp( 'plano_archivo', 'planos', 'plano_id = ' . mysql_real_escape_string($plano_id), $db);
		if ( !empty( $image ) ) {
			$filePath = WWW_ROOT . PLANOS_ATTACHED_PATH . DS . $image;
			if ( file_exists( $filePath ) ) {
				$attachedImage = PLANOS_ATTACHED_PATH . DS . $image;
			}
		}
		// trae los archivos de planos
		$planosImg = obtenerPlanoImg( array('plano_id' => $plano_id, 'debug' => false), $db );

		// si hay datos genera el slide
		if ( !empty( $attachedImage ) || !empty( $planosImg ) ) {
			// si debe crearse el wrapper
			$htm .= ( !empty( $options['wrapper'] ) ) ? '<div id="' . $options['wrapper'] . '" title="' . $options['wrapper_title'] . '">' : '';
			// si es múltiple
			if ( empty( $options['multiple'] ) ) {
				$htm .= '<div id="' . $options['dom_id'] . '" class="slides_section">';
			} else {
				$htm .= '<div id="' . $options['dom_id'] . '-' . uniqid() . '" class="slides_section">';
			}
			$htm .= '  <div class="slides_container ' . $options['additional_classes']  . '">';
			// incluye slide de imagen atachada
			if ( !empty($attachedImage) ) {
				$htm .= '    <div>';
				$htm .= '      <a target="_blank" href="' . RelativePath . $attachedImage . '"><img border="0" src="' . RelativePath . '/phpThumb/phpThumb.php?src=' . RelativePath . $attachedImage  . '&w=' . $options['width'] .'&h=' . $options['height'] . '" title="Imagen adjunta al plano ' . $counter . '" /></a>';
				$htm .= '    </div>';
			}
			// incluye slide de planos escaneados
			if ( !empty($planosImg) ) {
				foreach( $planosImg as $img ) {
					$counter++;
					$htm .= '    <div>';
					$htm .= '      <a target="_blank" href="' . RelativePath . $img . '"><img border="0" src="' . RelativePath . '/phpThumb/phpThumb.php?src=' . RelativePath . $img  . '&w=' . $options['width'] .'&h=' . $options['height'] . '" title="Plano escaneado #' . $counter . '" /></a>';
					$htm .= '    </div>';
				}
			}
			$htm .= '  </div>';
			$htm .= '</div>';
			// si debe crearse el wrapper
			$htm .= ( !empty( $options['wrapper'] ) ) ? '</div><!-- end: dialog -->' : '';
			// devuelve el código HTML codificado en JSON o no
			if ( $options['encode'] ) {
				return json_encode( $htm );
			} else {
				return $htm;
			}
		}

	}

	// salida en el caso de no tener resultados
	if ( $options['encode'] ) {
		return json_encode( '"";' );
	} else {
		return '';
	}
}

/**
 * Obtiene las P.O. del plano
 * @param  integer  $planoId [description]
 * @param  resource $db      Objeto de la conexión con la DDDBB
 * @return mixed             Devuelve un array con las parcelas o false si no tiene
 */
function getParcOrigen($planoId, $db) {
	$sql = 'SELECT parcelas.* FROM parcelas INNER JOIN uniones_desgloses ON uniones_desgloses.parcela_id = parcelas.parcela_id WHERE uniones_desgloses.plano_id = ' . mysql_real_escape_string( $planoId ) . ' GROUP BY parcelas.parcela_id ORDER BY parcela_partida, parcela_id';
	$data = CCQueryToArray($sql, $db);

	return $data;
}


/**
 * Obtiene las P.D. del plano
 * @param  integer  $planoId [description]
 * @param  resource $db      Objeto de la conexión con la DDDBB
 * @return mixed             Devuelve un array con las parcelas o false si no tiene
 */
function getParcDestino($planoId, $db) {
	$sql = 'SELECT parcelas.* FROM parcelas INNER JOIN uniones_desgloses ON uniones_desgloses.parcela_destino_id = parcelas.parcela_id WHERE uniones_desgloses.plano_id = ' . mysql_real_escape_string( $planoId ) . ' GROUP BY parcelas.parcela_id ORDER BY parcela_partida, parcela_destino_id';
	$data = CCQueryToArray($sql, $db);

	return $data;
}

/**
 * Obtiene las parcelas Origen a vincular o desvincular en base a las provisorias
 * @param  integer  $plano_id El iD del plano
 * @param  resource $db       Obejeto de la vonexión con la DDBB
 * @param  array    $options  Las opciones disponibles para la función (explicadas en la función)
 * @return mixed              Devuelve un array con los resultados o 'false' si no hay
 */
function getParcOrigenDiff( $plano_id, $db, $options = array() ) {
	$defaultOptions = array(
		'debug' => false
	);
	$options = array_merge($defaultOptions, $options);
	if ( $options['debug'] ) debug( $options, false, false, 'Opciones de la llamada a getParcOrigenDiff' );

	// obtiene las parcelas actualmente vinculadas
	$poSQL = 'SELECT parcela_id FROM uniones_desgloses WHERE plano_id = ' . mysql_real_escape_string( $plano_id ) . ' GROUP BY parcela_id ORDER BY parcela_id ASC;';
	$po = CCQueryToArray( $poSQL, $db );
	if ( $options['debug'] ) debug( $poSQL, false, false, 'P.O. SQL' );
	if ( $options['debug'] ) debug( $po, false, false, 'P.O. Resultados' );

	// obtiene las parcelas provisorias a vincular
	$popSQL = 'SELECT parcela_id FROM planos_parc_prov WHERE plano_id = ' . mysql_real_escape_string( $plano_id ) . ' AND planos_parc_prov_tipo = "origen" GROUP BY parcela_id ORDER BY parcela_id ASC;';
	$pop = CCQueryToArray( $popSQL, $db );
	if ( $options['debug'] ) debug( $popSQL, false, false, 'P.O.P. SQL' );
	if ( $options['debug'] ) debug( $pop, false, false, 'P.O.P. Resultados' );


	// Evalúa las diferencias y saca
	foreach ($po as $poval) {
		$poClean[] = $poval['parcela_id'];
	}

	foreach ($pop as $popval) {
		$popClean[] = $popval['parcela_id'];
	}

	$results = array(
		'remove' => array_diff( $poClean, $popClean ),
		'keep' => array_diff( $poClean, array_diff( $poClean, $popClean ) ),
		'add' => array_diff( $popClean, $poClean),
		'total' => count($po) - count(array_diff( $poClean, $popClean )) + count(array_diff( $popClean, $poClean))
	);

	if ( empty($results['remove']) && empty($results['add']) && empty($results['keep']) ) {
		return false;
	} else {
		return $results;
	}
}


/**
 * Obtiene las parcelas Destino a vincular o desvincular en base a las provisorias
 * @param  integer  $plano_id El iD del plano
 * @param  resource $db       Obejeto de la vonexión con la DDBB
 * @param  array    $options  Las opciones disponibles para la función (explicadas en la función)
 * @return mixed              Devuelve un array con los resultados o 'false' si no hay
 */
function getParcDestinoDiff( $plano_id, $db, $options = array() ) {
	$defaultOptions = array(
		'debug' => false
	);
	$options = array_merge($defaultOptions, $options);
	if ( $options['debug'] ) debug( $options, false, false, 'Opciones de la llamada a getParcDestinoDiff' );

	// obtiene las parcelas actualmente vinculadas
	$pdSQL = 'SELECT parcela_destino_id FROM uniones_desgloses WHERE plano_id = ' . mysql_real_escape_string( $plano_id ) . ' GROUP BY parcela_destino_id ORDER BY parcela_id ASC;';
	$pd = CCQueryToArray( $pdSQL, $db );
	if ( $options['debug'] ) debug( $pdSQL, false, false, 'P.D. SQL' );
	if ( $options['debug'] ) debug( $pd, false, false, 'P.D. Resultados' );

	// obtiene las parcelas provisorias -- a crear --
	$pdpSQL = 'SELECT * FROM planos_parc_prov WHERE plano_id = ' . mysql_real_escape_string( $plano_id ) . ' AND (parcela_id IS NULL OR parcela_id = "" OR parcela_id = 0) AND planos_parc_prov_tipo = "destino" ORDER BY parcela_id ASC;';
	$pdp = CCQueryToArray( $pdpSQL, $db );
	if ( $options['debug'] ) debug( $pdpSQL, false, false, 'P.D.P. (a crear) SQL' );
	if ( $options['debug'] ) debug( $pdp, false, false, 'P.D.P. (a crear) Resultados' );

	// obtiene las parcelas provisorias -- a vincular --
	$pdpvSQL = 'SELECT parcela_id FROM planos_parc_prov WHERE plano_id = ' . mysql_real_escape_string( $plano_id ) . ' AND (parcela_id IS NOT NULL OR parcela_id != "" OR parcela_id != 0) AND planos_parc_prov_tipo = "destino" GROUP BY parcela_id ORDER BY parcela_id ASC;';
	$pdpv = CCQueryToArray( $pdpvSQL, $db );
	if ( $options['debug'] ) debug( $pdpvSQL, false, false, 'P.D.P. (a vincular) SQL' );
	if ( $options['debug'] ) debug( $pdpv, false, false, 'P.D.P. (a vincular) Resultados' );


	// Evalúa las diferencias y saca
	foreach ($pd as $pdval) {
		$pdClean[] = $pdval['parcela_destino_id'];
	}

	foreach ($pdpv as $pdpvVal) {
		$pdpvClean[] = $pdpvVal['parcela_id'];
	}

	$results = array(
		'remove' => array_diff( $pdClean, $pdpvClean ),
		'keep' => array_diff( $pdClean, array_diff( $pdClean, $pdpvClean ) ),
		'add' => array_diff($pdpvClean, $pdClean)
	);

	if ( !empty($pdp) ) {
		$results['create'] = $pdp;
	}
	$results['total'] = count($pd) - count(array_diff( $pdClean, $pdpvClean )) + count(array_diff($pdpvClean, $pdClean)) + count($results['create']);

	if ( empty($results['remove']) && empty($results['add']) && empty($results['keep']) ) {
		return false;
	} else {
		return $results;
	}
}


/**
 * Inserta la parcela en el sistema en base a parcela provisoria
 * @param  array    $data    Datos de la parcela provisoria
 * @param  resource $db      Obejeto de la vonexión con la DDBB
 * @param  array    $options Las opciones disponibles para la función (explicadas en la función)
 * @return mixed             Si inserta devuelve entero con el ID del insert o false si hay problemas o es duplicada
 */
function createParcela( $data, $db, $options = array() ) {
	$defaultOptions = array(
		'isPlanoSVC' => false,				// si el plano al que se vinculan es Sin Vig. Catastral
		'checkDuplicates' => true,			// chequea o no por parcelas duplicadas
		'debug' => false 					// muestra información de desbichaje
	);
	$options = array_merge($defaultOptions, $options);
	if ( $options['debug'] ) debug( $options, false, false, 'Opciones de la llamada a createParcela' );


	// chequea si la parcela existe
	if ( $options['checkDuplicates'] === true ) {
		$condition = genParcelaSearchCondition( $data );
		if ( $options['debug'] ) debug( $condition, false, false, 'Condición de búsqueda:' );
		$SQL = 'SELECT * FROM parcelas WHERE ' . $condition;
		if ( $options['debug'] ) debug( $SQL, false, false, 'Consulta de búsqueda:' );

		$check = CCQueryToArray($SQL, $db);
		if ( !empty($check) )  return 'duplicated';
	}

	/* -- Inserta la parcela */
	// Determina partida y estado de acuerdo a si es SVC o no
	if ( !$options['isPlanoSVC'] ) {
	  $ultimaPartida = getUltimaPartida( $db );
	  $ultimaPartida++;
	  $estadoParcela = 1;
	} else {
	  $ultimaPartida = 0;
	  $estadoParcela = 3;
	}

	// crea la parcela de destino
	$supUF = ( !empty( $data['planos_prov_sup_uf'] ) ) ? $data['planos_prov_sup_uf'] : 0;
	$porcUF = ( !empty( $data['planos_prov_porc_uf'] ) ) ? $data['planos_prov_porc_uf'] : 0;

	$SQL = '
	INSERT INTO parcelas SET
	parcela_partida = ' . mysql_real_escape_string( $ultimaPartida )  . ',
	tipo_depto_parc_id = ' . mysql_real_escape_string( $data['tipo_depto_parc_id'] )  . ',
	parcela_seccion = "' . mysql_real_escape_string( $data['planos_prov_seccion'] )  . '",
	parcela_macizo = "' . mysql_real_escape_string( $data['planos_prov_macizo'] )  . '",
	parcela_parcela = "' . mysql_real_escape_string( $data['planos_prov_parcela'] )  . '",
	parcela_chacra = "' . mysql_real_escape_string( $data['planos_prov_chacra'] )  . '",
	parcela_quinta = "' . mysql_real_escape_string( $data['planos_prov_quinta'] )  . '",
	parcela_fraccion = "' . mysql_real_escape_string( $data['planos_prov_fraccion'] )  . '",
	parcela_uf = "' . mysql_real_escape_string( $data['planos_prov_uf'] )  . '",
	parcela_predio = "' . mysql_real_escape_string( $data['planos_prov_predio'] )  . '",
	parcela_rte = "' . mysql_real_escape_string( $data['planos_prov_rte'] )  . '",
	parcela_super_mensura = ' . mysql_real_escape_string( $data['planos_prov_super_mensura'] )  . ',
	unidades_medidas_id = ' . mysql_real_escape_string( $data['unidades_medidas_id'] )  . ',
	parcela_sup_uf = ' . mysql_real_escape_string( $supUF )  . ',
	parcela_porc_uf = ' . mysql_real_escape_string( $porcUF ) . ',
	usuario_id = ' . mysql_real_escape_string( CCGetSession("UID") ) . ',
	tipo_est_parc_id = ' . mysql_real_escape_string( $estadoParcela ) . ',
	parcela_f_alta = NOW(),
	parcela_f_proceso = NOW();';
	if ( $options['debug'] ) debug( $SQL, false, false, 'Consulta de inserción de parcela:' );

	if ( $db->query( $SQL ) ) {
		return mysql_insert_id();
	} else {
		return 'error';
	};
}


/**
 * Genera las condiciones SQL para buscar una parcela en base a los datos pasados
 * @param  array  $data    Array conteniendo los campos de la nomenclatura
 * @param  array  $options Las opciones disponibles para la función (explicadas en la función)
 * @return string          String con las condiciones para la consulta SQL
 */
function genParcelaSearchCondition( $data, $options = array() ) {
	$defaultOptions = array(
		'source_fields' => array( // nombres de los campos en los que vienen los datos
			'depto' => 'tipo_depto_parc_id', 'seccion' => 'planos_prov_seccion', 'macizo' => 'planos_prov_macizo', 'parcela' => 'planos_prov_parcela', 'chacra' => 'planos_prov_chacra', 'quinta' => 'planos_prov_quinta', 'fraccion' => 'planos_prov_fraccion', 'uf' => 'planos_prov_uf', 'predio' => 'planos_prov_predio', 'rte' =>'planos_prov_rte', 'mzna' => 'planos_prov_mzna', 'lote' => 'planos_prov_lote'
		),
		'target_fields' => array( // nombres de los campos en la tabla donde se va a buscar
			'depto' => 'tipo_depto_parc_id', 'seccion' => 'parcela_seccion', 'macizo' => 'parcela_macizo', 'parcela' => 'parcela_parcela', 'chacra' => 'parcela_chacra', 'quinta' => 'parcela_quinta', 'fraccion' => 'parcela_fraccion', 'uf' => 'parcela_uf', 'predio' => 'parcela_predio', 'rte' => 'parcela_rte', 'mzna' => 'parcela_mzna', 'lote' => 'parcela_lote'
		),
		'debug' => false // habilita la salida de datos de depuración
	);
	$options = array_merge($defaultOptions, $options);
	if ( $options['debug'] ) debug( $options, false, false, 'Opciones de la llamada a genParcelaSearchCondition' );

	// inicializa la salida
	$output = false;

	if ( $options['debug'] ) debug( $data, false, false, 'Datos fuente para crear condición:' );

	// va creando las condiciones
	foreach( $options['source_fields'] as $sfKey => $sf ) {
		// arma y guarda los valores en variables más simples
		$sourceField = $options['source_fields'][$sfKey];
		$targetField = $options['target_fields'][$sfKey];

		if ( !empty( $data[$sourceField] ) ) {
			// si la salida ya tiene alguna condición agrega el concatenador
			if ( !empty($output) ) $output .= ' AND ';
			// agrega la condición
			$output .= $targetField . ' = "' . $data[$sourceField] . '"';
		}
	}
	return $output;
}


function generarPlanchetasSlidesSimple( $parcela_id, $db ) {
	if ( !empty( $parcela_id ) ) {
		$SQL = 'SELECT * FROM parcelas WHERE parcela_id = ' . mysql_real_escape_string( $parcela_id );
		$parcelaData = CCQueryToArray( $SQL, $db );
		if ( !empty( $parcelaData ) ) {
			$pasa = false;
			$where = ' 1 ';
			if ( !empty( $parcelaData[0]['tipo_depto_parc_id'] ) ) {
				$where .= " AND tipo_depto_parc_id = '" . $parcelaData[0]['tipo_depto_parc_id'] . "'";
			}
			if ( !empty( $parcelaData[0]['tipo_padron_parc_id'] ) ) {
				$where .= " AND tipo_padron_parc_id = '" . $parcelaData[0]['tipo_padron_parc_id'] . "'";
			}
			if ( !empty( $parcelaData[0]['parcela_seccion'] ) ) {
				$where .= " AND plancheta_scc = '" . $parcelaData[0]['parcela_seccion'] . "'";
				$pasa = true;
			}
			if ( !empty( $parcelaData[0]['parcela_macizo'] ) ) {
				$where .= " AND plancheta_mzo = '" . $parcelaData[0]['parcela_macizo'] . "'";
				$pasa = true;
			}
			if ( !empty( $parcelaData[0]['parcela_parcela'] ) ) {
				//$where .= " AND ( (TRIM(LEADING '0' FROM plancheta_par) = '" . $parcelaData[0]['parcela_parcela'] . "') OR (IFNULL(TRIM(LEADING '0' FROM plancheta_par),'')= ''))";
				if(trim($parcelaData[0]['tipo_padron_parc_id']) == 2){
					$where .= " AND plancheta_par = '" . trim($parcelaData[0]['parcela_parcela']) . "'";
				}else{
					$where .= " AND ( (TRIM(LEADING '0' FROM plancheta_par) = '" . trim($parcelaData[0]['parcela_parcela']) . "') OR (IFNULL(TRIM(LEADING '0' FROM plancheta_par),'')= ''))";
				}				
				$pasa = true;
			}
			if ( !empty( $parcelaData[0]['parcela_chacra'] ) ) {
				$where .= " AND plancheta_cha = '" . $parcelaData[0]['parcela_chacra'] . "'";
				$pasa = true;
			}
			if ( !empty( $parcelaData[0]['parcela_quinta'] ) ) {
				$where .= " AND plancheta_qta = '" . $parcelaData[0]['parcela_quinta'] . "'";
				$pasa = true;
			}
			if ( $pasa ) {
				$SQL = 'SELECT plancheta_id, plancheta_file, plancheta_hoja FROM planchetas WHERE ' . $where . ' GROUP BY plancheta_file ORDER BY plancheta_hoja';
				$planchetas = CCQueryToArray( $SQL, $db );
				$htm = '';
				$counter = 0;
				if ( !empty( $planchetas ) ) {
					foreach( $planchetas as $plancheta ) {
						$counter++;
						$fn = isset($plancheta['plancheta_file']) ? $plancheta['plancheta_file'] : '';
						$proxyGet = '../obtener_plancheta_archivo.php?archivo=' . rawurlencode($fn);
						$htm .= '<form method="post" action="../obtener_plancheta_archivo.php" target="_blank" style="display:inline;margin:0;padding:0;border:0;">';
						$htm .= '<input type="hidden" name="archivo" value="' . htmlspecialchars($fn, ENT_QUOTES, 'UTF-8') . '" />';
						$htm .= '<button type="submit" title="Plancheta #' . $counter . '" style="background:transparent;border:none;padding:0;cursor:pointer;">';
						$htm .= '<img border="1" style="width:30px;height:20px;" src="' . htmlspecialchars($proxyGet, ENT_QUOTES, 'UTF-8') . '" alt="" />';
						$htm .= '</button></form>';
					}
					return $htm;
				} else {
					return false;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	} else {
		return false;
	}
}

// TODO: documentar!!
function sendNotification( $subject = false, $content = false, $options = false ) {
	/**
	 * Opciones por defecto:
	 * TODO: explicar parámetros
	 */
	$defaultOptions = array(
		'recipient' => NOTIFICATIONS_EMAIL,
		'recipient_cc' => false,
		'recipient_bcc' => false,
		'from_email' => NOTIFICATIONS_FROM_EMAIL,
		'from_name' => NOTIFICATIONS_FROM_NAME,
		'headers' => false,
		'strip_tags' => true,
		'debug' => false
	);
	$options = array_merge($defaultOptions, $options);
	if ($options['debug']) debug($options, false, false, 'Options:');
	if ($options['debug']) debug($subject, false, false, 'Subject:');
	if ($options['debug']) debug($content, false, false, 'Content:');

	if ( !empty($subject) && !empty($content) && !empty($options['recipient']) ) {
		// preparación y configuración de la instancia
		include_once('PHPMailer/class.phpmailer.php');
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->Host = NOTIFICATIONS_SMTP_HOST;
		$mail->SMTPAuth = true;
		$mail->Username = NOTIFICATIONS_SMTP_USER;
		$mail->Password = NOTIFICATIONS_SMTP_PASSWORD;
		$mail->WordWrap = 70;
		// asignación de recipientes
		$mail->From = $options['from_email'];
		$mail->FromName = $options['from_name'];
		$mail->addAddress($options['recipient']);
		$mail->addReplyTo('noreply@divisiongis.com');
		if ( !empty( $options['recipient_cc'] ) ) $mail->addCC( $options['recipient_cc'] );
		if ( !empty( $options['recipient_bcc'] ) ) $mail->addBCC( $options['recipient_bcc'] );
		// preparación del contenido
		$mail->Subject = $subject;
		$mail->Body = ( is_array($content) ) ? implode("\r\n", $content ) : $content;

		// intenta el envío
		if ( $mail->send() ) {
		   return true;
		} else {
			return $mail->ErrorInfo;
		}
	}
}

function sendNotificationTDF( $notifications_email_destino = false, $subject = false, $content = false, $options = false ) {
	/**
	 * Opciones por defecto:
	 * TODO: explicar parámetros
	 */
	$defaultOptions = array(
		'recipient' => 'catastrotdf@tierradelfuego.gov.ar',
		'recipient_cc' => false,
		'recipient_bcc' => false,
		'from_email' => 'catastrotdf@tierradelfuego.gov.ar',
		'from_name' => 'Direccion General de Catastro TDF',
		'headers' => false,
		'strip_tags' => true,
		'debug' => false
	);
	$options = array_merge($defaultOptions, $options);
	if ($options['debug']) debug($subject, false, false, 'Subject:');
	if ($options['debug']) debug($content, false, false, 'Content:');
	if ($options['debug']) debug($options, false, false, 'Options:');
	if ( !empty($subject) && !empty($content) && !empty($options['recipient']) ) {
		//include_once('PHPMailer/class.phpmailer.php');
		include_once('PHPMailer/PHPMailerAutoload.php');
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->Host = 'mail.tierradelfuego.gov.ar';
		$mail->Port = 465;
		$mail->SMTPSecure = 'ssl';
		$mail->SMTPAuth = true;
		$mail->Username = 'catastrotdf';
		$mail->Password = 'Tdf36002';
		//$mail->WordWrap = 70;
		// asignación de recipientes
		$mail->setFrom($options['from_email'], 'Plancheta - Observaciones');
		$mail->addAddress($options['recipient'], $options['from_name']);
		//$mail->addReplyTo(NOTIFICATIONS_TDF_FROM_EMAIL);
		if ( !empty( $options['recipient_cc'] ) ) $mail->addCC( $options['recipient_cc'] );
		if ( !empty( $options['recipient_bcc'] ) ) $mail->addBCC( $options['recipient_bcc'] );
		// preparación del contenido
		$mail->Subject = $subject;
		$mail->Body = ( is_array($content) ) ? implode("\r\n", $content ) : $content;
		$mail->Body = "OBSERVACIONES:\r\n".$mail->Body;
		//var_dump($mail);die();
		// intenta el envío
		if ( $mail->send() ) {
			return true;
		} else {
			return $mail->ErrorInfo;
		}
	}
}

function sendNotification_general_TDF( $notifications_email_destino = false, $subject = false, $content = false, $options = false) {
	define('TDF_MAIL', 'catastrotdf@tierradelfuego.gov.ar');
	define('HOST', 'mail.tierradelfuego.gov.ar');
	define('PORT', '465');
	define('USERNAME', 'catastrotdf');
	define('PASSWORD', 'Tdf36002');
	
	$defaultOptions = array(
		'recipient' => $notifications_email_destino,
		'recipient_cc' => false,
		'recipient_bcc' => false,
		'from_email' => TDF_MAIL,
		'from_name' => 'Direccion General de Catastro TDF',
		'headers' => false,
		'strip_tags' => true,
		'debug' => false
	);
	
	$options = array_merge($defaultOptions, $options);
	if ($options['debug']) debug($subject, false, false, 'Subject:');
	if ($options['debug']) debug($content, false, false, 'Content:');
	if ($options['debug']) debug($options, false, false, 'Options:');
	if ( !empty($subject) && !empty($content) && !empty($options['recipient']) ) {
		include_once('PHPMailer/PHPMailerAutoload.php');
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->Host = HOST;
		$mail->Port = PORT;
		$mail->SMTPSecure = 'ssl';
		$mail->SMTPAuth = true;
		$mail->Username = USERNAME;
		$mail->Password = PASSWORD;
		//$mail->WordWrap = 70;
		// asignación de recipientes
		$mail->setFrom($options['from_email'], 'Previsado Plano');
		$mail->addAddress($options['recipient'], $options['from_name']);
		if ( !empty( $options['recipient_cc'] ) ) $mail->addCC( $options['recipient_cc'] );
		if ( !empty( $options['recipient_bcc'] ) ) $mail->addBCC( $options['recipient_bcc'] );
		// preparación del contenido
		$mail->Subject = $subject;
		$mail->Body = ( is_array($content) ) ? implode("\r\n", $content ) : $content;
		$mail->Body = "Contenido:\r\n".$mail->Body;
		// intenta el envío
		if ( $mail->send() ) {
			return true;
		} else {
			return $mail->ErrorInfo;
		}
	}
}

function rest_center($srv,$wkid,$rings){
	$rings = '[' . json_encode($rings) . ']';
	//print_R($rings);exit;
	$qs = "f=json&sr=$wkid&polygons=$rings";
	$url = $srv . "labelPoints?" . $qs;
	//echo $url;exit;
	$contents = file_get_contents($url); 
	$results = json_decode($contents); 
	return($results->labelPoints[0]);
}

function rest_query($srv,$where,$layer){
	$qs = "outFields=*&f=json";
	$qs .= "&where=" . $where;
	$url = $srv . "$layer/query?" . $qs;
	//echo $url;exit;
	$contents = file_get_contents($url); 
	$results = json_decode($contents); 
	//print_r($results);exit;
	return($results);
}

function calculaFecha($valor,$fecha_inicio=false){
	$modo="days";
	if($fecha_inicio!=false){
		  $fecha_base = strtotime($fecha_inicio);
	}else{
		  $time=time();
		  $fecha_actual=date("Y-m-d",$time);
		  $fecha_base=strtotime($fecha_actual);
	}
	$calculo = strtotime("$valor $modo","$fecha_base");
	return date("Y-m-d", $calculo);
}

function rest_export($srv,$bbox,$zoom,$size,$dpi,$wkid,$layers,$layerdefs='',$trans='false',$zoom_jpg){
	$ancho = $bbox['xmax'] - $bbox['xmin'];
	$alto = $bbox['ymax'] - $bbox['ymin'];
	if($ancho > $alto){
		$alto = $ancho;
	}elseif($ancho < $alto){
		$ancho = $alto;
	}
	//print_r($bbox);die();
	$xmin = $bbox['xmin'];
	$ymin = $bbox['ymin'];
	$xmax = $bbox['xmax'];
	$ymax = $bbox['ymax'];	
	$zoom_jpg = round(sqrt(round($alto * $alto) + round($ancho * $ancho))) * 5;
	$bbox = "$xmin,$ymin,$xmax,$ymax";
	$qs = "bbox=$bbox&bboxSR=$wkid&layers=show:$layers&layerDefs=$layerdefs&size=$size&imageSR=$wkid&format=JPG&transparent=$trans&dpi=$dpi&gdbVersion=sde.DEFAULT&mapScale=$zoom_jpg&f=json";
	$url = $srv . "export?" . $qs;
	//echo $url;die();
	$contents = file_get_contents($url);
	$results = json_decode($contents);
	$img = $results->href;
	//echo $img;die();
	if(!$img){
		return("../imagenes/sin_imagen.jpg");
	}else{
		return($img);
	}
}


function mapa_jpg($parcela_id){
	$db = new clsDBtdf_nuevo();
	$SQL="SELECT parcelas.tipo_depto_parc_id AS DTO, parcelas.parcela_seccion AS SEC, parcelas.parcela_macizo AS MZO,
				 parcelas.parcela_chacra AS CHA, parcelas.parcela_quinta AS QTA, parcelas.parcela_parcela AS PPA,
				 parcelas.tipo_padron_parc_id AS PAD, parcelas.parcela_partida AS PARTIDA
			FROM parcelas
			WHERE parcelas.parcela_id = $parcela_id";
	$db->query($SQL);
	
	if($db->next_record()){
		$partida = $db->f('PARTIDA'); 
		$padron = $db->f('PAD');
		$DTO = $db->f('DTO');
		$SEC = $db->f('SEC');
		$MZO = $db->f('MZO');
		$CHA = $db->f('CHA');
		$QTA = $db->f('QTA');
		$PPA = $db->f('PPA');
	}
	$db->close();
	//$url = "http://catastro.aref.gob.ar/arcgis/rest/services/interna/TDF_interna/MapServer/";
	$url = "http://catastro.aref.gob.ar/arcgis/rest/services/PRUEBAS/Plancheta_actual/MapServer/";
	//$url = "http://catastro.aref.gob.ar/arcgis/rest/services/interna/Plancheta_gis/MapServer/";
	$parcelario = $url;
	$geometry = "http://catastro.aref.gob.ar/arcgis/rest/services/Utilities/Geometry/GeometryServer/";
	
	if($padron == 1){//urbano macizo
		$capa_parcela = 7;
	}elseif($padron == 2){//rural general
		$capa_parcela = 8;
	}
	
	if($capa_parcela == 7){//urbano
		$where = "1=1+AND+DTO+=+'$DTO'+AND+SEC+=+'$SEC'+AND+MZO+=+'$MZO'";
	}elseif($capa_parcela == 8){//rural
		$where = "DTO+=+'$DTO'+AND+SEC+=+'$SEC'+AND+MZO+=+'$MZO'+AND+CHA+=+'$CHA'+AND+QTA+=+'$QTA'+AND+PAR+=+'$PPA'";
	}
	
	$q = rest_query($parcelario,$where,$capa_parcela);
	$wkid = $q->spatialReference->wkid;
	if($q->error->code != ''){
		echo $html="<table cellspacing='0' cellpadding='0' width='100%' border='1' style='border:0.5px solid DodgerBlue;border-collapse:collapse;'>
						<tr>
						<td><br><div align='center'><font color='red' size='3'><b>*ERROR DEL SERVICIO CARTOGRAFICO*</b></font></div><br></td>
						</tr>
						<tr>
						<td><div><br>
						Error Tipo: ".$q->error->code."<br><br>
						Mensaje del Servidor:<br>
						-".$q->error->message."<br>
						-".$q->error->details[0]."<br>
						-".$q->error->details[1]."<br>
						</div></td>
						</tr>
						<tr>
						<td><br><div align='center'><b>Contactar con le Administrador e informar, Gracias.</b></div><br></td>
						</tr>						
					<table>";
		exit;
	}
	//print_r($q->features);die();
	$xmin = 0;
	$xmax = 0;
	$ymin = 0;
	$ymax = 0;
	$inicio = true;
	//echo count($q->features);die();
	foreach ($q->features as $f){//cantidad de poligonos
		//var_dump($f->geometry);
		//$punto = rest_center($geometry,$wkid,$f->geometry);
		$bbox = rest_bbox($f->geometry);//por anillos de poligonos		
		if($inicio){
			$xmin = $bbox['xmin'];
			$ymin = $bbox['ymin'];
			$xmax = $bbox['xmax'];
			$ymax = $bbox['ymax'];
			$inicio = false;		
		}else{
			if($xmin > $bbox['xmin']){
				$xmin = $bbox['xmin'];
			}
			if($xmax < $bbox['xmax']){
				$xmax = $bbox['xmax'];
			}
			if($ymin > $bbox['ymin']){
				$ymin = $bbox['ymin'];
			}
			if($ymax < $bbox['ymax']){
				$ymax = $bbox['ymax'];
			}	
		}
		//print_r($bbox);die();
		$id = $f->attributes->OBJECTID;
		$f2 = json_decode(str_replace("SHAPE.area","SHAPE_area",json_encode($f->attributes)));
	}
	$bbox['xmin'] = $xmin;
	$bbox['ymin'] = $ymin;
	$bbox['xmax'] = $xmax;
	$bbox['ymax'] = $ymax;	
	//print_r($bbox);die();
	//echo $f2->SHAPE_area;exit;
	if($capa_parcela == 7){
		$zoom_jpg = 1200;
	}elseif($capa_parcela == 8){
		$zoom_jpg = 1500;
	}
	//$zoom_jpg = 80;
	//cuando este las medidas, agregar en show la capa 3
	//return(rest_export($parcelario,$bbox,$f2->SHAPE_area/9,'1011,702',100,$wkid,'0,1,2,3,4,5,6,7,8,9,10,11',($capa_parcela-1).','.$capa_parcela.':OBJECTID=' . $id,'',$zoom_jpg));
	//return(rest_export($parcelario,$bbox,$f2->SHAPE_area/9,'1011,702',100,$wkid,'0,1,2,3,4,5,6,7,8,9,10,11',($capa_parcela-3).','.($capa_parcela-2).','.($capa_parcela-1).','.$capa_parcela.':OBJECTID=' . $id,'',$zoom_jpg));
	return(rest_export($parcelario,$bbox,$f2->SHAPE_area/9,'2158,1500',200,$wkid,'0,1,2,3,4,5,6,7,8,9,11,12','OBJECTID=' . $id,'',$zoom_jpg));
}

//busca caja que encierra todos los poligonos buscados, retorna(xmin,ymin,xmax,ymax)
function rest_bbox($rings){
	$anillos=0;
	$primero=true;//primer entrada de anillo
	foreach ($rings->rings as &$valor) {
		for($i = 0;$i < count($valor) ;$i++){
			$x = $valor[$i][0];
			$y = $valor[$i][1];
			if($primero){//si es la primera entrada, carga datos iniciales y despues no vuelve a entrar
				$xmin = $x;
				$xmax = $x;
				$ymin = $y;
				$ymax = $y;
				$primero=false;
			}
			if($xmin > $x){
				$xmin = $x;
			}
			if($xmax < $x){
				$xmax = $x;
			}
			if($ymin > $y){
				$ymin = $y;
			}
			if($ymax < $y){
				$ymax = $y;
			}			
		}
		$anillos++;
	}
	$results_bbox = array();
	$results_bbox['xmin'] = $xmin;
	$results_bbox['ymin'] = $ymin;
	$results_bbox['xmax'] = $xmax;
	$results_bbox['ymax'] = $ymax;
	return($results_bbox);
}

/**
 * Obtienela nomenclatura de la parcela en el formato que se utiliza en la cartografía de la Municipalidad
 * @param  integer $parcela_id      El ID de la parcela
 * @param  integer $parcela_prov_id El ID de la parcela en la tabla de provisorias
 * @return mixed                    String con la nomenclatura o false en caso de no encontrarla o error
 */
function obtenerNomencMuni($parcela_id = false, $parcela_prov_id = false, $connection) {
/*	if ( !empty($parcela_id) ) {
		$data = CCQueryToArray('
			SELECT parcela_seccion, parcela_macizo, parcela_parcela
			FROM parcelas WHERE parcela_id = ' . mysql_real_escape_string($parcela_id), $connection);
	} elseif {
		//$
	}*/

	return false;
}


// TODO: documentar!
function encodeArray($arr) {
  foreach ($arr as $n => $v) {
    if (is_array($v)) {
      $arr[$n] = encodeArray($v);
    } else {
      $arr[$n] = mb_convert_encoding($v, 'Windows-1252', 'UTF-8');
    }
  }
  return $arr;
}

function getRealIP(){
    if (isset($_SERVER["HTTP_CLIENT_IP"])){
        return $_SERVER["HTTP_CLIENT_IP"];
    }elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
        return $_SERVER["HTTP_X_FORWARDED_FOR"];
    }elseif (isset($_SERVER["HTTP_X_FORWARDED"])){
        return $_SERVER["HTTP_X_FORWARDED"];
    }elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])){
        return $_SERVER["HTTP_FORWARDED_FOR"];
    }elseif (isset($_SERVER["HTTP_FORWARDED"])){
        return $_SERVER["HTTP_FORWARDED"];
    }else{
        return $_SERVER["REMOTE_ADDR"];
    }
}