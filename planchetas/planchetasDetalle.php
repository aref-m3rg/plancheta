<?php
//Include Common Files @1-93F8D934
define("RelativePath", "..");
define("PathToCurrentPage", "/planchetas/");
define("FileName", "planchetasDetalle.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @2-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @3-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

//Include Page implementation @4-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

class clsGridplanchetas { //planchetas class @6-DCA8D98B

//Variables @6-6E51DF5A

    // Public variables
    public $ComponentType = "Grid";
    public $ComponentName;
    public $Visible;
    public $Errors;
    public $ErrorBlock;
    public $ds;
    public $DataSource;
    public $PageSize;
    public $IsEmpty;
    public $ForceIteration = false;
    public $HasRecord = false;
    public $SorterName = "";
    public $SorterDirection = "";
    public $PageNumber;
    public $RowNumber;
    public $ControlsVisible = array();

    public $CCSEvents = "";
    public $CCSEventResult;

    public $RelativePath = "";
    public $Attributes;

    // Grid Controls
    public $StaticControls;
    public $RowControls;
//End Variables

//Class_Initialize Event @6-ABF3A66B
    function clsGridplanchetas($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "planchetas";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid planchetas";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsplanchetasDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 10;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;

        $this->tipo_depto_parc_desc = new clsControl(ccsLabel, "tipo_depto_parc_desc", "tipo_depto_parc_desc", ccsText, "", CCGetRequestParam("tipo_depto_parc_desc", ccsGet, NULL), $this);
        $this->tipo_padron_parc_desc = new clsControl(ccsLabel, "tipo_padron_parc_desc", "tipo_padron_parc_desc", ccsText, "", CCGetRequestParam("tipo_padron_parc_desc", ccsGet, NULL), $this);
        $this->plancheta_scc = new clsControl(ccsLabel, "plancheta_scc", "plancheta_scc", ccsText, "", CCGetRequestParam("plancheta_scc", ccsGet, NULL), $this);
        $this->plancheta_qta = new clsControl(ccsLabel, "plancheta_qta", "plancheta_qta", ccsText, "", CCGetRequestParam("plancheta_qta", ccsGet, NULL), $this);
        $this->plancheta_cha = new clsControl(ccsLabel, "plancheta_cha", "plancheta_cha", ccsText, "", CCGetRequestParam("plancheta_cha", ccsGet, NULL), $this);
        $this->plancheta_mzo = new clsControl(ccsLabel, "plancheta_mzo", "plancheta_mzo", ccsText, "", CCGetRequestParam("plancheta_mzo", ccsGet, NULL), $this);
        $this->plancheta_par = new clsControl(ccsLabel, "plancheta_par", "plancheta_par", ccsText, "", CCGetRequestParam("plancheta_par", ccsGet, NULL), $this);
        $this->plancheta_hoja = new clsControl(ccsLabel, "plancheta_hoja", "plancheta_hoja", ccsInteger, "", CCGetRequestParam("plancheta_hoja", ccsGet, NULL), $this);
        $this->plancheta_ruta = new clsControl(ccsLabel, "plancheta_ruta", "plancheta_ruta", ccsText, "", CCGetRequestParam("plancheta_ruta", ccsGet, NULL), $this);
        $this->plancheta_obs = new clsControl(ccsLabel, "plancheta_obs", "plancheta_obs", ccsText, "", CCGetRequestParam("plancheta_obs", ccsGet, NULL), $this);
        $this->plancheta_f_act = new clsControl(ccsLabel, "plancheta_f_act", "plancheta_f_act", ccsDate, array("dd", "/", "mm", "/", "yyyy", " ", "h", ":", "nn", " ", "AM/PM"), CCGetRequestParam("plancheta_f_act", ccsGet, NULL), $this);
        $this->html = new clsControl(ccsLabel, "html", "html", ccsText, "", CCGetRequestParam("html", ccsGet, NULL), $this);
        $this->html->HTML = true;
        $this->link_volver = new clsControl(ccsImageLink, "link_volver", "link_volver", ccsText, "", CCGetRequestParam("link_volver", ccsGet, NULL), $this);
        $this->link_volver->Parameters = CCGetQueryString("QueryString", array("plancheta_id", "ccsForm"));
        $this->link_volver->Page = "planchetasGrid.php";
        $this->link_edit = new clsControl(ccsImageLink, "link_edit", "link_edit", ccsText, "", CCGetRequestParam("link_edit", ccsGet, NULL), $this);
        $this->link_edit->Page = "planchetasEdit.php";
    }
//End Class_Initialize Event

//Initialize Method @6-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @6-9557C8B4
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlplancheta_id"] = CCGetFromGet("plancheta_id", NULL);

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);


        $this->DataSource->Prepare();
        $this->DataSource->Open();
        $this->HasRecord = $this->DataSource->has_next_record();
        $this->IsEmpty = ! $this->HasRecord;
        $this->Attributes->Show();

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        if(!$this->Visible) return;

        $GridBlock = "Grid " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $GridBlock;


        if (!$this->IsEmpty) {
            $this->ControlsVisible["tipo_depto_parc_desc"] = $this->tipo_depto_parc_desc->Visible;
            $this->ControlsVisible["tipo_padron_parc_desc"] = $this->tipo_padron_parc_desc->Visible;
            $this->ControlsVisible["plancheta_scc"] = $this->plancheta_scc->Visible;
            $this->ControlsVisible["plancheta_qta"] = $this->plancheta_qta->Visible;
            $this->ControlsVisible["plancheta_cha"] = $this->plancheta_cha->Visible;
            $this->ControlsVisible["plancheta_mzo"] = $this->plancheta_mzo->Visible;
            $this->ControlsVisible["plancheta_par"] = $this->plancheta_par->Visible;
            $this->ControlsVisible["plancheta_hoja"] = $this->plancheta_hoja->Visible;
            $this->ControlsVisible["plancheta_ruta"] = $this->plancheta_ruta->Visible;
            $this->ControlsVisible["plancheta_obs"] = $this->plancheta_obs->Visible;
            $this->ControlsVisible["plancheta_f_act"] = $this->plancheta_f_act->Visible;
            $this->ControlsVisible["html"] = $this->html->Visible;
            $this->ControlsVisible["link_volver"] = $this->link_volver->Visible;
            $this->ControlsVisible["link_edit"] = $this->link_edit->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->tipo_depto_parc_desc->SetValue($this->DataSource->tipo_depto_parc_desc->GetValue());
                $this->tipo_padron_parc_desc->SetValue($this->DataSource->tipo_padron_parc_desc->GetValue());
                $this->plancheta_scc->SetValue($this->DataSource->plancheta_scc->GetValue());
                $this->plancheta_qta->SetValue($this->DataSource->plancheta_qta->GetValue());
                $this->plancheta_cha->SetValue($this->DataSource->plancheta_cha->GetValue());
                $this->plancheta_mzo->SetValue($this->DataSource->plancheta_mzo->GetValue());
                $this->plancheta_par->SetValue($this->DataSource->plancheta_par->GetValue());
                $this->plancheta_hoja->SetValue($this->DataSource->plancheta_hoja->GetValue());
                $this->plancheta_ruta->SetValue($this->DataSource->plancheta_ruta->GetValue());
                $this->plancheta_obs->SetValue($this->DataSource->plancheta_obs->GetValue());
                $this->plancheta_f_act->SetValue($this->DataSource->plancheta_f_act->GetValue());
                $this->link_edit->Parameters = CCGetQueryString("QueryString", array("plancheta_id", "ccsForm"));
                $this->link_edit->Parameters = CCAddParam($this->link_edit->Parameters, "plancheta_id", $this->DataSource->f("plancheta_id"));
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->tipo_depto_parc_desc->Show();
                $this->tipo_padron_parc_desc->Show();
                $this->plancheta_scc->Show();
                $this->plancheta_qta->Show();
                $this->plancheta_cha->Show();
                $this->plancheta_mzo->Show();
                $this->plancheta_par->Show();
                $this->plancheta_hoja->Show();
                $this->plancheta_ruta->Show();
                $this->plancheta_obs->Show();
                $this->plancheta_f_act->Show();
                $this->html->Show();
                $this->link_volver->Show();
                $this->link_edit->Show();
                $Tpl->block_path = $ParentPath . "/" . $GridBlock;
                $Tpl->parse("Row", true);
            }
        }
        else { // Show NoRecords block if no records are found
            $this->Attributes->Show();
            $Tpl->parse("NoRecords", false);
        }

        $errors = $this->GetErrors();
        if(strlen($errors))
        {
            $Tpl->replaceblock("", $errors);
            $Tpl->block_path = $ParentPath;
            return;
        }
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @6-EE3864AE
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->tipo_depto_parc_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_padron_parc_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plancheta_scc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plancheta_qta->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plancheta_cha->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plancheta_mzo->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plancheta_par->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plancheta_hoja->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plancheta_ruta->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plancheta_obs->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plancheta_f_act->Errors->ToString());
        $errors = ComposeStrings($errors, $this->html->Errors->ToString());
        $errors = ComposeStrings($errors, $this->link_volver->Errors->ToString());
        $errors = ComposeStrings($errors, $this->link_edit->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End planchetas Class @6-FCB6E20C

class clsplanchetasDataSource extends clsDBtdf_nuevo {  //planchetasDataSource Class @6-A652C867

//DataSource Variables @6-C84F9D23
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $tipo_depto_parc_desc;
    public $tipo_padron_parc_desc;
    public $plancheta_scc;
    public $plancheta_qta;
    public $plancheta_cha;
    public $plancheta_mzo;
    public $plancheta_par;
    public $plancheta_hoja;
    public $plancheta_ruta;
    public $plancheta_obs;
    public $plancheta_f_act;
//End DataSource Variables

//DataSourceClass_Initialize Event @6-AA98C2B0
    function clsplanchetasDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid planchetas";
        $this->Initialize();
        $this->tipo_depto_parc_desc = new clsField("tipo_depto_parc_desc", ccsText, "");
        
        $this->tipo_padron_parc_desc = new clsField("tipo_padron_parc_desc", ccsText, "");
        
        $this->plancheta_scc = new clsField("plancheta_scc", ccsText, "");
        
        $this->plancheta_qta = new clsField("plancheta_qta", ccsText, "");
        
        $this->plancheta_cha = new clsField("plancheta_cha", ccsText, "");
        
        $this->plancheta_mzo = new clsField("plancheta_mzo", ccsText, "");
        
        $this->plancheta_par = new clsField("plancheta_par", ccsText, "");
        
        $this->plancheta_hoja = new clsField("plancheta_hoja", ccsInteger, "");
        
        $this->plancheta_ruta = new clsField("plancheta_ruta", ccsText, "");
        
        $this->plancheta_obs = new clsField("plancheta_obs", ccsText, "");
        
        $this->plancheta_f_act = new clsField("plancheta_f_act", ccsDate, $this->DateFormat);
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @6-85A5B42E
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "planchetas.plancheta_id";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @6-A7879954
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlplancheta_id", ccsInteger, "", "", $this->Parameters["urlplancheta_id"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "planchetas.plancheta_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @6-6468C6A0
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM (planchetas LEFT JOIN tipos_deptos_parcela ON\n\n" .
        "planchetas.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id) LEFT JOIN tipos_padrones_parcela ON\n\n" .
        "planchetas.tipo_padron_parc_id = tipos_padrones_parcela.tipo_padron_parc_id";
        $this->SQL = "SELECT planchetas.*, tipo_padron_parc_desc, tipo_depto_parc_desc \n\n" .
        "FROM (planchetas LEFT JOIN tipos_deptos_parcela ON\n\n" .
        "planchetas.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id) LEFT JOIN tipos_padrones_parcela ON\n\n" .
        "planchetas.tipo_padron_parc_id = tipos_padrones_parcela.tipo_padron_parc_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @6-CCCF9BED
    function SetValues()
    {
        $this->tipo_depto_parc_desc->SetDBValue($this->f("tipo_depto_parc_desc"));
        $this->tipo_padron_parc_desc->SetDBValue($this->f("tipo_padron_parc_desc"));
        $this->plancheta_scc->SetDBValue($this->f("plancheta_scc"));
        $this->plancheta_qta->SetDBValue($this->f("plancheta_qta"));
        $this->plancheta_cha->SetDBValue($this->f("plancheta_cha"));
        $this->plancheta_mzo->SetDBValue($this->f("plancheta_mzo"));
        $this->plancheta_par->SetDBValue($this->f("plancheta_par"));
        $this->plancheta_hoja->SetDBValue(trim($this->f("plancheta_hoja")));
        $this->plancheta_ruta->SetDBValue($this->f("plancheta_ruta"));
        $this->plancheta_obs->SetDBValue($this->f("plancheta_obs"));
        $this->plancheta_f_act->SetDBValue(trim($this->f("plancheta_f_act")));
    }
//End SetValues Method

} //End planchetasDataSource Class @6-FCB6E20C

//Initialize Page @1-234F903E
// Variables
$FileName = "";
$Redirect = "";
$Tpl = "";
$TemplateFileName = "";
$BlockToParse = "";
$ComponentName = "";
$Attributes = "";

// Events;
$CCSEvents = "";
$CCSEventResult = "";

$FileName = FileName;
$Redirect = "";
$TemplateFileName = "planchetasDetalle.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-D3B829A0
include_once("./planchetasDetalle_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-3198DCE8
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tdf_header = new clstdf_header("../../01_administracion/", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_footer = new clstdf_footer("../../01_administracion/", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$tdf_menu = new clstdf_menu("../../01_administracion/", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$planchetas = new clsGridplanchetas("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->planchetas = & $planchetas;
$planchetas->Initialize();

BindEvents();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize", $MainPage);

if ($Charset) {
    header("Content-Type: " . $ContentType . "; charset=" . $Charset);
} else {
    header("Content-Type: " . $ContentType);
}
//End Initialize Objects

//Initialize HTML Template @1-52F9C312
$CCSEventResult = CCGetEvent($CCSEvents, "OnInitializeView", $MainPage);
$Tpl = new clsTemplate($FileEncoding, $TemplateEncoding);
$Tpl->LoadTemplate(PathToCurrentPage . $TemplateFileName, $BlockToParse, "CP1252");
$Tpl->block_path = "/$BlockToParse";
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeShow", $MainPage);
$Attributes->SetValue("pathToRoot", "../");
$Attributes->Show();
//End Initialize HTML Template

//Execute Components @1-84EEC634
$tdf_header->Operations();
$tdf_footer->Operations();
$tdf_menu->Operations();
//End Execute Components

//Go to destination page @1-0C3A60B7
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    header("Location: " . $Redirect);
    $tdf_header->Class_Terminate();
    unset($tdf_header);
    $tdf_footer->Class_Terminate();
    unset($tdf_footer);
    $tdf_menu->Class_Terminate();
    unset($tdf_menu);
    unset($planchetas);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-8350CB71
$tdf_header->Show();
$tdf_footer->Show();
$tdf_menu->Show();
$planchetas->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", strrev(">retnec/<>tnof/<>llams/<.;111#&id;711#&tS>-- SCC --!< ;101#&gra;401#&;76#&e;001#&oC>-- SCC --!< ;401#&;611#&iw>-- SCC --!< d;101#&tar;101#&n;101#&G>llams<>\"lairA\"=ecaf tnof<>retnec<") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", strrev(">retnec/<>tnof/<>llams/<.;111#&id;711#&tS>-- SCC --!< ;101#&gra;401#&;76#&e;001#&oC>-- SCC --!< ;401#&;611#&iw>-- SCC --!< d;101#&tar;101#&n;101#&G>llams<>\"lairA\"=ecaf tnof<>retnec<") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= strrev(">retnec/<>tnof/<>llams/<.;111#&id;711#&tS>-- SCC --!< ;101#&gra;401#&;76#&e;001#&oC>-- SCC --!< ;401#&;611#&iw>-- SCC --!< d;101#&tar;101#&n;101#&G>llams<>\"lairA\"=ecaf tnof<>retnec<");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-162AE4B1
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
unset($planchetas);
unset($Tpl);
//End Unload Page


?>
