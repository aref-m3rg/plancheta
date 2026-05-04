<?php
//BindEvents Method @1-5751DB08
function BindEvents()
{
    global $departamentos_doc_tipos_f;
    global $CCSEvents;
    $departamentos_doc_tipos_f->CCSEvents["BeforeShowRow"] = "departamentos_doc_tipos_f_BeforeShowRow";
    $departamentos_doc_tipos_f->CCSEvents["BeforeShow"] = "departamentos_doc_tipos_f_BeforeShow";
}
//End BindEvents Method

//departamentos_doc_tipos_f_BeforeShowRow @2-7EF514BC
function departamentos_doc_tipos_f_BeforeShowRow(& $sender)
{
    $departamentos_doc_tipos_f_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $departamentos_doc_tipos_f; //Compatibility
//End departamentos_doc_tipos_f_BeforeShowRow

//Set Row Style @177-07645FFB
    $styles = array("Row", "AltRow");
    if (count($styles)) {
        $Style = $styles[($Component->RowNumber - 1) % count($styles)];
        if (strlen($Style) && !strpos($Style, "="))
            $Style = (strpos($Style, ":") ? 'style="' : 'class="'). $Style . '"';
        $Component->Attributes->SetValue("estilo", $Style);
    }
//End Set Row Style

//Custom Code @193-2A29BDB7
// -------------------------
	$persona_parcela_id = $Component->ds->f('persona_parcela_id');
	$persona_id = $Component->ds->f('persona_id');
	$db = new clsDBtdf_nuevo();
	$Component->tipo_persona_parcela_descrip->SetValue(CCDLookUp("tipo_persona_parcela_descrip","personas_parcelas LEFT JOIN tipos_personas_parcelas ON personas_parcelas.tipo_persona_parcela_id = tipos_personas_parcelas.tipo_persona_parcela_id","persona_parcela_id = $persona_parcela_id",$db));
	$Component->tipo_documento_abrev->SetValue(CCDLookUp("tipo_documento_abrev","personas LEFT JOIN tipos_documentos ON personas.tipo_documento_id = tipos_documentos.tipo_documento_id","persona_id = $persona_id",$db));
	$Component->instrumento->SetValue(CCDLookUp("CONCAT(tipo_instrumento_abrev,' ',persona_parcela_num_int)","personas_parcelas LEFT JOIN tipos_instrumentos ON personas_parcelas.tipo_instrumento_id = tipos_instrumentos.tipo_instrumento_id","persona_parcela_id = $persona_parcela_id",$db));
	$db->close();
// -------------------------
//End Custom Code

//Close departamentos_doc_tipos_f_BeforeShowRow @2-30BC910C
    return $departamentos_doc_tipos_f_BeforeShowRow;
}
//End Close departamentos_doc_tipos_f_BeforeShowRow

//departamentos_doc_tipos_f_BeforeShow @2-FAB72641
function departamentos_doc_tipos_f_BeforeShow(& $sender)
{
    $departamentos_doc_tipos_f_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $departamentos_doc_tipos_f; //Compatibility
//End departamentos_doc_tipos_f_BeforeShow

//Custom Code @449-2A29BDB7
// -------------------------
	$db = new clsDBtdf_nuevo();
	$parcela_id = CCGetParam('parcela_id');
	$Component->tipo_instrumento_abrev->SetValue(CCDLookUp("tipo_instrumento_abrev","parcelas LEFT JOIN tipos_instrumentos ON parcelas.tipo_instrumento_id = tipos_instrumentos.tipo_instrumento_id","parcela_id = $parcela_id",$db));
	$Component->planete->SetValue(obtenerPlano('',$parcela_id,'',$db));
	$Component->plano_est_desc->SetValue(CCDLookUp("tipos_estados_planos.tipo_estado_plano_desc","uniones_desgloses INNER JOIN planos ON uniones_desgloses.plano_id = planos.plano_id LEFT JOIN tipos_estados_planos ON planos.tipo_estado_plano_id = tipos_estados_planos.tipo_estado_plano_id","uniones_desgloses.parcela_id = $parcela_id",$db));
	$SQL="SELECT * FROM afectaciones LEFT JOIN tipos_afectaciones ON afectaciones.tipo_afectacion_id = tipos_afectaciones.tipo_afectacion_id WHERE afectaciones.parcela_id = $parcela_id";
	$db->query($SQL);
	if($db->num_rows('afectacion_id')){	
		$db2 = new clsDBtdf_nuevo();
		$html = "<table cellspacing='0' cellpadding='0' width='100%' border='1' style='border:0.5px solid DodgerBlue;border-collapse:collapse;'>
				<tr>
				<td><div align='center'>Tipo de Afectacion</div></td>
				<td><div align='center'>Superficie afectacion</div></td>
				<td><div align='center'>Observaciones</div></td>
				</tr>";
		while($db->next_record()){
			$html.="<tr><td>".$db->f('tipo_afectacion_nombre')."</td> 
						<td>".$db->f('afectacion_superficie')."</td> 
						<td>".$db->f('afectacion_descripcion')."</td> 
					</tr>";
		}
		$html.="</table>";
		$db2->close();
	}else{
		$html = "NO TIENE";
	}
	$departamentos_doc_tipos_f->lista_afectaciones->SetValue($html);
	$db->close();
// -------------------------
//End Custom Code

//Close departamentos_doc_tipos_f_BeforeShow @2-BFC59507
    return $departamentos_doc_tipos_f_BeforeShow;
}
//End Close departamentos_doc_tipos_f_BeforeShow

//Page_BeforeInitialize @1-1AFE86E2
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $gis_info; //Compatibility
//End Page_BeforeInitialize

//Custom Code @455-2A29BDB7
// -------------------------
    //include_once(RelativePath . "/scripts/permisos1.php");
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

?>
