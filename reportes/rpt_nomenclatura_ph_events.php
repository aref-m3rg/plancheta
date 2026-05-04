<?php
//BindEvents Method @1-F6EFC212
function BindEvents()
{
    global $parcelas_parcelas_tipos_p;
    global $CCSEvents;
    $parcelas_parcelas_tipos_p->obs->CCSEvents["BeforeShow"] = "parcelas_parcelas_tipos_p_obs_BeforeShow";
    $parcelas_parcelas_tipos_p->restricciones->CCSEvents["BeforeShow"] = "parcelas_parcelas_tipos_p_restricciones_BeforeShow";
    $parcelas_parcelas_tipos_p->notas->CCSEvents["BeforeShow"] = "parcelas_parcelas_tipos_p_notas_BeforeShow";
    $parcelas_parcelas_tipos_p->observaciones->CCSEvents["BeforeShow"] = "parcelas_parcelas_tipos_p_observaciones_BeforeShow";
    $parcelas_parcelas_tipos_p->CCSEvents["BeforeShow"] = "parcelas_parcelas_tipos_p_BeforeShow";
}
//End BindEvents Method

//parcelas_parcelas_tipos_p_obs_BeforeShow @111-426B872C
function parcelas_parcelas_tipos_p_obs_BeforeShow(& $sender)
{
    $parcelas_parcelas_tipos_p_obs_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_parcelas_tipos_p; //Compatibility
//End parcelas_parcelas_tipos_p_obs_BeforeShow

//PTAutocomplete2 BeforeShow @112-ACFDD29A
    $Component->Attributes->SetValue('id', 'parcelas_parcelas_tipos_pDetailobs');
//End PTAutocomplete2 BeforeShow

//Close parcelas_parcelas_tipos_p_obs_BeforeShow @111-B45CB362
    return $parcelas_parcelas_tipos_p_obs_BeforeShow;
}
//End Close parcelas_parcelas_tipos_p_obs_BeforeShow

//parcelas_parcelas_tipos_p_restricciones_BeforeShow @76-5D21E228
function parcelas_parcelas_tipos_p_restricciones_BeforeShow(& $sender)
{
    $parcelas_parcelas_tipos_p_restricciones_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_parcelas_tipos_p; //Compatibility
//End parcelas_parcelas_tipos_p_restricciones_BeforeShow

//Open as popup @56-4D6E5132
    

// restricciones
// restricciones
	
global $parcelas_parcelas_tipos_p;

$lnk=$parcelas_parcelas_tipos_p->restricciones->GetLink();
$newlnk="$lnk\" onclick=\"javascript:window.open(this.href,'','width=500,height=500,top='+(screen.height-500)/2+',left='+(screen.width-500)/2+',scrollbars=no,location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no');return false;";
$parcelas_parcelas_tipos_p->restricciones->SetLink($newlnk);

	
//End Open as popup

//Close parcelas_parcelas_tipos_p_restricciones_BeforeShow @76-426CC862
    return $parcelas_parcelas_tipos_p_restricciones_BeforeShow;
}
//End Close parcelas_parcelas_tipos_p_restricciones_BeforeShow

//parcelas_parcelas_tipos_p_notas_BeforeShow @57-AF94CE6E
function parcelas_parcelas_tipos_p_notas_BeforeShow(& $sender)
{
    $parcelas_parcelas_tipos_p_notas_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_parcelas_tipos_p; //Compatibility
//End parcelas_parcelas_tipos_p_notas_BeforeShow

//Open as popup @77-FC86F1B9
    

// notas
// notas
	
global $parcelas_parcelas_tipos_p;

$lnk=$parcelas_parcelas_tipos_p->notas->GetLink();
$newlnk="$lnk\" onclick=\"javascript:window.open(this.href,'','width=500,height=500,top='+(screen.height-500)/2+',left='+(screen.width-500)/2+',scrollbars=no,location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no');return false;";
$parcelas_parcelas_tipos_p->notas->SetLink($newlnk);

	
//End Open as popup

//Close parcelas_parcelas_tipos_p_notas_BeforeShow @57-B24A1F41
    return $parcelas_parcelas_tipos_p_notas_BeforeShow;
}
//End Close parcelas_parcelas_tipos_p_notas_BeforeShow

//parcelas_parcelas_tipos_p_observaciones_BeforeShow @93-741CAD9D
function parcelas_parcelas_tipos_p_observaciones_BeforeShow(& $sender)
{
    $parcelas_parcelas_tipos_p_observaciones_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_parcelas_tipos_p; //Compatibility
//End parcelas_parcelas_tipos_p_observaciones_BeforeShow

//Open as popup @94-1C1E2554
    

// observaciones
// observaciones
	
global $parcelas_parcelas_tipos_p;

$lnk=$parcelas_parcelas_tipos_p->observaciones->GetLink();
$newlnk="$lnk\" onclick=\"javascript:window.open(this.href,'','width=500,height=500,top='+(screen.height-500)/2+',left='+(screen.width-500)/2+',scrollbars=no,location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no');return false;";
$parcelas_parcelas_tipos_p->observaciones->SetLink($newlnk);

	
//End Open as popup

//Close parcelas_parcelas_tipos_p_observaciones_BeforeShow @93-E9F0F591
    return $parcelas_parcelas_tipos_p_observaciones_BeforeShow;
}
//End Close parcelas_parcelas_tipos_p_observaciones_BeforeShow

//parcelas_parcelas_tipos_p_BeforeShow @2-A553406F
function parcelas_parcelas_tipos_p_BeforeShow(& $sender)
{
    $parcelas_parcelas_tipos_p_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_parcelas_tipos_p; //Compatibility
//End parcelas_parcelas_tipos_p_BeforeShow

//Custom Code @84-2A29BDB7
// -------------------------
    // Write your own code here.
	
	if(CCGetParam(imprimir) == 1){
		$Component->panel->Visible = false;
	}
// -------------------------
//End Custom Code

//Close parcelas_parcelas_tipos_p_BeforeShow @2-4B40B802
    return $parcelas_parcelas_tipos_p_BeforeShow;
}
//End Close parcelas_parcelas_tipos_p_BeforeShow

//Page_BeforeInitialize @1-00A48B9D
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $rpt_nomenclatura_ph; //Compatibility
//End Page_BeforeInitialize

//PTAutocomplete2 Initialization @112-DB8CD3AB
    global $Charset;
    if ('parcelas_parcelas_tipos_pDetailobsPTAutocomplete2' == CCGetParam('callbackControl')) {
        $Service = new Service();
        $Service->SetFormatter(new ListFormatter());
//End PTAutocomplete2 Initialization

//PTAutocomplete2 DataSource @112-B4A3971F
        $Service->SetDataSourceQuery(CCBuildSQL($Service->DataSource->SQL, $Service->DataSource->Where, $Service->DataSource->Order));
//End PTAutocomplete2 DataSource

//PTAutocomplete2 Charset @112-4F7C968C
        $Service->AddHttpHeader("Content-type", "text/html; charset=" . $Charset);
//End PTAutocomplete2 Charset

//PTAutocomplete2 DataFields @112-53A4E65F
        $Service->AddDataSourceField('');
//End PTAutocomplete2 DataFields

//PTAutocomplete2 Execution @112-D749E478
        $Service->DisplayHeaders();
        echo $Service->Execute();
//End PTAutocomplete2 Execution

//PTAutocomplete2 Tail @112-27890EF8
        exit;
    }
//End PTAutocomplete2 Tail

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize


?>
