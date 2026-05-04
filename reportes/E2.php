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
	
		$pdf->Line(5,10,200,10);
		$pdf->Line(5,10,5,140);
		$pdf->Line(200,10,200,140);
		$pdf->Line(5,140,200,140);
		$pdf->SetFont('Arial','B',9);
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
		
		$cantE2B=CCDLookUp("mejora_tipo_cat_cant","mejoras_tipos_cat","mejora_id = '".CCGetParam('mejora_id')."' AND tipo_mejora_cat_id = '2'",$db2);
		if(!$cantE2B){
			$cantE2B = 0;
		}
		$valE2B=CCDLookUp("mejoras_valores.mejora_valor_valor","mejoras_valores INNER JOIN mejoras_formularios ON mejoras_valores.mejora_formulario_id = mejoras_formularios.mejora_formulario_id INNER JOIN tipos_mejoras_cat ON mejoras_valores.tipo_mejora_cat_id = tipos_mejoras_cat.tipo_mejora_cat_id","mejoras_formularios.mejora_formulario_abrev = 'E2' AND mejoras_valores.mejora_valor_f_ini <= NOW() AND tipos_mejoras_cat.tipo_mejora_cat_descript = 'B'",$db2);
		
		$pdf->Cell(20,5,'B',1,0,'C');
		$pdf->Cell(30,5,$cantE2B,1,0,'C');
		$pdf->Cell(40,5,'$'.$valE2B,1,0,'C');
		$pdf->Cell(46,5,'$'.($cantE2B*$valE2B),1,0,'C');
		$pdf->Cell(48,5,'','LR',1,'C');		
		
		$cantE2C=CCDLookUp("mejora_tipo_cat_cant","mejoras_tipos_cat","mejora_id = '".CCGetParam('mejora_id')."' AND tipo_mejora_cat_id = '3'",$db2);
		if(!$cantE2C){
			$cantE2C = 0;
		}		
		$valE2C=CCDLookUp("mejoras_valores.mejora_valor_valor","mejoras_valores INNER JOIN mejoras_formularios ON mejoras_valores.mejora_formulario_id = mejoras_formularios.mejora_formulario_id INNER JOIN tipos_mejoras_cat ON mejoras_valores.tipo_mejora_cat_id = tipos_mejoras_cat.tipo_mejora_cat_id","mejoras_formularios.mejora_formulario_abrev = 'E2' AND mejoras_valores.mejora_valor_f_ini <= NOW() AND tipos_mejoras_cat.tipo_mejora_cat_descript = 'C'",$db2);
		
		$pdf->Cell(20,5,'C',1,0,'C');
		$pdf->Cell(30,5,$cantE2C,1,0,'C');
		$pdf->Cell(40,5,'$'.$valE2C,1,0,'C');
		$pdf->Cell(46,5,'$'.($cantE2C*$valE2C),1,0,'C');
		$pdf->Cell(48,5,'','LR',1,'C');
		
		if(($cantE2B+$cantE2C) == 0){
			echo "Error de division por cero, corrija los datos ingresados";exit;
		}
		
		$sum_cant=$cantE2B+$cantE2C;
		$sum_val=($cantE2B*$valE2B)+($cantE2C*$valE2C);
		
		$pdf->Cell(20,5,'Totales',1,0,'C');
		$pdf->Cell(30,5,$sum_cant,1,0,'C');
		$pdf->Cell(40,5,'',1,0,'C');
		$pdf->Cell(46,5,'$'.$sum_val,1,0,'C');
		$pdf->Cell(48,5,'$'.(round($sum_val/$sum_cant,2)),1,1,'C');
		$pdf->MultiCell(200,5,"",0,'C');

		if($cantE2B > $cantE2C){
			$tipo='B';
		}elseif($cantE2B < $cantE2C){
			$tipo='C';
		}elseif($cantE2B == $cantE2C){
			if($valE2B >= $valE2C){
				$tipo='B';
			}elseif($valE2B < $valE2C){
				$tipo='C';
			}
		}
		
		$tipo_cat = CCDLookUp("tipo_mejora_cat_id","tipos_mejoras_cat","tipo_mejora_cat_descript = '$tipo'",$db2);
		$coef = CCDLookUp("mejora_coeficiente_valor","mejoras_coeficientes","tipo_mejora_conserva_id = '".$db->f(tipo_mejora_conserva_id)."' AND mejora_coeficiente_anio = '".$db->f(mejora_anio_construccion)."' AND tipo_mejora_cat_id = '$tipo_cat'",$db2);
		if(!$coef){
			$coef = 0.0;
		}
		
		$pdf->Cell(50,10,'',0,0,'C');
		$pdf->Cell(30,10,'Tipo del edificio',1,0,'C');
		$pdf->Cell(10,10,$tipo,1,0,'C');
		$pdf->Cell(46,10,'Coeficiente de ajuste',1,0,'C');
		$pdf->Cell(20,10,$coef,1,1,'C');
		
		$pdf->MultiCell(200,5,"",0,'C');
		$pdf->MultiCell(200,5,"VALUACION DEL EDIFICIO",0,'C');
		$pdf->MultiCell(200,5,"",0,'C');		
		
		$pdf->Cell(25,5,'Estado de','LTR',0,'C');
		$pdf->Cell(20,5,'Año de','LTR',0,'C');
		$pdf->Cell(20,5,'Tipo del','LTR',0,'C');
		$pdf->Cell(20,5,'Coef. de','LTR',0,'C');
		$pdf->Cell(33,5,'Valor unitario','LTR',0,'C');
		$pdf->Cell(33,5,'Superficie','LTR',0,'C');
		$pdf->Cell(33,5,'Valor del','LTR',1,'C');
		
		$pdf->Cell(25,5,'conservación','LRB',0,'C');
		$pdf->Cell(20,5,'habilitación','LRB',0,'C');
		$pdf->Cell(20,5,'edificio','LRB',0,'C');
		$pdf->Cell(20,5,'ajuste','LRB',0,'C');
		$pdf->Cell(33,5,'$/m2 *','LRB',0,'C');
		$pdf->Cell(33,5,'cubierta','LRB',0,'C');
		$pdf->Cell(33,5,'edificio','LRB',1,'C');		
		
		$pdf->Cell(25,5,CCDLookUp("tipo_mejora_conserva_descrip","tipos_mejoras_conserva","tipo_mejora_conserva_id = ".$db->f(tipo_mejora_conserva_id),$db2),1,0,'C');
		$pdf->Cell(20,5,$db->f(mejora_anio_construccion),1,0,'C');
		$pdf->Cell(20,5,$tipo,1,0,'C');
		$pdf->Cell(20,5,$coef,1,0,'C');
		$pdf->Cell(33,5,'$'.(round($sum_val/$sum_cant,2)),1,0,'C');
		$pdf->Cell(33,5,round($db->f(mejora_sup_cub),2),1,0,'C');
		$pdf->Cell(33,5,'',1,1,'C');

		$pdf->Cell(151,5,'Valor Total',1,0,'L');
		$pdf->Cell(33,5,'$'.(round($coef*(round($sum_val/$sum_cant,2))*$db->f(mejora_sup_cub),2)),1,1,'C');
		
		$pdf->MultiCell(200,5,"",0,'C');			
		
		$pdf->Cell(45,5,'Valuación Actualizada','LTR',0,'C');		
		$pdf->Cell(40,5,'','LTR',1,'C');

		$pdf->Cell(45,5,'mejora E2 / $','LRB',0,'C');
		
		$ajuste = CCDLookUp("tipo_coef_ajuste_valor","tipos_coef_ajustes","tipo_coef_ajuste_f_ini <= NOW()",$db2);
		$pdf->Cell(40,5,'$'.(round((($coef*(round($sum_val/$sum_cant,2))*$db->f(mejora_sup_cub))*$ajuste),2)),'LRB',1,'C');	
		
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