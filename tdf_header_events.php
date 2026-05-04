<?php
// //Events @1-F81417CB

//tdf_header_BeforeInitialize @1-FD4EB76C
function tdf_header_BeforeInitialize(& $sender)
{
    $tdf_header_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tdf_header; //Compatibility
//End tdf_header_BeforeInitialize

//Custom Code @2-2A29BDB7
// -------------------------
    // Write your own code here.
/*
	$db_2 = new clsDBcatastro();
	$pagina = substr(strrchr($_SERVER['SCRIPT_FILENAME'], "/"), 1) ;
	$pagina = trim($pagina);
	$menu_id = CCDLookUp("menu_id","menu","menu_link LIKE  '%" . $pagina . "%'",$db_2);
	CCSetSession("menu_id",$menu_id);
	//$perfil_id = CCGetSession("perfil_id");
	$perfil_id = CCDLookUp('perfil_id','_usuarios','usuario_id = ' . CCGetUserID(),$db_2);
	$nivel_id =     CCDLookUp("_perfiles_items.nivel_id"    ,"_perfiles_items LEFT JOIN _nivel ON _nivel.nivel_id =  _perfiles_items.nivel_id"," perfil_id = ". $perfil_id . " AND menu_id =  " . $menu_id ,$db_2);
	$nivel_nombre = CCDLookUp("nivel_nombre","_perfiles_items LEFT JOIN _nivel ON _nivel.nivel_id =  _perfiles_items.nivel_id"," perfil_id = ". $perfil_id . " AND menu_id =  " . $menu_id ,$db_2);
	
	echo "<BR> Pagina: " . $pagina;
	echo " <BR> perfil_id = ". $perfil_id . " AND menu_id =  " . $menu_id;
	echo "<BR> a: " .   CCGetSession("GID") . " - " . $nivel_id ;
	
	CCSetSession("GID",$nivel_id);
	CCSetSession("perfil_id",$perfil_id);
	

	echo "<BR> b: " .   CCGetSession("GID") ;
	exit;
*/
	 //echo  " <BR> nivel_id: " . $nivel_id . " nivel_nombre :"  . $nivel_nombre;
//exit;





// -------------------------
//End Custom Code

//Close tdf_header_BeforeInitialize @1-84FBF597
    return $tdf_header_BeforeInitialize;
}
//End Close tdf_header_BeforeInitialize


?>
