<?php
// //Events @1-F81417CB

//tdf_menu1_old_Menu2_BeforeShowRow @7-497DE0BB
function tdf_menu1_old_Menu2_BeforeShowRow(& $sender)
{
    $tdf_menu1_old_Menu2_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tdf_menu1_old; //Compatibility
//End tdf_menu1_old_Menu2_BeforeShowRow

//Custom Code @14-2A29BDB7
// -------------------------
  	
	$Component->ItemLink->Parameters="";
	
    if($Component->ItemLink->Page){
        $Component->ItemLink->Page = RelativePath . $Component->ItemLink->Page;//"<br>";
    } else {
        $Component->ItemLink->Page = $_SERVER['SCRIPT_NAME'];
    }

    // Write your own code here.
// -------------------------
//End Custom Code

//Close tdf_menu1_old_Menu2_BeforeShowRow @7-4254BAC6
    return $tdf_menu1_old_Menu2_BeforeShowRow;
}
//End Close tdf_menu1_old_Menu2_BeforeShowRow

//tdf_menu1_old_BeforeInitialize @1-2F0F1267
function tdf_menu1_old_BeforeInitialize(& $sender)
{
    $tdf_menu1_old_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tdf_menu1_old; //Compatibility
//End tdf_menu1_old_BeforeInitialize

//Custom Code @11-2A29BDB7
// -------------------------

//$RelativePath = "/catastro_tdf_nuevo/";
//echo " RelativePath :" . $RelativePath;
//exit;
    // Write your own code here.
// -------------------------
//End Custom Code

//Close tdf_menu1_old_BeforeInitialize @1-DB7C28FC
    return $tdf_menu1_old_BeforeInitialize;
}
//End Close tdf_menu1_old_BeforeInitialize

//tdf_menu1_old_AfterInitialize @1-86D070B0
function tdf_menu1_old_AfterInitialize(& $sender)
{
    $tdf_menu1_old_AfterInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tdf_menu1_old; //Compatibility
//End tdf_menu1_old_AfterInitialize

//Custom Code @12-2A29BDB7
// -------------------------
    // Write your own code here.
//echo " <BR> 2 - RelativePath :" . $RelativePath;
//exit;
// -------------------------
//End Custom Code

//Close tdf_menu1_old_AfterInitialize @1-CFBB8D40
    return $tdf_menu1_old_AfterInitialize;
}
//End Close tdf_menu1_old_AfterInitialize

//tdf_menu1_old_BeforeShow @1-F6C6AB08
function tdf_menu1_old_BeforeShow(& $sender)
{
    $tdf_menu1_old_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tdf_menu1_old; //Compatibility
//End tdf_menu1_old_BeforeShow

//Custom Code @13-2A29BDB7
// -------------------------
//echo " <BR> 3 - RelativePath :" . $RelativePath;
//exit;

    // Write your own code here.
// -------------------------
//End Custom Code

//Close tdf_menu1_old_BeforeShow @1-CD4C805A
    return $tdf_menu1_old_BeforeShow;
}
//End Close tdf_menu1_old_BeforeShow
?>
