<?php
//BindEvents Method @1-ADDE3DEA
function BindEvents()
{
    global $previsados_cargas;
    global $previsados_detalles_carga1;
    global $CCSEvents;
    $previsados_cargas->CCSEvents["AfterInsert"] = "previsados_cargas_AfterInsert";
    $previsados_cargas->CCSEvents["BeforeShow"] = "previsados_cargas_BeforeShow";
    $previsados_detalles_carga1->previsado_requisito_id->CCSEvents["BeforeShow"] = "previsados_detalles_carga1_previsado_requisito_id_BeforeShow";
    $previsados_detalles_carga1->CCSEvents["BeforeShow"] = "previsados_detalles_carga1_BeforeShow";
    $previsados_detalles_carga1->CCSEvents["BeforeShowRow"] = "previsados_detalles_carga1_BeforeShowRow";
}
//End BindEvents Method

//previsados_cargas_AfterInsert @2-CE91BE57
function previsados_cargas_AfterInsert(& $sender)
{
    $previsados_cargas_AfterInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $previsados_cargas; //Compatibility
//End previsados_cargas_AfterInsert

//Custom Code @17-2A29BDB7
// -------------------------
    $previsado_carga_id = mysql_insert_id();
	$db = new clsDBtdf_nuevo();
	$db2 = new clsDBtdf_nuevo();
	$SQL = "UPDATE previsados_cargas SET previsado_carga_alta = NOW(), previsado_carga_proc = NOW() WHERE previsado_carga_id = $previsado_carga_id";
	$db->query($SQL);
	//tipo de plano
	$previsado_tipo_plano_id = $previsados_cargas->previsado_tipo_plano_id->GetValue();
	//busco documento obligatorio segun tipo de plano:
	$SQL = "SELECT previsados_relaciones_tipos_requisitos.previsado_requisito_id AS previsado_requisito_id
				FROM previsados_relaciones_tipos_requisitos
				INNER JOIN previsados_tipos_planos_requisitos ON previsados_relaciones_tipos_requisitos.previsado_requisito_id = previsados_tipos_planos_requisitos.previsado_requisito_id
				WHERE previsados_relaciones_tipos_requisitos.previsado_tipo_plano_id = $previsado_tipo_plano_id 
				AND previsados_relaciones_tipos_requisitos.previsado_relacion_obligatorio = 1 
				AND previsados_tipos_planos_requisitos.tipo_estado_id = 1";
	$db->query($SQL);
	while($db->next_record()){//creo detalle de carga
		$previsado_requisito_id = $db->f('previsado_requisito_id');
		$SQL="INSERT INTO previsados_detalles_cargas SET 
							previsado_carga_id = $previsado_carga_id, 
							previsado_requisito_id = $previsado_requisito_id";
		$db2->query($SQL);
	}
	//die();
	$db->close();
	$db2->close();
	global $Redirect;
	$Redirect = "previsados_cargas.php?previsado_carga_id=$previsado_carga_id";
// -------------------------
//End Custom Code

//Close previsados_cargas_AfterInsert @2-4D64ABD8
    return $previsados_cargas_AfterInsert;
}
//End Close previsados_cargas_AfterInsert

//previsados_cargas_BeforeShow @2-84ADEC20
function previsados_cargas_BeforeShow(& $sender)
{
    $previsados_cargas_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $previsados_cargas; //Compatibility
//End previsados_cargas_BeforeShow

//Custom Code @18-2A29BDB7
// -------------------------
    if(CCGetParam('previsado_carga_id')){
		$previsados_cargas->Visible = FALSE;
	}else{
		$previsados_cargas->Visible = TRUE;
		$previsados_cargas->user_id->SetValue(CCGetSession('user_id'));
	}
// -------------------------
//End Custom Code

//Close previsados_cargas_BeforeShow @2-A748EB69
    return $previsados_cargas_BeforeShow;
}
//End Close previsados_cargas_BeforeShow

//previsados_detalles_carga1_previsado_requisito_id_BeforeShow @30-B84B79B9
function previsados_detalles_carga1_previsado_requisito_id_BeforeShow(& $sender)
{
    $previsados_detalles_carga1_previsado_requisito_id_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $previsados_detalles_carga1; //Compatibility
//End previsados_detalles_carga1_previsado_requisito_id_BeforeShow

//Custom Code @35-2A29BDB7
// -------------------------
    $db = new clsDBtdf_nuevo();
	$previsados_detalles_carga1->previsado_requisito_id->SetValue("<b>".CCDLookUp("previsado_requisito_descrip","previsados_tipos_planos_requisitos","previsado_requisito_id=".$previsados_detalles_carga1->previsado_requisito_id->GetValue(),$db).":</b>");
	$db->close();
// -------------------------
//End Custom Code

//Close previsados_detalles_carga1_previsado_requisito_id_BeforeShow @30-D23FAD7E
    return $previsados_detalles_carga1_previsado_requisito_id_BeforeShow;
}
//End Close previsados_detalles_carga1_previsado_requisito_id_BeforeShow


//previsados_detalles_carga1_BeforeShow @27-9AEBECC8
function previsados_detalles_carga1_BeforeShow(& $sender)
{
    $previsados_detalles_carga1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $previsados_detalles_carga1; //Compatibility
//End previsados_detalles_carga1_BeforeShow

//Custom Code @36-2A29BDB7
// -------------------------
	$previsado_carga_id = CCGetParam('previsado_carga_id');
	$previsados_detalles_carga1->previsado_carga_id->SetValue($previsado_carga_id);
    if($previsado_carga_id){
  		$previsados_detalles_carga1->Visible = TRUE;
  	}else{
  		$previsados_detalles_carga1->Visible = FALSE;
  	}
	$db = new clsDBtdf_nuevo();
	$previsado_carga_ubica_cat = CCDLookUp("previsado_carga_ubica_cat","previsados_cargas","previsado_carga_id = $previsado_carga_id",$db);
	if(!$previsado_carga_ubica_cat){
		$html = "<form onsubmit='return checkFileCAD();' enctype='multipart/form-data' method='post' action='uploadCAD.php'>
					<input type='hidden' name='previsado_carga_id' value='$previsado_carga_id' />
                	<input id='fileToUploadCAD' type='file' accept='.dxf,.dwg,.DXF,.DWG' name='fileToUploadCAD'>
					<input class='Button' type='submit' value='Cargar CAD (dxf,dwg)' name='submit'>
             	</form>";
	}else{
		$previsado_nombre_archivo_org = CCDLookUp("previsado_nombre_archivo_org","previsados_cargas","previsado_carga_id = ".CCGetParam('previsado_carga_id'),$db);
		$html = "<form onsubmit='return confirmacion();' method='post' action='downloadCAD.php'>
					<input type='hidden' name='previsado_carga_id' value='$previsado_carga_id' />
					<input class='Button' type='submit' value='Quitar Archivo' name='submit'>
					<font color='GREEN'> $previsado_nombre_archivo_org</font>
					</form>";
	}
	$previsados_detalles_carga1->nombre->SetValue(CCDLookUp("prof_nombre","profesionales","user_id = ".$_SESSION["user_id"],$db));
	$previsados_detalles_carga1->cargacad->SetValue($html);
	$previsados_detalles_carga1->mensaje->SetValue("<font size='3'><b>".CCGetParam('mensaje')."</b></font>");
	$previsados_detalles_carga1->volver->SetValue("<a href='previsados_consola.php'><button class='Button'>Volver al inicio</button></a>");
	
	//-----------------------------------titulares----------------------------------------------
	$cant_titulares = CCDLookUp("COUNT(*)","previsados_titulares","previsado_carga_id = ".CCGetParam('previsado_carga_id'),$db);
	$previsados_detalles_carga1->cant_titulares->SetValue($cant_titulares);
	if($cant_titulares){
		$SQL="SELECT * FROM previsados_titulares WHERE previsado_carga_id = ".CCGetParam('previsado_carga_id')." ORDER BY previsado_titular_id DESC";
		$db->query($SQL);
		$html = "";
		while($db->next_record()){
			$html .= $db->f('previsado_titular_nombre')."<br>";
		}
		$html = substr_replace($html,"",-4);
		$previsados_detalles_carga1->titulares->SetValue($html);
	}else{
		$html = "<font color='RED'><b>NO TIENE</b></font>";
		$previsados_detalles_carga1->titulares->SetValue($html);
	}
	//-----------------------------------origenes----------------------------------------------
	//si es TFSM
	$checktfsm = CCDLookUp("CheckBox_tfsm","previsados_cargas","previsado_carga_id = ".CCGetParam('previsado_carga_id'),$db);
	$previsados_detalles_carga1->CheckBox_tfsm->SetValue($checktfsm);
	$previsados_detalles_carga1->Label_tfsm->SetValue("TFSM");
	if($checktfsm){
		$previsados_detalles_carga1->nomenclatura_origen->SetValue("");
		$previsados_detalles_carga1->ImageLink2->Visible = FALSE;
		$cant_origenes = "tfsm";//origen por tfsm
	}else{		
		$cant_origenes = CCDLookUp("COUNT(*)","previsados_parcelas_origenes","previsado_carga_id = ".CCGetParam('previsado_carga_id'),$db);
		$previsados_detalles_carga1->cant_origenes->SetValue($cant_origenes);
		if($cant_origenes){
			$SQL="SELECT previsados_parcelas_origenes.*, tipos_deptos_parcela.tipo_depto_parc_desc AS tipo_depto_parc_desc
					FROM previsados_parcelas_origenes 
					LEFT JOIN tipos_deptos_parcela ON previsados_parcelas_origenes.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id
					WHERE previsado_carga_id = ".CCGetParam('previsado_carga_id')." 
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
					<td style='color: #fff; background: #3D84CC;'><div align='center'>Uf/Uc</div></td>
					</tr>";
			while($db->next_record()){
				$html .= "<tr>";
				$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('tipo_depto_parc_desc')."</div></td>";
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
			$previsados_detalles_carga1->nomenclatura_origen->SetValue($html);
			$previsados_detalles_carga1->CheckBox_tfsm->Visible = FALSE;
			$previsados_detalles_carga1->Label_tfsm->SetValue("");
		}else{
			$html = "<font color='RED'><b>NO TIENE</b></font>";
			$previsados_detalles_carga1->nomenclatura_origen->SetValue($html);
		}
	}
	//-----------------------------------destinos----------------------------------------------
	$cant_destinos = CCDLookUp("COUNT(*)","previsados_parcelas_destinos","previsado_carga_id = ".CCGetParam('previsado_carga_id'),$db);
	$previsados_detalles_carga1->cant_destinos->SetValue($cant_destinos);
	if($cant_destinos){
		$SQL="SELECT previsados_parcelas_destinos.*, tipos_deptos_parcela.tipo_depto_parc_desc AS tipo_depto_parc_desc
				FROM previsados_parcelas_destinos 
				LEFT JOIN tipos_deptos_parcela ON previsados_parcelas_destinos.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id
				WHERE previsado_carga_id = ".CCGetParam('previsado_carga_id')."  AND ISNULL(previsados_parcelas_destinos.previsado_parcela_destino_reemplazo_id)
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
				<td style='color: #fff; background: #3D84CC;'><div align='center'>Uf/Uc</div></td>
				</tr>";
		while($db->next_record()){
			$html .= "<tr>";
			$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('tipo_depto_parc_desc')."</div></td>";
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
		$previsados_detalles_carga1->nomenclatura_destino->SetValue($html);
	}else{
		$html = "<font color='RED'><b>NO TIENE</b></font>";
		$previsados_detalles_carga1->nomenclatura_destino->SetValue($html);
	}
	//------------------------------------------afectaciones--------------------------------------------------------------------
	$cant_afectaciones = CCDLookUp("COUNT(*)","previsados_parcelas_afectaciones","previsado_carga_id = ".CCGetParam('previsado_carga_id'),$db);
	if($cant_afectaciones){
		$SQL="SELECT previsados_parcelas_afectaciones.*, tipos_deptos_parcela.tipo_depto_parc_desc AS tipo_depto_parc_desc
				FROM previsados_parcelas_afectaciones 
				LEFT JOIN tipos_deptos_parcela ON previsados_parcelas_afectaciones.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id
				WHERE previsado_carga_id = ".CCGetParam('previsado_carga_id')." 
				ORDER BY previsado_parcela_afectacion_id DESC";
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
				<td style='color: #fff; background: #3D84CC;'><div align='center'>Uf/Uc</div></td>
				<td style='color: #fff; background: #3D84CC;'><div align='center'>Poligono</div></td>
				</tr>";
		while($db->next_record()){
			$html .= "<tr>";
			$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('tipo_depto_parc_desc')."</div></td>";
			$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_seccion')."</div></td>";
			$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_chacra')."</div></td>";
			$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_quinta')."</div></td>";
			$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_macizo')."</div></td>";
			$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_fraccion')."</div></td>";
			$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_parcela')."</div></td>";
			$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_uf')."</td>";
			$html .= "<td style='color: #000; background: #fff;'><div align='center'>".$db->f('parcela_poligono')."</td>";
			$html .= "</tr>";
		}
		$html .= "</table>";
		$previsados_detalles_carga1->nomenclatura_afectacion->SetValue($html);
	}else{
		$html = "<font color='RED'><b>NO TIENE</b></font>";
		$previsados_detalles_carga1->nomenclatura_afectacion->SetValue($html);
	}

	//si existen cantidad de detalle sin cargar
	$cant_falta = CCDLookUp("COUNT(*)","previsados_detalles_cargas LEFT JOIN previsados_archivos_detalles ON previsados_detalles_cargas.previsado_detalle_carga_id=previsados_archivos_detalles.previsado_detalle_carga_id","previsados_detalles_cargas.previsado_carga_id = ".CCGetParam('previsado_carga_id')." AND ISNULL(previsados_archivos_detalles.previsado_detalle_carga_id)",$db);
	if($cant_falta == 0 && $cant_titulares && $cant_origenes && ($cant_destinos || $cant_afectaciones)){//si los detalles estan completos y tiene titulares y parcelas destinos y parcelas origen
		$etiqueta = "CONFIRMAR CARGA";
		$cant = CCDLookUp("COUNT(*)","previsados_respuestas","previsado_carga_id = ".CCGetParam('previsado_carga_id'),$db);
		if($cant){
			$etiqueta = "RE-CARGAR";
		}
		$html = "<form onsubmit='return confirmar();' enctype='multipart/form-data' method='post' action='confirmar_carga.php'>
					<input type='hidden' name='previsado_carga_id' value='$previsado_carga_id' />
					<input class='Button' type='submit' value='$etiqueta' name='submit'>
             	</form>";
		$previsados_detalles_carga1->boton->SetValue($html);
	}else{
		$html = "<form onsubmit='return cancelar();' enctype='multipart/form-data' method='post' action='cancelar_carga.php'>
					<input type='hidden' name='previsado_carga_id' value='$previsado_carga_id' />
					<input class='Button' type='submit' value='CANCELAR CARGA' name='submit'> 
             	</form>";
		$previsados_detalles_carga1->boton->SetValue($html);
	}

	$tipo_plano_carga = CCDLookUp("previsado_tipo_plano_id","previsados_cargas","previsado_carga_id = ".CCGetParam('previsado_carga_id'),$db);
	$previsados_detalles_carga1->tipo_cargado->SetValue($tipo_plano_carga);
	$previsados_detalles_carga1->previsado_tipo_plano_id->SetValue($tipo_plano_carga);
	$db->close();
// -------------------------
//End Custom Code

//Close previsados_detalles_carga1_BeforeShow @27-1BB75368
    return $previsados_detalles_carga1_BeforeShow;
}
//End Close previsados_detalles_carga1_BeforeShow

//previsados_detalles_carga1_BeforeShowRow @27-2D762EBD
function previsados_detalles_carga1_BeforeShowRow(& $sender)
{
    $previsados_detalles_carga1_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $previsados_detalles_carga1; //Compatibility
//End previsados_detalles_carga1_BeforeShowRow

//Custom Code @39-2A29BDB7
// -------------------------
	$previsado_detalle_carga_id = $previsados_detalles_carga1->DataSource->f('previsado_detalle_carga_id');
	$previsado_detalle_nombre_arch_org = $previsados_detalles_carga1->DataSource->f('previsado_detalle_nombre_arch_org');
	$cabecera_previsado_carga_id = CCGetParam('previsado_carga_id');
	//-----------------------carga de archivo--------------------------
	$htmlc = "<form onsubmit='return checkFileimage($previsado_detalle_carga_id);' enctype='multipart/form-data' method='post' action='uploadImagen.php'>
				<input type='hidden' name='previsado_detalle_carga_id' value='$previsado_detalle_carga_id' />
                <input id='fileToUploadImagen_$previsado_detalle_carga_id' name='fileToUploadImagen_$previsado_detalle_carga_id' type='file' accept='.jpg,.png,.gif,.xls,.xlsx,.JPG,.PNG,.GIF,.XLS,.XLSX'>
			    <input class='Button' type='submit' value='Cargar Archivo' name='submit'>
            </form>";
    $previsados_detalles_carga1->cargaimagen->SetValue($htmlc);


	//--------------------------lista de descarga------------------------------------------
	$db = new clsDBtdf_nuevo();
	$SQL = "SELECT * FROM previsados_archivos_detalles WHERE previsado_detalle_carga_id = $previsado_detalle_carga_id ORDER BY previsado_archivo_detalle_id ASC";
	$db->query($SQL);
	if($db->num_rows(previsado_archivo_detalle_id)){
		$htmlm = "<table cellspacing='0' cellpadding='0' width='100%' class='Grid'>";
		while($db->next_record()){
			$htmlm .=  "<tr>
					  	<td style='BACKGROUND: #fff; COLOR: #000' width='10px'><div align='center'><a href='#' onclick='quitar_archivo(".$db->f('previsado_archivo_detalle_id').")' title='Quitar este archivo'><img src='../iconos/16x16/nav_decline.png' height='10' width='10'></a></div></td>
						<td style='BACKGROUND: #fff; COLOR: #000'><div align='left'><font color='GREEN'><b>".$db->f('previsado_detalle_nombre_arch_org')."</b></font></div></td>
						</tr>";
		}
		$htmlm .= "</table>";	
	 	$previsados_detalles_carga1->muestraimagen->SetValue($htmlm);
	}else{
		$previsados_detalles_carga1->muestraimagen->SetValue("<font color='RED'><b>NO TIENE</b></font>");
	}
	$db->close();
// -------------------------
//End Custom Code

//Close previsados_detalles_carga1_BeforeShowRow @27-509C7D6D
    return $previsados_detalles_carga1_BeforeShowRow;
}
//End Close previsados_detalles_carga1_BeforeShowRow

//Page_BeforeInitialize @1-FE293247
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $previsados_cargas; //Compatibility
//End Page_BeforeInitialize

//Custom Code @50-2A29BDB7
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
