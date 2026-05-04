<?php
//este script tiene algunas funciones utiles
 

 function avaluo_bd($parcela_id){
// calcula el avaluo con los datos de la base de datos
	$dbg = new clsDBguaymallen();
	$pe_idd = CCDLookUp('tipo_parcela_estado_id',' parcelas  ',' parcela_id = ' . $parcela_id ,$dbg);
	$ryb_idd =  CCDLookUp('tipo_parcela_ryb_id',' parcelas  ',' parcela_id = ' . $parcela_id ,$dbg);
	$cant_serv = CCDLookUp('COUNT(parcelas_servicios.parcela_servicio_id) AS cant',' parcelas_servicios ',' parcelas_servicios.parcela_id = ' . $parcela_id ,$dbg);
	$parcela_super_mensura = CCDLookUp('parcela_super_mensura',' parcelas  ',' parcela_id = ' . $parcela_id ,$dbg);
	$lado_frente = CCDLookUp('parcela_lado_frente',' parcelas  ',' parcela_id = ' . $parcela_id ,$dbg);
	$parcela_lateral_norte = CCDLookUp('parcela_lateral_norte',' parcelas  ',' parcela_id = ' . $parcela_id ,$dbg);
	$parcela_lateral_sur = CCDLookUp('parcela_lateral_sur',' parcelas  ',' parcela_id = ' . $parcela_id ,$dbg);
	$parcela_lateral_este = CCDLookUp('parcela_lateral_este',' parcelas  ',' parcela_id = ' . $parcela_id ,$dbg);
	$parcela_lateral_oeste = CCDLookUp('parcela_lateral_oeste',' parcelas  ',' parcela_id = ' . $parcela_id ,$dbg);
	$calculo_avaluo_auto = CCDLookUp('calculos_avaluo.calculo_avaluo_auto',' calculos_avaluo  ','calculos_avaluo.tipo_parcela_estado_id = '. $pe_idd . ' AND calculos_avaluo.tipo_parcela_ryb_id = ' . $ryb_idd ,$dbg);
	$coeficiente = avaluo($parcela_id,$pe_idd,$ryb_idd,$calculo_avaluo_imp,$calculo_avaluo_auto,$cant_serv,$parcela_super_mensura,$lado_frente,$parcela_lateral_norte,$parcela_lateral_sur,$parcela_lateral_este,$parcela_lateral_oeste);
	return $coeficiente; 
 
 }
 
 
 function importe_bd($parcela_id){
 // calcula el importe con los datos de la base de datos
	$coeficiente = avaluo_bd($parcela_id);
	$calculo_avaluo_imp = CCDLookUp('calculos_avaluo.calculo_avaluo_imp',' calculos_avaluo  ','calculos_avaluo.tipo_parcela_estado_id = '. $pe_idd . ' AND calculos_avaluo.tipo_parcela_ryb_id = ' . $ryb_idd ,$dbg);
	$importe =importe($calculo_avaluo_imp ,$parcela_id,$coeficiente,$ryb_idd);
	return $importe;  
 }
 
function avaluo($parcela_id,
				$pe_idd,
				$ryb_idd,
				$calculo_avaluo_imp,
				$calculo_avaluo_auto,
				$cant_serv,
				$parcela_super_mensura,
				$lado_frente,
				$parcela_lateral_norte,
				$parcela_lateral_sur,
				$parcela_lateral_este,
				$parcela_lateral_oeste){
	//calcula el avaluo con los datos recividos
	$dbg = new clsDBguaymallen();
	$dbg1 = new clsDBguaymallen();
	
	/*echo $parcela_id . " *** " . $calculo_avaluo_auto . " - " . $dbg1->f('mej');
	exit;
	*/
	
	
	
	IF($calculo_avaluo_auto == 1) {
		$coef = CCDLookUp('tipos_coef_serv.tipo_coef_serv_coef',' tipos_coef_serv ','tipos_coef_serv.tipo_coef_serv_cant = '. $cant_serv ,$dbg);
		$sup = $parcela_super_mensura * $coef;
		$SQL1 = "SELECT sum(mejoras.mejora_sup_cub * tipos_mejoras_categorias.tipo_mejora_categoria_coeficiente) as mej
				FROM mejoras
				LEFT JOIN tipos_mejoras_categorias ON tipos_mejoras_categorias.tipo_mejora_categoria_id = mejoras.tipo_mejora_categoria_id
				WHERE mejoras.parcela_id = " . $parcela_id . "  AND mejoras.tipo_estado_id = 1
				group by mejoras.parcela_id"  ;
		$dbg1->query($SQL1);
		$valor = $sup;
		$conmejora = FALSE;
		while($Result = $dbg1->next_record()){
			$conmejora = TRUE;
			$valor = $valor + $dbg1->f('mej');
			
		}
		if (!$conmejora){
			//$parcela_super_mensura = CCDLookUp('parcela_super_mensura',' parcelas','parcelas.parcela_id ='. $vparcela_id ,$dbg); lo paso como parametro
			if ($parcela_super_mensura > 700) {
				$lado = CCDLookUp('parcela_lado_frente',' parcelas','parcelas.parcela_id ='. $vparcela_id ,$dbg);
				if ($lado == "N" ) $frente = $parcela_lateral_norte; 
				if ($lado == "S" ) $frente = $parcela_lateral_sur; 
				if ($lado == "E" ) $frente = $parcela_lateral_este;
				if ($lado == "O" ) $frente = $parcela_lateral_oeste;
				//$tipo_coef_serv_coef = CCDLookUp('tipos_coef_serv.tipo_coef_serv_coef  ','FROM parcelas  LEFT JOIN tipos_coef_serv ON tipos_coef_serv.tipo_coef_serv_cant = (select count(parcelas_servicios.parcela_servicio_id) as cant from parcelas_servicios wherE parcelas_servicios.parcela_id = parcelas.parcela_id) 		LEFT JOIN parcelas_servicios ON parcelas_servicios.parcela_id = parcelas.parcela_id ','parcelas.parcela_id ='. $vparcela_id ,$dbg);
				if ($frente <= 15) $valor = ($frente * 20) * $coef /*$tipo_coef_serv_coef*/;
				if ($frente > 15 AND $frente <= 30 ) $valor = ($frente * 30) * $coef /*$tipo_coef_serv_coef*/;
				if ($frente == 0) $valor = $parcela_super_mensura * $coef /*$tipo_coef_serv_coef*/;
			}
		}
		
		//echo " <BR> valor : " . $valor . " -- " . $calculo_avaluo_auto;
		$valor = round ($valor,2);
	}
	ELSE $valor = 0;
	$dbg->close();
	$dbg1->close();
	$coeficiente = $valor;
	return $coeficiente;
}


function importe($calculo_avaluo_imp ,$parcela_id,$coeficiente,$ryb_idd){
	//calcula el IMPORTE con los datos recividos
	$dbg = new clsDBguaymallen();
	$dbg1 = new clsDBguaymallen();
	if ($calculo_avaluo_imp == 2) $importe = 0; // no calcular
	if ($calculo_avaluo_imp == 1){
	
		$tipo = CCDLookUp('tipo_parcela_ryb_tipo ',' tipos_parcelas_ryb ','tipos_parcelas_ryb.tipo_parcela_ryb_id = '. $ryb_idd ,$dbg);
		$importe = 0;
		if ($tipo == "ED") {
			$importe = CCDLookUp('avaluo.ed_total ',' avaluo ',' avaluo.minimo <= ' . $coeficiente . ' AND avaluo.maximo >= ' . $coeficiente ,$dbg);
		}
		if ($tipo == "BSC") {
			$importe = CCDLookUp('avaluo.sc_total ',' avaluo ',' avaluo.minimo <= ' . $coeficiente . ' AND avaluo.maximo >= ' . $coeficiente ,$dbg);
		} 
		if ($tipo == "BCC") {
			$importe = CCDLookUp(" avaluo.cc_total "," avaluo "," avaluo.minimo <= " . $coeficiente . " AND avaluo.maximo >= " . $coeficiente . " ; " ,$dbg);
		}		
		if ($tipo == "CUL") {
			$importe = CCDLookUp('avaluo.cu_total ',' avaluo ',' avaluo.minimo <= '.  $coeficiente . ' AND avaluo.maximo >= ' . $coeficiente ,$dbg);
		}			
		$importe = round ($importe,2);
	}
	if ($calculo_avaluo_imp == 3){
		$importe = CCDLookUp('(utm.utm_valor * tipos_parcelas_ryb.tipo_parcela_utm) ','  tipos_parcelas_ryb INNER JOIN utm ON utm.tipo_estado_id = 1','utm.tipo_estado_id = 1 AND tipos_parcelas_ryb.tipo_parcela_ryb_id = '. $ryb_idd ,$dbg);	
	}
	$dbg->close();
	$dbg1->close();
	return $importe; 
}
?>