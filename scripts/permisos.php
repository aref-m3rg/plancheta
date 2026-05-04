<?php
	/*
	new clsDBcatastro();
	$pagina = substr(strrchr($_SERVER['SCRIPT_FILENAME'], "/"), 1) ;
	$pagina = trim($pagina);
	$menu_id = CCDLookUp("menu_id","menu","menu_link LIKE  '%" . $pagina . "%'",$db_2);
	CCSetSession("menu_id",$menu_id);
	$perfil_id = CCDLookUp('perfil_id','_usuarios','usuario_id = ' . CCGetUserID(),$db_2);
	$nivel_id =     CCDLookUp("_perfiles_items.nivel_id"    ,"_perfiles_items LEFT JOIN _nivel ON _nivel.nivel_id =  _perfiles_items.nivel_id"," perfil_id = ". $perfil_id . " AND menu_id =  " . $menu_id ,$db_2);
	$nivel_nombre = CCDLookUp("nivel_nombre","_perfiles_items LEFT JOIN _nivel ON _nivel.nivel_id =  _perfiles_items.nivel_id"," perfil_id = ". $perfil_id . " AND menu_id =  " . $menu_id ,$db_2);
	echo "<BR> Pagina: " . $_SERVER['SCRIPT_FILENAME'] ;
	echo "<BR> escrips: Pagina: " . $pagina;
	echo " <BR> perfil_id = ". $perfil_id . " AND menu_id =  " . $menu_id;
	echo "<BR> NIVEL: " .   CCGetSession("GID") . " - " . $nivel_id ;
	CCSetSession("GID",$nivel_id);
	CCSetSession("perfil_id",$perfil_id);
	//if ($nivel_id == '') $Redirect = "../tdf_restricted.php";
	//GLOBAL $Redirect;
	echo "<BR> b: " .   $Redirect;
	*/
?>