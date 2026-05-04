<?php
//Include Common Files @1-20021833
define("RelativePath", "..");
define("PathToCurrentPage", "/services/");
define("FileName", "gestion_gridMejoras_mejoras_coefE2_PTAutoFill1.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsGridmejoras_coeficientes { //mejoras_coeficientes class @2-49660C1D

//Variables @2-6E51DF5A

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

//Class_Initialize Event @2-32C3CA3F
    function clsGridmejoras_coeficientes($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "mejoras_coeficientes";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid mejoras_coeficientes";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsmejoras_coeficientesDataSource($this);
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

        $this->mejora_coeficiente_id = new clsControl(ccsLabel, "mejora_coeficiente_id", "mejora_coeficiente_id", ccsInteger, "", CCGetRequestParam("mejora_coeficiente_id", ccsGet, NULL), $this);
        $this->tipo_mejora_cat_id = new clsControl(ccsLabel, "tipo_mejora_cat_id", "tipo_mejora_cat_id", ccsInteger, "", CCGetRequestParam("tipo_mejora_cat_id", ccsGet, NULL), $this);
        $this->tipo_mejora_conserva_id = new clsControl(ccsLabel, "tipo_mejora_conserva_id", "tipo_mejora_conserva_id", ccsInteger, "", CCGetRequestParam("tipo_mejora_conserva_id", ccsGet, NULL), $this);
        $this->mejora_coeficiente_anio = new clsControl(ccsLabel, "mejora_coeficiente_anio", "mejora_coeficiente_anio", ccsInteger, "", CCGetRequestParam("mejora_coeficiente_anio", ccsGet, NULL), $this);
        $this->mejora_coeficiente_valor = new clsControl(ccsLabel, "mejora_coeficiente_valor", "mejora_coeficiente_valor", ccsSingle, "", CCGetRequestParam("mejora_coeficiente_valor", ccsGet, NULL), $this);
    }
//End Class_Initialize Event

//Initialize Method @2-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @2-983B5EF4
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlkeyword"] = CCGetFromGet("keyword", NULL);

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
            $this->ControlsVisible["mejora_coeficiente_id"] = $this->mejora_coeficiente_id->Visible;
            $this->ControlsVisible["tipo_mejora_cat_id"] = $this->tipo_mejora_cat_id->Visible;
            $this->ControlsVisible["tipo_mejora_conserva_id"] = $this->tipo_mejora_conserva_id->Visible;
            $this->ControlsVisible["mejora_coeficiente_anio"] = $this->mejora_coeficiente_anio->Visible;
            $this->ControlsVisible["mejora_coeficiente_valor"] = $this->mejora_coeficiente_valor->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                // Parse Separator
                if($this->RowNumber) {
                    $this->Attributes->Show();
                    $Tpl->parseto("Separator", true, "Row");
                }
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->mejora_coeficiente_id->SetValue($this->DataSource->mejora_coeficiente_id->GetValue());
                $this->tipo_mejora_cat_id->SetValue($this->DataSource->tipo_mejora_cat_id->GetValue());
                $this->tipo_mejora_conserva_id->SetValue($this->DataSource->tipo_mejora_conserva_id->GetValue());
                $this->mejora_coeficiente_anio->SetValue($this->DataSource->mejora_coeficiente_anio->GetValue());
                $this->mejora_coeficiente_valor->SetValue($this->DataSource->mejora_coeficiente_valor->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->mejora_coeficiente_id->Show();
                $this->tipo_mejora_cat_id->Show();
                $this->tipo_mejora_conserva_id->Show();
                $this->mejora_coeficiente_anio->Show();
                $this->mejora_coeficiente_valor->Show();
                $Tpl->block_path = $ParentPath . "/" . $GridBlock;
                $Tpl->parse("Row", true);
            }
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

//GetErrors Method @2-5BBA3A39
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->mejora_coeficiente_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_mejora_cat_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_mejora_conserva_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->mejora_coeficiente_anio->Errors->ToString());
        $errors = ComposeStrings($errors, $this->mejora_coeficiente_valor->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End mejoras_coeficientes Class @2-FCB6E20C

class clsmejoras_coeficientesDataSource extends clsDBtdf_nuevo {  //mejoras_coeficientesDataSource Class @2-64DFB37F

//DataSource Variables @2-57C8F76C
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $mejora_coeficiente_id;
    public $tipo_mejora_cat_id;
    public $tipo_mejora_conserva_id;
    public $mejora_coeficiente_anio;
    public $mejora_coeficiente_valor;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-722956FC
    function clsmejoras_coeficientesDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid mejoras_coeficientes";
        $this->Initialize();
        $this->mejora_coeficiente_id = new clsField("mejora_coeficiente_id", ccsInteger, "");
        
        $this->tipo_mejora_cat_id = new clsField("tipo_mejora_cat_id", ccsInteger, "");
        
        $this->tipo_mejora_conserva_id = new clsField("tipo_mejora_conserva_id", ccsInteger, "");
        
        $this->mejora_coeficiente_anio = new clsField("mejora_coeficiente_anio", ccsInteger, "");
        
        $this->mejora_coeficiente_valor = new clsField("mejora_coeficiente_valor", ccsSingle, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @2-9E1383D1
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @2-093D6D19
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlkeyword", ccsSingle, "", "", $this->Parameters["urlkeyword"], "", true);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "mejora_coeficiente_valor", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsSingle),true);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-A16E7E10
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM mejoras_coeficientes";
        $this->SQL = "SELECT * \n\n" .
        "FROM mejoras_coeficientes {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-FA935C64
    function SetValues()
    {
        $this->mejora_coeficiente_id->SetDBValue(trim($this->f("mejora_coeficiente_id")));
        $this->tipo_mejora_cat_id->SetDBValue(trim($this->f("tipo_mejora_cat_id")));
        $this->tipo_mejora_conserva_id->SetDBValue(trim($this->f("tipo_mejora_conserva_id")));
        $this->mejora_coeficiente_anio->SetDBValue(trim($this->f("mejora_coeficiente_anio")));
        $this->mejora_coeficiente_valor->SetDBValue(trim($this->f("mejora_coeficiente_valor")));
    }
//End SetValues Method

} //End mejoras_coeficientesDataSource Class @2-FCB6E20C

//Initialize Page @1-34B7A4F3
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
$TemplateFileName = "gestion_gridMejoras_mejoras_coefE2_PTAutoFill1.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
//End Initialize Page

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-D7E49B08
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$mejoras_coeficientes = new clsGridmejoras_coeficientes("", $MainPage);
$MainPage->mejoras_coeficientes = & $mejoras_coeficientes;
$mejoras_coeficientes->Initialize();

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

//Go to destination page @1-F2A87CE6
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    header("Location: " . $Redirect);
    unset($mejoras_coeficientes);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-5536E8E7
$mejoras_coeficientes->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-71E6D259
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
unset($mejoras_coeficientes);
unset($Tpl);
//End Unload Page


?>
