<?php
// //Events @1-F81417CB

//tdf_menu_Menu1_BeforeShowRow @42-D4ADDAC7
function tdf_menu_Menu1_BeforeShowRow(& $sender)
{
    $tdf_menu_Menu1_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tdf_menu; //Compatibility
//End tdf_menu_Menu1_BeforeShowRow

//Custom Code @46-2A29BDB7
// -------------------------
	//corrige parametros segun necesidad
    if($Component->ItemLink->Page != ''){
        $Component->ItemLink->Page = RelativePath . $Component->ItemLink->Page;
    } else {
        $Component->ItemLink->Page = $_SERVER['SCRIPT_NAME']."?".CCGetSession("parametros");
    }
// -------------------------
//End Custom Code

//Close tdf_menu_Menu1_BeforeShowRow @42-B5A689F4
    return $tdf_menu_Menu1_BeforeShowRow;
}
//End Close tdf_menu_Menu1_BeforeShowRow

//tdf_menu_Menu1_BeforeShow @42-8E531D9F
function tdf_menu_Menu1_BeforeShow(& $sender)
{
    $tdf_menu_Menu1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tdf_menu; //Compatibility
//End tdf_menu_Menu1_BeforeShow

//Custom Code @62-2A29BDB7
// -------------------------
	//lista de parametros del navegador
	CCSetSession("parametros",$Component->ItemLink->Parameters);
	$Component->ItemLink->Parameters = "";
// -------------------------
//End Custom Code

//Close tdf_menu_Menu1_BeforeShow @42-20B4B52E
    return $tdf_menu_Menu1_BeforeShow;
}
//End Close tdf_menu_Menu1_BeforeShow

//tdf_menu_AfterInitialize @1-18CBE868
function tdf_menu_AfterInitialize(& $sender)
{
    $tdf_menu_AfterInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tdf_menu; //Compatibility
//End tdf_menu_AfterInitialize

//Custom Code @15-2A29BDB7
// -------------------------
	
	global $PathToRoot;

    // Arma los paths de las imágenes de la cabecera
	$img1 = $PathToRoot . "/imagenes/header_1.gif";
	$img2 = $PathToRoot . "/imagenes/header_2.gif";
	$img3 = $PathToRoot . "/imagenes/header_3.gif";
	$Component->banner0->SetValue("<img alt='Catastro' src='$img1'>");
	$Component->banner->SetValue("<img alt='Catastro' src='$img2'>");
	$Component->banner2->SetValue("<img alt='Catastro' src='$img3'>");
// -------------------------
//End Custom Code

//Close tdf_menu_AfterInitialize @1-B2884DFD
    return $tdf_menu_AfterInitialize;
}
//End Close tdf_menu_AfterInitialize

//tdf_menu_BeforeInitialize @1-8073DFD4
function tdf_menu_BeforeInitialize(& $sender)
{
    $tdf_menu_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tdf_menu; //Compatibility
//End tdf_menu_BeforeInitialize

//Custom Code @49-2A29BDB7
// -------------------------

  /* Incluye el archivo de configuraciones generales
  ---------------------------------------------------------- */
  include_once( 'configuracion_general.php' );


// -------------------------
//End Custom Code

//Close tdf_menu_BeforeInitialize @1-6ED1D40D
    return $tdf_menu_BeforeInitialize;
}
//End Close tdf_menu_BeforeInitialize
?>
