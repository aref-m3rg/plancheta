<?php
define("RelativePath", "..");
include(RelativePath . "/Common.php");

setcookie("registrado","yes",time()-1);
setcookie("registrado","");
$_COOKIE['registrado']="";
$_POST['log']="";
$_POST['pwd']="";
header('Location: ../index.php');
?>
