<?php
//Include Common Files @1-DE215D9F
define("RelativePath", "..");
define("PathToCurrentPage", "/previsado/");
define("FileName", "previsados_cargas.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsRecordprevisados_cargas { //previsados_cargas Class @2-342B6A37

//Variables @2-9E315808

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

//Class_Initialize Event @2-A491E741
    function clsRecordprevisados_cargas($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record previsados_cargas/Error";
        $this->DataSource = new clsprevisados_cargasDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "previsados_cargas";
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
            $this->previsado_tipo_plano_id = new clsControl(ccsListBox, "previsado_tipo_plano_id", "Tipo de planos", ccsInteger, "", CCGetRequestParam("previsado_tipo_plano_id", $Method, NULL), $this);
            $this->previsado_tipo_plano_id->DSType = dsTable;
            $this->previsado_tipo_plano_id->DataSource = new clsDBtdf_nuevo();
            $this->previsado_tipo_plano_id->ds = & $this->previsado_tipo_plano_id->DataSource;
            $this->previsado_tipo_plano_id->DataSource->SQL = "SELECT * \n" .
"FROM previsados_tipos_planos {SQL_Where} {SQL_OrderBy}";
            list($this->previsado_tipo_plano_id->BoundColumn, $this->previsado_tipo_plano_id->TextColumn, $this->previsado_tipo_plano_id->DBFormat) = array("previsado_tipo_plano_id", "previsado_tipo_plano_descrip", "");
            $this->previsado_tipo_plano_id->DataSource->Parameters["expr21"] = 1;
            $this->previsado_tipo_plano_id->DataSource->wp = new clsSQLParameters();
            $this->previsado_tipo_plano_id->DataSource->wp->AddParameter("1", "expr21", ccsInteger, "", "", $this->previsado_tipo_plano_id->DataSource->Parameters["expr21"], "", false);
            $this->previsado_tipo_plano_id->DataSource->wp->Criterion[1] = $this->previsado_tipo_plano_id->DataSource->wp->Operation(opEqual, "tipo_estado_id", $this->previsado_tipo_plano_id->DataSource->wp->GetDBValue("1"), $this->previsado_tipo_plano_id->DataSource->ToSQL($this->previsado_tipo_plano_id->DataSource->wp->GetDBValue("1"), ccsInteger),false);
            $this->previsado_tipo_plano_id->DataSource->Where = 
                 $this->previsado_tipo_plano_id->DataSource->wp->Criterion[1];
            $this->previsado_tipo_plano_id->Required = true;
            $this->Button_cancel = new clsButton("Button_cancel", $Method, $this);
            $this->user_id = new clsControl(ccsHidden, "user_id", "user_id", ccsInteger, "", CCGetRequestParam("user_id", $Method, NULL), $this);
            if(!$this->FormSubmitted) {
                if(!is_array($this->user_id->Value) && !strlen($this->user_id->Value) && $this->user_id->Value !== false)
                    $this->user_id->SetText(CCGetSession('user_id'));
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @2-5D060BAC
    function Initialize()
    {

        if(!$this->Visible)
            return;

    }
//End Initialize Method

//Validate Method @2-1C1E2A82
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->previsado_tipo_plano_id->Validate() && $Validation);
        $Validation = ($this->user_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->previsado_tipo_plano_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->user_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @2-264BAEB8
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->previsado_tipo_plano_id->Errors->Count());
        $errors = ($errors || $this->user_id->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @2-ED598703
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

//Operation Method @2-F66E9E77
    function Operation()
    {
        if(!$this->Visible)
            return;

        global $Redirect;
        global $FileName;

        $this->DataSource->Prepare();
        if(!$this->FormSubmitted) {
            $this->EditMode = true;
            return;
        }

        if($this->FormSubmitted) {
            $this->PressedButton = "Button_Insert";
            if($this->Button_Insert->Pressed) {
                $this->PressedButton = "Button_Insert";
            } else if($this->Button_cancel->Pressed) {
                $this->PressedButton = "Button_cancel";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_cancel") {
            $Redirect = "previsados_consola.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
            if(!CCGetEvent($this->Button_cancel->CCSEvents, "OnClick", $this->Button_cancel)) {
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

//InsertRow Method @2-25C5E1F7
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->previsado_tipo_plano_id->SetValue($this->previsado_tipo_plano_id->GetValue(true));
        $this->DataSource->user_id->SetValue($this->user_id->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//Show Method @2-DB6F90EB
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

        $this->previsado_tipo_plano_id->Prepare();

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
                    $this->previsado_tipo_plano_id->SetValue($this->DataSource->previsado_tipo_plano_id->GetValue());
                    $this->user_id->SetValue($this->DataSource->user_id->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->previsado_tipo_plano_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->user_id->Errors->ToString());
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
        $this->previsado_tipo_plano_id->Show();
        $this->Button_cancel->Show();
        $this->user_id->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End previsados_cargas Class @2-FCB6E20C

class clsprevisados_cargasDataSource extends clsDBtdf_nuevo {  //previsados_cargasDataSource Class @2-D9184292

//DataSource Variables @2-96155D4F
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
    public $previsado_tipo_plano_id;
    public $user_id;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-7D1BFAF7
    function clsprevisados_cargasDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record previsados_cargas/Error";
        $this->Initialize();
        $this->previsado_tipo_plano_id = new clsField("previsado_tipo_plano_id", ccsInteger, "");
        
        $this->user_id = new clsField("user_id", ccsInteger, "");
        

        $this->InsertFields["previsado_tipo_plano_id"] = array("Name" => "previsado_tipo_plano_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["user_id"] = array("Name" => "user_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @2-14D6CD9D
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
    }
//End Prepare Method

//Open Method @2-066770A4
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM previsados_cargas {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-2210B8DF
    function SetValues()
    {
        $this->previsado_tipo_plano_id->SetDBValue(trim($this->f("previsado_tipo_plano_id")));
        $this->user_id->SetDBValue(trim($this->f("user_id")));
    }
//End SetValues Method

//Insert Method @2-6C7E67EB
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["previsado_tipo_plano_id"]["Value"] = $this->previsado_tipo_plano_id->GetDBValue(true);
        $this->InsertFields["user_id"]["Value"] = $this->user_id->GetDBValue(true);
        $this->SQL = CCBuildInsert("previsados_cargas", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

} //End previsados_cargasDataSource Class @2-FCB6E20C



//Include Page implementation @25-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @26-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

class clsGridprevisados_detalles_carga1 { //previsados_detalles_carga1 class @27-D604FAC3

//Variables @27-6E51DF5A

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

//Class_Initialize Event @27-8F68CCFC
    function clsGridprevisados_detalles_carga1($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "previsados_detalles_carga1";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid previsados_detalles_carga1";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsprevisados_detalles_carga1DataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 100;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;

        $this->previsado_requisito_id = new clsControl(ccsLabel, "previsado_requisito_id", "previsado_requisito_id", ccsInteger, "", CCGetRequestParam("previsado_requisito_id", ccsGet, NULL), $this);
        $this->previsado_requisito_id->HTML = true;
        $this->cargaimagen = new clsControl(ccsLabel, "cargaimagen", "cargaimagen", ccsText, "", CCGetRequestParam("cargaimagen", ccsGet, NULL), $this);
        $this->cargaimagen->HTML = true;
        $this->muestraimagen = new clsControl(ccsLabel, "muestraimagen", "muestraimagen", ccsText, "", CCGetRequestParam("muestraimagen", ccsGet, NULL), $this);
        $this->muestraimagen->HTML = true;
        $this->cargacad = new clsControl(ccsLabel, "cargacad", "cargacad", ccsText, "", CCGetRequestParam("cargacad", ccsGet, NULL), $this);
        $this->cargacad->HTML = true;
        $this->nombre = new clsControl(ccsLabel, "nombre", "nombre", ccsText, "", CCGetRequestParam("nombre", ccsGet, NULL), $this);
        $this->mensaje = new clsControl(ccsLabel, "mensaje", "mensaje", ccsText, "", CCGetRequestParam("mensaje", ccsGet, NULL), $this);
        $this->mensaje->HTML = true;
        $this->titulares = new clsControl(ccsLabel, "titulares", "titulares", ccsText, "", CCGetRequestParam("titulares", ccsGet, NULL), $this);
        $this->titulares->HTML = true;
        $this->nomenclatura_origen = new clsControl(ccsLabel, "nomenclatura_origen", "nomenclatura_origen", ccsText, "", CCGetRequestParam("nomenclatura_origen", ccsGet, NULL), $this);
        $this->nomenclatura_origen->HTML = true;
        $this->ImageLink1 = new clsControl(ccsImageLink, "ImageLink1", "ImageLink1", ccsText, "", CCGetRequestParam("ImageLink1", ccsGet, NULL), $this);
        $this->ImageLink1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
        $this->ImageLink1->Page = "previsados_titulares.php";
        $this->ImageLink2 = new clsControl(ccsImageLink, "ImageLink2", "ImageLink2", ccsText, "", CCGetRequestParam("ImageLink2", ccsGet, NULL), $this);
        $this->ImageLink2->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
        $this->ImageLink2->Page = "previsados_nomenclatura_origen.php";
        $this->boton = new clsControl(ccsLabel, "boton", "boton", ccsText, "", CCGetRequestParam("boton", ccsGet, NULL), $this);
        $this->boton->HTML = true;
        $this->volver = new clsControl(ccsLabel, "volver", "volver", ccsText, "", CCGetRequestParam("volver", ccsGet, NULL), $this);
        $this->volver->HTML = true;
        $this->nomenclatura_destino = new clsControl(ccsLabel, "nomenclatura_destino", "nomenclatura_destino", ccsText, "", CCGetRequestParam("nomenclatura_destino", ccsGet, NULL), $this);
        $this->nomenclatura_destino->HTML = true;
        $this->ImageLink3 = new clsControl(ccsImageLink, "ImageLink3", "ImageLink3", ccsText, "", CCGetRequestParam("ImageLink3", ccsGet, NULL), $this);
        $this->ImageLink3->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
        $this->ImageLink3->Page = "previsados_nomenclatura_destino.php";
        $this->previsado_tipo_plano_id = new clsControl(ccsListBox, "previsado_tipo_plano_id", "Tipo de planos", ccsInteger, "", CCGetRequestParam("previsado_tipo_plano_id", ccsGet, NULL), $this);
        $this->previsado_tipo_plano_id->DSType = dsTable;
        $this->previsado_tipo_plano_id->DataSource = new clsDBtdf_nuevo();
        $this->previsado_tipo_plano_id->ds = & $this->previsado_tipo_plano_id->DataSource;
        $this->previsado_tipo_plano_id->DataSource->SQL = "SELECT * \n" .
"FROM previsados_tipos_planos {SQL_Where} {SQL_OrderBy}";
        list($this->previsado_tipo_plano_id->BoundColumn, $this->previsado_tipo_plano_id->TextColumn, $this->previsado_tipo_plano_id->DBFormat) = array("previsado_tipo_plano_id", "previsado_tipo_plano_descrip", "");
        $this->previsado_tipo_plano_id->DataSource->Parameters["expr63"] = 1;
        $this->previsado_tipo_plano_id->DataSource->wp = new clsSQLParameters();
        $this->previsado_tipo_plano_id->DataSource->wp->AddParameter("1", "expr63", ccsInteger, "", "", $this->previsado_tipo_plano_id->DataSource->Parameters["expr63"], "", false);
        $this->previsado_tipo_plano_id->DataSource->wp->Criterion[1] = $this->previsado_tipo_plano_id->DataSource->wp->Operation(opEqual, "tipo_estado_id", $this->previsado_tipo_plano_id->DataSource->wp->GetDBValue("1"), $this->previsado_tipo_plano_id->DataSource->ToSQL($this->previsado_tipo_plano_id->DataSource->wp->GetDBValue("1"), ccsInteger),false);
        $this->previsado_tipo_plano_id->DataSource->Where = 
             $this->previsado_tipo_plano_id->DataSource->wp->Criterion[1];
        $this->previsado_tipo_plano_id->Required = true;
        $this->tipo_cargado = new clsControl(ccsHidden, "tipo_cargado", "tipo_cargado", ccsText, "", CCGetRequestParam("tipo_cargado", ccsGet, NULL), $this);
        $this->nomenclatura_afectacion = new clsControl(ccsLabel, "nomenclatura_afectacion", "nomenclatura_afectacion", ccsText, "", CCGetRequestParam("nomenclatura_afectacion", ccsGet, NULL), $this);
        $this->nomenclatura_afectacion->HTML = true;
        $this->ImageLink4 = new clsControl(ccsImageLink, "ImageLink4", "ImageLink4", ccsText, "", CCGetRequestParam("ImageLink4", ccsGet, NULL), $this);
        $this->ImageLink4->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
        $this->ImageLink4->Page = "previsados_nomenclatura_afectacion.php";
        $this->cant_titulares = new clsControl(ccsHidden, "cant_titulares", "cant_titulares", ccsText, "", CCGetRequestParam("cant_titulares", ccsGet, NULL), $this);
        $this->cant_origenes = new clsControl(ccsHidden, "cant_origenes", "cant_origenes", ccsText, "", CCGetRequestParam("cant_origenes", ccsGet, NULL), $this);
        $this->cant_destinos = new clsControl(ccsHidden, "cant_destinos", "cant_destinos", ccsText, "", CCGetRequestParam("cant_destinos", ccsGet, NULL), $this);
        $this->CheckBox_tfsm = new clsControl(ccsCheckBox, "CheckBox_tfsm", "CheckBox_tfsm", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), CCGetRequestParam("CheckBox_tfsm", ccsGet, NULL), $this);
        $this->CheckBox_tfsm->CheckedValue = true;
        $this->CheckBox_tfsm->UncheckedValue = false;
        $this->Label_tfsm = new clsControl(ccsLabel, "Label_tfsm", "Label_tfsm", ccsText, "", CCGetRequestParam("Label_tfsm", ccsGet, NULL), $this);
        $this->previsado_carga_id = new clsControl(ccsHidden, "previsado_carga_id", "previsado_carga_id", ccsText, "", CCGetRequestParam("previsado_carga_id", ccsGet, NULL), $this);
    }
//End Class_Initialize Event

//Initialize Method @27-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @27-5304C803
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlprevisado_carga_id"] = CCGetFromGet("previsado_carga_id", NULL);

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);

        $this->previsado_tipo_plano_id->Prepare();

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
            $this->ControlsVisible["previsado_requisito_id"] = $this->previsado_requisito_id->Visible;
            $this->ControlsVisible["cargaimagen"] = $this->cargaimagen->Visible;
            $this->ControlsVisible["muestraimagen"] = $this->muestraimagen->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->previsado_requisito_id->SetValue($this->DataSource->previsado_requisito_id->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->previsado_requisito_id->Show();
                $this->cargaimagen->Show();
                $this->muestraimagen->Show();
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
        if(!is_array($this->CheckBox_tfsm->Value) && !strlen($this->CheckBox_tfsm->Value) && $this->CheckBox_tfsm->Value !== false)
            $this->CheckBox_tfsm->SetValue(false);
        $this->cargacad->Show();
        $this->nombre->Show();
        $this->mensaje->Show();
        $this->titulares->Show();
        $this->nomenclatura_origen->Show();
        $this->ImageLink1->Show();
        $this->ImageLink2->Show();
        $this->boton->Show();
        $this->volver->Show();
        $this->nomenclatura_destino->Show();
        $this->ImageLink3->Show();
        $this->previsado_tipo_plano_id->Show();
        $this->tipo_cargado->Show();
        $this->nomenclatura_afectacion->Show();
        $this->ImageLink4->Show();
        $this->cant_titulares->Show();
        $this->cant_origenes->Show();
        $this->cant_destinos->Show();
        $this->CheckBox_tfsm->Show();
        $this->Label_tfsm->Show();
        $this->previsado_carga_id->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @27-0BD62089
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->previsado_requisito_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->cargaimagen->Errors->ToString());
        $errors = ComposeStrings($errors, $this->muestraimagen->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End previsados_detalles_carga1 Class @27-FCB6E20C

class clsprevisados_detalles_carga1DataSource extends clsDBtdf_nuevo {  //previsados_detalles_carga1DataSource Class @27-CDDFF1D5

//DataSource Variables @27-B686D2CA
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $previsado_requisito_id;
//End DataSource Variables

//DataSourceClass_Initialize Event @27-23577C68
    function clsprevisados_detalles_carga1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid previsados_detalles_carga1";
        $this->Initialize();
        $this->previsado_requisito_id = new clsField("previsado_requisito_id", ccsInteger, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @27-9E1383D1
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @27-90B0CBF1
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlprevisado_carga_id", ccsInteger, "", "", $this->Parameters["urlprevisado_carga_id"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "previsado_carga_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @27-04431B41
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM previsados_detalles_cargas";
        $this->SQL = "SELECT * \n\n" .
        "FROM previsados_detalles_cargas {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @27-19AD6172
    function SetValues()
    {
        $this->previsado_requisito_id->SetDBValue(trim($this->f("previsado_requisito_id")));
    }
//End SetValues Method

} //End previsados_detalles_carga1DataSource Class @27-FCB6E20C



//Initialize Page @1-07297496
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
$TemplateFileName = "previsados_cargas.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-8A734B4C
include_once("./previsados_cargas_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-9AF2FF97
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$previsados_cargas = new clsRecordprevisados_cargas("", $MainPage);
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$previsados_detalles_carga1 = new clsGridprevisados_detalles_carga1("", $MainPage);
$MainPage->previsados_cargas = & $previsados_cargas;
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->previsados_detalles_carga1 = & $previsados_detalles_carga1;
$previsados_cargas->Initialize();
$previsados_detalles_carga1->Initialize();

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

//Execute Components @1-6DBD1826
$previsados_cargas->Operation();
$tdf_header->Operations();
$tdf_footer->Operations();
//End Execute Components

//Go to destination page @1-D6CE1039
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    header("Location: " . $Redirect);
    unset($previsados_cargas);
    $tdf_header->Class_Terminate();
    unset($tdf_header);
    $tdf_footer->Class_Terminate();
    unset($tdf_footer);
    unset($previsados_detalles_carga1);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-8BFFD191
$previsados_cargas->Show();
$tdf_header->Show();
$tdf_footer->Show();
$previsados_detalles_carga1->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", strrev(">retnec/<>tnof/<>llams/<.;111#&;501#&;001#&u;611#&S>-- SCC --!< ;101#&;301#&;411#&a;401#&;76#&;101#&do;76#&>-- SCC --!< hti;911#&>-- CCS --!< ;001#&;101#&tareneG>llams<>\"lairA\"=ecaf tnof<>retnec<") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", strrev(">retnec/<>tnof/<>llams/<.;111#&;501#&;001#&u;611#&S>-- SCC --!< ;101#&;301#&;411#&a;401#&;76#&;101#&do;76#&>-- SCC --!< hti;911#&>-- CCS --!< ;001#&;101#&tareneG>llams<>\"lairA\"=ecaf tnof<>retnec<") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= strrev(">retnec/<>tnof/<>llams/<.;111#&;501#&;001#&u;611#&S>-- SCC --!< ;101#&;301#&;411#&a;401#&;76#&;101#&do;76#&>-- SCC --!< hti;911#&>-- CCS --!< ;001#&;101#&tareneG>llams<>\"lairA\"=ecaf tnof<>retnec<");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-24A0168D
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
unset($previsados_cargas);
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($previsados_detalles_carga1);
unset($Tpl);
//End Unload Page


?>
