<?php

define("RelativePath", "..");
include(RelativePath . "/Common.php");
include(RelativePath . "/scripts/avaluo.php");

/*$parcela_id = CCGetParam(parcela_id);
$cant_serv = CCGetParam(cant_serv);
$parcelaparcela_lado_frente = CCGetParam(parcelaparcela_lado_frente);
$parcelaparcela_lateral_este = CCGetParam(parcelaparcela_lateral_este);
$parcelaparcela_lateral_norte = CCGetParam(parcelaparcela_lateral_norte);
$parcelaparcela_lateral_oeste = CCGetParam(parcelaparcela_lateral_oeste);
$parcelaparcela_lateral_sur = CCGetParam(parcelaparcela_lateral_sur);
$parcelaparcela_super_mensura = CCGetParam(parcelaparcela_super_mensura);
$parcelatipo_parcela_estado_id = CCGetParam(parcelatipo_parcela_estado_id);
$parcelatipo_parcela_ryb_id = CCGetParam(parcelatipo_parcela_ryb_id);
$cant_serv = CCGetParam(cant_serv);
*/


$parcela_id = CCGetParam(parcela_id);
$pe_idd = CCGetParam(pe_id);
$ryb_idd = CCGetParam(ryb_id);
$cant_serv = CCGetParam(cantser);
$parcela_super_mensura = CCGetParam(parcela_super_mensura);
$lado_frente = CCGetParam(lado_frente); //el lado de frente
$parcela_lateral_norte = CCGetParam(parcela_lateral_norte);
$parcela_lateral_sur = CCGetParam(parcela_lateral_sur);
$parcela_lateral_este = CCGetParam(parcela_lateral_este);
$parcela_lateral_oeste = CCGetParam(parcela_lateral_oeste);



$dbg = new clsDBguaymallen();
$calculo_avaluo_imp = CCDLookUp('calculos_avaluo.calculo_avaluo_imp',' calculos_avaluo  ','calculos_avaluo.tipo_parcela_estado_id = '. $pe_idd . ' AND calculos_avaluo.tipo_parcela_ryb_id = ' . $ryb_idd ,$dbg);	
$calculo_avaluo_auto = CCDLookUp('calculos_avaluo.calculo_avaluo_auto',' calculos_avaluo  ','calculos_avaluo.tipo_parcela_estado_id = '. $pe_idd . ' AND calculos_avaluo.tipo_parcela_ryb_id = ' . $ryb_idd ,$dbg);	
$dbg->close();

if(!$calculo_avaluo_imp) $calculo_avaluo_imp = 1;
if(!$calculo_avaluo_auto) $calculo_avaluo_auto = 1;

/*
echo "avaluo_js_aaa " . $parcela_id , "ryb_idd : " . $ryb_idd . " calculo_avaluo_imp : " . $calculo_avaluo_imp;
exit;
*/
$aval= avaluo($parcela_id,
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
			  $parcela_lateral_oeste);

/*
echo $parcela_id ."-" . 
	 $pe_idd ."-" . 
	 $ryb_idd ."-" . 
	 $calculo_avaluo_imp . "-" . 
	 $calculo_avaluo_auto ."-" . 
	 $cant_serv ."-" . 
	 $parcela_super_mensura ."-" .
	 $lado_frente ."-" .
	 $parcela_lateral_norte ."-" . 
	 $parcela_lateral_sur ."-" . 
	 $parcela_lateral_este ."-" . 
	 $parcela_lateral_oeste ."-" . 
	 $aval;
exit;
*/

$valor=importe($calculo_avaluo_imp ,$parcela_id,$aval,$ryb_idd);

$db = new clsDBguaymallen();
	$valorv = CCDLookUp('parcela_avaluo_imp','parcelas',"parcela_id=$parcela_id",$db);
	$avaluov = CCDLookUp('parcela_avaluo','parcelas',"parcela_id=$parcela_id",$db);
$db->Close();
IF ($valorv <> $valor) 
	$dif['dif']="SI";
ELSE 
 	$dif['dif']="NO";

$dif['calculado']=$valor;	
$dif['grabado']=$valorv;	

$dif['calculadoa']=$aval;	
$dif['grabadoa']=$avaluov;	

$diff = json_encode($dif);

echo $diff;



?>