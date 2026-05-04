<?php

//BindEvents Method @1-60DC3473
function BindEvents()
{
    global $previsados_titulares1;
    $previsados_titulares1->CCSEvents["BeforeShow"] = "previsados_titulares1_BeforeShow";
    $previsados_titulares1->CCSEvents["OnValidate"] = "previsados_titulares1_OnValidate";
    $previsados_titulares1->CCSEvents["BeforeInsert"] = "previsados_titulares1_BeforeInsert";
    $previsados_titulares1->CCSEvents["BeforeUpdate"] = "previsados_titulares1_BeforeUpdate";
}
//End BindEvents Method

//previsados_titulares1_BeforeShow @14-5D35A1B7
function previsados_titulares1_BeforeShow(& $sender)
{
    $previsados_titulares1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $previsados_titulares1; //Compatibility
//End previsados_titulares1_BeforeShow

//Custom Code @24-2A29BDB7
// -------------------------
    $previsados_titulares1->previsado_carga_id->SetValue(CCGetParam('previsado_carga_id'));
// -------------------------
//End Custom Code

//Close previsados_titulares1_BeforeShow @14-CCE56CC4
    return $previsados_titulares1_BeforeShow;
}
//End Close previsados_titulares1_BeforeShow

//previsados_titulares1_OnValidate @14-A2A3D94C
function previsados_titulares1_OnValidate(& $sender)
{
    $previsados_titulares1_OnValidate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $previsados_titulares1; //Compatibility
//End previsados_titulares1_OnValidate

//Custom Code @27-2A29BDB7
// -------------------------
    $previsado_titular_nombre = trim($previsados_titulares1->previsado_titular_nombre->GetValue());
	$db = new clsDBtdf_nuevo();
	if(CCGetParam('previsado_titular_id')){
		$where = "previsado_titular_nombre = '$previsado_titular_nombre' AND previsado_carga_id = ".CCGetParam('previsado_carga_id')." AND previsado_titular_id <> ".CCGetParam('previsado_titular_id');
	}else{
		$where = "previsado_titular_nombre = '$previsado_titular_nombre' AND previsado_carga_id = ".CCGetParam('previsado_carga_id');
	}
	$cant = CCDLookUp("COUNT(*)","previsados_titulares","$where",$db);
	if($cant){
		$previsados_titulares1->Errors->addError("Este nombre de persona ya esta ingresado.");
	}
	if(!$previsado_titular_nombre){
		$previsados_titulares1->Errors->addError("Debe ingresar un nombre.");
	}
	$db->close();
// -------------------------
//End Custom Code

//Close previsados_titulares1_OnValidate @14-F31E084D
    return $previsados_titulares1_OnValidate;
}
//End Close previsados_titulares1_OnValidate

//previsados_titulares1_BeforeInsert @14-ECB0F689
function previsados_titulares1_BeforeInsert(& $sender)
{
    $previsados_titulares1_BeforeInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $previsados_titulares1; //Compatibility
//End previsados_titulares1_BeforeInsert

//Custom Code @28-2A29BDB7
// -------------------------
    $previsado_titular_nombre = trim($previsados_titulares1->previsado_titular_nombre->GetValue());
	$db = new clsDBtdf_nuevo();
	$persona_id = CCDLookUp("persona_id","personas","persona_denominacion = '$previsado_titular_nombre' ORDER BY persona_id DESC LIMIT 1",$db);
	$previsados_titulares1->persona_id->SetValue($persona_id);
	$db->close();
// -------------------------
//End Custom Code

//Close previsados_titulares1_BeforeInsert @14-B11F3179
    return $previsados_titulares1_BeforeInsert;
}
//End Close previsados_titulares1_BeforeInsert

//previsados_titulares1_BeforeUpdate @14-7D70431D
function previsados_titulares1_BeforeUpdate(& $sender)
{
    $previsados_titulares1_BeforeUpdate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $previsados_titulares1; //Compatibility
//End previsados_titulares1_BeforeUpdate

//Custom Code @29-2A29BDB7
// -------------------------
    $previsado_titular_nombre = trim($previsados_titulares1->previsado_titular_nombre->GetValue());
	$db = new clsDBtdf_nuevo();
	$persona_id = CCDLookUp("persona_id","personas","persona_denominacion = '$previsado_titular_nombre' ORDER BY persona_id DESC LIMIT 1",$db);
	$previsados_titulares1->persona_id->SetValue($persona_id);
	$db->close();
// -------------------------
//End Custom Code

//Close previsados_titulares1_BeforeUpdate @14-7E36F0F6
    return $previsados_titulares1_BeforeUpdate;
}
//End Close previsados_titulares1_BeforeUpdate

?>
