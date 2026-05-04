<?php
define("RelativePath", "..");
include(RelativePath . "/Common.php");
$db = new clsDBtdf_nuevo();
$previsado_carga_id = CCGetParam("previsado_carga_id");
$SQL="DELETE FROM previsados_parcelas_destinos WHERE previsado_carga_id=$previsado_carga_id";
$db->query($SQL);
$db->close();
header('Location: previsados_nomenclatura_destino.php?previsado_carga_id='.$previsado_carga_id);
?>