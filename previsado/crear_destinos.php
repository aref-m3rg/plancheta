<?php
define("RelativePath", "..");
include(RelativePath . "/Common.php");
$db = new clsDBtdf_nuevo();
$previsado_carga_id = CCGetParam("previsado_carga_id");
$cant_destino = CCGetParam("cant_destino");
$rango_tipo = CCGetParam("rango_tipo");
$rango_ini = CCGetParam("rango_ini");
$rango_fin = CCGetParam("rango_fin");
$parcela_seccion = CCGetParam("parcela_seccion");
$parcela_macizo = CCGetParam("parcela_macizo");
$parcela_parcela = CCGetParam("parcela_parcela");
$parcela_uf = CCGetParam("parcela_uf");
$tipo_depto_parc_id = CCGetParam("tipo_depto_parc_id");
$parcela_chacra = CCGetParam("parcela_chacra");
$parcela_quinta = CCGetParam("parcela_quinta");
$parcela_fraccion = CCGetParam("parcela_fraccion");
$parcela_super_mensura = CCGetParam("parcela_super_mensura");
$unidades_medidas_id = CCGetParam("unidades_medidas_id");
$parcela_super_uf = CCGetParam("parcela_super_uf");
$unidades_medidas_uf_id = CCGetParam("unidades_medidas_uf_id");
$previsado_titular_fijo_id = CCGetParam("previsado_titular_fijo_id");

for($i=$rango_ini;$i<=$rango_fin;$i++){
	if($rango_tipo == 1){//parcelas
		$parcela_parcela = $i;
	}elseif($rango_tipo == 2){//uf/uc
		$parcela_uf = $i;
	}else{
		$parcela_parcela = 0;
		$parcela_uf = 0;
	}	
	$SQL="INSERT INTO previsados_parcelas_destinos SET
						tipo_depto_parc_id = '$tipo_depto_parc_id',
						parcela_seccion = '$parcela_seccion',
						parcela_chacra = '$parcela_chacra',
						parcela_quinta = '$parcela_quinta',
						parcela_macizo = '$parcela_macizo',
						parcela_fraccion = '$parcela_fraccion',
						parcela_parcela = '$parcela_parcela',
						parcela_super_mensura = '$parcela_super_mensura',
						unidades_medidas_id = '$unidades_medidas_id',
						parcela_uf = '$parcela_uf',
						parcela_super_uf = '$parcela_super_uf',
						unidades_medidas_uf_id = '$unidades_medidas_uf_id',
						previsado_titular_fijo_id = '$previsado_titular_fijo_id',
						previsado_carga_id = '$previsado_carga_id'";
	$db->query($SQL);
	$db->close();	
}
header('Location: previsados_nomenclatura_destino.php?previsado_carga_id='.$previsado_carga_id);
?>