<?php
//BindEvents Method @1-6D4AA4A2
function BindEvents()
{
    global $checkXls;
    global $CCSEvents;
    $checkXls->columnas->CCSEvents["BeforeShow"] = "checkXls_columnas_BeforeShow";
    $checkXls->CCSEvents["BeforeShow"] = "checkXls_BeforeShow";
    $CCSEvents["BeforeShow"] = "Page_BeforeShow";
}
//End BindEvents Method

//checkXls_columnas_BeforeShow @3-4C07BBFD
function checkXls_columnas_BeforeShow(& $sender)
{
    $checkXls_columnas_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $checkXls; //Compatibility
//End checkXls_columnas_BeforeShow

//Custom Code @8-2A29BDB7
// -------------------------
    // Write your own code here.
	//$Component->columnas->DataSource = $_SESSION[colXls][0];
	//echo "<pre>";
	//print_r(array(array(1,1),array(2,2),array(3,3)));

	while (list ($clave, $val) = each ($_SESSION[colXls])) {
    	$a[] = array($clave,$val);
	} 
	
	$Component->Values = $a;
// -------------------------
//End Custom Code

//Close checkXls_columnas_BeforeShow @3-274AA258
    return $checkXls_columnas_BeforeShow;
}
//End Close checkXls_columnas_BeforeShow

//checkXls_BeforeShow @2-D9DE5661
function checkXls_BeforeShow(& $sender)
{
    $checkXls_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $checkXls; //Compatibility
//End checkXls_BeforeShow

//Custom Code @7-2A29BDB7
// -------------------------
    // Write your own code here.
	//echo "<pre>";
// -------------------------
//End Custom Code

//Close checkXls_BeforeShow @2-F2CF363F
    return $checkXls_BeforeShow;
}
//End Close checkXls_BeforeShow

//Page_BeforeShow @1-6C00EAFF
function Page_BeforeShow(& $sender)
{
    $Page_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $preXls; //Compatibility
//End Page_BeforeShow

//Custom Code @6-2A29BDB7
// -------------------------
    // Write your own code here.
	//echo "<pre>";
	//print_r($_SESSION);
// -------------------------
//End Custom Code

//Close Page_BeforeShow @1-4BC230CD
    return $Page_BeforeShow;
}
//End Close Page_BeforeShow


?>
