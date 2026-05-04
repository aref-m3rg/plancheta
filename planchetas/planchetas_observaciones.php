<?php
//Include Common Files @1-2044CEF4
define("RelativePath", "..");
define("PathToCurrentPage", "/planchetas/");
define("FileName", "planchetas_observaciones.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @2-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

class clsRecordplanchetas_observaciones1 { //planchetas_observaciones1 Class @13-697084CB

//Variables @13-9E315808

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

//Class_Initialize Event @13-D56CF3C2
    function clsRecordplanchetas_observaciones1($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record planchetas_observaciones1/Error";
        $this->DataSource = new clsplanchetas_observaciones1DataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "planchetas_observaciones1";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->EditMode = ($FormMethod == "Edit");
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_Insert = new clsButton("Button_Insert", $Method, $this);
            $this->Button_Cancel = new clsButton("Button_Cancel", $Method, $this);
            $this->plancheta_obs_descrip = new clsControl(ccsTextArea, "plancheta_obs_descrip", "Observaciones", ccsMemo, "", CCGetRequestParam("plancheta_obs_descrip", $Method, NULL), $this);
            $this->plancheta_obs_descrip->Required = true;
            $this->usuario = new clsControl(ccsLabel, "usuario", "usuario", ccsText, "", CCGetRequestParam("usuario", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Initialize Method @13-B08FE84F
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlplancheta_obs_id"] = CCGetFromGet("plancheta_obs_id", NULL);
    }
//End Initialize Method

//Validate Method @13-2FC225B5
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->plancheta_obs_descrip->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->plancheta_obs_descrip->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @13-6223D262
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->plancheta_obs_descrip->Errors->Count());
        $errors = ($errors || $this->usuario->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @13-ED598703
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

//Operation Method @13-FD319BFD
    function Operation()
    {
        if(!$this->Visible)
            return;

        global $Redirect;
        global $FileName;

        $this->DataSource->Prepare();
        if(!$this->FormSubmitted) {
            $this->EditMode = $this->DataSource->AllParametersSet;
            return;
        }

        if($this->FormSubmitted) {
            $this->PressedButton = "Button_Insert";
            if($this->Button_Insert->Pressed) {
                $this->PressedButton = "Button_Insert";
            } else if($this->Button_Cancel->Pressed) {
                $this->PressedButton = "Button_Cancel";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Cancel") {
            $Redirect = "planchetas.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
            if(!CCGetEvent($this->Button_Cancel->CCSEvents, "OnClick", $this->Button_Cancel)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_Insert") {
                if(!CCGetEvent($this->Button_Insert->CCSEvents, "OnClick", $this->Button_Insert) || !$this->InsertRow()) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
        if ($Redirect)
            $this->DataSource->close();
    }
//End Operation Method

//InsertRow Method @13-00EB20A3
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->plancheta_obs_descrip->SetValue($this->plancheta_obs_descrip->GetValue(true));
        $this->DataSource->usuario->SetValue($this->usuario->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//Show Method @13-6E85D528
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


        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if($this->EditMode) {
            if($this->DataSource->Errors->Count()){
                $this->Errors->AddErrors($this->DataSource->Errors);
                $this->DataSource->Errors->clear();
            }
            $this->DataSource->Open();
            if($this->DataSource->Errors->Count() == 0 && $this->DataSource->next_record()) {
                $this->DataSource->SetValues();
                if(!$this->FormSubmitted){
                    $this->plancheta_obs_descrip->SetValue($this->DataSource->plancheta_obs_descrip->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->plancheta_obs_descrip->Errors->ToString());
            $Error = ComposeStrings($Error, $this->usuario->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DataSource->Errors->ToString());
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $CCSForm = $this->EditMode ? $this->ComponentName . ":" . "Edit" : $this->ComponentName;
        $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $CCSForm);
        $Tpl->SetVar("Action", !$CCSUseAmp ? $this->HTMLFormAction : str_replace("&", "&amp;", $this->HTMLFormAction));
        $Tpl->SetVar("HTMLFormName", $this->ComponentName);
        $Tpl->SetVar("HTMLFormEnctype", $this->FormEnctype);
        $this->Button_Insert->Visible = !$this->EditMode && $this->InsertAllowed;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_Insert->Show();
        $this->Button_Cancel->Show();
        $this->plancheta_obs_descrip->Show();
        $this->usuario->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End planchetas_observaciones1 Class @13-FCB6E20C

class clsplanchetas_observaciones1DataSource extends clsDBtdf_nuevo {  //planchetas_observaciones1DataSource Class @13-568D56F6

//DataSource Variables @13-B561383B
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $InsertParameters;
    public $wp;
    public $AllParametersSet;

    public $InsertFields = array();

    // Datasource fields
    public $plancheta_obs_descrip;
    public $usuario;
//End DataSource Variables

//DataSourceClass_Initialize Event @13-D6A24174
    function clsplanchetas_observaciones1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record planchetas_observaciones1/Error";
        $this->Initialize();
        $this->plancheta_obs_descrip = new clsField("plancheta_obs_descrip", ccsMemo, "");
        
        $this->usuario = new clsField("usuario", ccsText, "");
        

        $this->InsertFields["plancheta_obs_descrip"] = array("Name" => "plancheta_obs_descrip", "Value" => "", "DataType" => ccsMemo, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @13-20199862
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlplancheta_obs_id", ccsInteger, "", "", $this->Parameters["urlplancheta_obs_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "plancheta_obs_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @13-DB8621A4
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM planchetas_observaciones {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @13-409140BA
    function SetValues()
    {
        $this->plancheta_obs_descrip->SetDBValue($this->f("plancheta_obs_descrip"));
    }
//End SetValues Method

//Insert Method @13-35DE8FD1
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["plancheta_obs_descrip"]["Value"] = $this->plancheta_obs_descrip->GetDBValue(true);
        $this->SQL = CCBuildInsert("planchetas_observaciones", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

} //End planchetas_observaciones1DataSource Class @13-FCB6E20C

class clsGridplanchetas_observaciones { //planchetas_observaciones class @3-3991C746

//Variables @3-B97CE7B9

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
    public $Sorter_plancheta_obs_f;
//End Variables

//Class_Initialize Event @3-AFE85E28
    function clsGridplanchetas_observaciones($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "planchetas_observaciones";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid planchetas_observaciones";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsplanchetas_observacionesDataSource($this);
        $this->ds = & $this->DataSource;
        $this->SorterName = CCGetParam("planchetas_observacionesOrder", "");
        $this->SorterDirection = CCGetParam("planchetas_observacionesDir", "");

        $this->plancheta_obs_f = new clsControl(ccsLabel, "plancheta_obs_f", "plancheta_obs_f", ccsDate, array("dd", "/", "mm", "/", "yyyy", " ", "H", ":", "nn", ":", "ss"), CCGetRequestParam("plancheta_obs_f", ccsGet, NULL), $this);
        $this->plancheta_obs_descrip = new clsControl(ccsLabel, "plancheta_obs_descrip", "plancheta_obs_descrip", ccsMemo, "", CCGetRequestParam("plancheta_obs_descrip", ccsGet, NULL), $this);
        $this->Sorter_plancheta_obs_f = new clsSorter($this->ComponentName, "Sorter_plancheta_obs_f", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 25, tpSimple, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50", "100");
    }
//End Class_Initialize Event

//Initialize Method @3-75D22D4D
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @3-47D60F6C
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["sesuser_id"] = CCGetSession("user_id", NULL);

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
            $this->ControlsVisible["plancheta_obs_f"] = $this->plancheta_obs_f->Visible;
            $this->ControlsVisible["plancheta_obs_descrip"] = $this->plancheta_obs_descrip->Visible;
            while ($this->ForceIteration ||  ($this->HasRecord = $this->DataSource->has_next_record())) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->plancheta_obs_f->SetValue($this->DataSource->plancheta_obs_f->GetValue());
                $this->plancheta_obs_descrip->SetValue($this->DataSource->plancheta_obs_descrip->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->plancheta_obs_f->Show();
                $this->plancheta_obs_descrip->Show();
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
        $this->Sorter_plancheta_obs_f->Show();
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @3-2EB68A08
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->plancheta_obs_f->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plancheta_obs_descrip->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End planchetas_observaciones Class @3-FCB6E20C

class clsplanchetas_observacionesDataSource extends clsDBtdf_nuevo {  //planchetas_observacionesDataSource Class @3-0E09CEBE

//DataSource Variables @3-4AF84813
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $plancheta_obs_f;
    public $plancheta_obs_descrip;
//End DataSource Variables

//DataSourceClass_Initialize Event @3-A41B9F36
    function clsplanchetas_observacionesDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid planchetas_observaciones";
        $this->Initialize();
        $this->plancheta_obs_f = new clsField("plancheta_obs_f", ccsDate, $this->DateFormat);
        
        $this->plancheta_obs_descrip = new clsField("plancheta_obs_descrip", ccsMemo, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @3-86C3910E
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "plancheta_obs_f desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_plancheta_obs_f" => array("plancheta_obs_f", "")));
    }
//End SetOrder Method

//Prepare Method @3-78B76A7A
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "sesuser_id", ccsInteger, "", "", $this->Parameters["sesuser_id"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "user_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @3-7B01AAB9
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM planchetas_observaciones";
        $this->SQL = "SELECT plancheta_obs_id, plancheta_obs_f, plancheta_obs_descrip \n\n" .
        "FROM planchetas_observaciones {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @3-21DAB88F
    function SetValues()
    {
        $this->plancheta_obs_f->SetDBValue(trim($this->f("plancheta_obs_f")));
        $this->plancheta_obs_descrip->SetDBValue($this->f("plancheta_obs_descrip"));
    }
//End SetValues Method

} //End planchetas_observacionesDataSource Class @3-FCB6E20C

//Initialize Page @1-040E78F9
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
$TemplateFileName = "planchetas_observaciones.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-977082AB
include_once("./planchetas_observaciones_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-38FF034F
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$planchetas_observaciones1 = new clsRecordplanchetas_observaciones1("", $MainPage);
$planchetas_observaciones = new clsGridplanchetas_observaciones("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->planchetas_observaciones1 = & $planchetas_observaciones1;
$MainPage->planchetas_observaciones = & $planchetas_observaciones;
$planchetas_observaciones1->Initialize();
$planchetas_observaciones->Initialize();

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

//Execute Components @1-AF0861BD
$tdf_header->Operations();
$planchetas_observaciones1->Operation();
//End Execute Components

//Go to destination page @1-265547A7
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    header("Location: " . $Redirect);
    $tdf_header->Class_Terminate();
    unset($tdf_header);
    unset($planchetas_observaciones1);
    unset($planchetas_observaciones);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-9DCC6880
$tdf_header->Show();
$planchetas_observaciones1->Show();
$planchetas_observaciones->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", implode(array("<center><font fa", "ce=\"Arial\"><smal", "l>Gen&#101;ra&", "#116;&#101;&", "#100; <!-- CCS ", "-->&#119;i&#1", "16;&#104; <!--", " CCS -->C&#111;d", "&#101;&#67;har", "g&#101; <!-- CC", "S -->St&#117;&#", "100;i&#111;.", "</small></font></", "center>"), "") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", implode(array("<center><font fa", "ce=\"Arial\"><smal", "l>Gen&#101;ra&", "#116;&#101;&", "#100; <!-- CCS ", "-->&#119;i&#1", "16;&#104; <!--", " CCS -->C&#111;d", "&#101;&#67;har", "g&#101; <!-- CC", "S -->St&#117;&#", "100;i&#111;.", "</small></font></", "center>"), "") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= implode(array("<center><font fa", "ce=\"Arial\"><smal", "l>Gen&#101;ra&", "#116;&#101;&", "#100; <!-- CCS ", "-->&#119;i&#1", "16;&#104; <!--", " CCS -->C&#111;d", "&#101;&#67;har", "g&#101; <!-- CC", "S -->St&#117;&#", "100;i&#111;.", "</small></font></", "center>"), "");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-A2277552
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
unset($planchetas_observaciones1);
unset($planchetas_observaciones);
unset($Tpl);
//End Unload Page


?>
