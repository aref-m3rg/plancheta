<?php
define("RelativePath", "..");
include(RelativePath . "/Common.php");
define('FPDF_FONTPATH',RelativePath . '/fpdf/font/');
include(RelativePath . "/fpdf/fpdf.php");
//include(RelativePath . "/scripts/separar_num.php");

$db = new clsDBtdf_nuevo();
$db2 = new clsDBtdf_nuevo();
$autor = CCDLookUp('usuario_nombre','_usuarios','usuario_id = ' . CCGetUserID(),$db);

class PDF extends FPDF{
	function Header(){
		//Title
		$this->SetXY(8,15);
		$this->Cell(200,18,'',1,1,'C');
		$this->Image(RelativePath . '/imagenes/header_rpt_2.jpg',8,15,200,18);
		$this->SetFont('Arial','',8);
		//$this->Cell(200,6,'Fecha: ' . date('d/m/Y H:i:s'),0,1,'R');
		//$this->Ln(3);
		//Ensure table header is output
		parent::Header();
	}
	function Footer(){
		//Posición: a 1,5 cm del final
		$this->SetY(-15);
		//Arial italic 8
		$this->SetFont('Arial','I',8);
		//Número de página
		$this->Cell(0,4,"“Las Islas Malvinas, Georgias y Sándwich del sur, son y serán argentinas”",0,1,'C');
		//$this->SetFont('Arial','I',6);
		//$this->Cell(0,4,'Pagina '.$this->PageNo().' de {nb}',0,1,'C');
	}
	
}

	function tipo_medida($mesura,$tipo){
		//separa las Ha total con decimeles en A y Ca
		if($tipo == 'm2' || $tipo == ''){
			$retorno=$mesura.' m2';
		}elseif($tipo == 'Ha'){
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
		}elseif($tipo == 'As'){ 
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
		}elseif($tipo == 'Cs'){
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
/*
$SQL = "SELECT UPPER(tipo_depto_parc_desc) AS dpto_desc, tipo_parcela_descrip, tipo_parcela_uso_descrip, tipo_parcela_uso_abrev, tipo_padron_parc_id, 
		IFNULL(parcela_partida,'-') parcela_partida, IF(parcela_macizo,parcela_macizo,'-') AS parcela_macizo,
		IF(parcela_parcela,parcela_parcela,'-') AS parcela_parcela, IF(parcela_chacra,parcela_chacra,'-') AS parcela_chacra, 
		IF(parcela_quinta,parcela_quinta,'-') parcela_quinta, IF(parcela_fraccion,parcela_fraccion,'-') AS parcela_fraccion, 
		IF(LENGTH(parcela_uf) > 0,parcela_uf,'-') AS parcela_uf_view,parcela_uf, IF(parcela_predio,parcela_predio,'-') AS parcela_predio, 
		parcela_super_mensura, parcela_val_tierra,parcela_val_mejora, parcela_val_total, plano_nro, 
		parcela_observa, parcela_cert, parcela_descrip, parcela_notas_nom, parcela_restr, tmp_plano,parcela_val_ampliac, 
		IF(plano_nro,CONCAT('T.F. ',CONCAT_WS('-',tipo_depto_parc_plano_nro,CONCAT(tipo_plano_abrev,plano_nro),RIGHT(plano_anio,2))),'') AS plano,
		unidades_medidas_abrev, unidades_medidas_htm, parcela_porc_uf, parcela_sup_uf,
		IF(parcela_seccion='R','RURAL',parcela_seccion)	AS parcela_seccion	 
		FROM parcelas 
		LEFT JOIN tipos_parcelas ON parcelas.tipo_parcela_id = tipos_parcelas.tipo_parcela_id
		LEFT JOIN tipos_parcelas_usos ON parcelas.tipo_parcela_uso_id = tipos_parcelas_usos.tipo_parcela_uso_id
		LEFT JOIN tipos_deptos_parcela ON parcelas.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id
		LEFT JOIN parcelas_planos ON parcelas.parcela_id = parcelas_planos.parcela_id
		LEFT JOIN planos ON parcelas_planos.plano_id = planos.plano_id
		LEFT JOIN unidades_medidas ON parcelas.unidades_medidas_id = unidades_medidas.unidades_medidas_id
		LEFT JOIN tipos_planos ON planos.tipo_plano_id = tipos_planos.tipo_plano_id
		WHERE parcelas.parcela_id = " . CCGetParam(parcela_id);
*/
$SQL = "SELECT UPPER(tipo_depto_parc_desc) AS dpto_desc, tipo_parcela_descrip, tipo_parcela_uso_descrip, tipo_parcela_uso_abrev, tipo_padron_parc_id, 
		IFNULL(parcela_partida,'-') parcela_partida, IF(parcela_macizo,parcela_macizo,'-') AS parcela_macizo,
		IF(parcela_parcela,parcela_parcela,'-') AS parcela_parcela, IF(parcela_chacra,parcela_chacra,'-') AS parcela_chacra, 
		IF(parcela_quinta,parcela_quinta,'-') parcela_quinta, IF(parcela_fraccion,parcela_fraccion,'-') AS parcela_fraccion, IF(parcela_seccion='R','RURAL',parcela_seccion) AS parcela_seccion,
		IF(LENGTH(parcela_uf) > 0,parcela_uf,'-') AS parcela_uf_view,parcela_uf, IF(parcela_predio,parcela_predio,'-') AS parcela_predio, 
		parcela_super_mensura, parcela_val_tierra,parcela_val_mejora, parcela_val_total, plano_nro, 
		parcela_observa, parcela_cert, parcela_descrip, parcela_notas_nom, parcela_restr, tmp_plano,parcela_val_ampliac,
		unidades_medidas_abrev, unidades_medidas_htm, parcela_porc_uf, parcela_sup_uf,
		IF(plano_nro,CONCAT('T.F. ',CONCAT_WS('-',tipo_depto_parc_plano_nro,CONCAT(tipo_plano_abrev,plano_nro),RIGHT(plano_anio,2))),'') AS plano
		FROM parcelas
		LEFT JOIN uniones_desgloses ON parcelas.parcela_id = uniones_desgloses.parcela_destino_id
		LEFT JOIN tipos_parcelas ON parcelas.tipo_parcela_id = tipos_parcelas.tipo_parcela_id
		LEFT JOIN tipos_parcelas_usos ON parcelas.tipo_parcela_uso_id = tipos_parcelas_usos.tipo_parcela_uso_id
		LEFT JOIN tipos_deptos_parcela ON parcelas.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id
		LEFT JOIN unidades_medidas ON parcelas.unidades_medidas_id = unidades_medidas.unidades_medidas_id
		LEFT JOIN planos ON uniones_desgloses.plano_id = planos.plano_id
		LEFT JOIN tipos_planos ON planos.tipo_plano_id = tipos_planos.tipo_plano_id
		WHERE parcelas.parcela_id = " . CCGetParam(parcela_id) . "
		LIMIT 1";
$db->query($SQL);

if($db->next_record()){

	if(CCGetParam(plano)){
		$plano=CCGetParam(plano);
	}elseif($db->f(plano)){
		$plano=$db->f(plano);
	}else{
		$plano=CCDLookUp("IF(planos.plano_nro,CONCAT('T.F. ',CONCAT_WS('-',tipos_deptos_parcela.tipo_depto_parc_plano_nro,CONCAT(tipos_planos.tipo_plano_abrev,planos.plano_nro),RIGHT(planos.plano_anio,2))),IFNULL(planos.tmp_plano,'Sin Mensura')) AS plano","FROM uniones_desgloses LEFT JOIN planos ON uniones_desgloses.plano_id = planos.plano_id LEFT JOIN tipos_planos ON planos.tipo_plano_id = tipos_planos.tipo_plano_id LEFT JOIN tipos_deptos_parcela ON planos.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id","uniones_desgloses.parcela_destino_id = ". CCGetParam(parcela_id),$db2);
	}
	if($db->f(parcela_restr)){$obser .= $db->f(parcela_restr) . "\n";};
	if($db->f(parcela_notas_nom)){$obser .= $db->f(parcela_notas_nom) . "\n";};
	if(CCGetParam(obs)){
		$obser .= $db->f(parcela_cert);
	}else{
		$obser .= $db->f(parcela_observa);
	}
	if(CCGetParam(descrip)){
		$descripcion = $db->f(parcela_descrip);
	}else{
		$descripcion = "";
	}	
	$pdf = new PDF('P','mm','A4');
	$pdf->AliasNbPages();
	$pdf->SetMargins(8,15);
	$pdf->Open();
	$pdf->AddPage();
	
	switch($db->f('tipo_padron_parc_id')){
		case 1://urbano
			if(strlen($db->f(parcela_uf)) > 0){//uf
				//$superficie = number_format($db->f('parcela_sup_uf'),2,',','') .' '. $db->f('unidades_medidas_abrev');
				$superficie = tipo_medida($db->f('parcela_sup_uf'),$db->f('unidades_medidas_abrev'));
			} else {//parcela comun
				//$superficie = number_format($db->f('parcela_super_mensura'),2,',','') .' '. $db->f('unidades_medidas_abrev');
				$superficie = tipo_medida($db->f('parcela_super_mensura'),$db->f('unidades_medidas_abrev'));
			}
			break;
		case 2://rural
			$superficie = number_format($db->f('parcela_super_mensura'),4,',','') .' '. $db->f('unidades_medidas_abrev');
			break;
	}

	if($superficie == ''){
		$superficie = number_format($db->f('parcela_super_mensura'),4,',','') .' '. $db->f('unidades_medidas_abrev');
	}
	
	$pdf->SetFont('Arial','B',10);
	$pdf->SetY(33);
	$pdf->MultiCell(200,6,"CERTIFICADO DE LA DIRECCION DE CATASTRO \n VALIDO POR 12 MESES",1,'C');
	$pdf->MultiCell(200,5,"DESIGNACION SEGUN CATASTRO",1,'C');

	if(strlen($db->f(parcela_uf)) > 0){//es una unidad funcional
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(28,5,'DEPARTAMENTO',1,0,'C');
		$pdf->Cell(19,5,'SECCION',1,0,'C');
		$pdf->Cell(19,5,'CHACRA',1,0,'C');
		$pdf->Cell(19,5,'QUINTA',1,0,'C');
		$pdf->Cell(17,5,'MACIZO',1,0,'C');
		$pdf->Cell(19,5,'FRACCION',1,0,'C');
		$pdf->Cell(19,5,'PARCELA',1,0,'C');
		$pdf->Cell(17,5,'U.F./U.C.',1,0,'C');
		$pdf->Cell(19,5,'%FISCAL',1,0,'C');
		$pdf->Cell(24,5,'PLANO',1,1,'C');
		//datos
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(28,5,$db->f(dpto_desc),1,0,'C');
		$pdf->Cell(19,5,$db->f(parcela_seccion),1,0,'C');
		$pdf->Cell(19,5,$db->f(parcela_chacra),1,0,'C');
		$pdf->Cell(19,5,$db->f(parcela_quinta),1,0,'C');
		$pdf->Cell(17,5,$db->f(parcela_macizo),1,0,'C');
		$pdf->Cell(19,5,$db->f(parcela_fraccion),1,0,'C');
		$pdf->Cell(19,5,$db->f(parcela_parcela),1,0,'C');
		$pdf->Cell(17,5,$db->f(parcela_uf_view),1,0,'C');
		$pdf->Cell(19,5,$db->f(parcela_porc_uf),1,0,'C');
		$pdf->Cell(24,5,$plano,1,1,'C');
		//corte 1
		$pdf->SetFont('Arial','B',10);
		$pdf->MultiCell(200,15,"",1,'C');
		$pdf->SetXY(5,60);
		$pdf->MultiCell(200,15,"INFORME DEL PADRON INMOBILIARIO",0,'C');
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(86,5,'PADRON',1,0,'C');
		$pdf->Cell(114,5,'VALUACION FISCAL',1,1,'C');
		
		$pdf->SetFont('Arial','B',8);
		
		$pdf->MultiCell(20,8,"PARTIDA",1,'C');
		$pdf->SetY($pdf->GetY() - 8);
		$pdf->SetX($pdf->GetX() + 20);
		$pdf->MultiCell(33,8,"CARACTERISTICA",1,'C');
		$pdf->SetY($pdf->GetY() - 8);
		$pdf->SetX($pdf->GetX() + 53);
		$pdf->MultiCell(33,4,"SUPERFICIE\nPROPIA DE LA U.F.",1,'C');
		$pdf->SetY($pdf->GetY() - 8);
		$pdf->SetX($pdf->GetX() + 86);
		$pdf->MultiCell(35,4,"VALUACION TIERRA\nDE LA PARCELA",1,'C');
		$pdf->SetY($pdf->GetY() - 8);
		$pdf->SetX($pdf->GetX() + 121);
		$pdf->MultiCell(35,4,"VALUACION MEJORA\nDE LA PARCELA",1,'C');
		$pdf->SetY($pdf->GetY() - 8);
		$pdf->SetX($pdf->GetX() + 156);
		$pdf->MultiCell(44,4,"VALUACION TOTAL DE LA\n UNIDAD FUNCIONAL (*)",1,'C');
		
		//datos
		$pdf->SetFont('Arial','',9);

		$pdf->Cell(20,5,$db->f(parcela_partida),1,0,'C');
		$pdf->Cell(33,5,$db->f(tipo_parcela_uso_descrip),1,0,'C');
		$pdf->Cell(33,5,$superficie,1,0,'C');
		$pdf->Cell(35,5,'$' . number_format($db->f(parcela_val_tierra),2,',',''),1,0,'C');
		$pdf->Cell(35,5,'$' . number_format($db->f(parcela_val_mejora),2,',',''),1,0,'C');
		$pdf->Cell(44,5,'$' . number_format($db->f(parcela_val_total),2,',',''),1,1,'C');
		
		$pdf->SetFont('Arial','',7);
		if($db->f(parcela_val_ampliac) > 0){
			$pdf->MultiCell(200,4,"(*) Importe que surge de aplicar el correspondiente porcentaje fiscal sobre la Valuación total de la tierra y las mejoras emplazadas en la parcela de referencia mas las ampliaciones efectuadas por el propietario",1,'L');
		} else {
			$pdf->MultiCell(200,4,"(*) Importe que surge de aplicar el correspondiente porcentaje fiscal sobre la Valuación total de la tierra y las mejoras emplazadas en la parcela de referencia",1,'L');
		}
		
	} else { //es una parcela comun
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(28,5,'DEPARTAMENTO',1,0,'C');
		$pdf->Cell(22,5,'SECCION',1,0,'C');
		$pdf->Cell(22,5,'CHACRA',1,0,'C');
		$pdf->Cell(19,5,'QUINTA',1,0,'C');
		$pdf->Cell(20,5,'MACIZO',1,0,'C');
		$pdf->Cell(22,5,'FRACCION',1,0,'C');
		$pdf->Cell(22,5,'PARCELA',1,0,'C');
		$pdf->Cell(22,5,'PREDIO',1,0,'C');
		$pdf->Cell(23,5,'PLANO',1,1,'C');
		//datos
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(28,5,$db->f(dpto_desc),1,0,'C');
		$pdf->Cell(22,5,$db->f(parcela_seccion),1,0,'C');
		$pdf->Cell(22,5,$db->f(parcela_chacra),1,0,'C');
		$pdf->Cell(19,5,$db->f(parcela_quinta),1,0,'C');
		$pdf->Cell(20,5,$db->f(parcela_macizo),1,0,'C');
		$pdf->Cell(22,5,$db->f(parcela_fraccion),1,0,'C');
		$pdf->Cell(22,5,$db->f(parcela_parcela),1,0,'C');
		$pdf->Cell(22,5,$db->f(parcela_predio),1,0,'C');
		$pdf->Cell(23,5,$plano,1,1,'C');
		
		//corte 1
		$pdf->SetFont('Arial','B',10);
		$pdf->MultiCell(200,15,"",1,'C');
		$pdf->SetXY(5,60);
		$pdf->MultiCell(200,15,"INFORME DEL PADRON INMOBILIARIO",0,'C');
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(101,5,'PADRON',1,0,'C');
		$pdf->Cell(99,5,'VALUACION FISCAL',1,1,'C');
		$pdf->Cell(20,5,'PARTIDA',1,0,'C');
		$pdf->Cell(30,5,'CARACTERISTICA',1,0,'C');
		$pdf->Cell(51,5,'SUPERFICIE DE LA PARCELA',1,0,'C');
		$pdf->Cell(33,5,'VAL. TIERRA',1,0,'C');
		$pdf->Cell(33,5,'VAL. MEJORA',1,0,'C');
		$pdf->Cell(33,5,'VAL. TOTAL',1,1,'C');
		//datos
		$pdf->SetFont('Arial','',9);

		$pdf->Cell(20,5,$db->f(parcela_partida),1,0,'C');
		$pdf->Cell(30,5,$db->f(tipo_parcela_uso_descrip),1,0,'C');
		$pdf->Cell(51,5,$superficie,1,0,'C');
		$pdf->Cell(33,5,'$' . number_format($db->f(parcela_val_tierra),2,',',''),1,0,'C');
		$pdf->Cell(33,5,'$' . number_format($db->f(parcela_val_mejora),2,',',''),1,0,'C');
		$pdf->Cell(33,5,'$' . number_format($db->f(parcela_val_total),2,',',''),1,1,'C');
	}

	//corte 2
	$pdf->SetFont('Arial','B',10);
	$pdf->MultiCell(200,15,"OBSERVACIONES",1,'C');
	$pdf->SetFont('Arial','',8);
	$pdf->MultiCell(200,4,$obser,'LRT',1,'L');
	if($descripcion){
		//$pdf->SetFont('Arial','B',10);
		//$pdf->MultiCell(200,15,"DESCRIPCION DE LA PARCELA",1,'C');
		//$pdf->SetFont('Arial','',8);	
		$pdf->MultiCell(200,4,$descripcion,'LR',1,'L');
	}
	$pdf->Cell(200,4,'','LR',1,'L');
	//corte 3
	$pdf->SetFont('Arial','B',10);
	//$pdf->MultiCell(200,85,"",1,'C');
	$pdf->MultiCell(200,40,"USHUAIA",1,'L');
	$pdf->SetFont('Arial','',8);
	$pdf->SetY(192);	
	$pdf->MultiCell(200,10,$autor,0,'L');
	$pdf->Output();
}
$db->close();
$db2->close();

?>