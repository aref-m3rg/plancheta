<?php
	
	
	global $Redirect;	
	
	//$usuario_id = CCGetUserID();
	$pagina_name = substr (strrchr($_SERVER['PHP_SELF'], "/"), 1);
	$mando = "";
	$Redirect = "";
	//echo " <BR> pagina_name : " . $pagina_name . " <BR> PHP_SELF: " .  $_SERVER['PHP_SELF'] . " <BR> Redirect:" . $Redirect;
	
	//exit;
	
	
	
	//CCSetSession("LINKED", "0");
	
	$db_2 = new clsDBcatastro();
	//$pagina = substr(strrchr($_SERVER['SCRIPT_FILENAME'], "/"), 1) ;
	//$pagina = trim($pagina);
	$pagina = TRIM(basename($_SERVER['PHP_SELF'] ).PHP_EOL);
	$menu_id = CCDLookUp("menu_id","menu","menu_link LIKE  '%" . $pagina . "%'",$db_2);
	CCSetSession("menu_id",$menu_id);
	$perfil_id = CCDLookUp('perfil_id','_usuarios','usuario_id = ' . CCGetUserID(),$db_2);
	$nivel_id =     CCDLookUp("_perfiles_items.nivel_id"    ,"_perfiles_items LEFT JOIN _nivel ON _nivel.nivel_id =  _perfiles_items.nivel_id"," perfil_id = ". $perfil_id . " AND menu_id =  " . $menu_id ,$db_2);
	$nivel_nombre = CCDLookUp("nivel_nombre","_perfiles_items LEFT JOIN _nivel ON _nivel.nivel_id =  _perfiles_items.nivel_id"," perfil_id = ". $perfil_id . " AND menu_id =  " . $menu_id ,$db_2);
	
	
	//$nivel_id = 2;
	//$perfil_id = 1;
	CCSetSession("GID",$nivel_id);
	CCSetSession("perfil_id",$perfil_id);
	
	/*
	echo "<BR> SCRIPT_FILENAME: " . $_SERVER['SCRIPT_FILENAME'] ;
	echo "<BR> Pagina: " . $Pagina ;
	echo "<BR> escrips: Pagina: " . $pagina;
	echo " <BR> perfil_id = ". $perfil_id . " AND menu_id =  " . $menu_id;
	echo "<BR> GID : " .   CCGetSession("GID") . " <BR> Nivel:  " . $nivel_id ;
	*/
	//exit;
	
	if (($nivel_id == '') AND ($pagina <> "tdf_restricted.php")) {
	//if (($nivel_id == '') AND ($pagina <> "tdf_restricted.php")) {
		$Redirect = RelativePath . "/tdf_restricted.php" . CCGetParam(mnu_tab_id);
		$mando = RelativePath . "/tdf_restricted.php" . CCGetParam(mnu_tab_id);
		CCSetSession("GID",1); // sino no sale
		echo " <BR>  <BR> ENTROOOOOOO A REDIRECCIONAR <BR> <BR>";
		
	}
	
	//$Redirect = "../tdf_restricted.php";
	//
	//echo "<BR> b: Redirect:" .   $Redirect . "<BR> pagina_name : " . $pagina_name;
	//echo "<BR> c: mando:" .   $mando ;
	//exit;
?>