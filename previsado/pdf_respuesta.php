<?php
// Notificar todos los errores de PHP (ver el registro de cambios)
//error_reporting(E_ALL);
define("RelativePath", "..");
include(RelativePath . "/Common.php");
define('FPDF_FONTPATH',RelativePath . '/fpdf/font/');
include(RelativePath . "/fpdf/fpdf.php");

$db = new clsDBtdf_nuevo();
$db2 = new clsDBtdf_nuevo();
$autor = CCDLookUp('usuario_nombre','_usuarios','usuario_id = ' . CCGetUserID(),$db);

$previsado_carga_id = CCGetParam('previsado_carga_id');
$SQL = "SELECT * FROM previsados_cargas WHERE previsado_carga_id = $previsado_carga_id";	
$db->query($SQL);

class PDF extends FPDF{
	function Code39($xpos, $ypos, $code, $baseline=0.5, $height=5){

		$wide = $baseline;
		$narrow = $baseline / 3 ; 
		$gap = $narrow;

		$barChar['0'] = 'nnnwwnwnn';
		$barChar['1'] = 'wnnwnnnnw';
		$barChar['2'] = 'nnwwnnnnw';
		$barChar['3'] = 'wnwwnnnnn';
		$barChar['4'] = 'nnnwwnnnw';
		$barChar['5'] = 'wnnwwnnnn';
		$barChar['6'] = 'nnwwwnnnn';
		$barChar['7'] = 'nnnwnnwnw';
		$barChar['8'] = 'wnnwnnwnn';
		$barChar['9'] = 'nnwwnnwnn';
		$barChar['A'] = 'wnnnnwnnw';
		$barChar['B'] = 'nnwnnwnnw';
		$barChar['C'] = 'wnwnnwnnn';
		$barChar['D'] = 'nnnnwwnnw';
		$barChar['E'] = 'wnnnwwnnn';
		$barChar['F'] = 'nnwnwwnnn';
		$barChar['G'] = 'nnnnnwwnw';
		$barChar['H'] = 'wnnnnwwnn';
		$barChar['I'] = 'nnwnnwwnn';
		$barChar['J'] = 'nnnnwwwnn';
		$barChar['K'] = 'wnnnnnnww';
		$barChar['L'] = 'nnwnnnnww';
		$barChar['M'] = 'wnwnnnnwn';
		$barChar['N'] = 'nnnnwnnww';
		$barChar['O'] = 'wnnnwnnwn'; 
		$barChar['P'] = 'nnwnwnnwn';
		$barChar['Q'] = 'nnnnnnwww';
		$barChar['R'] = 'wnnnnnwwn';
		$barChar['S'] = 'nnwnnnwwn';
		$barChar['T'] = 'nnnnwnwwn';
		$barChar['U'] = 'wwnnnnnnw';
		$barChar['V'] = 'nwwnnnnnw';
		$barChar['W'] = 'wwwnnnnnn';
		$barChar['X'] = 'nwnnwnnnw';
		$barChar['Y'] = 'wwnnwnnnn';
		$barChar['Z'] = 'nwwnwnnnn';
		$barChar['-'] = 'nwnnnnwnw';
		$barChar['.'] = 'wwnnnnwnn';
		$barChar[' '] = 'nwwnnnwnn';
		$barChar['*'] = 'nwnnwnwnn';
		$barChar['$'] = 'nwnwnwnnn';
		$barChar['/'] = 'nwnwnnnwn';
		$barChar['+'] = 'nwnnnwnwn';
		$barChar['%'] = 'nnnwnwnwn';

		$this->SetFont('Arial','',10);
		$this->Text($xpos, $ypos + $height + 4, $code);
		$this->SetFillColor(0);

		$code = '*'.strtoupper($code).'*';
		for($i=0; $i<strlen($code); $i++){
			$char = $code[$i];
			if(!isset($barChar[$char])){
				$this->Error('Invalid character in barcode: '.$char);
			}
			$seq = $barChar[$char];
			for($bar=0; $bar<9; $bar++){
				if($seq[$bar] == 'n'){
					$lineWidth = $narrow;
				}else{
					$lineWidth = $wide;
				}
				if($bar % 2 == 0){
					$this->Rect($xpos, $ypos, $lineWidth, $height, 'F');
				}
				$xpos += $lineWidth;
			}
			$xpos += $gap;
		}
	}
	function Header(){
		//Title
		$this->SetXY(5,8);
		$this->Cell(202,25,'',1,1,'C');
		$this->Image(RelativePath . '/imagenes/header_rpt_2.jpg',6,10,200,18);
		$this->SetFont('Arial','',8);
		//$this->Cell(200,6,'Fecha: ' . date('d/m/Y H:i:s'),0,1,'R');
		//$this->Ln(3);
		//Ensure table header is output
		parent::Header();
	}
	function Footer(){
		//Posición: a 1,5 cm del final
		$this->SetY(-11);
		//Arial italic 8
		$this->SetFont('Arial','I',8);
		//Número de página
		$leyenda = iconv('UTF-8', 'windows-1252', "\"Las Islas Malvinas, Georgias y Sándwich del sur, son y serán argentinas\"");
		//$this->Cell(0,4,$leyenda,0,1,'C');
		//$this->SetFont('Arial','I',6);
		//$this->Cell(0,4,'Pagina '.$this->PageNo().' de {nb}',0,1,'C');
	}	
}

if($db->next_record()){	
	$pdf = new PDF('P','mm','A4');
	$pdf->AliasNbPages();
	$pdf->SetMargins(8,15);
	$pdf->Open();
	
	$pdf->AddPage();	
	$pdf->SetFont('Arial','B',10);
	$pdf->SetY(33);
	$pdf->MultiCell(195,5,"",0,'C');
	$pdf->MultiCell(195,6,"-RESULTADO DE LA EVALUACION DEL PREVISADO-",0,'C');
	$pdf->Cell(30,5,"RESULTADO:",1,'I');
	$previsado_tipo_estado_carga_id=$db->f('previsado_tipo_estado_carga_id');
	$previsado_tipo_estado_carga_descrip = CCDLookUp("previsado_tipo_estado_carga_descrip","previsados_tipos_estados_cargas","previsado_tipo_estado_carga_id=$previsado_tipo_estado_carga_id",$db2);
	$pdf->MultiCell(165,5,$previsado_tipo_estado_carga_descrip,1,'C');
	$pdf->Cell(30,5,"Operador:",1,'I');
	$pdf->MultiCell(165,5,CCDLookUp("_usuarios.usuario_nombre","previsados_respuestas INNER JOIN _usuarios ON previsados_respuestas.usuario_id = _usuarios.usuario_id","previsados_respuestas.previsado_carga_id =$previsado_carga_id",$db2),1,'I');
	$pdf->Cell(30,5,"Fecha:",1,'I');
	$pdf->MultiCell(165,5,CCDLookUp("DATE_FORMAT(previsados_respuestas.previsado_respuesta_proc,'%d/%m/%Y')","previsados_respuestas INNER JOIN _usuarios ON previsados_respuestas.usuario_id = _usuarios.usuario_id","previsados_respuestas.previsado_carga_id = $previsado_carga_id",$db2),1,'I');
	$pdf->Cell(30,5,"Profesional:",1,'I');
	$user_name = CCDLookUp("prof_nombre","profesionales","user_id = ".$db->f('user_id'),$db2);
	$pdf->MultiCell(165,5,$user_name,1,'I');	
	$pdf->Cell(30,5,"Tipo Plano:",1,'I');
	$tipo_plano = CCDLookUp("previsado_tipo_plano_descrip","previsados_tipos_planos","previsado_tipo_plano_id = ".$db->f('previsado_tipo_plano_id'),$db2);
	$pdf->SetFont('Arial','B',8);
	$pdf->MultiCell(165,5,$tipo_plano,1,'I');	
	$pdf->SetFont('Arial','B',10);
	$previsado_respuesta_observ = CCDLookUp("previsado_respuesta_observ","previsados_respuestas","previsado_carga_id=$previsado_carga_id",$db2);
	//---------------dato plano-------------------
	$tipo_depto_parc_id = CCDLookUp("tipo_depto_parc_id","previsados_respuestas","previsado_carga_id=$previsado_carga_id",$db2);
	$previsado_respuesta_nro_plano = CCDLookUp("previsado_respuesta_nro_plano","previsados_respuestas","previsado_carga_id=$previsado_carga_id",$db2);
	$previsado_respuesta_nro_anio = CCDLookUp("previsado_respuesta_nro_anio","previsados_respuestas","previsado_carga_id=$previsado_carga_id",$db2);
	//---------------dato expediente--------------
	$previsado_respuesta_exp_nro = CCDLookUp("previsado_respuesta_exp_nro","previsados_respuestas","previsado_carga_id=$previsado_carga_id",$db2);
	$previsado_respuesta_exp_letra = CCDLookUp("previsado_respuesta_exp_letra","previsados_respuestas","previsado_carga_id=$previsado_carga_id",$db2);
	$previsado_respuesta_exp_anio = CCDLookUp("previsado_respuesta_exp_anio","previsados_respuestas","previsado_carga_id=$previsado_carga_id",$db2);
	
	$pdf->Cell(30,5,"Plano:",1,'I');
	$pdf->Cell(65,5,"$tipo_depto_parc_id-$previsado_respuesta_nro_plano-$previsado_respuesta_nro_anio",1,'I');
	$pdf->Cell(30,5,"Expediente:",1,'I');
	$pdf->Cell(70,5,"$previsado_respuesta_exp_nro-$previsado_respuesta_exp_letra-$previsado_respuesta_exp_anio",1,1,'I');
	$pdf->Cell(60,12,"",1,0,'I');
	$pdf->SetFont('Arial','',8);	
	$pdf->Cell(50,12,"fecha",1,0,'I');
	$pdf->Cell(85,12,"firma y aclaracion",1,1,'I');	
	$pdf->SetFont('Arial','B',8);		
	if($previsado_tipo_estado_carga_id == 2){//SI ESTA APROBADO
		$pdf->Code39(27,76,$previsado_carga_id,1,5);
		$pdf->MultiCell(195,5,"",0,'C');
		$pdf->SetFont('Arial','',5);
		$pdf->Cell(10,5,"CONTROL",0,0);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(180,5,"Documentacion a Presentar",0,'C');
		$previsado_tipo_plano_id = $db->f('previsado_tipo_plano_id');
		$SQL = "SELECT previsados_tipos_planos_requisitos.previsado_requisito_descrip AS previsado_requisito_descrip, previsados_relaciones_tipos_requisitos.previsado_relacion_obligatorio AS previsado_relacion_obligatorio
					FROM previsados_relaciones_tipos_requisitos INNER JOIN previsados_tipos_planos_requisitos ON previsados_relaciones_tipos_requisitos.previsado_requisito_id = previsados_tipos_planos_requisitos.previsado_requisito_id
					WHERE previsados_relaciones_tipos_requisitos.previsado_tipo_plano_id = $previsado_tipo_plano_id";
		$db2->query($SQL);
		
		$pdf->SetFont('Arial','',8);
		while($db2->next_record()){
			if($db2->f('previsado_relacion_obligatorio')){
				$presentadoOL="*";
			}else{
				$presentadoOL="";
			}
			$pdf->Cell(10,5,"",1,0);
			$pdf->MultiCell(185,5,$db2->f('previsado_requisito_descrip')." $presentadoOL",1,'I');
		}
		$pdf->SetFont('Arial','',7);
		$pdf->MultiCell(195,5,"* Se presentó de forma on-line, para la documentacion se debe presentar el mismo.",0,'I');
		$pdf->SetFont('Arial','',10);

	}elseif($previsado_tipo_estado_carga_id == 3){//SI ESTA OBSERVADO

	}
	$pdf->MultiCell(195,5,"",0,'I');
	$pdf->MultiCell(195,5,"Observaciones:",0,'I');
	if($previsado_respuesta_observ){
		$pdf->MultiCell(195,5,$previsado_respuesta_observ,0,'J');
	}else{
		$pdf->MultiCell(195,5,"<no tiene>",0,'J');
	}
	/*
	$pdf->Line($pdf->GetX(),$pdf->GetY(),$pdf->GetX(),$pdf->GetY()-5);
	$pdf->SetY($pdf->GetY()-5);
	$pdf->Line($pdf->GetX(),$pdf->GetY(),$pdf->GetX()+195,$pdf->GetY());
	$pdf->SetX($pdf->GetX()+195);
	$pdf->Line($pdf->GetX(),$pdf->GetY(),$pdf->GetX(),$pdf->GetY()+55);
	$pdf->SetY($pdf->GetY()+55);
	$pdf->Line($pdf->GetX(),$pdf->GetY(),$pdf->GetX()+195,$pdf->GetY());
	$pdf->Line($pdf->GetX(),$pdf->GetY(),$pdf->GetX(),$pdf->GetY()-49.84);
	*/
	$pdf->Output();
}

$db->close();
$db2->close();
?>