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
		parent::Header();
	}
	function Footer(){
		//Posición: a 1,5 cm del final
		$this->SetY(-15);
	}
}

$SQL = "SELECT tipos_deptos_parcela.tipo_depto_parc_desc,parcelas.parcela_seccion,parcelas.parcela_macizo,parcelas.parcela_parcela,DATE_FORMAT(mejora_f_alta,'%d/%m/%Y') AS mejora_fecha_alta,mejoras.*
		FROM mejoras INNER JOIN parcelas ON mejoras.parcela_id = parcelas.parcela_id
		LEFT JOIN tipos_deptos_parcela ON parcelas.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id
		WHERE mejora_id = " . CCGetParam(mejora_id);
$db->query($SQL);

if($db->next_record()){

	$pdf = new PDF('P','mm','A4');
	$pdf->AliasNbPages();
	$pdf->SetMargins(8,15);
	$pdf->Open();
	$pdf->AddPage();
	
		$pdf->Line(5,10,200,10);//linea superior
		$pdf->Line(5,10,5,250);//linea izquierda
		$pdf->Line(200,10,200,250);//linea derecha
		$pdf->Line(5,250,200,250);//linea inferior
		$pdf->SetFont('Arial','B',9);//cambio de fuente, estilo y tamaño de la letra
		
		$pdf->Cell(23,5,'DEPTO',0,0,'C');
		$pdf->Cell(23,5,$db->f(tipo_depto_parc_desc),1,0,'C');
		$pdf->Cell(23,5,'SECCION',0,0,'C');
		$pdf->Cell(23,5,$db->f(parcela_seccion),1,0,'C');
		$pdf->Cell(23,5,'MACIZO',0,0,'C');
		$pdf->Cell(23,5,$db->f(parcela_macizo),1,0,'C');
		$pdf->Cell(23,5,'PARCELA',0,0,'C');
		$pdf->Cell(23,5,$db->f(parcela_parcela),1,1,'C');
		$pdf->MultiCell(200,2,"",0,'C');		
		$pdf->Cell(81,5,'RESERVADO PARA LA DIRECCION',1,0,'C');
		$pdf->Cell(80,5,'FECHA DE DECLARACION JURADA',1,0,'C');
		$pdf->Cell(23,5,$db->f(mejora_fecha_alta),1,1,'C');
		$pdf->MultiCell(200,4,"",0,'C');
		$pdf->Cell(20,10,'Tipo',1,0,'C');
		$pdf->Cell(30,10,'Cant. Marcados',1,0,'C');
		$pdf->Cell(40,10,'$/m2',1,0,'C');
		$pdf->Cell(46,10,'Cuad. X $/m2',1,0,'C');
		$pdf->Cell(48,10,'Valor Unitario $/m2',1,1,'C');

		$cantE1A=CCDLookUp("mejora_tipo_cat_cant","mejoras_tipos_cat","mejora_id = '".CCGetParam('mejora_id')."' AND tipo_mejora_cat_id = '1'",$db2);
		if(!$cantE1A){
			$cantE1A = 0;
		}
		$valE1A=CCDLookUp("mejoras_valores.mejora_valor_valor","mejoras_valores INNER JOIN mejoras_formularios ON mejoras_valores.mejora_formulario_id = mejoras_formularios.mejora_formulario_id INNER JOIN tipos_mejoras_cat ON mejoras_valores.tipo_mejora_cat_id = tipos_mejoras_cat.tipo_mejora_cat_id","mejoras_formularios.mejora_formulario_abrev = 'E1' AND mejoras_valores.mejora_valor_f_ini <= NOW() AND tipos_mejoras_cat.tipo_mejora_cat_descript = 'A'",$db2);
		
		$pdf->Cell(20,5,'A',1,0,'C');
		$pdf->Cell(30,5,$cantE1A,1,0,'C');
		$pdf->Cell(40,5,'$'.$valE1A,1,0,'C');
		$pdf->Cell(46,5,'$'.($cantE1A*$valE1A),1,0,'C');
		$pdf->Cell(48,5,'','LR',1,'C');		
		
		$cantE1B=CCDLookUp("mejora_tipo_cat_cant","mejoras_tipos_cat","mejora_id = '".CCGetParam('mejora_id')."' AND tipo_mejora_cat_id = '2'",$db2);
		if(!$cantE1B){
			$cantE1B = 0;
		}
		$valE1B=CCDLookUp("mejoras_valores.mejora_valor_valor","mejoras_valores INNER JOIN mejoras_formularios ON mejoras_valores.mejora_formulario_id = mejoras_formularios.mejora_formulario_id INNER JOIN tipos_mejoras_cat ON mejoras_valores.tipo_mejora_cat_id = tipos_mejoras_cat.tipo_mejora_cat_id","mejoras_formularios.mejora_formulario_abrev = 'E1' AND mejoras_valores.mejora_valor_f_ini <= NOW() AND tipos_mejoras_cat.tipo_mejora_cat_descript = 'B'",$db2);
		
		$pdf->Cell(20,5,'B',1,0,'C');
		$pdf->Cell(30,5,$cantE1B,1,0,'C');
		$pdf->Cell(40,5,'$'.$valE1B,1,0,'C');
		$pdf->Cell(46,5,'$'.($cantE1B*$valE1B),1,0,'C');
		$pdf->Cell(48,5,'','LR',1,'C');		
		
		$cantE1C=CCDLookUp("mejora_tipo_cat_cant","mejoras_tipos_cat","mejora_id = '".CCGetParam('mejora_id')."' AND tipo_mejora_cat_id = '3'",$db2);
		if(!$cantE1C){
			$cantE1C = 0;
		}		
		$valE1C=CCDLookUp("mejoras_valores.mejora_valor_valor","mejoras_valores INNER JOIN mejoras_formularios ON mejoras_valores.mejora_formulario_id = mejoras_formularios.mejora_formulario_id INNER JOIN tipos_mejoras_cat ON mejoras_valores.tipo_mejora_cat_id = tipos_mejoras_cat.tipo_mejora_cat_id","mejoras_formularios.mejora_formulario_abrev = 'E1' AND mejoras_valores.mejora_valor_f_ini <= NOW() AND tipos_mejoras_cat.tipo_mejora_cat_descript = 'C'",$db2);
		
		$pdf->Cell(20,5,'C',1,0,'C');
		$pdf->Cell(30,5,$cantE1C,1,0,'C');
		$pdf->Cell(40,5,'$'.$valE1C,1,0,'C');
		$pdf->Cell(46,5,'$'.($cantE1C*$valE1C),1,0,'C');
		$pdf->Cell(48,5,'','LR',1,'C');
		
		if(($cantE1A+$cantE1B+$cantE1C) == 0){
			echo "Error de division por cero, corrija los datos ingresados";exit;
		}
		
		$sum_cant=$cantE1A+$cantE1B+$cantE1C;
		$sum_valor=($cantE1A*$valE1A)+($cantE1B*$valE1B)+($cantE1C*$valE1C);
		
		$pdf->Cell(20,5,'Totales',1,0,'C');
		$pdf->Cell(30,5,$sum_cant,1,0,'C');
		$pdf->Cell(40,5,'',1,0,'C');
		$pdf->Cell(46,5,'$'.$sum_valor,1,0,'C');
		$pdf->Cell(48,5,'$'.(round($sum_valor/$sum_cant,2)),1,1,'C');
		$pdf->MultiCell(200,5,"",0,'C');
		$sum_sub_total = $sum_valor/$sum_cant;
		
		if(($cantE1A > $cantE1B) && ($cantE1A  > $cantE1C)){
			$tipo='A';
		}elseif(($cantE1B > $cantE1A) && ($cantE1B > $cantE1C)){
			$tipo='B';
		}elseif(($cantE1C > $cantE1A) && ($cantE1C > $cantE1B)){
			$tipo='C';
		}elseif(($cantE1A == $cantE1B) && ($cantE1A > $cantE1C)){
			$tipo='A';
		}elseif(($cantE1A == $cantE1C) && ($cantE1A > $cantE1B)){
			$tipo='A';
		}elseif(($cantE1B == $cantE1C) && ($cantE1B > $cantE1A)){
			$tipo='B';
		}elseif(($cantE1A == $cantE1B) && ($cantE1B == $cantE1C)){
			$tipo='A';
		}
		
		$tipo_cat = CCDLookUp("tipo_mejora_cat_id","tipos_mejoras_cat","tipo_mejora_cat_descript = '$tipo'",$db2);
		$coefg = CCDLookUp("mejora_coeficiente_valor","mejoras_coeficientes","tipo_mejora_conserva_id = '".$db->f(tipo_mejora_conserva_id)."' AND mejora_coeficiente_anio = '".$db->f(mejora_anio_construccion)."' AND tipo_mejora_cat_id = '$tipo_cat'",$db2);
		if(!$coefg){
			$coefg = 0.0;
		}
		
		$pdf->Cell(50,10,'',0,0,'C');
		$pdf->Cell(30,10,'Tipo del edificio',1,0,'C');
		$pdf->Cell(10,10,$tipo,1,0,'C');
		$pdf->Cell(46,10,'Coeficiente de ajuste',1,0,'C');
		$pdf->Cell(20,10,$coefg,1,1,'C');
		
		//para VIVIENDAS
		$pdf->MultiCell(200,5,"",0,'C');
		$pdf->MultiCell(200,5,"VALUACION DEL EDIFICIO DESTINADO A VIVIENDA O DESTINOS SIMILARES",0,'C');
		$pdf->Cell(23,5,'Construcción','LTR',0,'C');
		$pdf->Cell(23,5,'Estado de','LTR',0,'C');
		$pdf->Cell(20,5,'Año de','LTR',0,'C');
		$pdf->Cell(15,5,'Tipo del','LTR',0,'C');
		$pdf->Cell(15,5,'Coef. de','LTR',0,'C');
		$pdf->Cell(23,5,'Valor unitario','LTR',0,'C');
		$pdf->Cell(32,5,'Superficie','LTR',0,'C');
		$pdf->Cell(33,5,'Valor del','LTR',1,'C');
		$pdf->Cell(23,5,'','LRB',0,'C');
		$pdf->Cell(23,5,'conservación','LRB',0,'C');
		$pdf->Cell(20,5,'habilitación','LRB',0,'C');
		$pdf->Cell(15,5,'edificio','LRB',0,'C');
		$pdf->Cell(15,5,'ajuste','LRB',0,'C');
		$pdf->Cell(23,5,'$/m2 *','LRB',0,'C');
		$pdf->Cell(32,5,'cubierta','LRB',0,'C');
		$pdf->Cell(33,5,'edificio','LRB',1,'C');		
		
		$coef = CCDLookUp("mejora_coeficiente_valor","mejoras_coeficientes","tipo_mejora_conserva_id = '".$db->f(tipo_mejora_conserva_id)."' AND mejora_coeficiente_anio = '".$db->f(mejora_anio_construccion)."' AND tipo_mejora_cat_id = '".$db->f(tipo_mejora_cat_id)."'",$db2);
		$pdf->Cell(23,5,'Edificio',1,0,'L');
		$pdf->Cell(23,5,CCDLookUp("tipo_mejora_conserva_descrip","tipos_mejoras_conserva","tipo_mejora_conserva_id = ".$db->f(tipo_mejora_conserva_id),$db2),1,0,'C');
		$pdf->Cell(20,5,$db->f(mejora_anio_construccion),1,0,'C');
		$pdf->Cell(15,5,CCDLookUp("tipo_mejora_cat_descript","tipos_mejoras_cat","tipo_mejora_cat_id = ".$db->f(tipo_mejora_cat_id),$db2),1,0,'C');
		$pdf->Cell(15,5,$coef,1,0,'C');
		$pdf->Cell(23,5,'$'.round($sum_sub_total,2),1,0,'C');
		$pdf->Cell(32,5,round($db->f(mejora_sup_cub),2),1,0,'C');
		$pdf->Cell(33,5,'$'.(round($coef*round($sum_sub_total,2)*round($db->f(mejora_sup_cub),2),2)),1,1,'C');
		$total1 = round($coef*round($sum_sub_total,2)*round($db->f(mejora_sup_cub),2),2);
		
		$coef = CCDLookUp("mejora_coeficiente_valor","mejoras_coeficientes","tipo_mejora_conserva_id = '".$db->f(tipo_mejora_conserva_2_id)."' AND mejora_coeficiente_anio = '".$db->f(mejora_anio_construccion_2)."' AND tipo_mejora_cat_id = '".$db->f(tipo_mejora_cat_2_id)."'",$db2);
		$categ = CCDLookUp("tipo_mejora_cat_descript","tipos_mejoras_cat","tipo_mejora_cat_id = ".$db->f(tipo_mejora_cat_2_id),$db2);
		if($categ == "C"){
			$sum_sub_total2 = $sum_sub_total * 0.30;
		}else{
			$sum_sub_total2 = $sum_sub_total * 0.50;
		}
		$pdf->Cell(23,5,'Porch o galer',1,0,'L');
		$pdf->Cell(23,5,CCDLookUp("tipo_mejora_conserva_descrip","tipos_mejoras_conserva","tipo_mejora_conserva_id = ".$db->f(tipo_mejora_conserva_2_id),$db2),1,0,'C');
		$pdf->Cell(20,5,$db->f(mejora_anio_construccion_2),1,0,'C');
		$pdf->Cell(15,5,$categ,1,0,'C');
		$pdf->Cell(15,5,$coef,1,0,'C');
		$pdf->Cell(23,5,'$'.round($sum_sub_total2,2),1,0,'C');
		$pdf->Cell(32,5,round($db->f(mejora_sup_semi_cub),2),1,0,'C');
		$pdf->Cell(33,5,'$'.(round($coef*round($sum_sub_total2,2)*round($db->f(mejora_sup_semi_cub),2),2)),1,1,'C');
		$total2 = round($coef*round($sum_sub_total2,2)*round($db->f(mejora_sup_semi_cub),2),2);
		
		$pdf->Cell(151,5,'Valor Total',1,0,'L');
		$pdf->Cell(33,5,'$'.($total1+$total2),1,1,'C');
		$pdf->SetFont('Arial','B',6);
		$pdf->MultiCell(200,5,"*Para porch o galería el valor será el 50% del valor unitario para tipo A o B y el 30% para los tipos C",0,'L');
		$pdf->SetFont('Arial','B',9);
		
		$pdf->MultiCell(200,5,"",0,'C');			
		//para NEGOCIOS
		$pdf->MultiCell(200,5,"VALUACION DEL EDIFICIO DESTINADO A NEGOCIOS O SALAS DE ESPECTACULOS PUBLICOS",0,'C');
		$pdf->Cell(23,5,'Construcción','LTR',0,'C');
		$pdf->Cell(23,5,'Estado de','LTR',0,'C');
		$pdf->Cell(20,5,'Año de','LTR',0,'C');
		$pdf->Cell(15,5,'Tipo del','LTR',0,'C');
		$pdf->Cell(15,5,'Coef. de','LTR',0,'C');
		$pdf->Cell(23,5,'Valor unitario','LTR',0,'C');
		$pdf->Cell(32,5,'Superficie','LTR',0,'C');
		$pdf->Cell(33,5,'Valor del','LTR',1,'C');
		$pdf->Cell(23,5,'','LRB',0,'C');
		$pdf->Cell(23,5,'conservación','LRB',0,'C');
		$pdf->Cell(20,5,'habilitación','LRB',0,'C');
		$pdf->Cell(15,5,'edificio','LRB',0,'C');
		$pdf->Cell(15,5,'ajuste','LRB',0,'C');
		$pdf->Cell(23,5,'$/m2 *','LRB',0,'C');
		$pdf->Cell(32,5,'cubierta','LRB',0,'C');
		$pdf->Cell(33,5,'edificio','LRB',1,'C');		

		$coef = CCDLookUp("mejora_coeficiente_valor","mejoras_coeficientes","tipo_mejora_conserva_id = '".$db->f(tipo_mejora_conserva_3_id)."' AND mejora_coeficiente_anio = '".$db->f(mejora_anio_construccion_3)."' AND tipo_mejora_cat_id = '".$db->f(tipo_mejora_cat_3_id)."'",$db2);
		if($db->f(mejora_sup_cub_2) > 100.0){
			$sum_sub_total = $sum_sub_total * 0.70;
		}
		
		$pdf->Cell(23,5,'Edificio',1,0,'L');
		$pdf->Cell(23,5,CCDLookUp("tipo_mejora_conserva_descrip","tipos_mejoras_conserva","tipo_mejora_conserva_id = ".$db->f(tipo_mejora_conserva_3_id),$db2),1,0,'C');
		$pdf->Cell(20,5,$db->f(mejora_anio_construccion_3),1,0,'C');
		$pdf->Cell(15,5,CCDLookUp("tipo_mejora_cat_descript","tipos_mejoras_cat","tipo_mejora_cat_id = ".$db->f(tipo_mejora_cat_3_id),$db2),1,0,'C');
		$pdf->Cell(15,5,$coef,1,0,'C');
		$pdf->Cell(23,5,'$'.round($sum_sub_total,2),1,0,'C');
		$pdf->Cell(32,5,round($db->f(mejora_sup_cub_2),2),1,0,'C');
		$pdf->Cell(33,5,'$'.(round($coef*round($sum_sub_total,2)*round($db->f(mejora_sup_cub_2),2),2)),1,1,'C');
		$total_edif = round($coef*round($sum_sub_total,2)*round($db->f(mejora_sup_cub_2),2),2);
		
		$pdf->Cell(151,5,'Valor Total',1,0,'L');
		$pdf->Cell(33,5,'$'.(round($coef*round($sum_sub_total,2)*round($db->f(mejora_sup_cub_2),2),2)),1,1,'C');
		$pdf->SetFont('Arial','B',6);
		$pdf->MultiCell(200,5,"*Para negocios o salas de espectáculos públicos con superficie mayor de 100 m2 el valor a aplicar será el 70% del valor unitario",0,'L');
		$pdf->SetFont('Arial','B',9);		
		$pdf->MultiCell(200,5,"",0,'C');
		
		//para OBRAS ACCESORIAS
		$pdf->MultiCell(200,5,"VALUACION DE LAS OBRAS ACCESORIAS",0,'C');
		$pdf->Cell(46,5,'Obras Accesorias','LTR',0,'C');
		$pdf->Cell(20,5,'','LTR',0,'C');
		$pdf->Cell(15,5,'','LTR',0,'C');
		$pdf->Cell(15,5,'Coef. de','LTR',0,'C');
		$pdf->Cell(23,5,'Valor basico','LTR',0,'C');
		$pdf->Cell(32,5,'Cantidad de','LTR',0,'C');
		$pdf->Cell(33,5,'Valor','LTR',1,'C');
		$pdf->Cell(46,5,'','LRB',0,'C');
		$pdf->Cell(20,5,'','LRB',0,'C');
		$pdf->Cell(15,5,'','LRB',0,'C');
		$pdf->Cell(15,5,'ajuste','LRB',0,'C');
		$pdf->Cell(23,5,'por unidad','LRB',0,'C');
		$pdf->Cell(32,5,'Unidades','LRB',0,'C');
		$pdf->Cell(33,5,'','LRB',1,'C');		
		
		$valor = CCDLookUp("mejoras_valores.mejora_valor_valor","mejoras_valores INNER JOIN mejoras_formularios ON mejoras_valores.mejora_formulario_id = mejoras_formularios.mejora_formulario_id INNER JOIN tipos_mejoras_cat ON mejoras_valores.tipo_mejora_cat_id = tipos_mejoras_cat.tipo_mejora_cat_id","mejoras_formularios.mejora_formulario_abrev = 'E1' AND mejoras_valores.mejora_valor_f_ini <= NOW() AND tipos_mejoras_cat.tipo_mejora_cat_descript = '$tipo' AND mejoras_valores.mejora_construccion_id = 2",$db2);
		$pdf->Cell(46,5,'Baño principal',1,0,'L');
		$pdf->Cell(20,5,'',1,0,'C');
		$pdf->Cell(15,5,'',1,0,'C');
		$pdf->Cell(15,5,$coefg,1,0,'C');
		$pdf->Cell(23,5,'$'.round($valor,2),1,0,'C');
		$pdf->Cell(32,5,$db->f(mejora_cant_bp),1,0,'C');
		$pdf->Cell(33,5,'$'.(round($coefg*round($valor,2)*$db->f(mejora_cant_bp),2)),1,1,'C');
		$total_bp = round($coefg*round($valor,2)*$db->f(mejora_cant_bp),2);
		
		$valor = CCDLookUp("mejoras_valores.mejora_valor_valor","mejoras_valores INNER JOIN mejoras_formularios ON mejoras_valores.mejora_formulario_id = mejoras_formularios.mejora_formulario_id INNER JOIN tipos_mejoras_cat ON mejoras_valores.tipo_mejora_cat_id = tipos_mejoras_cat.tipo_mejora_cat_id","mejoras_formularios.mejora_formulario_abrev = 'E1' AND mejoras_valores.mejora_valor_f_ini <= NOW() AND tipos_mejoras_cat.tipo_mejora_cat_descript = '$tipo' AND mejoras_valores.mejora_construccion_id = 3",$db2);
		$pdf->Cell(46,5,'Baño secundario',1,0,'L');
		$pdf->Cell(20,5,'',1,0,'C');
		$pdf->Cell(15,5,'',1,0,'C');
		$pdf->Cell(15,5,$coefg,1,0,'C');
		$pdf->Cell(23,5,'$'.round($valor,2),1,0,'C');
		$pdf->Cell(32,5,$db->f(mejora_cant_bs),1,0,'C');
		$pdf->Cell(33,5,'$'.(round($coefg*round($valor,2)*$db->f(mejora_cant_bs),2)),1,1,'C');
		$total_bs = round($coefg*round($valor,2)*$db->f(mejora_cant_bs),2);
		
		$pdf->Cell(151,5,'Valor Total',1,0,'L');
		$pdf->Cell(33,5,'$'.($total_bp + $total_bs),1,1,'C');
		$pdf->MultiCell(200,5,"",0,'C');
		
		//para RESUMEN
		$pdf->MultiCell(200,5,"RESUMEN DE VALUACION",0,'C');
		$pdf->Cell(151,5,'CONCEPTO',1,0,'C');
		$pdf->Cell(33,5,'VALOR',1,1,'C');
		$pdf->Cell(151,5,'Valor Total del edificio destinado a vivienda',1,0,'L');
		$pdf->Cell(33,5,'$'.($total1+$total2),1,1,'C');
		$pdf->Cell(151,5,'Valor Total del edificio destinado a negocio o sala de espectáculo',1,0,'L');
		$pdf->Cell(33,5,'$'.($total_edif),1,1,'C');
		$pdf->Cell(151,5,'Valor Total de obras accesorias',1,0,'L');
		$pdf->Cell(33,5,'$'.($total_bp + $total_bs),1,1,'C');		
		$pdf->Cell(151,5,'VALOR TOTAL',1,0,'L');
		$pdf->Cell(33,5,'$'.($total1 + $total2 + $total_edif + $total_bp + $total_bs),1,1,'C');
		$total_total = $total1 + $total2 + $total_edif + $total_bp + $total_bs;
		$pdf->MultiCell(200,5,"",0,'C');
//--------------------------------------------		
		$pdf->Cell(45,5,'Valuación Actualizada','LTR',0,'C');		
		$pdf->Cell(40,5,'','LTR',1,'C');

		$pdf->Cell(45,5,'mejora E1 / $','LRB',0,'C');
		$ajuste = CCDLookUp("tipo_coef_ajuste_valor","tipos_coef_ajustes","tipo_coef_ajuste_f_ini <= NOW()",$db2);
		$pdf->Cell(40,5,'$'.round($total_total*$ajuste,2),'LRB',1,'C');	
		
		$pdf->MultiCell(200,5,"",0,'C');
		
		$pdf->Cell(60,5,'CARGADO POR',1,0,'C');		
		$pdf->Cell(40,5,$autor,1,0,'C');		
		$pdf->Cell(10,5,'',0,0,'C');		
		$pdf->Cell(40,5,'Fecha de carga',1,0,'C');	
		$pdf->Cell(34,5,date("d/m/Y"),1,1,'C');	
	$pdf->Output();
}
$db->close();
$db2->close();
?>