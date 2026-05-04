<?php
//Include Common Files @1-2AA6CCFD
define("RelativePath", "..");
define("PathToCurrentPage", "/planchetas/");
define("FileName", "planchetasGrid.php");
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

//Variables @6-D847A625

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
    public $Sorter_tipo_padron_parc_id;
    public $Sorter_plancheta_scc;
    public $Sorter_plancheta_qta;
    public $Sorter_plancheta_cha;
    public $Sorter_plancheta_mzo;
    public $Sorter_plancheta_par;
    public $Sorter_plancheta_hoja;
    public $Sorter_plancheta_ruta;
    public $Sorter_plancheta_f_act;
    public $Sorter_tipo_depto_parc_id;
//End Variables

//Class_Initialize Event @6-7952FA27
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
        $this->SorterName = CCGetParam("planchetasOrder", "");
        $this->SorterDirection = CCGetParam("planchetasDir", "");

        $this->tipo_depto_parc_desc = new clsControl(ccsLabel, "tipo_depto_parc_desc", "tipo_depto_parc_desc", ccsText, "", CCGetRequestParam("tipo_depto_parc_desc", ccsGet, NULL), $this);
        $this->tipo_padron_parc_desc = new clsControl(ccsLabel, "tipo_padron_parc_desc", "tipo_padron_parc_desc", ccsText, "", CCGetRequestParam("tipo_padron_parc_desc", ccsGet, NULL), $this);
        $this->plancheta_scc = new clsControl(ccsLabel, "plancheta_scc", "plancheta_scc", ccsText, "", CCGetRequestParam("plancheta_scc", ccsGet, NULL), $this);
        $this->plancheta_qta = new clsControl(ccsLabel, "plancheta_qta", "plancheta_qta", ccsText, "", CCGetRequestParam("plancheta_qta", ccsGet, NULL), $this);
        $this->plancheta_cha = new clsControl(ccsLabel, "plancheta_cha", "plancheta_cha", ccsText, "", CCGetRequestParam("plancheta_cha", ccsGet, NULL), $this);
        $this->plancheta_mzo = new clsControl(ccsLabel, "plancheta_mzo", "plancheta_mzo", ccsText, "", CCGetRequestParam("plancheta_mzo", ccsGet, NULL), $this);
        $this->plancheta_par = new clsControl(ccsLabel, "plancheta_par", "plancheta_par", ccsText, "", CCGetRequestParam("plancheta_par", ccsGet, NULL), $this);
        $this->plancheta_hoja = new clsControl(ccsLabel, "plancheta_hoja", "plancheta_hoja", ccsInteger, "", CCGetRequestParam("plancheta_hoja", ccsGet, NULL), $this);
        $this->plancheta_ruta = new clsControl(ccsLabel, "plancheta_ruta", "plancheta_ruta", ccsText, "", CCGetRequestParam("plancheta_ruta", ccsGet, NULL), $this);
        $this->plancheta_f_act = new clsControl(ccsLabel, "plancheta_f_act", "plancheta_f_act", ccsDate, array("dd", "/", "mm", "/", "yyyy", " ", "h", ":", "nn", " ", "AM/PM"), CCGetRequestParam("plancheta_f_act", ccsGet, NULL), $this);
        $this->html = new clsControl(ccsLabel, "html", "html", ccsText, "", CCGetRequestParam("html", ccsGet, NULL), $this);
        $this->html->HTML = true;
        $this->link_editar = new clsControl(ccsImageLink, "link_editar", "link_editar", ccsText, "", CCGetRequestParam("link_editar", ccsGet, NULL), $this);
        $this->link_editar->Page = "planchetasEdit.php";
        $this->link_detalle = new clsControl(ccsImageLink, "link_detalle", "link_detalle", ccsText, "", CCGetRequestParam("link_detalle", ccsGet, NULL), $this);
        $this->link_detalle->Page = "planchetasDetalle.php";
        $this->link_print = new clsControl(ccsImageLink, "link_print", "link_print", ccsText, "", CCGetRequestParam("link_print", ccsGet, NULL), $this);
        $this->link_print->Page = "../reportes/rpt_plancheta.php";
        $this->Sorter_tipo_padron_parc_id = new clsSorter($this->ComponentName, "Sorter_tipo_padron_parc_id", $FileName, $this);
        $this->Sorter_plancheta_scc = new clsSorter($this->ComponentName, "Sorter_plancheta_scc", $FileName, $this);
        $this->Sorter_plancheta_qta = new clsSorter($this->ComponentName, "Sorter_plancheta_qta", $FileName, $this);
        $this->Sorter_plancheta_cha = new clsSorter($this->ComponentName, "Sorter_plancheta_cha", $FileName, $this);
        $this->Sorter_plancheta_mzo = new clsSorter($this->ComponentName, "Sorter_plancheta_mzo", $FileName, $this);
        $this->Sorter_plancheta_par = new clsSorter($this->ComponentName, "Sorter_plancheta_par", $FileName, $this);
        $this->Sorter_plancheta_hoja = new clsSorter($this->ComponentName, "Sorter_plancheta_hoja", $FileName, $this);
        $this->Sorter_plancheta_ruta = new clsSorter($this->ComponentName, "Sorter_plancheta_ruta", $FileName, $this);
        $this->Sorter_plancheta_f_act = new clsSorter($this->ComponentName, "Sorter_plancheta_f_act", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->Sorter_tipo_depto_parc_id = new clsSorter($this->ComponentName, "Sorter_tipo_depto_parc_id", $FileName, $this);
        $this->link_detalle1 = new clsControl(ccsImageLink, "link_detalle1", "link_detalle1", ccsText, "", CCGetRequestParam("link_detalle1", ccsGet, NULL), $this);
        $this->link_detalle1->Parameters = CCGetQueryString("QueryString", array("plancheta_id", "ccsForm"));
        $this->link_detalle1->Page = "planchetasEdit.php";
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

//Show Method @6-F4055E39
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urls_plancheta_id"] = CCGetFromGet("s_plancheta_id", NULL);
        $this->DataSource->Parameters["urls_tipo_depto_parc_id"] = CCGetFromGet("s_tipo_depto_parc_id", NULL);
        $this->DataSource->Parameters["urls_tipo_padron_parc_id"] = CCGetFromGet("s_tipo_padron_parc_id", NULL);
        $this->DataSource->Parameters["urls_plancheta_scc"] = CCGetFromGet("s_plancheta_scc", NULL);
        $this->DataSource->Parameters["urls_plancheta_qta"] = CCGetFromGet("s_plancheta_qta", NULL);
        $this->DataSource->Parameters["urls_plancheta_cha"] = CCGetFromGet("s_plancheta_cha", NULL);
        $this->DataSource->Parameters["urls_plancheta_mzo"] = CCGetFromGet("s_plancheta_mzo", NULL);
        $this->DataSource->Parameters["urls_plancheta_par"] = CCGetFromGet("s_plancheta_par", NULL);
        $this->DataSource->Parameters["urls_plancheta_hoja"] = CCGetFromGet("s_plancheta_hoja", NULL);
        $this->DataSource->Parameters["urls_plancheta_ruta"] = CCGetFromGet("s_plancheta_ruta", NULL);
        $this->DataSource->Parameters["urls_plancheta_obs"] = CCGetFromGet("s_plancheta_obs", NULL);
        $this->DataSource->Parameters["urls_plancheta_file"] = CCGetFromGet("s_plancheta_file", NULL);
        $this->DataSource->Parameters["urls_plancheta_f_act"] = CCGetFromGet("s_plancheta_f_act", NULL);

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
            $this->ControlsVisible["plancheta_f_act"] = $this->plancheta_f_act->Visible;
            $this->ControlsVisible["html"] = $this->html->Visible;
            $this->ControlsVisible["link_editar"] = $this->link_editar->Visible;
            $this->ControlsVisible["link_detalle"] = $this->link_detalle->Visible;
            $this->ControlsVisible["link_print"] = $this->link_print->Visible;
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
                $this->plancheta_f_act->SetValue($this->DataSource->plancheta_f_act->GetValue());
                $this->html->SetValue($this->DataSource->html->GetValue());
                $this->link_editar->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->link_editar->Parameters = CCAddParam($this->link_editar->Parameters, "plancheta_id", $this->DataSource->f("plancheta_id"));
                $this->link_detalle->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->link_detalle->Parameters = CCAddParam($this->link_detalle->Parameters, "plancheta_id", $this->DataSource->f("plancheta_id"));
                $this->link_print->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->link_print->Parameters = CCAddParam($this->link_print->Parameters, "plancheta_id", $this->DataSource->f("plancheta_id"));
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
                $this->plancheta_f_act->Show();
                $this->html->Show();
                $this->link_editar->Show();
                $this->link_detalle->Show();
                $this->link_print->Show();
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
        $this->Navigator->PageNumber = $this->DataSource->AbsolutePage;
        $this->Navigator->PageSize = $this->PageSize;
        if ($this->DataSource->RecordsCount == "CCS not counted")
            $this->Navigator->TotalPages = $this->DataSource->AbsolutePage + ($this->DataSource->next_record() ? 1 : 0);
        else
            $this->Navigator->TotalPages = $this->DataSource->PageCount();
        if ($this->Navigator->TotalPages <= 1) {
            $this->Navigator->Visible = false;
        }
        $this->Sorter_tipo_padron_parc_id->Show();
        $this->Sorter_plancheta_scc->Show();
        $this->Sorter_plancheta_qta->Show();
        $this->Sorter_plancheta_cha->Show();
        $this->Sorter_plancheta_mzo->Show();
        $this->Sorter_plancheta_par->Show();
        $this->Sorter_plancheta_hoja->Show();
        $this->Sorter_plancheta_ruta->Show();
        $this->Sorter_plancheta_f_act->Show();
        $this->Navigator->Show();
        $this->Sorter_tipo_depto_parc_id->Show();
        $this->link_detalle1->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @6-4884C5EF
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
        $errors = ComposeStrings($errors, $this->plancheta_f_act->Errors->ToString());
        $errors = ComposeStrings($errors, $this->html->Errors->ToString());
        $errors = ComposeStrings($errors, $this->link_editar->Errors->ToString());
        $errors = ComposeStrings($errors, $this->link_detalle->Errors->ToString());
        $errors = ComposeStrings($errors, $this->link_print->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End planchetas Class @6-FCB6E20C

class clsplanchetasDataSource extends clsDBtdf_nuevo {  //planchetasDataSource Class @6-A652C867

//DataSource Variables @6-AF5B497D
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
    public $plancheta_f_act;
    public $html;
//End DataSource Variables

//DataSourceClass_Initialize Event @6-46E23FD6
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
        
        $this->plancheta_f_act = new clsField("plancheta_f_act", ccsDate, $this->DateFormat);
        
        $this->html = new clsField("html", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @6-BBDDD55C
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "planchetas.tipo_depto_parc_id, planchetas.tipo_padron_parc_id, plancheta_scc, plancheta_mzo, plancheta_par";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_tipo_padron_parc_id" => array("tipo_padron_parc_id", ""), 
            "Sorter_plancheta_scc" => array("plancheta_scc", ""), 
            "Sorter_plancheta_qta" => array("plancheta_qta", ""), 
            "Sorter_plancheta_cha" => array("plancheta_cha", ""), 
            "Sorter_plancheta_mzo" => array("plancheta_mzo", ""), 
            "Sorter_plancheta_par" => array("plancheta_par", ""), 
            "Sorter_plancheta_hoja" => array("plancheta_hoja", ""), 
            "Sorter_plancheta_ruta" => array("plancheta_ruta", ""), 
            "Sorter_plancheta_f_act" => array("plancheta_f_act", ""), 
            "Sorter_tipo_depto_parc_id" => array("tipo_depto_parc_desc", "")));
    }
//End SetOrder Method

//Prepare Method @6-1F97A0EC
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_plancheta_id", ccsInteger, "", "", $this->Parameters["urls_plancheta_id"], "", false);
        $this->wp->AddParameter("2", "urls_tipo_depto_parc_id", ccsInteger, "", "", $this->Parameters["urls_tipo_depto_parc_id"], "", false);
        $this->wp->AddParameter("3", "urls_tipo_padron_parc_id", ccsInteger, "", "", $this->Parameters["urls_tipo_padron_parc_id"], "", false);
        $this->wp->AddParameter("4", "urls_plancheta_scc", ccsText, "", "", $this->Parameters["urls_plancheta_scc"], "", false);
        $this->wp->AddParameter("5", "urls_plancheta_qta", ccsText, "", "", $this->Parameters["urls_plancheta_qta"], "", false);
        $this->wp->AddParameter("6", "urls_plancheta_cha", ccsText, "", "", $this->Parameters["urls_plancheta_cha"], "", false);
        $this->wp->AddParameter("7", "urls_plancheta_mzo", ccsText, "", "", $this->Parameters["urls_plancheta_mzo"], "", false);
        $this->wp->AddParameter("8", "urls_plancheta_par", ccsText, "", "", $this->Parameters["urls_plancheta_par"], "", false);
        $this->wp->AddParameter("9", "urls_plancheta_hoja", ccsInteger, "", "", $this->Parameters["urls_plancheta_hoja"], "", false);
        $this->wp->AddParameter("10", "urls_plancheta_ruta", ccsText, "", "", $this->Parameters["urls_plancheta_ruta"], "", false);
        $this->wp->AddParameter("11", "urls_plancheta_obs", ccsText, "", "", $this->Parameters["urls_plancheta_obs"], "", false);
        $this->wp->AddParameter("12", "urls_plancheta_file", ccsText, "", "", $this->Parameters["urls_plancheta_file"], "", false);
        $this->wp->AddParameter("13", "urls_plancheta_f_act", ccsDate, $DefaultDateFormat, $this->DateFormat, $this->Parameters["urls_plancheta_f_act"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "planchetas.plancheta_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "planchetas.tipo_depto_parc_id", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
        $this->wp->Criterion[3] = $this->wp->Operation(opEqual, "planchetas.tipo_padron_parc_id", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsInteger),false);
        $this->wp->Criterion[4] = $this->wp->Operation(opContains, "planchetas.plancheta_scc", $this->wp->GetDBValue("4"), $this->ToSQL($this->wp->GetDBValue("4"), ccsText),false);
        $this->wp->Criterion[5] = $this->wp->Operation(opContains, "planchetas.plancheta_qta", $this->wp->GetDBValue("5"), $this->ToSQL($this->wp->GetDBValue("5"), ccsText),false);
        $this->wp->Criterion[6] = $this->wp->Operation(opContains, "planchetas.plancheta_cha", $this->wp->GetDBValue("6"), $this->ToSQL($this->wp->GetDBValue("6"), ccsText),false);
        $this->wp->Criterion[7] = $this->wp->Operation(opContains, "planchetas.plancheta_mzo", $this->wp->GetDBValue("7"), $this->ToSQL($this->wp->GetDBValue("7"), ccsText),false);
        $this->wp->Criterion[8] = $this->wp->Operation(opContains, "planchetas.plancheta_par", $this->wp->GetDBValue("8"), $this->ToSQL($this->wp->GetDBValue("8"), ccsText),false);
        $this->wp->Criterion[9] = $this->wp->Operation(opEqual, "planchetas.plancheta_hoja", $this->wp->GetDBValue("9"), $this->ToSQL($this->wp->GetDBValue("9"), ccsInteger),false);
        $this->wp->Criterion[10] = $this->wp->Operation(opContains, "planchetas.plancheta_ruta", $this->wp->GetDBValue("10"), $this->ToSQL($this->wp->GetDBValue("10"), ccsText),false);
        $this->wp->Criterion[11] = $this->wp->Operation(opContains, "planchetas.plancheta_obs", $this->wp->GetDBValue("11"), $this->ToSQL($this->wp->GetDBValue("11"), ccsText),false);
        $this->wp->Criterion[12] = $this->wp->Operation(opContains, "planchetas.plancheta_file", $this->wp->GetDBValue("12"), $this->ToSQL($this->wp->GetDBValue("12"), ccsText),false);
        $this->wp->Criterion[13] = $this->wp->Operation(opEqual, "planchetas.plancheta_f_act", $this->wp->GetDBValue("13"), $this->ToSQL($this->wp->GetDBValue("13"), ccsDate),false);
        $this->Where = $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]), 
             $this->wp->Criterion[3]), 
             $this->wp->Criterion[4]), 
             $this->wp->Criterion[5]), 
             $this->wp->Criterion[6]), 
             $this->wp->Criterion[7]), 
             $this->wp->Criterion[8]), 
             $this->wp->Criterion[9]), 
             $this->wp->Criterion[10]), 
             $this->wp->Criterion[11]), 
             $this->wp->Criterion[12]), 
             $this->wp->Criterion[13]);
    }
//End Prepare Method

//Open Method @6-83D7E3A5
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM (planchetas INNER JOIN tipos_deptos_parcela ON\n\n" .
        "planchetas.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id) INNER JOIN tipos_padrones_parcela ON\n\n" .
        "planchetas.tipo_padron_parc_id = tipos_padrones_parcela.tipo_padron_parc_id";
        $this->SQL = "SELECT planchetas.*, tipo_depto_parc_desc, tipo_padron_parc_desc \n\n" .
        "FROM (planchetas INNER JOIN tipos_deptos_parcela ON\n\n" .
        "planchetas.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id) INNER JOIN tipos_padrones_parcela ON\n\n" .
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

//SetValues Method @6-18B61EA7
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
        $this->plancheta_f_act->SetDBValue(trim($this->f("plancheta_f_act")));
        $this->html->SetDBValue($this->f("plancheta_hoja"));
    }
//End SetValues Method

} //End planchetasDataSource Class @6-FCB6E20C

class clsRecordplanchetasSearch { //planchetasSearch Class @7-826220DA

//Variables @7-9E315808

    // Public variables
    public $ComponentType = "Record";
    public $ComponentName;
    public $Parent;
    public $HTMLFormAction;
    public $PressedButton;
    public $Errors;
    public $ErrorBlock;
    public $FormSubmitted;
    public $FormEnctype;
    public $Visible;
    public $IsEmpty;

    public $CCSEvents = "";
    public $CCSEventResult;

    public $RelativePath = "";

    public $InsertAllowed = false;
    public $UpdateAllowed = false;
    public $DeleteAllowed = false;
    public $ReadAllowed   = false;
    public $EditMode      = false;
    public $ds;
    public $DataSource;
    public $ValidatingControls;
    public $Controls;
    public $Attributes;

    // Class variables
//End Variables

//Class_Initialize Event @7-0E7F4D1A
    function clsRecordplanchetasSearch($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record planchetasSearch/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "planchetasSearch";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
            $this->s_tipo_depto_parc_id = new clsControl(ccsListBox, "s_tipo_depto_parc_id", "s_tipo_depto_parc_id", ccsInteger, "", CCGetRequestParam("s_tipo_depto_parc_id", $Method, NULL), $this);
            $this->s_tipo_depto_parc_id->DSType = dsTable;
            $this->s_tipo_depto_parc_id->DataSource = new clsDBtdf_nuevo();
            $this->s_tipo_depto_parc_id->ds = & $this->s_tipo_depto_parc_id->DataSource;
            $this->s_tipo_depto_parc_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_deptos_parcela {SQL_Where} {SQL_OrderBy}";
            list($this->s_tipo_depto_parc_id->BoundColumn, $this->s_tipo_depto_parc_id->TextColumn, $this->s_tipo_depto_parc_id->DBFormat) = array("tipo_depto_parc_id", "tipo_depto_parc_desc", "");
            $this->s_tipo_padron_parc_id = new clsControl(ccsListBox, "s_tipo_padron_parc_id", "s_tipo_padron_parc_id", ccsInteger, "", CCGetRequestParam("s_tipo_padron_parc_id", $Method, NULL), $this);
            $this->s_tipo_padron_parc_id->DSType = dsTable;
            $this->s_tipo_padron_parc_id->DataSource = new clsDBtdf_nuevo();
            $this->s_tipo_padron_parc_id->ds = & $this->s_tipo_padron_parc_id->DataSource;
            $this->s_tipo_padron_parc_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_padrones_parcela {SQL_Where} {SQL_OrderBy}";
            list($this->s_tipo_padron_parc_id->BoundColumn, $this->s_tipo_padron_parc_id->TextColumn, $this->s_tipo_padron_parc_id->DBFormat) = array("tipo_padron_parc_id", "tipo_padron_parc_desc", "");
            $this->s_plancheta_scc = new clsControl(ccsTextBox, "s_plancheta_scc", "s_plancheta_scc", ccsText, "", CCGetRequestParam("s_plancheta_scc", $Method, NULL), $this);
            $this->s_plancheta_qta = new clsControl(ccsTextBox, "s_plancheta_qta", "s_plancheta_qta", ccsText, "", CCGetRequestParam("s_plancheta_qta", $Method, NULL), $this);
            $this->s_plancheta_cha = new clsControl(ccsTextBox, "s_plancheta_cha", "s_plancheta_cha", ccsText, "", CCGetRequestParam("s_plancheta_cha", $Method, NULL), $this);
            $this->s_plancheta_mzo = new clsControl(ccsTextBox, "s_plancheta_mzo", "s_plancheta_mzo", ccsText, "", CCGetRequestParam("s_plancheta_mzo", $Method, NULL), $this);
            $this->s_plancheta_par = new clsControl(ccsTextBox, "s_plancheta_par", "s_plancheta_par", ccsText, "", CCGetRequestParam("s_plancheta_par", $Method, NULL), $this);
            $this->s_plancheta_ruta = new clsControl(ccsTextBox, "s_plancheta_ruta", "s_plancheta_ruta", ccsText, "", CCGetRequestParam("s_plancheta_ruta", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Validate Method @7-CFC25419
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_tipo_depto_parc_id->Validate() && $Validation);
        $Validation = ($this->s_tipo_padron_parc_id->Validate() && $Validation);
        $Validation = ($this->s_plancheta_scc->Validate() && $Validation);
        $Validation = ($this->s_plancheta_qta->Validate() && $Validation);
        $Validation = ($this->s_plancheta_cha->Validate() && $Validation);
        $Validation = ($this->s_plancheta_mzo->Validate() && $Validation);
        $Validation = ($this->s_plancheta_par->Validate() && $Validation);
        $Validation = ($this->s_plancheta_ruta->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_tipo_depto_parc_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_tipo_padron_parc_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_plancheta_scc->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_plancheta_qta->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_plancheta_cha->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_plancheta_mzo->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_plancheta_par->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_plancheta_ruta->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @7-A67E6FB7
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_tipo_depto_parc_id->Errors->Count());
        $errors = ($errors || $this->s_tipo_padron_parc_id->Errors->Count());
        $errors = ($errors || $this->s_plancheta_scc->Errors->Count());
        $errors = ($errors || $this->s_plancheta_qta->Errors->Count());
        $errors = ($errors || $this->s_plancheta_cha->Errors->Count());
        $errors = ($errors || $this->s_plancheta_mzo->Errors->Count());
        $errors = ($errors || $this->s_plancheta_par->Errors->Count());
        $errors = ($errors || $this->s_plancheta_ruta->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @7-ED598703
function SetPrimaryKeys($keyArray)
{
    $this->PrimaryKeys = $keyArray;
}
function GetPrimaryKeys()
{
    return $this->PrimaryKeys;
}
function GetPrimaryKey($keyName)
{
    return $this->PrimaryKeys[$keyName];
}
//End MasterDetail

//Operation Method @7-3E7CB95A
    function Operation()
    {
        if(!$this->Visible)
            return;

        global $Redirect;
        global $FileName;

        if(!$this->FormSubmitted) {
            return;
        }

        if($this->FormSubmitted) {
            $this->PressedButton = "Button_DoSearch";
            if($this->Button_DoSearch->Pressed) {
                $this->PressedButton = "Button_DoSearch";
            }
        }
        $Redirect = "planchetasGrid.php";
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "planchetasGrid.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @7-F87037BD
    function Show()
    {
        global $CCSUseAmp;
        global $Tpl;
        global $FileName;
        global $CCSLocales;
        $Error = "";

        if(!$this->Visible)
            return;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);

        $this->s_tipo_depto_parc_id->Prepare();
        $this->s_tipo_padron_parc_id->Prepare();

        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->s_tipo_depto_parc_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_tipo_padron_parc_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_plancheta_scc->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_plancheta_qta->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_plancheta_cha->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_plancheta_mzo->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_plancheta_par->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_plancheta_ruta->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Errors->ToString());
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $CCSForm = $this->EditMode ? $this->ComponentName . ":" . "Edit" : $this->ComponentName;
        $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $CCSForm);
        $Tpl->SetVar("Action", !$CCSUseAmp ? $this->HTMLFormAction : str_replace("&", "&amp;", $this->HTMLFormAction));
        $Tpl->SetVar("HTMLFormName", $this->ComponentName);
        $Tpl->SetVar("HTMLFormEnctype", $this->FormEnctype);

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_DoSearch->Show();
        $this->s_tipo_depto_parc_id->Show();
        $this->s_tipo_padron_parc_id->Show();
        $this->s_plancheta_scc->Show();
        $this->s_plancheta_qta->Show();
        $this->s_plancheta_cha->Show();
        $this->s_plancheta_mzo->Show();
        $this->s_plancheta_par->Show();
        $this->s_plancheta_ruta->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End planchetasSearch Class @7-FCB6E20C

//Initialize Page @1-23600A06
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
$TemplateFileName = "planchetasGrid.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-6F67F95A
include_once("./planchetasGrid_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-D1D2BB4A
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
$planchetasSearch = new clsRecordplanchetasSearch("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->planchetas = & $planchetas;
$MainPage->planchetasSearch = & $planchetasSearch;
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

//Execute Components @1-3D94F815
$tdf_header->Operations();
$tdf_footer->Operations();
$tdf_menu->Operations();
$planchetasSearch->Operation();
//End Execute Components

//Go to destination page @1-2C84540D
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
    unset($planchetasSearch);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-39FD4217
$tdf_header->Show();
$tdf_footer->Show();
$tdf_menu->Show();
$planchetas->Show();
$planchetasSearch->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", "<center><font face=\"Arial\"><small>G&#101;&#110;" . "erat&#101;&#100; <!-- CCS -->w&#105;&#116;&#1" . "04; <!-- SCC -->&#67;&#111;d&#101;Cha&#114;&#10" . "3;&#101; <!-- CCS -->&#83;&#116;u&#100;io.</smal" . "l></font></center>" . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", "<center><font face=\"Arial\"><small>G&#101;&#110;" . "erat&#101;&#100; <!-- CCS -->w&#105;&#116;&#1" . "04; <!-- SCC -->&#67;&#111;d&#101;Cha&#114;&#10" . "3;&#101; <!-- CCS -->&#83;&#116;u&#100;io.</smal" . "l></font></center>" . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= "<center><font face=\"Arial\"><small>G&#101;&#110;" . "erat&#101;&#100; <!-- CCS -->w&#105;&#116;&#1" . "04; <!-- SCC -->&#67;&#111;d&#101;Cha&#114;&#10" . "3;&#101; <!-- CCS -->&#83;&#116;u&#100;io.</smal" . "l></font></center>";
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-9EBBC783
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
unset($planchetas);
unset($planchetasSearch);
unset($Tpl);
//End Unload Page


?>
