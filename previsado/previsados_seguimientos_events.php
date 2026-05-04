<?php

//BindEvents Method @1-88C891A5
function BindEvents()
{
    global $previsados_contestaciones;
    global $previsados_contestaciones1;
    global $CCSEvents;
    $previsados_contestaciones->CCSEvents["BeforeShowRow"] = "previsados_contestaciones_BeforeShowRow";
    $previsados_contestaciones1->CCSEvents["BeforeShow"] = "previsados_contestaciones1_BeforeShow";
    $previsados_contestaciones1->CCSEvents["AfterInsert"] = "previsados_contestaciones1_AfterInsert";
}
//End BindEvents Method

//previsados_contestaciones_BeforeShowRow @6-BC366AC6
function previsados_contestaciones_BeforeShowRow(& $sender)
{
    $previsados_contestaciones_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $previsados_contestaciones; //Compatibility
//End previsados_contestaciones_BeforeShowRow

//Custom Code @23-2A29BDB7
// -------------------------
	$db = new clsDBtdf_nuevo();
    if($previsados_contestaciones->DataSource->f('user_id')){
		$nombre = CCDLookUp("prof_nombre","profesionales","user_id=".$previsados_contestaciones->DataSource->f('user_id'),$db);
		if(CCGetSession('user_id') == $previsados_contestaciones->DataSource->f('user_id')){
			$previsados_contestaciones->usuario_nombre->SetValue("<b>Yo</b>");
		}else{
			$previsados_contestaciones->usuario_nombre->SetValue("<b>".$nombre."</b>");
		}
	}elseif($previsados_contestaciones->DataSource->f('usuario_id')){
		$nombre = CCDLookUp("usuario_nombre","_usuarios","usuario_id=".$previsados_contestaciones->DataSource->f('usuario_id'),$db);
		$previsados_contestaciones->usuario_nombre->SetValue("<b>".$nombre."</b>");
	}else{
		$previsados_contestaciones->usuario_nombre->SetValue("<b>NS/NC</b>");
	}
	if($previsados_contestaciones->DataSource->f('previsado_contesta_arch_ubica') != ''){
		$nombre_archivo = $previsados_contestaciones->DataSource->f('previsado_contesta_arch_nom');
		$nombre_guardado = $previsados_contestaciones->DataSource->f('previsado_contesta_arch_ubica');
		$previsados_contestaciones->previsado_contestacion_texto->SetValue($previsados_contestaciones->previsado_contestacion_texto->GetValue()."<br><br><b>Adjunto: <a href='../../catastro_tdf_test/previsado/archivos_observaciones/$nombre_guardado' download='$nombre_archivo'>$nombre_archivo</a></b>");
	}
// -------------------------
//End Custom Code

//Close previsados_contestaciones_BeforeShowRow @6-C0ECD3E7
    return $previsados_contestaciones_BeforeShowRow;
}
//End Close previsados_contestaciones_BeforeShowRow

//previsados_contestaciones1_BeforeShow @13-F26941A8
function previsados_contestaciones1_BeforeShow(& $sender)
{
    $previsados_contestaciones1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $previsados_contestaciones1; //Compatibility
//End previsados_contestaciones1_BeforeShow

//Custom Code @20-2A29BDB7
// -------------------------
    $previsados_contestaciones1->user_id->SetValue(CCGetSession('user_id'));
	$db = new clsDBtdf_nuevo();
	$cant = CCDLookUp("COUNT(*)","previsados_contestaciones","previsado_respuesta_id=".CCGetParam('previsado_respuesta_id'),$db);
	if(CCGetParam('previsado_respuesta_id') && $cant){
		$previsados_contestaciones1->Button_Insert->Visible = true;
		$previsados_contestaciones1->previsado_respuesta_id->SetValue(CCGetParam('previsado_respuesta_id'));
	}else{
		$previsados_contestaciones1->Button_Insert->Visible = false;
	}
	$previsado_carga_id = CCDLookUp("previsado_carga_id","previsados_contestaciones","previsado_respuesta_id=".CCGetParam('previsado_respuesta_id'),$db);
	$previsado_tipo_estado_carga_id  = CCDLookUp("previsado_tipo_estado_carga_id","previsados_cargas","previsado_carga_id=$previsado_carga_id",$db);
	if($previsado_tipo_estado_carga_id == 2 && $previsado_tipo_estado_carga_id == 4){
		$previsados_contestaciones1->Button_Insert->Visible = false;
	}
	$db->close();
// -------------------------
//End Custom Code

//Close previsados_contestaciones1_BeforeShow @13-7DA88CE7
    return $previsados_contestaciones1_BeforeShow;
}
//End Close previsados_contestaciones1_BeforeShow

//previsados_contestaciones1_AfterInsert @13-058D9AA2
function previsados_contestaciones1_AfterInsert(& $sender)
{
    $previsados_contestaciones1_AfterInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $previsados_contestaciones1; //Compatibility
//End previsados_contestaciones1_AfterInsert

//Custom Code @24-2A29BDB7
// -------------------------
    $previsado_contestacion_id = mysql_insert_id();
	$db = new clsDBtdf_nuevo();
	$SQL = "UPDATE previsados_contestaciones SET previsado_contestacion_f = NOW() WHERE previsado_contestacion_id=$previsado_contestacion_id";
	$db->query($SQL);
	$db->close();
// -------------------------
//End Custom Code

//Close previsados_contestaciones1_AfterInsert @13-47BEE598
    return $previsados_contestaciones1_AfterInsert;
}
//End Close previsados_contestaciones1_AfterInsert

//Page_BeforeInitialize @1-083574F7
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $previsados_seguimientos; //Compatibility
//End Page_BeforeInitialize

//Custom Code @5-2A29BDB7
// -------------------------
	if(!CCGetSession('user_id')){
    	global $Redirect;
		$Redirect = "../index.php";
	}
// -------------------------
//End Custom Code

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize
?>
