<?php
//BindEvents Method @1-79BE76DC
function BindEvents()
{
    global $buscar;
    global $parcelas;
    global $CCSEvents;
    $buscar->Button_salir->CCSEvents["OnClick"] = "buscar_Button_salir_OnClick";
    $buscar->CCSEvents["OnValidate"] = "buscar_OnValidate";
    $buscar->CCSEvents["BeforeShow"] = "buscar_BeforeShow";
    $parcelas->ImageLink1->CCSEvents["BeforeShow"] = "parcelas_ImageLink1_BeforeShow";
    $parcelas->CCSEvents["BeforeShowRow"] = "parcelas_BeforeShowRow";
    $CCSEvents["AfterInitialize"] = "Page_AfterInitialize";
    $CCSEvents["BeforeShow"] = "Page_BeforeShow";
}
//End BindEvents Method

//buscar_Button_salir_OnClick @171-F004A89B
function buscar_Button_salir_OnClick(& $sender)
{
    $buscar_Button_salir_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $buscar; //Compatibility
//End buscar_Button_salir_OnClick

//Custom Code @172-2A29BDB7
// -------------------------
	setcookie("registrado","yes",time()-1);
	setcookie("registrado","");
	$_COOKIE['registrado']="";
	$_POST['log']="";
	$_POST['pwd']="";
	global $Redirect;
	$Redirect="../index.php";
// -------------------------
//End Custom Code

//Close buscar_Button_salir_OnClick @171-B91F6D3A
    return $buscar_Button_salir_OnClick;
}
//End Close buscar_Button_salir_OnClick

//buscar_OnValidate @62-69C2A61A
function buscar_OnValidate(& $sender)
{
    $buscar_OnValidate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $buscar; //Compatibility
//End buscar_OnValidate

//Custom Code @173-2A29BDB7
// -------------------------
    if($buscar->parcela_macizo->GetValue() == '' && $buscar->parcela_seccion->GetValue() == '' && $buscar->tipo_depto_parc_id->GetValue() == '' && $buscar->partida->GetValue() == '' && $buscar->parcela_f_proceso->GetValue() == ''){
		$buscar->Errors->addError("SE REQUIERE DATOS PARA INICIAR LA BUSQUEDA");
	}
    if($buscar->parcela_macizo->GetValue() != '' && $buscar->parcela_seccion->GetValue() != '' && $buscar->tipo_depto_parc_id->GetValue() == '' && $buscar->parcela_f_proceso->GetValue() == ''){
		$buscar->Errors->addError("SE REQUIERE QUE ELIJA UN DEPARTAMENTO");
	}
    if($buscar->parcela_macizo->GetValue() != '' && $buscar->parcela_seccion->GetValue() == '' && $buscar->tipo_depto_parc_id->GetValue() == '' && $buscar->parcela_f_proceso->GetValue() == ''){
		$buscar->Errors->addError("SE REQUIERE UN DEPARTAMENTO Y SECCION");
	}
// -------------------------
//End Custom Code

//Close buscar_OnValidate @62-1E34EDBD
    return $buscar_OnValidate;
}
//End Close buscar_OnValidate

//buscar_BeforeShow @62-19319CFD
function buscar_BeforeShow(& $sender)
{
    $buscar_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $buscar; //Compatibility
//End buscar_BeforeShow

//Custom Code @210-2A29BDB7
// -------------------------
    $interno = CCGetParam("interno");
	if($interno == 1){
		$buscar->Button_observaciones->Visible = false;
		$buscar->Button_salir->Visible = false;
	}
// -------------------------
//End Custom Code

//Close buscar_BeforeShow @62-21CF8934
    return $buscar_BeforeShow;
}
//End Close buscar_BeforeShow

//parcelas_ImageLink1_BeforeShow @176-CF43AD38
function parcelas_ImageLink1_BeforeShow(& $sender)
{
    $parcelas_ImageLink1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas; //Compatibility
//End parcelas_ImageLink1_BeforeShow

//Open as popup @209-1D16297C
    

// ImageLink1
// ImageLink1
	
global $parcelas;

$lnk=$parcelas->ImageLink1->GetLink();
$newlnk="$lnk\" onclick=\"javascript:window.open(this.href,'Parcela_datos','width=800,height=300,top='+(screen.height-300)/2+',left='+(screen.width-800)/2+',scrollbars=yes,location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=yes').focus();return false;";
$parcelas->ImageLink1->SetLink($newlnk);

	
//End Open as popup

//Close parcelas_ImageLink1_BeforeShow @176-5AAC1A8E
    return $parcelas_ImageLink1_BeforeShow;
}
//End Close parcelas_ImageLink1_BeforeShow

//parcelas_BeforeShowRow @98-AE8449FD
function parcelas_BeforeShowRow(& $sender)
{
    $parcelas_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas; //Compatibility
//End parcelas_BeforeShowRow

//Custom Code @135-2A29BDB7
// -------------------------
	require_once(RelativePath . "/configuracion_general.php");

	$db = new clsDBtdf_nuevo();

	$parcela_id = $parcelas->ds->f('parcela_id');
	$parcelas->plancheta->SetValue(generarPlanchetasSlidesSimple($parcela_id,$db));
	$retorno = false;
	$carpetaDepto = '';
	$SQL = "SELECT planos.plano_id AS plano_id, plano_archivo, planos.tipo_depto_parc_id AS tipo_depto_parc_id
			FROM uniones_desgloses
			INNER JOIN planos ON uniones_desgloses.plano_id = planos.plano_id
			WHERE parcela_destino_id = $parcela_id";
	$db->query($SQL);
	if($db->next_record()){//cargo dato nombre de archivo de plano del campo
		$plano=$db->f('plano_archivo');
		$tipoDeptoPlano = (int) $db->f('tipo_depto_parc_id');
		$carpetaDepto = '';
		if (isset($GLOBALS['planosFolders'][$tipoDeptoPlano])) {
			$carpetaDepto = $GLOBALS['planosFolders'][$tipoDeptoPlano];
		}
		$options = array(
			'plano_id' => $db->f('plano_id'),
			'parcela_id' => false,
			'parcela_prov_id' => false,
			'files_path' => WWW_ROOT . PLANOS_PATH,
			'return_mode' => 'files',
			'debug' => false
		);
		$retorno = obtenerPlanoImg($options,$db);
		//debug($retorno);
	}
	$nro_plano = obtenerPlano('',$parcela_id,'',$db);
	if($retorno && $carpetaDepto !== ''){//si hay archivo en registro cargo imagen
		for($i=0;$i<count($retorno);$i++){
			$proxyHref = '../obtener_plano.php?depto=' . rawurlencode($carpetaDepto) . '&plano=' . rawurlencode($retorno[$i]);
			$absPdf = rtrim(BASE_URL, '/') . str_replace('\\', '/', PLANOS_PATH) . '/' . $carpetaDepto . '/' . $retorno[$i];
			$thumbSrc = rtrim(BASE_URL, '/') . '/phpThumb/phpThumb.php?src=' . rawurlencode($absPdf) . '&w=60';
			$html=$html .= '<a target="_blank" href="' . htmlspecialchars($proxyHref, ENT_QUOTES, 'UTF-8') . '"><img border="1" style ="width:30px; height:20px;" src="' . htmlspecialchars($thumbSrc, ENT_QUOTES, 'UTF-8') . '" title="'.htmlspecialchars($nro_plano, ENT_QUOTES, 'UTF-8').' - Pag:'.($i+1).'" /></a>';
		}
		$archivo = $html;	
		$parcelas->plano->SetValue($archivo);
	}else{//mostrar dato de nombre de plano
		$parcelas->plano->SetValue($nro_plano);
	}

	$padron = $parcelas->ds->f('tipo_padron_parc_id');
	$dpto = $parcelas->ds->f('tipo_depto_parc_id');
	$sec = $parcelas->ds->f('parcela_seccion');
	$mac = $parcelas->ds->f('parcela_macizo');
	$cha = $parcelas->ds->f('parcela_chacra');
	$qta = $parcelas->ds->f('parcela_quinta');
	$par = $parcelas->ds->f('parcela_parcela');
	if($padron == 1){
		$ejemplo = "carto_buscar('$dpto','$sec','$mac');vista(".$parcelas->ds->f('parcela_id').");";
	}elseif($padron == 2){
		$ejemplo = "carto_buscar_rural('$dpto','$sec','$mac','$cha','$qta','$par');vista(".$parcelas->ds->f('parcela_id').");";
	}

	$parcelas->carto->SetValue('<a href="#" title="Centrar en Poligono"><img id="imagen_'.$parcelas->ds->f('parcela_id').'" onclick="'.$ejemplo.'" src="../iconos/22x22/mActionZoomToSelected.gif"></a>');
	$parcelas->actual->SetValue('<spam id="este_'.$parcelas->ds->f('parcela_id').'"></spam>');
	$db->close();
// -------------------------
//End Custom Code

//Close parcelas_BeforeShowRow @98-3957ECCB
    return $parcelas_BeforeShowRow;
}
//End Close parcelas_BeforeShowRow


//Page_AfterInitialize @1-0A2DFA75
function Page_AfterInitialize(& $sender)
{
    $Page_AfterInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $planchetas; //Compatibility
//End Page_AfterInitialize

//Custom Code @52-2A29BDB7
// -------------------------
	/* Trae los parmetros necesarios para la cartografa dinmica
	   desde la tabla de configuracin
	---------------------------------------------------------------------------- */
  	$db = new clsDBtdf_nuevo();

  	$SQL = "SELECT gis_par_server FROM gis_parametros WHERE gis_par_id = 1";
  	$db->query($SQL);
  
  	if($db->next_record()){
  		$Component->servicio->SetValue($db->f(gis_par_server));
	}
  
 	$db->close();
// -------------------------
//End Custom Code

//Close Page_AfterInitialize @1-379D319D
    return $Page_AfterInitialize;
}
//End Close Page_AfterInitialize

//Page_BeforeInitialize @1-8549D052
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $planchetas; //Compatibility
//End Page_BeforeInitialize

//Custom Code @59-2A29BDB7
// -------------------------
   // include_once(RelativePath . "/scripts/permisos1.php");
if ( empty($_COOKIE['registrado']) && $_COOKIE['registrado'] != "yes") {
	//header("location: ../login.php"); 
}  
   	include_once(RelativePath . "/scripts/myFunctions.php");
// -------------------------
//End Custom Code

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize

//Page_BeforeShow @1-2B22CCE8
function Page_BeforeShow(& $sender)
{
    $Page_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $planchetas; //Compatibility
//End Page_BeforeShow

//Custom Code @213-2A29BDB7
// -------------------------
    $interno = CCGetParam("interno");
	if($interno == 1){
		$Component->comentario1->SetValue("<!--");
		$Component->comentario2->SetValue("-->");
		$Component->comentario3->SetValue("<!--");
		$Component->comentario4->SetValue("-->");
	}
// -------------------------
//End Custom Code

//Close Page_BeforeShow @1-4BC230CD
    return $Page_BeforeShow;
}
//End Close Page_BeforeShow

?>
