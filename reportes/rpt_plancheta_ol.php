<?php
if (empty($_COOKIE['registrado']) || $_COOKIE['registrado'] != "yes") {
	header("Location: ../login.php");
	exit;
}
//require('rotation.php');
define("RelativePath", "..");
include(RelativePath . "/Common.php");
define('FPDF_FONTPATH',RelativePath . '/fpdf/font/');
include(RelativePath . "/fpdf/fpdf.php");
include(RelativePath . "/scripts/myFunctions.php");

$db = new clsDBtdf_nuevo();
$db2 = new clsDBtdf_nuevo();
$db3 = new clsDBtdf_nuevo();

class PDF extends FPDF{
    protected $extgstates = array();

    // alpha: real value from 0 (transparent) to 1 (opaque)
    // bm:    blend mode, one of the following:
    //          Normal, Multiply, Screen, Overlay, Darken, Lighten, ColorDodge, ColorBurn,
    //          HardLight, SoftLight, Difference, Exclusion, Hue, Saturation, Color, Luminosity
    function SetAlpha($alpha, $bm='Normal')
    {
        // set alpha for stroking (CA) and non-stroking (ca) operations
        $gs = $this->AddExtGState(array('ca'=>$alpha, 'CA'=>$alpha, 'BM'=>'/'.$bm));
        $this->SetExtGState($gs);
    }

    function AddExtGState($parms)
    {
        $n = count($this->extgstates)+1;
        $this->extgstates[$n]['parms'] = $parms;
        return $n;
    }

    function SetExtGState($gs)
    {
        $this->_out(sprintf('/GS%d gs', $gs));
    }

    function _enddoc()
    {
        if(!empty($this->extgstates) && $this->PDFVersion<'1.4')
            $this->PDFVersion='1.4';
        parent::_enddoc();
    }

    function _putextgstates()
    {
        for ($i = 1; $i <= count($this->extgstates); $i++)
        {
            $this->_newobj();
            $this->extgstates[$i]['n'] = $this->n;
            $this->_put('<</Type /ExtGState');
            $parms = $this->extgstates[$i]['parms'];
            $this->_put(sprintf('/ca %.3F', $parms['ca']));
            $this->_put(sprintf('/CA %.3F', $parms['CA']));
            $this->_put('/BM '.$parms['BM']);
            $this->_put('>>');
            $this->_put('endobj');
        }
    }

    function _putresourcedict()
    {
        parent::_putresourcedict();
        $this->_put('/ExtGState <<');
        foreach($this->extgstates as $k=>$extgstate)
            $this->_put('/GS'.$k.' '.$extgstate['n'].' 0 R');
        $this->_put('>>');
    }

    function _putresources()
    {
        $this->_putextgstates();
        parent::_putresources();
    }
	
	var $angle=0;
	function Rotate($angle,$x=-1,$y=-1){
		if($x==-1)
			$x=$this->x;
		if($y==-1)
			$y=$this->y;
		if($this->angle!=0)
			$this->_out('Q');
		$this->angle=$angle;
		if($angle!=0){
			$angle*=M_PI/180;
			$c=cos($angle);
			$s=sin($angle);
			$cx=$x*$this->k;
			$cy=($this->h-$y)*$this->k;
			$this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
		}
	}
	function _endpage(){
		if($this->angle!=0){
			$this->angle=0;
			$this->_out('Q');
		}
		parent::_endpage();
	}	
	function RotatedText($x, $y, $txt, $angle){
		//Text rotated around its origin
		$this->Rotate($angle,$x,$y);
		$this->Text($x,$y,$txt);
		$this->Rotate(0);
	}	
	function Header(){
		$this->SetFont('Arial','B',10);
		$this->Image('../imagenes/header_rpt_plancheta.JPG',10,10,40);
		$this->Cell(330,5,'',0,1,'C');//espacio superior
		$this->Cell(330,5,'AGENCIA DE RECAUDACIÓN FUEGUINA',0,1,'C');
		$this->Cell(330,5,'DIRECCIÓN PROVINCIAL DE CATASTRO',0,1,'C');
		$this->Cell(330,5,'',0,1,'C');//espacio inferior
		//espacio superior maximo 20 
		//QR ONLINE GOOGLE		
//		$URL_QR = "http://chart.apis.google.com/chart?cht=qr&chs=140x140&choe=UTF-8&chld=H&chl=AREF-DIRECCION%20PROVINCIAL%20DE%20CATASTRO-TIERRA%20DEL%20FUEGO".urlencode(" -Fecha Emision:".date("d/m/Y H:i:s").")");
//		//Validar si se obtuvo la URL
//		$imagen2 = getimagesize($URL_QR);
		if($imagen2[mime] != '' && $imagen2 !== false){
			$this->Image($URL_QR,317,5,25,25,'PNG');
		}
		$this->SetFont('Arial','B',26);
		$this->SetTextColor(211,211,211);
		$this->RotatedText(255,193,'DIRECCIÓN PROVINCIAL DE CATASTRO',62);		
	}
	function Footer(){
		$this->SetY(-15);
		$this->SetFont('Arial','I',10);
		$this->Cell(0,10,'Pagina '.$this->PageNo(),0,0,'C');
	}
	function truncateFloat($number,$digitos){
		$raiz = 10;
		$multiplicador = pow ($raiz,$digitos);
		$resultado = ((int)($number * $multiplicador)) / $multiplicador;
		return number_format($resultado, $digitos);
	}
}

//estructura para almacenar los distintos registros
class struct { 
	var $parcela; 
	var $uf; 
	var $loteOrigen; 
	var $superficie; 
	var $parcela_sup_uf;
	var $partida; 
	var $plano;
	var $estado;
} 
$a = array();//arrar para guardar la estructura

if(CCGetParam('parcela_id')){
	$parcela_id = CCGetParam('parcela_id');
	$SQL = "SELECT parcelas.tipo_padron_parc_id AS tipo_padron_parc_id, parcelas.tipo_depto_parc_id AS tipo_depto_parc_id,tipos_deptos_parcela.tipo_depto_parc_desc AS depto, parcelas.parcela_seccion AS seccion, parcelas.parcela_macizo AS macizo, parcelas.parcela_parcela AS parcela, parcelas.parcela_chacra AS chacra 
			FROM parcelas
			LEFT JOIN tipos_deptos_parcela ON parcelas.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id
			WHERE parcela_id = $parcela_id
			ORDER BY  parcelas.parcela_parcela";
	//echo $SQL;die();
	$db->query($SQL);

	if($db->next_record()){
		$pdf = new PDF('L','mm','Legal');
		//$pdf->AliasNbPages();
		//$pdf->Open();
		$where = '';
		if(CCGetParam('tipo_padron_parc_id') == 2){//si es una busqueda de parcela rural
			if($where){
				$where .= " AND ";
			}
			$where .= "parcelas.parcela_id = $parcela_id";
		}else{//si es una busqueda de parcela urbana
			if($db->f('tipo_padron_parc_id')){
				if($where){
					$where .= " AND ";
				}
				$where .= "parcelas.tipo_padron_parc_id = ".$db->f('tipo_padron_parc_id');
			}
			if($db->f('tipo_depto_parc_id')){
				if($where){
					$where .= " AND ";
				}
				$where .= "parcelas.tipo_depto_parc_id = ".$db->f('tipo_depto_parc_id');
			}
			if($db->f('seccion')){
				if($where){
					$where .= " AND ";
				}
				$where .= "parcelas.parcela_seccion = '".$db->f('seccion')."'";
			}
			if($db->f('macizo')){
				if($where){
					$where .= " AND ";
				}
				$where .= "parcelas.parcela_macizo = '".$db->f('macizo')."'";
			}
			if($db->f('chacra')){
				if($where){
					$where .= " AND ";
				}
				$where .= "parcelas.parcela_chacra = '".$db->f('chacra')."'";
			}
		}
		if($where){
			$where .= " AND ";
		}		
		$where .= "parcelas.parcela_partida <> 0 ";		
		$SQL="SELECT parcelas.parcela_partida AS partida, parcelas.parcela_super_mensura AS mensura, parcelas.parcela_parcela AS parcela, parcelas.parcela_id AS parcela_id, parcelas.parcela_uf AS uf, parcelas.parcela_sup_uf AS parcela_sup_uf, tipos_estados_parcela.tipo_est_parc_descr AS tipo_est_parc_descr, unidades_medidas.unidades_medidas_abrev AS unidad
				FROM parcelas
				LEFT JOIN tipos_estados_parcela ON parcelas.tipo_est_parc_id = tipos_estados_parcela.tipo_est_parc_id
				LEFT JOIN unidades_medidas ON parcelas.unidades_medidas_id = unidades_medidas.unidades_medidas_id
				WHERE $where
				ORDER BY tipos_estados_parcela.tipo_est_parc_descr, parcelas.parcela_partida";
		//echo $SQL;die();
		$db2->query($SQL);
		//echo $SQL;exit;
		$cantidad = CCDLookUp("COUNT(*)","parcelas",$where,$db3);
		$count = 0;//total cargados en array
		$registro = 0;//total de registros mostrados
		//carga en array los objetos registrados
		$parcelas_ids = array();
		while($db2->next_record()){
			$x = new struct; 
			$x->parcela = $db2->f('parcela'); 
			$x->uf = $db2->f('uf'); 
			$x->loteOrigen = ''; 
			$x->superficie = number_format($db2->f('mensura'),2,',','.');
			$x->parcela_sup_uf = number_format($db2->f('parcela_sup_uf'),2,',','.');
			$x->unidad = $db2->f('unidad');
			$x->partida = $db2->f('partida');
			$plano = obtenerPlano('',$db2->f('parcela_id'),'',$db3);
			if($plano){
				$x->plano = $plano;
			}else{
				$x->plano = obtenerPlano('','',$db2->f('parcela_id'),$db3);
			}
			$x->estado = $db2->f('tipo_est_parc_descr');
			$a[$count]=$x;
			$parcelas_ids[] = $db2->f('parcela_id');
			$count++;
		}		
		//----INICIO PAGINAR----
		for($j = 0; $j <= $pdf->truncateFloat($cantidad/28,0); $j++){		
			$pdf->AddPage();			
			if($j == 0){//solo en la primera pagina
				//--------------------mapa-------------------------------
				$imagen = mapa_jpg($parcela_id);
				$pdf->Image($imagen,10,30,238,165,'JPG');
				$pdf->Image('../imagenes/compass_rose.jpg',251,31,17);				
				//-------------------------------------------------------
				$pdf->SetFont('Times','B',18);
				$pdf->SetTextColor(179,179,179);
				$pdf->SetAlpha(0.3);
				$pdf->RotatedText(110,116,'ES COPIA SIMPLE',0);
				$pdf->SetAlpha(1);
				$pdf->Image('fondo.png',135.5,187.5);
				$pdf->SetFont('Times','B',12);
				$pdf->SetTextColor(211,211,211);
				$pdf->RotatedText(137,193,'NO VALIDO SIN SELLOS DE CATASTRO PROVINCIAL',0);	
			}
			$pdf->SetFont('Arial','B',8);
			$pdf->SetTextColor(1,1,1);
			$pdf->Cell(260,165,'',1,0,'C');		
			$departamento = 'Departamento: '.$db->f('depto');
			$seccion = 'Sección: '.$db->f('seccion');
			$macizo = 'Macizo: '.$db->f('macizo');
			//encabezado lista parcela
			$pdf->Cell(70,5,'Nomenclatura Catastral',1,1,'C');
			$pdf->SetX(270);
			$pdf->Cell(70,5,$departamento,1,1,'L');
			$pdf->SetX(270);
			$pdf->Cell(35,5,$seccion,1,0,'L');
			$pdf->Cell(35,5,$macizo,1,1,'L');
			$pdf->SetX(270);
			$pdf->Cell(70,5,'Origen: ',1,1,'L');
			$pdf->SetX(248);
			$pdf->Cell(12,5,'Parcela',1,0,'C');
			$pdf->Cell(10,5,'UF/UC',1,0,'C');
			//$pdf->Cell(12,5,'Lote O.',1,0,'C');
			$pdf->Cell(24,5,'Sup.',1,0,'C');
			$pdf->Cell(18,5,'Partida',1,0,'C');
			$pdf->Cell(28,5,'Plano',1,1,'C');
			//nombre para el archivo
			$nombre = str_replace(" ","_","plancheta_online_".$db->f('depto')."_".$db->f('seccion')."_".$db->f('macizo'));
			
			//contenido
			$linea=0;//contol de dibujo de linea de dato de parcela
			for($i = $linea; $i < 28; $i++){
				$pdf->SetX(248);
				$pdf->Cell(12,5,$a[$registro]->parcela,1,0,'C');
				$pdf->Cell(10,5,$a[$registro]->uf,1,0,'C');
				//$pdf->Cell(12,5,$a[$registro]->loteOrigen,1,0,'C');
				if($a[$registro]->uf){
					$pdf->Cell(24,5,$a[$registro]->parcela_sup_uf."".$a[$registro]->unidad,1,0,'R');
				}else{
					$pdf->Cell(24,5,$a[$registro]->superficie."".$a[$registro]->unidad,1,0,'R');
				}
				if($a[$registro]->estado == 'Histórica'){
					$pdf->Line($pdf->GetX()-45,$pdf->GetY()+2,$pdf->GetX()+45,$pdf->GetY()+2);
				}
				$pdf->Cell(18,5,$a[$registro]->partida,1,0,'R');
				$pdf->Cell(28,5,$a[$registro]->plano,1,1,'C');
				$registro++;
				$linea++;
			}
			//si flata completar, completa con vacios las fila
			for($i = $linea; $i < 28; $i++){
				$pdf->SetX(248);
				$pdf->Cell(12,5,'',1,0,'C');
				$pdf->Cell(10,5,'',1,0,'C');
				//$pdf->Cell(17,5,'',1,0,'C');
				$pdf->Cell(19,5,'',1,0,'C');
				$pdf->Cell(18,5,'',1,0,'C');
				$pdf->Cell(28,5,'',1,1,'C');
			}
			//----FIN PAGINAR----
		}
		if(count($parcelas_ids)){//restricciones
			$pasa = false;
			$rest_parcela_id = array();
			for($i=0;$i<count($parcelas_ids);$i++){
				$cantidad = CCDLookUp("COUNT(*)","parcelas_tipos_restricc INNER JOIN tipos_restricc_parcela ON parcelas_tipos_restricc.tipo_restricc_parcela_id = tipos_restricc_parcela.tipo_restricc_parcela_id","parcelas_tipos_restricc.parcela_id = ".$parcelas_ids[$i]." AND tipos_restricc_parcela.tipo_restricc_parcela_id <> 1",$db3);
				if($cantidad > 0){//tiene restriccion marcada que no son 'SIN RESTRICCIONES'
					$pasa = true;
					$parcela = CCDLookUp("parcela_parcela","parcelas","parcela_id = ".$parcelas_ids[$i],$db3);
					$uf_uc = CCDLookUp("parcela_uf","parcelas","parcela_id = ".$parcelas_ids[$i],$db3);
					$descrip_Restriccion = CCDLookUp("parcela_restr","parcelas","parcela_id = ".$parcelas_ids[$i],$db3);
					if($cantidad > 1){//tiene mas de 1 tipo de restriccion
						$SQL = "SELECT tipos_restricc_parcela.tipo_restricc_parcela_desc AS tipo_restricc_parcela_desc
								FROM parcelas_tipos_restricc INNER JOIN tipos_restricc_parcela ON parcelas_tipos_restricc.tipo_restricc_parcela_id = tipos_restricc_parcela.tipo_restricc_parcela_id
								WHERE parcelas_tipos_restricc.parcela_id = ".$parcelas_ids[$i];
						$db3->query($SQL);
						while($db3->next_record()){
							$tipo_restriccion[] = $db3->f('tipo_restricc_parcela_desc');
						}
					}else{						
						$tipo_restriccion[] = CCDLookUp("tipos_restricc_parcela.tipo_restricc_parcela_desc","parcelas_tipos_restricc INNER JOIN tipos_restricc_parcela ON parcelas_tipos_restricc.tipo_restricc_parcela_id = tipos_restricc_parcela.tipo_restricc_parcela_id","parcelas_tipos_restricc.parcela_id = ".$parcelas_ids[$i],$db3);
					}
					$rest_parcela_id[] = array("parcela" => $parcela,"uf_uc" => $uf_uc,"tipo_restriccion" => $tipo_restriccion,"descrip_Restriccion" => $descrip_Restriccion);
					$tipo_restriccion = array();
				}
			}	
			if($pasa){
				$pdf->AddPage();
				$pdf->Cell(330,5,"RESTRICCIONES para: $departamento - $seccion - $macizo",1,1,'L');
				for($i=0;$i<count($rest_parcela_id);$i++){
					$parcela = $rest_parcela_id[$i]["parcela"];
					if($rest_parcela_id[$i]["uf_uc"]){
						$uf_uc = "- UF/UC: ".$rest_parcela_id[$i]["uf_uc"];
					}else{
						$uf_uc = "";
					}					
					$tipo_restriccion = implode(",",$rest_parcela_id[$i]["tipo_restriccion"]);
					if($rest_parcela_id[$i]["descrip_Restriccion"]){
						$descrip_Restriccion = "\nDescripcion:\n".$rest_parcela_id[$i]["descrip_Restriccion"];
					}else{
						$descrip_Restriccion = "";
					}
					$texto = "Parcela: $parcela $uf_uc - Tipo Restriccion: $tipo_restriccion".$descrip_Restriccion;
					$pdf->MultiCell(330,5,$texto,"LRTB","L",0);
				}				
			}			
		}
		$pdf->Output($nombre.".pdf",'I');
	}else{
		echo "Error - no se encontro la parcela";
	}
}else{
 echo "Error - se requiere parametro";
}
$db->close();
$db2->close();
$db3->close();
?>