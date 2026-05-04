<?php
//BindEvents Method @1-9625DE4C
function BindEvents()
{
    global $planchetas_observaciones1;
    global $planchetas_observaciones;
    global $CCSEvents;
    $planchetas_observaciones1->CCSEvents["BeforeShow"] = "planchetas_observaciones1_BeforeShow";
    $planchetas_observaciones1->CCSEvents["AfterInsert"] = "planchetas_observaciones1_AfterInsert";
    $planchetas_observaciones->CCSEvents["BeforeShowRow"] = "planchetas_observaciones_BeforeShowRow";
}
//End BindEvents Method

//planchetas_observaciones1_BeforeShow @13-BA019ABE
function planchetas_observaciones1_BeforeShow(& $sender)
{
    $planchetas_observaciones1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $planchetas_observaciones1; //Compatibility
//End planchetas_observaciones1_BeforeShow

//Custom Code @22-2A29BDB7
// -------------------------
    // Write your own code here.
	$user_id = CCGetSession('user_id');
	$user_name = CCGetSession('user_name');
	$institute_id = CCGetSession('institute_id');
	if($user_name){
		$planchetas_observaciones1->usuario->SetValue(" del usuario $user_name");
	}
// -------------------------
//End Custom Code

//Close planchetas_observaciones1_BeforeShow @13-555340D3
    return $planchetas_observaciones1_BeforeShow;
}
//End Close planchetas_observaciones1_BeforeShow

//planchetas_observaciones1_AfterInsert @13-D184973B
function planchetas_observaciones1_AfterInsert(& $sender)
{
    $planchetas_observaciones1_AfterInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $planchetas_observaciones1; //Compatibility
//End planchetas_observaciones1_AfterInsert

//Custom Code @18-2A29BDB7
// -------------------------
    $plancheta_obs_id = mysql_insert_id();
	$db = new clsDBtdf_nuevo();
	$user_id = CCGetSession('user_id');
	$user_name = CCGetSession('user_name');
	$institute_id = CCGetSession('institute_id');
	//$profesional_id
	$SQL="UPDATE planchetas_observaciones SET plancheta_obs_f = NOW(), user_id = '$user_id', user_name = '$user_name' WHERE plancheta_obs_id = $plancheta_obs_id";
	$db->query($SQL);
	$db->close();

	/* Enviar notificación por email
	------------------------------------------------------------------------------------- */
	$subject = "[PLANCHETA ONLINE - OBSERVACIONES]";
	$message = $planchetas_observaciones1->plancheta_obs_descrip->GetValue();

	$body[] = 'Se ha agregado una observacion en el aplicativo de Planchetas OnLine.';
	$body[] = '';
	$body[] = 'Autor: ' . $user_name;
	$body[] = 'Fecha: ' . date('d/m/Y') . ' a las ' . date('H:i:s');
	$body[] = 'Mensaje: (este E-MAIL puede contener errores de formato)';
	$body[] = '';
	$body[] = strip_tags($message);

	sendNotificationTDF( 'catastro@tierradelfuego.gov.ar',$subject,$body,array('debug' => false));
// -------------------------
//End Custom Code

//Close planchetas_observaciones1_AfterInsert @13-6622EAE1
    return $planchetas_observaciones1_AfterInsert;
}
//End Close planchetas_observaciones1_AfterInsert

//planchetas_observaciones_BeforeShowRow @3-ADED19FF
function planchetas_observaciones_BeforeShowRow(& $sender)
{
    $planchetas_observaciones_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $planchetas_observaciones; //Compatibility
//End planchetas_observaciones_BeforeShowRow

//Set Row Style @23-76B945EE
    $styles = array("Row", "AltRow");
    if (count($styles)) {
        $Style = $styles[($Component->RowNumber - 1) % count($styles)];
        if (strlen($Style) && !strpos($Style, "="))
            $Style = (strpos($Style, ":") ? 'style="' : 'class="'). $Style . '"';
        $Component->Attributes->SetValue("planchetas_observaciones", $Style);
    }
//End Set Row Style

//Close planchetas_observaciones_BeforeShowRow @3-E9148670
    return $planchetas_observaciones_BeforeShowRow;
}
//End Close planchetas_observaciones_BeforeShowRow

//Page_BeforeInitialize @1-11AA8448
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $planchetas_observaciones; //Compatibility
//End Page_BeforeInitialize

//Custom Code @24-2A29BDB7
// -------------------------
	include_once(RelativePath . "/scripts/myFunctions.php");
// -------------------------
//End Custom Code

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize
?>
