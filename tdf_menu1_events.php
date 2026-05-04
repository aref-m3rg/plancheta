<?php
// //Events @1-F81417CB

//tdf_menu1_Menu1_BeforeShowRow @42-7E590409
function tdf_menu1_Menu1_BeforeShowRow(& $sender)
{
    $tdf_menu1_Menu1_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tdf_menu1; //Compatibility
//End tdf_menu1_Menu1_BeforeShowRow

//Custom Code @46-2A29BDB7
// -------------------------
    // Write your own code here.
  	
	$Component->ItemLink->Parameters="";
	
    if($Component->ItemLink->Page){
        $Component->ItemLink->Page = RelativePath . $Component->ItemLink->Page;//"<br>";
    } else {
        $Component->ItemLink->Page = $_SERVER['SCRIPT_NAME'];
    }

// -------------------------
//End Custom Code

//Close tdf_menu1_Menu1_BeforeShowRow @42-50B5E9B4
    return $tdf_menu1_Menu1_BeforeShowRow;
}
//End Close tdf_menu1_Menu1_BeforeShowRow

//DEL  // -------------------------
//DEL      // Write your own code here.
//DEL  	//echo "<pre>";
//DEL  	//print_r($Component->ItemLink);
//DEL  	//echo $Component->ItemLink->Value . "<br>";
//DEL  	if($Component->ItemLink->Value != "Cerrar Sesión"){
//DEL  		$Component->ItemLink->Parameters="";
//DEL  	}
//DEL  // -------------------------

//tdf_menu1_AfterInitialize @1-1904A630
function tdf_menu1_AfterInitialize(& $sender)
{
    $tdf_menu1_AfterInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tdf_menu1; //Compatibility
//End tdf_menu1_AfterInitialize

//Custom Code @15-2A29BDB7
// -------------------------
    // Write your own code here.
	$img1 = "../imagenes/header_1.gif";
	$img2 = "../imagenes/header_2.gif";
	$img3 = "../imagenes/header_3.gif";
	$Component->banner0->SetValue("<img alt='Catastro' src='$img1'>");
	$Component->banner->SetValue("<img alt='Catastro' src='$img2'>");
	$Component->banner2->SetValue("<img alt='Catastro' src='$img3'>");
// -------------------------
//End Custom Code

//Close tdf_menu1_AfterInitialize @1-411ED1FE
    return $tdf_menu1_AfterInitialize;
}
//End Close tdf_menu1_AfterInitialize
?>
