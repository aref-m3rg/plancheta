<?php
//BindEvents Method @1-EA753667
function BindEvents()
{
    global $Login;
    $Login->Button1->CCSEvents["OnClick"] = "Login_Button1_OnClick";
}
//End BindEvents Method

//Login_Button1_OnClick @11-16DBF50D
function Login_Button1_OnClick(& $sender)
{
    $Login_Button1_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Login; //Compatibility
//End Login_Button1_OnClick

//Custom Code @13-2A29BDB7
// -------------------------
    // Write your own code here.
	global $Redirect;
	$Redirect = "tdf_login.php?Logout=True";


// -------------------------
//End Custom Code

//Close Login_Button1_OnClick @11-A702A8A4
    return $Login_Button1_OnClick;
}
//End Close Login_Button1_OnClick


?>
