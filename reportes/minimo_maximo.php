<?php
define("RelativePath", "..");
include(RelativePath . "/Common.php");

$db = new clsDBcatastro();
$SQL="SELECT MIN(plano_nro) AS MINIMO FROM planos";
$db->query($SQL);
if($db->next_record()){
	$min=$db->f("MINIMO");
}
$SQL="SELECT MAX(plano_nro) AS MAXIMO FROM planos";
$db->query($SQL);
if($db->next_record()){
	$max=$db->f("MAXIMO");
}
for($min;$min<$max;$min++){
	if(CCDLookUp("COUNT(*)","planos","plano_nro='".$min."'",$db) == 0){
		echo $min."<br>";
		break;
	}
}
$db->close();
?>