<?php
// //Events @1-F81417CB

//tdf_footer_debug_BeforeShow @2-E73C08DD
function tdf_footer_debug_BeforeShow(& $sender)
{
    $tdf_footer_debug_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tdf_footer; //Compatibility
//End tdf_footer_debug_BeforeShow

//Custom Code @6-2A29BDB7
// -------------------------
    // Write your own code here.
// -------------------------
//End Custom Code

//Close tdf_footer_debug_BeforeShow @2-1F521337
    return $tdf_footer_debug_BeforeShow;
}
//End Close tdf_footer_debug_BeforeShow

//tdf_footer_BeforeShow @1-8D7F4F1F
function tdf_footer_BeforeShow(& $sender)
{
    $tdf_footer_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tdf_footer; //Compatibility
//End tdf_footer_BeforeShow

//Custom Code @7-2A29BDB7
// -------------------------


	/* Panel de debug
	------------------------------------------------------------ */	

	/* Uso del modo debug
	 * 
	 * Caso 1: Activación permanente (mientras dure la sesión)
	 *    Pasar el parámetro debugMode en la URL con valor 'on'
	 *    ej. http://192.168.62.2/catastro_tdf_nuevo/tdf_login.php?debugMode=on
	 * 
	 * Caso 2: Desactivar modo permanente
	 *    Pasar el parámetro debugMode en la URL con valor 'off'
	 *    ej. http://192.168.62.2/catastro_tdf_nuevo/tdf_login.php?debugMode=off
	 *
	 * Caso 3: Activación temporal (solo para la página cargada)
	 *    Pasar el parámetro debugMode en la URL con valor 1
	 *    ej. http://192.168.62.2/catastro_tdf_nuevo/tdf_login.php?debugMode=1
	 *
	 */

	$debugMode = CCGetParam('debugMode', false);

	if ( !empty( $_SESSION['debugMode'] ) || !empty( $debugMode ) ) :

		// evalua el switch del modo debug
		switch( $debugMode ) :
			case 'off':
				// si el parámetro de debug es 'off' quita la variable
				// de la sesión y aborta el resto de la función
				unset( $_SESSION['debugMode'] );
				return false;
			case 'on':
				// si el parámetro de debug es 'on' setea el flag en la sesión
				$_SESSION['debugMode'] = true;
				break;
		endswitch;

		$Component->debug->Visible = true;


		// Session
		$htm = "<table border='1' cellspacing=0>
					<tr><td colspan='2'> VARIABLE SESSION </td></tr>";
		foreach ($_SESSION as $k => $v) {
					$htm .= "<tr><td>$k</td>";
					$htm .= "<td>";
					if(!is_array($v)){
						$htm .= "$v";
					} else {
						foreach( $v as $k2 => $v2){
							$htm .= "$k2: $v2 <br>";
						}
					}
					$htm .= "</td></tr>";
				

		}
		$htm .= "</table>";

		$Component->session->SetValue($htm);


		//get
		$htm = "<table border='1' cellspacing=0>
					<tr><td colspan='2'> VARIABLE GET </td></tr>";
		foreach ($_GET as $k => $v) {
					$htm .= "<tr><td>$k</td>";
					$htm .= "<td>";
					if(!is_array($v)){
						$htm .= "$v";
					} else {
						foreach( $v as $k2 => $v2){
							$htm .= "$k2: $v2 <br>";
						}
					}
					$htm .= "</td></tr>";

		}
		$htm .= "</table>";

		$Component->get->SetValue($htm);


		//utiles
		$htm = "<table border='1' cellspacing=0>
					<tr><td colspan='2'> OTRAS UTILES </td></tr>";
	
		$htm .= "<tr><td>SERVER NAME</td>";
		$htm .= "<td>" . $_SERVER['SERVER_NAME'] . "</td></tr>";

		$htm .= "<tr><td>SERVER NAME</td>";
		$htm .= "<td>" . $_SERVER['SERVER_NAME'] . "</td></tr>";
	
		$htm .= "<tr><td>SERVER_ADDR</td>";
		$htm .= "<td>" . $_SERVER['SERVER_ADDR'] . "</td></tr>";
	
		$htm .= "<tr><td>REMOTE_ADDR</td>";
		$htm .= "<td>" . $_SERVER['REMOTE_ADDR'] . "</td></tr>";
	
		$htm .= "<tr><td>REMOTE_HOST</td>";
		$htm .= "<td>" . $_SERVER["REMOTE_HOST"] . "</td></tr>";

		$htm .= "<tr><td>SCRIPT_FILENAME</td>";
		$htm .= "<td>" . $_SERVER['SCRIPT_FILENAME'] . "</td></tr>";

		$htm .= "<tr><td>SCRIPT_NAME</td>";
		$htm .= "<td>" . $_SERVER['SCRIPT_NAME'] . "</td></tr>";

		$htm .= "<tr><td>PHP_SELF</td>";
		$htm .= "<td>" . $_SERVER['PHP_SELF'] . "</td></tr>";

		$htm .= "</table>";

		$Component->utiles->SetValue($htm);

	endif;


// -------------------------
//End Custom Code

//Close tdf_footer_BeforeShow @1-FC5356B1
    return $tdf_footer_BeforeShow;
}
//End Close tdf_footer_BeforeShow


?>
