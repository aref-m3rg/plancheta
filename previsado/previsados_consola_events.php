<?php
//BindEvents Method @1-C00018BE
function BindEvents()
{
    global $previsados_cargas;
    global $presentacion;
    global $CCSEvents;
    $previsados_cargas->CCSEvents["BeforeShowRow"] = "previsados_cargas_BeforeShowRow";
    $presentacion->Button1->CCSEvents["OnClick"] = "presentacion_Button1_OnClick";
    $presentacion->CCSEvents["BeforeShow"] = "presentacion_BeforeShow";
}
//End BindEvents Method

//previsados_cargas_BeforeShowRow @4-6472FF9E
function previsados_cargas_BeforeShowRow(& $sender)
{
    $previsados_cargas_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $previsados_cargas; //Compatibility
//End previsados_cargas_BeforeShowRow

//Custom Code @37-2A29BDB7
// -------------------------
    $previsado_tipo_estado_carga_id = $previsados_cargas->previsado_tipo_estado_carga_id->GetValue();
	$previsado_carga_id = $previsados_cargas->DataSource->f('previsado_carga_id');
	$previsados_cargas->resultado->SetValue('');
	$previsados_cargas->pdf_respuesta->SetValue('');

	$db = new clsDBtdf_nuevo();
	//________________________________ TITULARES _____________________________________________
	$cant_titulares = CCDLookUp("COUNT(*)","previsados_titulares","previsado_carga_id = $previsado_carga_id",$db);
	if($cant_titulares){
		$SQL="SELECT * FROM previsados_titulares WHERE previsado_carga_id = $previsado_carga_id ORDER BY previsado_titular_id DESC";
		$db->query($SQL);
		$html = "";
		$number=1;
		while($db->next_record()){
			$html .= $number."-".$db->f('previsado_titular_nombre').".<br>";
			$number++;
		}
		$html = substr_replace($html,"",-4);
		$previsados_cargas->previsado_titular->SetValue($html);
	}else{
		$html = "<font color='RED'><b>NO TIENE</b></font>";
		$previsados_cargas->previsado_titular->SetValue($html);
	}
	//________________________________ ORIGEN _____________________________________________
	$cant_origenes = CCDLookUp("COUNT(*)","previsados_parcelas_origenes","previsado_carga_id = $previsado_carga_id",$db);
	$tfsm = CCDLookUp("CheckBox_tfsm","previsados_cargas","previsado_carga_id = $previsado_carga_id",$db);
	if($cant_origenes){
		if(!$tfsm){
			$SQL="SELECT previsados_parcelas_origenes.*, tipos_deptos_parcela.tipo_depto_parc_abrev AS tipo_depto_parc_abrev
					FROM previsados_parcelas_origenes 
					LEFT JOIN tipos_deptos_parcela ON previsados_parcelas_origenes.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id
					WHERE previsado_carga_id = $previsado_carga_id 
					ORDER BY previsado_parcela_origen_id DESC";
			$db->query($SQL);
			$html = "<table cellspacing='0' cellpadding='0' width='100%' class='Grid'>
					<tr>
					<td style='color: #fff; background: #3D84CC;'><div align='center'>Depto</div></td>
					<td style='color: #fff; background: #3D84CC;'><div align='center'>Secc</div></td>
					<td style='color: #fff; background: #3D84CC;'><div align='center'>Cha</div></td>
					<td style='color: #fff; background: #3D84CC;'><div align='center'>Qta</div></td>
					<td style='color: #fff; background: #3D84CC;'><div align='center'>Mzo</div></td>
					<td style='color: #fff; background: #3D84CC;'><div align='center'>Fra</div></td>
					<td style='color: #fff; background: #3D84CC;'><div align='center'>Par</div></td>
					<td style='color: #fff; background: #3D84CC;'><div align='center'>Uf|Uc</div></td>
					</tr>";
			while($db->next_record()){
				$html .= "<tr>";
				$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('tipo_depto_parc_abrev')."</div></td>";
				$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_seccion')."</div></td>";
				$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_chacra')."</div></td>";
				$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_quinta')."</div></td>";
				$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_macizo')."</div></td>";
				$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_fraccion')."</div></td>";
				$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_parcela')."</div></td>";
				$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_uf')."</td>";
				$html .= "</tr>";
			}
			$html .= "</table>";
		}else{
			$html = "<font><b>TFSM</b></font>";
		}
		$previsados_cargas->nomenclatura_origen->SetValue($html);
	}else{
		if($tfsm){
			$html = "<font><b>TFSM</b></font>";
		}else{
			$html = "<font color='RED'><b>NO TIENE</b></font>";
		}
		$previsados_cargas->nomenclatura_origen->SetValue($html);
	}
	//________________________________ DESTINO _____________________________________________
	$cant_destinos = CCDLookUp("COUNT(*)","previsados_parcelas_destinos","previsado_carga_id = $previsado_carga_id",$db);
	if($cant_destinos){
		$SQL="SELECT previsados_parcelas_destinos.*, tipos_deptos_parcela.tipo_depto_parc_abrev AS tipo_depto_parc_abrev
				FROM previsados_parcelas_destinos 
				LEFT JOIN tipos_deptos_parcela ON previsados_parcelas_destinos.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id
				WHERE previsado_carga_id = $previsado_carga_id AND ISNULL(previsados_parcelas_destinos.previsado_parcela_destino_reemplazo_id) 
				ORDER BY previsado_parcela_destino_id DESC";
		$db->query($SQL);
		$html = "<table cellspacing='0' cellpadding='0' width='100%' class='Grid'>
				<tr>
				<td style='color: #fff; background: #3D84CC;'><div align='center'>Depto</div></td>
				<td style='color: #fff; background: #3D84CC;'><div align='center'>Secc</div></td>
				<td style='color: #fff; background: #3D84CC;'><div align='center'>Cha</div></td>
				<td style='color: #fff; background: #3D84CC;'><div align='center'>Qta</div></td>
				<td style='color: #fff; background: #3D84CC;'><div align='center'>Mzo</div></td>
				<td style='color: #fff; background: #3D84CC;'><div align='center'>Fra</div></td>
				<td style='color: #fff; background: #3D84CC;'><div align='center'>Par</div></td>
				<td style='color: #fff; background: #3D84CC;'><div align='center'>Uf|Uc</div></td>
				<td style='color: #fff; background: #3D84CC;'><div align='center'>Sup.P.</div></td>
				</tr>";
		while($db->next_record()){
			$html .= "<tr>";
			$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('tipo_depto_parc_abrev')."</div></td>";
			$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_seccion')."</div></td>";
			$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_chacra')."</div></td>";
			$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_quinta')."</div></td>";
			$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_macizo')."</div></td>";
			$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_fraccion')."</div></td>";
			$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_parcela')."</div></td>";
			$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_uf')."</td>";
			$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_super_mensura')."</td>";
			$html .= "</tr>";
		}
		$html .= "</table>";
		$previsados_cargas->nomenclatura_destino->SetValue($html);
	}else{
		$html = "<font color='RED'><b>NO TIENE</b></font>";
		$previsados_cargas->nomenclatura_destino->SetValue($html);
	}

	$previsado_respuesta_id = CCDLookUp("previsado_respuesta_id","previsados_respuestas","previsado_carga_id = $previsado_carga_id LIMIT 1",$db);
	$previsados_cargas->icono->SetValue("");
	$previsados_cargas->cant->SetValue("");

	if(!$previsado_tipo_estado_carga_id){//no tiene estado
		$previsados_cargas->previsado_tipo_estado_carga_id->SetValue("<font color='BLUE'><b>INCOMPLETO</b></font>");
		$previsados_cargas->ImageLink1->Visible = true;
		$previsados_cargas->ImageLink2->SetValue("<a href='#' onclick='confirmar($previsado_carga_id)'><img style='BORDER-TOP: 0px; BORDER-RIGHT: 0px; BORDER-BOTTOM: 0px; BORDER-LEFT: 0px' src='../iconos/22x22/emblem-unreadable.gif'></a>");
	}else{//tiene estado
		$previsados_cargas->ImageLink1->Visible = false;
		$previsados_cargas->ImageLink2->SetValue("");
		$previsado_tipo_estado_carga_id = CCDLookUp("previsado_tipo_estado_carga_id","previsados_tipos_estados_cargas","previsado_tipo_estado_carga_id=$previsado_tipo_estado_carga_id",$db);
		$carga = CCDLookUp("COUNT(*)","previsados_respuestas","previsado_carga_id=$previsado_carga_id",$db);
		//si tiene respuestas/comentarios
		if($previsado_respuesta_id){
			$previsados_cargas->icono->SetValue("<a href='previsados_seguimientos.php?previsado_respuesta_id=".$previsado_respuesta_id."'><img style='BORDER-TOP: 0px; BORDER-RIGHT: 0px; BORDER-BOTTOM: 0px; BORDER-LEFT: 0px' src='../iconos/16x16/mail-send-receive.gif'></a>");
			$cantidad = CCDLookUp("COUNT(*)","previsados_contestaciones","previsado_respuesta_id = $previsado_respuesta_id",$db);
			$previsados_cargas->cant->SetValue("($cantidad)");
		}
		if($previsado_tipo_estado_carga_id == 1){//si esta A VERIFICAR
		    if($carga == 0){
				$previsados_cargas->previsado_tipo_estado_carga_id->SetValue("<font color='RED'><b>CARGADO</b></font>");
			}else{
				$previsados_cargas->previsado_tipo_estado_carga_id->SetValue("<font color='ORANGE'><b>EN PROCESO</b></font>");
			}
		}elseif($previsado_tipo_estado_carga_id == 3){//si esta OBSERVADO
			$previsado_tipo_estado_carga_descrip_html = CCDLookUp("previsado_tipo_estado_carga_descrip_html","previsados_tipos_estados_cargas","previsado_tipo_estado_carga_id=$previsado_tipo_estado_carga_id",$db);
			$previsados_cargas->ImageLink2->SetValue("<a href='#' onclick='confirmar($previsado_carga_id)'><img style='BORDER-TOP: 0px; BORDER-RIGHT: 0px; BORDER-BOTTOM: 0px; BORDER-LEFT: 0px' src='../iconos/22x22/emblem-unreadable.gif'></a>");
			$previsados_cargas->previsado_tipo_estado_carga_id->SetValue("<font color='ORANGE'><b>EN PROCESO</b></font>");
			$previsados_cargas->resultado->SetValue($previsado_tipo_estado_carga_descrip_html);
			$previsados_cargas->ImageLink1->Visible = true;
		}elseif($previsado_tipo_estado_carga_id == 5){//si es A CARATULAR
			$previsado_tipo_estado_carga_descrip_html = CCDLookUp("previsado_tipo_estado_carga_descrip_html","previsados_tipos_estados_cargas","previsado_tipo_estado_carga_id=$previsado_tipo_estado_carga_id",$db);
			$previsados_cargas->previsado_tipo_estado_carga_id->SetValue("<font color='ORANGE'><b>EN PROCESO</b></font>");
			$previsados_cargas->resultado->SetValue($previsado_tipo_estado_carga_descrip_html);
		}elseif($previsado_tipo_estado_carga_id == 2){//si esta APTO DEFINITIVO
			$previsado_tipo_estado_carga_descrip_html = CCDLookUp("previsado_tipo_estado_carga_descrip_html","previsados_tipos_estados_cargas","previsado_tipo_estado_carga_id=$previsado_tipo_estado_carga_id",$db);
			$previsados_cargas->previsado_tipo_estado_carga_id->SetValue("<font color='GREEN'><b>A PRESENTAR</b></font>");
			$previsados_cargas->resultado->SetValue($previsado_tipo_estado_carga_descrip_html);
			$previsados_cargas->pdf_respuesta->SetValue("<a href='pdf_respuesta.php?previsado_carga_id=".$previsado_carga_id."' target='_BLANK'><img style='BORDER-TOP: 0px; BORDER-RIGHT: 0px; BORDER-BOTTOM: 0px; BORDER-LEFT: 0px' src='../iconos/16x16/pdf_document.png'></a>");
		}elseif($previsado_tipo_estado_carga_id == 4){//si esta REGISTRADO
			$previsado_tipo_estado_carga_descrip_html = CCDLookUp("previsado_tipo_estado_carga_descrip_html","previsados_tipos_estados_cargas","previsado_tipo_estado_carga_id=$previsado_tipo_estado_carga_id",$db);
			$previsados_cargas->previsado_tipo_estado_carga_id->SetValue("<b>FINALIZADO</b>");
			$previsados_cargas->resultado->SetValue($previsado_tipo_estado_carga_descrip_html);
		}
	}
	$db->close();
// -------------------------
//End Custom Code

//Close previsados_cargas_BeforeShowRow @4-5040DCDB
    return $previsados_cargas_BeforeShowRow;
}
//End Close previsados_cargas_BeforeShowRow

//presentacion_Button1_OnClick @45-A6DEF88E
function presentacion_Button1_OnClick(& $sender)
{
    $presentacion_Button1_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $presentacion; //Compatibility
//End presentacion_Button1_OnClick

//Custom Code @47-2A29BDB7
// -------------------------
	session_start();
	unset($_SESSION["user_id"]);
	unset($_SESSION["user_login"]);
	unset($_SESSION["user_grupo"]);
    global $Redirect;
	$Redirect = "../index.php";
// -------------------------
//End Custom Code

//Close presentacion_Button1_OnClick @45-A72C270F
    return $presentacion_Button1_OnClick;
}
//End Close presentacion_Button1_OnClick

//presentacion_BeforeShow @41-C65E6D20
function presentacion_BeforeShow(& $sender)
{
    $presentacion_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $presentacion; //Compatibility
//End presentacion_BeforeShow

//Custom Code @43-2A29BDB7
// -------------------------
	$db = new clsDBtdf_nuevo();
	$presentacion->profesional->SetValue(CCDLookUp("prof_nombre","profesionales","user_id = ".$_SESSION["user_id"],$db));
	$db->close();
	$presentacion->plantilla->SetValue("<a href='PLANO_PLANTILLA.DXF' target='_self'><img style='BORDER-TOP: 0px; BORDER-RIGHT: 0px; BORDER-BOTTOM: 0px; BORDER-LEFT: 0px' src='../iconos/33x33/dwg_33.png'></a>");
	$presentacion->puntos->SetValue("<a href='RED_IGN.DWG' target='_self'><img style='BORDER-TOP: 0px; BORDER-RIGHT: 0px; BORDER-BOTTOM: 0px; BORDER-LEFT: 0px' src='../iconos/33x33/dwg_33.png'></a>");
	$presentacion->archivo->SetValue("<a href='pdf_recomendaciones.php' target='_blank'><img style='BORDER-TOP: 0px; BORDER-RIGHT: 0px; BORDER-BOTTOM: 0px; BORDER-LEFT: 0px' src='../iconos/16x16/pdf_document.png'></a>");
	$presentacion->plano->SetValue("<a href='pdf_recomendaciones2.php' target='_blank'><img style='BORDER-TOP: 0px; BORDER-RIGHT: 0px; BORDER-BOTTOM: 0px; BORDER-LEFT: 0px' src='../iconos/16x16/pdf_document.png'></a>");
// -------------------------
//End Custom Code

//Close presentacion_BeforeShow @41-AD3F919E
    return $presentacion_BeforeShow;
}
//End Close presentacion_BeforeShow

//Page_BeforeInitialize @1-F5F9E0B8
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $previsados_consola; //Compatibility
//End Page_BeforeInitialize

//Custom Code @48-2A29BDB7
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
