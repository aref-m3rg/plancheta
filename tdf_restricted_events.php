<?php
//BindEvents Method @1-2777CCFA
function BindEvents()
{
    global $login;
    global $CCSEvents;
    $login->CCSEvents["BeforeShow"] = "login_BeforeShow";
    $CCSEvents["BeforeShow"] = "Page_BeforeShow";
}
//End BindEvents Method

//login_BeforeShow @9-47115E6D
function login_BeforeShow(& $sender)
{
    $login_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $login; //Compatibility
//End login_BeforeShow

//Custom Code @10-2A29BDB7
// -------------------------
    // Write your own code here.
// -------------------------
//End Custom Code

//Close login_BeforeShow @9-C8988BEE
    return $login_BeforeShow;
}
//End Close login_BeforeShow

//Page_BeforeShow @1-415EA394
function Page_BeforeShow(& $sender)
{
    $Page_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tdf_restricted; //Compatibility
//End Page_BeforeShow

//Custom Code @8-2A29BDB7
// -------------------------
    // Write your own code here.
	$db = new clsDBtdf_nuevo();
	$SQL = "SELECT usuario_nombre, usuario_login , perfil_descr 
			FROM _usuarios
			LEFT JOIN _perfiles USING (perfil_id)
			WHERE usuario_id = " . CCGetUserID();
	//echo $SQL;
	//exit;
	$db->query($SQL);
	//echo $SQL;
	if($db->next_record()){
		$Component->usr->SetValue($db->f('usuario_nombre'));
		$Component->grp->SetValue($db->f('perfil_descr'));
		$Component->login->SetValue($db->f('usuario_login'));
	}

	$db->close();
// -------------------------
//End Custom Code

//Close Page_BeforeShow @1-4BC230CD
    return $Page_BeforeShow;
}
//End Close Page_BeforeShow

//Page_BeforeInitialize @1-91CA6BFD
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tdf_restricted; //Compatibility
//End Page_BeforeInitialize

//Custom Code @11-2A29BDB7
// -------------------------
    // Write your own code here.
	//include_once(RelativePath . "/scripts/permisos1.php");
	CCSetSession("GID",1); // sino no sale
		
// -------------------------
//End Custom Code

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize
?>
