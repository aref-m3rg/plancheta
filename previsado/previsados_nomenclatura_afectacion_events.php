<?php

//BindEvents Method @1-631B4513
function BindEvents()
{
    global $previsados_parcelas_orige1;
    global $CCSEvents;
    $previsados_parcelas_orige1->CCSEvents["BeforeInsert"] = "previsados_parcelas_orige1_BeforeInsert";
    $previsados_parcelas_orige1->CCSEvents["BeforeUpdate"] = "previsados_parcelas_orige1_BeforeUpdate";
    $previsados_parcelas_orige1->CCSEvents["OnValidate"] = "previsados_parcelas_orige1_OnValidate";
    $previsados_parcelas_orige1->CCSEvents["BeforeShow"] = "previsados_parcelas_orige1_BeforeShow";
}
//End BindEvents Method

//previsados_parcelas_orige1_BeforeInsert @35-A80ABEA5
function previsados_parcelas_orige1_BeforeInsert(& $sender)
{
    $previsados_parcelas_orige1_BeforeInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $previsados_parcelas_orige1; //Compatibility
//End previsados_parcelas_orige1_BeforeInsert

//Custom Code @66-2A29BDB7
// -------------------------
	$tipo_depto_parc_id = $previsados_parcelas_orige1->tipo_depto_parc_id->GetValue();
	$parcela_seccion = $previsados_parcelas_orige1->parcela_seccion->GetValue();
	$parcela_chacra = $previsados_parcelas_orige1->parcela_chacra->GetValue();
	$parcela_quinta = $previsados_parcelas_orige1->parcela_quinta->GetValue();
	$parcela_macizo = $previsados_parcelas_orige1->parcela_macizo->GetValue();
	$parcela_fraccion = $previsados_parcelas_orige1->parcela_fraccion->GetValue();
	$parcela_parcela = $previsados_parcelas_orige1->parcela_parcela->GetValue();
	$parcela_uf = $previsados_parcelas_orige1->parcela_uf->GetValue();
	$SQL="SELECT parcela_id FROM parcelas WHERE 
				tipo_depto_parc_id='$tipo_depto_parc_id' AND 
				parcela_seccion='$parcela_seccion' AND 
				parcela_chacra='$parcela_chacra' AND 
				parcela_quinta='$parcela_quinta' AND 
				parcela_macizo='$parcela_macizo' AND 
				parcela_fraccion='$parcela_fraccion' AND 
				parcela_parcela='$parcela_parcela' AND 
				parcela_uf='$parcela_uf'
				ORDER BY parcela_partida DESC LIMIT 1";
	$db = new clsDBtdf_nuevo();
	$db->query($SQL);
	if($db->next_record()){
		$previsados_parcelas_orige1->parcela_id->SetValue($db->f('parcela_id'));
	}
// -------------------------
//End Custom Code

//Close previsados_parcelas_orige1_BeforeInsert @35-6285AB73
    return $previsados_parcelas_orige1_BeforeInsert;
}
//End Close previsados_parcelas_orige1_BeforeInsert

//previsados_parcelas_orige1_BeforeUpdate @35-B33F6936
function previsados_parcelas_orige1_BeforeUpdate(& $sender)
{
    $previsados_parcelas_orige1_BeforeUpdate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $previsados_parcelas_orige1; //Compatibility
//End previsados_parcelas_orige1_BeforeUpdate

//Custom Code @67-2A29BDB7
// -------------------------
	$tipo_depto_parc_id = $previsados_parcelas_orige1->tipo_depto_parc_id->GetValue();
	$parcela_seccion = $previsados_parcelas_orige1->parcela_seccion->GetValue();
	$parcela_chacra = $previsados_parcelas_orige1->parcela_chacra->GetValue();
	$parcela_quinta = $previsados_parcelas_orige1->parcela_quinta->GetValue();
	$parcela_macizo = $previsados_parcelas_orige1->parcela_macizo->GetValue();
	$parcela_fraccion = $previsados_parcelas_orige1->parcela_fraccion->GetValue();
	$parcela_parcela = $previsados_parcelas_orige1->parcela_parcela->GetValue();
	$parcela_uf = $previsados_parcelas_orige1->parcela_uf->GetValue();
	$SQL="SELECT parcela_id FROM parcelas WHERE 
				tipo_depto_parc_id='$tipo_depto_parc_id' AND 
				parcela_seccion='$parcela_seccion' AND 
				parcela_chacra='$parcela_chacra' AND 
				parcela_quinta='$parcela_quinta' AND 
				parcela_macizo='$parcela_macizo' AND 
				parcela_fraccion='$parcela_fraccion' AND 
				parcela_parcela='$parcela_parcela' AND 
				parcela_uf='$parcela_uf'
				ORDER BY parcela_partida DESC LIMIT 1";
	$db = new clsDBtdf_nuevo();
	$db->query($SQL);
	if($db->next_record()){
		$previsados_parcelas_orige1->parcela_id->SetValue($db->f('parcela_id'));
	}
// -------------------------
//End Custom Code

//Close previsados_parcelas_orige1_BeforeUpdate @35-ADAC6AFC
    return $previsados_parcelas_orige1_BeforeUpdate;
}
//End Close previsados_parcelas_orige1_BeforeUpdate

//previsados_parcelas_orige1_OnValidate @35-8E57D2C8
function previsados_parcelas_orige1_OnValidate(& $sender)
{
    $previsados_parcelas_orige1_OnValidate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $previsados_parcelas_orige1; //Compatibility
//End previsados_parcelas_orige1_OnValidate

//Custom Code @71-2A29BDB7
// -------------------------
	$tipo_depto_parc_id = $previsados_parcelas_orige1->tipo_depto_parc_id->GetValue();
	$parcela_seccion = $previsados_parcelas_orige1->parcela_seccion->GetValue();
	$parcela_chacra = $previsados_parcelas_orige1->parcela_chacra->GetValue();
	$parcela_quinta = $previsados_parcelas_orige1->parcela_quinta->GetValue();
	$parcela_macizo = $previsados_parcelas_orige1->parcela_macizo->GetValue();
	$parcela_fraccion = $previsados_parcelas_orige1->parcela_fraccion->GetValue();
	$parcela_parcela = $previsados_parcelas_orige1->parcela_parcela->GetValue();
	$parcela_uf = $previsados_parcelas_orige1->parcela_uf->GetValue();
	$previsado_parcela_origen_id = CCGetParam('previsado_parcela_origen_id');
	$previsado_carga_id = CCGetParam('previsado_carga_id');
	if(!$parcela_seccion){
		$where_parcela_seccion = "parcela_seccion = '' OR parcela_seccion IS NULL";
	}else{
		$where_parcela_seccion = "parcela_seccion = '$parcela_seccion'";
	}
	if(!$parcela_chacra){
		$where_parcela_chacra = "parcela_chacra = '' OR parcela_chacra IS NULL";
	}else{
		$where_parcela_chacra = "parcela_chacra = '$parcela_chacra'";
	}
	if(!$parcela_quinta){
		$where_parcela_quinta = "parcela_quinta = '' OR parcela_quinta IS NULL";
	}else{
		$where_parcela_quinta = "parcela_quinta = '$parcela_quinta'";
	}
	if(!$parcela_macizo){
		$where_parcela_macizo = "parcela_macizo = '' OR parcela_macizo IS NULL";
	}else{
		$where_parcela_macizo = "parcela_macizo = '$parcela_macizo'";
	}
	if(!$parcela_fraccion){
		$where_parcela_fraccion = "parcela_fraccion = '' OR parcela_fraccion IS NULL";
	}else{
		$where_parcela_fraccion = "parcela_fraccion = '$parcela_fraccion'";
	}
	if(!$parcela_parcela){
		$where_parcela_parcela = "parcela_parcela = '' OR parcela_parcela IS NULL";
	}else{
		$where_parcela_parcela = "parcela_parcela = '$parcela_parcela'";
	}
	if(!$parcela_uf){
		$where_parcela_uf = "parcela_uf = '' OR parcela_uf IS NULL";
	}else{
		$where_parcela_uf = "parcela_uf = '$parcela_uf'";
	}
	$where = "tipo_depto_parc_id = $tipo_depto_parc_id AND ($where_parcela_seccion) AND ($where_parcela_chacra) AND ($where_parcela_quinta) AND ($where_parcela_macizo) AND ($where_parcela_fraccion) AND ($where_parcela_parcela) AND ($where_parcela_uf) AND previsado_carga_id = '$previsado_carga_id'";
	if($previsado_parcela_origen_id){//si actualiza
		$where .= " AND previsado_parcela_origen_id <> $previsado_parcela_origen_id";
	}else{//si inserta
		$where .= "";
	}
	$db = new clsDBtdf_nuevo();
	$cant = CCDLookUp("COUNT(*)","previsados_parcelas_origenes","$where",$db);
	$db->close();
	if($cant){
		$previsados_parcelas_orige1->Errors->addError("YA EXISTE LA NOMENCLATURA QUE INTENTA INGRESAR");
	}
	
// -------------------------
//End Custom Code

//Close previsados_parcelas_orige1_OnValidate @35-F4FF316C
    return $previsados_parcelas_orige1_OnValidate;
}
//End Close previsados_parcelas_orige1_OnValidate

//previsados_parcelas_orige1_BeforeShow @35-6087FA8F
function previsados_parcelas_orige1_BeforeShow(& $sender)
{
    $previsados_parcelas_orige1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $previsados_parcelas_orige1; //Compatibility
//End previsados_parcelas_orige1_BeforeShow

//Custom Code @73-2A29BDB7
// -------------------------
    $previsados_parcelas_orige1->previsado_carga_id->SetValue(CCGetParam('previsado_carga_id'));
// -------------------------
//End Custom Code

//Close previsados_parcelas_orige1_BeforeShow @35-CB0455E5
    return $previsados_parcelas_orige1_BeforeShow;
}
//End Close previsados_parcelas_orige1_BeforeShow

//Page_BeforeInitialize @1-BBE22082
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $previsados_nomenclatura_afectacion; //Compatibility
//End Page_BeforeInitialize

//Custom Code @5-2A29BDB7
// -------------------------
    // Write your own code here.
// -------------------------
//End Custom Code

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize

?>
