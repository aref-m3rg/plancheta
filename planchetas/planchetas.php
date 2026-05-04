<?php
//Include Common Files @1-15694A91
define("RelativePath", "..");
define("PathToCurrentPage", "/planchetas/");
define("FileName", "planchetas.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files



//Include Page implementation @38-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @40-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

class clsRecordbuscar { //buscar Class @62-7506058D

//Variables @62-9E315808

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

//Class_Initialize Event @62-E391709D
    function clsRecordbuscar($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record buscar/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "buscar";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->tipo_depto_parc_id = new clsControl(ccsListBox, "tipo_depto_parc_id", "tipo_depto_parc_id", ccsText, "", CCGetRequestParam("tipo_depto_parc_id", $Method, NULL), $this);
            $this->tipo_depto_parc_id->DSType = dsTable;
            $this->tipo_depto_parc_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_depto_parc_id->ds = & $this->tipo_depto_parc_id->DataSource;
            $this->tipo_depto_parc_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_deptos_parcela {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_depto_parc_id->BoundColumn, $this->tipo_depto_parc_id->TextColumn, $this->tipo_depto_parc_id->DBFormat) = array("tipo_depto_parc_id", "tipo_depto_parc_desc", "");
            $this->parcela_seccion = new clsControl(ccsTextBox, "parcela_seccion", "parcela_seccion", ccsText, "", CCGetRequestParam("parcela_seccion", $Method, NULL), $this);
            $this->partida = new clsControl(ccsTextBox, "partida", "partida", ccsText, "", CCGetRequestParam("partida", $Method, NULL), $this);
            $this->tipo_padron_parc_id = new clsControl(ccsListBox, "tipo_padron_parc_id", "tipo_padron_parc_id", ccsInteger, "", CCGetRequestParam("tipo_padron_parc_id", $Method, NULL), $this);
            $this->tipo_padron_parc_id->DSType = dsTable;
            $this->tipo_padron_parc_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_padron_parc_id->ds = & $this->tipo_padron_parc_id->DataSource;
            $this->tipo_padron_parc_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_padrones_parcela {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_padron_parc_id->BoundColumn, $this->tipo_padron_parc_id->TextColumn, $this->tipo_padron_parc_id->DBFormat) = array("tipo_padron_parc_id", "tipo_padron_parc_abrev", "");
            $this->parcela_macizo = new clsControl(ccsTextBox, "parcela_macizo", "parcela_macizo", ccsText, "", CCGetRequestParam("parcela_macizo", $Method, NULL), $this);
            $this->parcela_chacra = new clsControl(ccsTextBox, "parcela_chacra", "parcela_chacra", ccsText, "", CCGetRequestParam("parcela_chacra", $Method, NULL), $this);
            $this->parcela_quinta = new clsControl(ccsTextBox, "parcela_quinta", "parcela_quinta", ccsText, "", CCGetRequestParam("parcela_quinta", $Method, NULL), $this);
            $this->parcela_f_proceso = new clsControl(ccsTextBox, "parcela_f_proceso", "parcela_f_proceso", ccsDate, $DefaultDateFormat, CCGetRequestParam("parcela_f_proceso", $Method, NULL), $this);
            $this->DatePicker_parcela_f_proceso1 = new clsDatePicker("DatePicker_parcela_f_proceso1", "buscar", "parcela_f_proceso", $this);
            $this->parcela_parcela = new clsControl(ccsTextBox, "parcela_parcela", "parcela_parcela", ccsText, "", CCGetRequestParam("parcela_parcela", $Method, NULL), $this);
            $this->Button_salir = new clsButton("Button_salir", $Method, $this);
            $this->Link1 = new clsControl(ccsLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", $Method, NULL), $this);
            $this->Link1->Parameters = CCGetQueryString("QueryString", array("tipo_depto_parc_id", "parcela_seccion", "parcela_macizo", "dominio", "partida", "tipo_padron_parc_id", "parcela_chacra", "parcela_quinta", "parcela_f_proceso", "parcela_parcela", "ccsForm"));
            $this->Link1->Page = "planchetas.php";
            $this->Button_Search = new clsButton("Button_Search", $Method, $this);
            $this->Button_observaciones = new clsButton("Button_observaciones", $Method, $this);
        }
    }
//End Class_Initialize Event

//Validate Method @62-79C52C56
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->tipo_depto_parc_id->Validate() && $Validation);
        $Validation = ($this->parcela_seccion->Validate() && $Validation);
        $Validation = ($this->partida->Validate() && $Validation);
        $Validation = ($this->tipo_padron_parc_id->Validate() && $Validation);
        $Validation = ($this->parcela_macizo->Validate() && $Validation);
        $Validation = ($this->parcela_chacra->Validate() && $Validation);
        $Validation = ($this->parcela_quinta->Validate() && $Validation);
        $Validation = ($this->parcela_f_proceso->Validate() && $Validation);
        $Validation = ($this->parcela_parcela->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->tipo_depto_parc_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_seccion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->partida->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_padron_parc_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_macizo->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_chacra->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_quinta->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_f_proceso->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_parcela->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @62-205253BA
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->tipo_depto_parc_id->Errors->Count());
        $errors = ($errors || $this->parcela_seccion->Errors->Count());
        $errors = ($errors || $this->partida->Errors->Count());
        $errors = ($errors || $this->tipo_padron_parc_id->Errors->Count());
        $errors = ($errors || $this->parcela_macizo->Errors->Count());
        $errors = ($errors || $this->parcela_chacra->Errors->Count());
        $errors = ($errors || $this->parcela_quinta->Errors->Count());
        $errors = ($errors || $this->parcela_f_proceso->Errors->Count());
        $errors = ($errors || $this->DatePicker_parcela_f_proceso1->Errors->Count());
        $errors = ($errors || $this->parcela_parcela->Errors->Count());
        $errors = ($errors || $this->Link1->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @62-ED598703
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

//Operation Method @62-B89105D4
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
            $this->PressedButton = "Button_Search";
            if($this->Button_salir->Pressed) {
                $this->PressedButton = "Button_salir";
            } else if($this->Button_Search->Pressed) {
                $this->PressedButton = "Button_Search";
            } else if($this->Button_observaciones->Pressed) {
                $this->PressedButton = "Button_observaciones";
            }
        }
        $Redirect = $FileName;
        if($this->PressedButton == "Button_salir") {
            if(!CCGetEvent($this->Button_salir->CCSEvents, "OnClick", $this->Button_salir)) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Button_observaciones") {
            $Redirect = "planchetas_observaciones.php";
            if(!CCGetEvent($this->Button_observaciones->CCSEvents, "OnClick", $this->Button_observaciones)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_Search") {
                $Redirect = $FileName . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_salir", "Button_salir_x", "Button_salir_y", "Button_Search", "Button_Search_x", "Button_Search_y", "Button_observaciones", "Button_observaciones_x", "Button_observaciones_y")));
                if(!CCGetEvent($this->Button_Search->CCSEvents, "OnClick", $this->Button_Search)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @62-4CAEC823
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

        $this->tipo_depto_parc_id->Prepare();
        $this->tipo_padron_parc_id->Prepare();

        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->tipo_depto_parc_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_seccion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->partida->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_padron_parc_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_macizo->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_chacra->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_quinta->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_f_proceso->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DatePicker_parcela_f_proceso1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_parcela->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Link1->Errors->ToString());
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

        $this->tipo_depto_parc_id->Show();
        $this->parcela_seccion->Show();
        $this->partida->Show();
        $this->tipo_padron_parc_id->Show();
        $this->parcela_macizo->Show();
        $this->parcela_chacra->Show();
        $this->parcela_quinta->Show();
        $this->parcela_f_proceso->Show();
        $this->DatePicker_parcela_f_proceso1->Show();
        $this->parcela_parcela->Show();
        $this->Button_salir->Show();
        $this->Link1->Show();
        $this->Button_Search->Show();
        $this->Button_observaciones->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End buscar Class @62-FCB6E20C



class clsGridparcelas { //parcelas class @98-C47EAFDB

//Variables @98-6E51DF5A

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

//Class_Initialize Event @98-01884621
    function clsGridparcelas($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "parcelas";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid parcelas";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsparcelasDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 14;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;

        $this->parcela_partida = new clsControl(ccsLabel, "parcela_partida", "parcela_partida", ccsInteger, "", CCGetRequestParam("parcela_partida", ccsGet, NULL), $this);
        $this->tipo_depto_parc_abrev = new clsControl(ccsLabel, "tipo_depto_parc_abrev", "tipo_depto_parc_abrev", ccsText, "", CCGetRequestParam("tipo_depto_parc_abrev", ccsGet, NULL), $this);
        $this->tipo_padron_parc_abrev = new clsControl(ccsLabel, "tipo_padron_parc_abrev", "tipo_padron_parc_abrev", ccsText, "", CCGetRequestParam("tipo_padron_parc_abrev", ccsGet, NULL), $this);
        $this->parcela_seccion = new clsControl(ccsLabel, "parcela_seccion", "parcela_seccion", ccsText, "", CCGetRequestParam("parcela_seccion", ccsGet, NULL), $this);
        $this->parcela_macizo = new clsControl(ccsLabel, "parcela_macizo", "parcela_macizo", ccsText, "", CCGetRequestParam("parcela_macizo", ccsGet, NULL), $this);
        $this->parcela_uf = new clsControl(ccsLabel, "parcela_uf", "parcela_uf", ccsText, "", CCGetRequestParam("parcela_uf", ccsGet, NULL), $this);
        $this->parcela_parcela = new clsControl(ccsLabel, "parcela_parcela", "parcela_parcela", ccsText, "", CCGetRequestParam("parcela_parcela", ccsGet, NULL), $this);
        $this->tipo_depto_parc_id = new clsControl(ccsHidden, "tipo_depto_parc_id", "tipo_depto_parc_id", ccsText, "", CCGetRequestParam("tipo_depto_parc_id", ccsGet, NULL), $this);
        $this->carto = new clsControl(ccsLabel, "carto", "carto", ccsText, "", CCGetRequestParam("carto", ccsGet, NULL), $this);
        $this->carto->HTML = true;
        $this->ImageLink1 = new clsControl(ccsImageLink, "ImageLink1", "ImageLink1", ccsText, "", CCGetRequestParam("ImageLink1", ccsGet, NULL), $this);
        $this->ImageLink1->Page = "gis_info.php";
        $this->ImageLink2 = new clsControl(ccsImageLink, "ImageLink2", "ImageLink2", ccsText, "", CCGetRequestParam("ImageLink2", ccsGet, NULL), $this);
        $this->ImageLink2->Page = "../reportes/rpt_plancheta_ol.php";
        $this->actual = new clsControl(ccsLabel, "actual", "actual", ccsText, "", CCGetRequestParam("actual", ccsGet, NULL), $this);
        $this->actual->HTML = true;
        $this->tipo_est_parc_descr = new clsControl(ccsLabel, "tipo_est_parc_descr", "tipo_est_parc_descr", ccsText, "", CCGetRequestParam("tipo_est_parc_descr", ccsGet, NULL), $this);
        $this->plancheta = new clsControl(ccsLabel, "plancheta", "plancheta", ccsText, "", CCGetRequestParam("plancheta", ccsGet, NULL), $this);
        $this->plancheta->HTML = true;
        $this->plano = new clsControl(ccsLabel, "plano", "plano", ccsText, "", CCGetRequestParam("plano", ccsGet, NULL), $this);
        $this->plano->HTML = true;
        $this->Label1 = new clsControl(ccsLabel, "Label1", "Label1", ccsText, "", CCGetRequestParam("Label1", ccsGet, NULL), $this);
        $this->Label1->HTML = true;
        $this->Label2 = new clsControl(ccsLabel, "Label2", "Label2", ccsText, "", CCGetRequestParam("Label2", ccsGet, NULL), $this);
        $this->Label2->HTML = true;
        $this->parcela_f_proceso = new clsControl(ccsLabel, "parcela_f_proceso", "parcela_f_proceso", ccsDate, array("dd", "/", "mm", "/", "yyyy"), CCGetRequestParam("parcela_f_proceso", ccsGet, NULL), $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
    }
//End Class_Initialize Event

//Initialize Method @98-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @98-637DB297
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlpartida"] = CCGetFromGet("partida", NULL);
        $this->DataSource->Parameters["urltipo_depto_parc_id"] = CCGetFromGet("tipo_depto_parc_id", NULL);
        $this->DataSource->Parameters["urltipo_padron_parc_id"] = CCGetFromGet("tipo_padron_parc_id", NULL);
        $this->DataSource->Parameters["urlparcela_seccion"] = CCGetFromGet("parcela_seccion", NULL);
        $this->DataSource->Parameters["urlparcela_macizo"] = CCGetFromGet("parcela_macizo", NULL);
        $this->DataSource->Parameters["urlparcela_chacra"] = CCGetFromGet("parcela_chacra", NULL);
        $this->DataSource->Parameters["urlparcela_quinta"] = CCGetFromGet("parcela_quinta", NULL);
        $this->DataSource->Parameters["urlparcela_parcela"] = CCGetFromGet("parcela_parcela", NULL);
        $this->DataSource->Parameters["urlparcela_f_proceso"] = CCGetFromGet("parcela_f_proceso", NULL);
        $this->DataSource->Parameters["expr134"] = 0;

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
            $this->ControlsVisible["parcela_partida"] = $this->parcela_partida->Visible;
            $this->ControlsVisible["tipo_depto_parc_abrev"] = $this->tipo_depto_parc_abrev->Visible;
            $this->ControlsVisible["tipo_padron_parc_abrev"] = $this->tipo_padron_parc_abrev->Visible;
            $this->ControlsVisible["parcela_seccion"] = $this->parcela_seccion->Visible;
            $this->ControlsVisible["parcela_macizo"] = $this->parcela_macizo->Visible;
            $this->ControlsVisible["parcela_uf"] = $this->parcela_uf->Visible;
            $this->ControlsVisible["parcela_parcela"] = $this->parcela_parcela->Visible;
            $this->ControlsVisible["tipo_depto_parc_id"] = $this->tipo_depto_parc_id->Visible;
            $this->ControlsVisible["carto"] = $this->carto->Visible;
            $this->ControlsVisible["ImageLink1"] = $this->ImageLink1->Visible;
            $this->ControlsVisible["ImageLink2"] = $this->ImageLink2->Visible;
            $this->ControlsVisible["actual"] = $this->actual->Visible;
            $this->ControlsVisible["tipo_est_parc_descr"] = $this->tipo_est_parc_descr->Visible;
            $this->ControlsVisible["plancheta"] = $this->plancheta->Visible;
            $this->ControlsVisible["plano"] = $this->plano->Visible;
            $this->ControlsVisible["Label1"] = $this->Label1->Visible;
            $this->ControlsVisible["Label2"] = $this->Label2->Visible;
            $this->ControlsVisible["parcela_f_proceso"] = $this->parcela_f_proceso->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->parcela_partida->SetValue($this->DataSource->parcela_partida->GetValue());
                $this->tipo_depto_parc_abrev->SetValue($this->DataSource->tipo_depto_parc_abrev->GetValue());
                $this->tipo_padron_parc_abrev->SetValue($this->DataSource->tipo_padron_parc_abrev->GetValue());
                $this->parcela_seccion->SetValue($this->DataSource->parcela_seccion->GetValue());
                $this->parcela_macizo->SetValue($this->DataSource->parcela_macizo->GetValue());
                $this->parcela_uf->SetValue($this->DataSource->parcela_uf->GetValue());
                $this->parcela_parcela->SetValue($this->DataSource->parcela_parcela->GetValue());
                $this->tipo_depto_parc_id->SetValue($this->DataSource->tipo_depto_parc_id->GetValue());
                $this->ImageLink1->Parameters = CCGetQueryString("QueryString", array("tipo_depto_parc_id", "parcela_seccion", "parcela_macizo", "partida", "parcelasPage", "tipo_padron_parc_id", "parcela_chacra", "parcela_quinta", "parcela_f_proceso", "interno", "parcela_parcela", "ccsForm"));
                $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "parcela_id", $this->DataSource->f("parcela_id"));
                $this->ImageLink2->Parameters = CCGetQueryString("QueryString", array("tipo_depto_parc_id", "parcela_seccion", "parcela_macizo", "partida", "interno", "parcela_parcela", "ccsForm"));
                $this->ImageLink2->Parameters = CCAddParam($this->ImageLink2->Parameters, "parcela_id", $this->DataSource->f("parcela_id"));
                $this->tipo_est_parc_descr->SetValue($this->DataSource->tipo_est_parc_descr->GetValue());
                $this->parcela_f_proceso->SetValue($this->DataSource->parcela_f_proceso->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->parcela_partida->Show();
                $this->tipo_depto_parc_abrev->Show();
                $this->tipo_padron_parc_abrev->Show();
                $this->parcela_seccion->Show();
                $this->parcela_macizo->Show();
                $this->parcela_uf->Show();
                $this->parcela_parcela->Show();
                $this->tipo_depto_parc_id->Show();
                $this->carto->Show();
                $this->ImageLink1->Show();
                $this->ImageLink2->Show();
                $this->actual->Show();
                $this->tipo_est_parc_descr->Show();
                $this->plancheta->Show();
                $this->plano->Show();
                $this->Label1->Show();
                $this->Label2->Show();
                $this->parcela_f_proceso->Show();
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
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @98-59DDAA5F
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->parcela_partida->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_depto_parc_abrev->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_padron_parc_abrev->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_seccion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_macizo->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_uf->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_parcela->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_depto_parc_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->carto->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ImageLink1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ImageLink2->Errors->ToString());
        $errors = ComposeStrings($errors, $this->actual->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_est_parc_descr->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plancheta->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plano->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Label1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Label2->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_f_proceso->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End parcelas Class @98-FCB6E20C

class clsparcelasDataSource extends clsDBtdf_nuevo {  //parcelasDataSource Class @98-DA23B507

//DataSource Variables @98-1703477B
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $parcela_partida;
    public $tipo_depto_parc_abrev;
    public $tipo_padron_parc_abrev;
    public $parcela_seccion;
    public $parcela_macizo;
    public $parcela_uf;
    public $parcela_parcela;
    public $tipo_depto_parc_id;
    public $tipo_est_parc_descr;
    public $parcela_f_proceso;
//End DataSource Variables

//DataSourceClass_Initialize Event @98-4E1EC87C
    function clsparcelasDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid parcelas";
        $this->Initialize();
        $this->parcela_partida = new clsField("parcela_partida", ccsInteger, "");
        
        $this->tipo_depto_parc_abrev = new clsField("tipo_depto_parc_abrev", ccsText, "");
        
        $this->tipo_padron_parc_abrev = new clsField("tipo_padron_parc_abrev", ccsText, "");
        
        $this->parcela_seccion = new clsField("parcela_seccion", ccsText, "");
        
        $this->parcela_macizo = new clsField("parcela_macizo", ccsText, "");
        
        $this->parcela_uf = new clsField("parcela_uf", ccsText, "");
        
        $this->parcela_parcela = new clsField("parcela_parcela", ccsText, "");
        
        $this->tipo_depto_parc_id = new clsField("tipo_depto_parc_id", ccsText, "");
        
        $this->tipo_est_parc_descr = new clsField("tipo_est_parc_descr", ccsText, "");
        
        $this->parcela_f_proceso = new clsField("parcela_f_proceso", ccsDate, $this->DateFormat);
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @98-3993B012
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "parcela_partida";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @98-48A4EEB4
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlpartida", ccsInteger, "", "", $this->Parameters["urlpartida"], "", false);
        $this->wp->AddParameter("2", "urltipo_depto_parc_id", ccsInteger, "", "", $this->Parameters["urltipo_depto_parc_id"], "", false);
        $this->wp->AddParameter("3", "urltipo_padron_parc_id", ccsInteger, "", "", $this->Parameters["urltipo_padron_parc_id"], "", false);
        $this->wp->AddParameter("4", "urlparcela_seccion", ccsText, "", "", $this->Parameters["urlparcela_seccion"], "", false);
        $this->wp->AddParameter("5", "urlparcela_macizo", ccsText, "", "", $this->Parameters["urlparcela_macizo"], "", false);
        $this->wp->AddParameter("6", "urlparcela_chacra", ccsText, "", "", $this->Parameters["urlparcela_chacra"], "", false);
        $this->wp->AddParameter("7", "urlparcela_quinta", ccsText, "", "", $this->Parameters["urlparcela_quinta"], "", false);
        $this->wp->AddParameter("8", "urlparcela_parcela", ccsText, "", "", $this->Parameters["urlparcela_parcela"], "", false);
        $this->wp->AddParameter("9", "urlparcela_f_proceso", ccsDate, array("dd", "/", "mm", "/", "yyyy"), array("yyyy", "-", "mm", "-", "dd"), $this->Parameters["urlparcela_f_proceso"], "", false);
        $this->wp->AddParameter("10", "expr134", ccsInteger, "", "", $this->Parameters["expr134"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "parcelas.parcela_partida", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "parcelas.tipo_depto_parc_id", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
        $this->wp->Criterion[3] = $this->wp->Operation(opEqual, "parcelas.tipo_padron_parc_id", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsInteger),false);
        $this->wp->Criterion[4] = $this->wp->Operation(opEqual, "parcelas.parcela_seccion", $this->wp->GetDBValue("4"), $this->ToSQL($this->wp->GetDBValue("4"), ccsText),false);
        $this->wp->Criterion[5] = $this->wp->Operation(opEqual, "parcelas.parcela_macizo", $this->wp->GetDBValue("5"), $this->ToSQL($this->wp->GetDBValue("5"), ccsText),false);
        $this->wp->Criterion[6] = $this->wp->Operation(opEqual, "parcelas.parcela_chacra", $this->wp->GetDBValue("6"), $this->ToSQL($this->wp->GetDBValue("6"), ccsText),false);
        $this->wp->Criterion[7] = $this->wp->Operation(opEqual, "parcelas.parcela_quinta", $this->wp->GetDBValue("7"), $this->ToSQL($this->wp->GetDBValue("7"), ccsText),false);
        $this->wp->Criterion[8] = $this->wp->Operation(opEqual, "parcelas.parcela_parcela", $this->wp->GetDBValue("8"), $this->ToSQL($this->wp->GetDBValue("8"), ccsText),false);
        $this->wp->Criterion[9] = $this->wp->Operation(opBeginsWith, "parcelas.parcela_f_proceso", $this->wp->GetDBValue("9"), $this->ToSQL($this->wp->GetDBValue("9"), ccsDate),false);
        $this->wp->Criterion[10] = $this->wp->Operation(opNotEqual, "parcelas.parcela_partida", $this->wp->GetDBValue("10"), $this->ToSQL($this->wp->GetDBValue("10"), ccsInteger),false);
        $this->Where = $this->wp->opAND(
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
             $this->wp->Criterion[10]);
    }
//End Prepare Method

//Open Method @98-5B273F75
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT parcelas.*, tipo_padron_parc_abrev, tipo_depto_parc_abrev, tipo_est_parc_descr \n\n" .
        "FROM ((parcelas LEFT JOIN tipos_deptos_parcela ON\n\n" .
        "parcelas.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id) LEFT JOIN tipos_padrones_parcela ON\n\n" .
        "parcelas.tipo_padron_parc_id = tipos_padrones_parcela.tipo_padron_parc_id) LEFT JOIN tipos_estados_parcela ON\n\n" .
        "parcelas.tipo_est_parc_id = tipos_estados_parcela.tipo_est_parc_id {SQL_Where}\n\n" .
        "GROUP BY parcelas.parcela_id {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @98-883AFDD9
    function SetValues()
    {
        $this->parcela_partida->SetDBValue(trim($this->f("parcela_partida")));
        $this->tipo_depto_parc_abrev->SetDBValue($this->f("tipo_depto_parc_abrev"));
        $this->tipo_padron_parc_abrev->SetDBValue($this->f("tipo_padron_parc_abrev"));
        $this->parcela_seccion->SetDBValue($this->f("parcela_seccion"));
        $this->parcela_macizo->SetDBValue($this->f("parcela_macizo"));
        $this->parcela_uf->SetDBValue($this->f("parcela_uf"));
        $this->parcela_parcela->SetDBValue($this->f("parcela_parcela"));
        $this->tipo_depto_parc_id->SetDBValue($this->f("tipo_depto_parc_id"));
        $this->tipo_est_parc_descr->SetDBValue($this->f("tipo_est_parc_descr"));
        $this->parcela_f_proceso->SetDBValue(trim($this->f("parcela_f_proceso")));
    }
//End SetValues Method

} //End parcelasDataSource Class @98-FCB6E20C





//Initialize Page @1-777BFD89
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
$TemplateFileName = "planchetas.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-34632CEE
include_once("./planchetas_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-53D8F9A9
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$servicio = new clsControl(ccsHidden, "servicio", "servicio", ccsText, "", CCGetRequestParam("servicio", ccsGet, NULL), $MainPage);
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$buscar = new clsRecordbuscar("", $MainPage);
$parcelas = new clsGridparcelas("", $MainPage);
$comentario2 = new clsControl(ccsLabel, "comentario2", "comentario2", ccsText, "", CCGetRequestParam("comentario2", ccsGet, NULL), $MainPage);
$comentario2->HTML = true;
$comentario1 = new clsControl(ccsLabel, "comentario1", "comentario1", ccsText, "", CCGetRequestParam("comentario1", ccsGet, NULL), $MainPage);
$comentario1->HTML = true;
$comentario3 = new clsControl(ccsLabel, "comentario3", "comentario3", ccsText, "", CCGetRequestParam("comentario3", ccsGet, NULL), $MainPage);
$comentario3->HTML = true;
$comentario4 = new clsControl(ccsLabel, "comentario4", "comentario4", ccsText, "", CCGetRequestParam("comentario4", ccsGet, NULL), $MainPage);
$comentario4->HTML = true;
$MainPage->servicio = & $servicio;
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->buscar = & $buscar;
$MainPage->parcelas = & $parcelas;
$MainPage->comentario2 = & $comentario2;
$MainPage->comentario1 = & $comentario1;
$MainPage->comentario3 = & $comentario3;
$MainPage->comentario4 = & $comentario4;
$parcelas->Initialize();

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

//Execute Components @1-13005A77
$tdf_header->Operations();
$tdf_footer->Operations();
$buscar->Operation();
//End Execute Components

//Go to destination page @1-D65C0309
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    header("Location: " . $Redirect);
    $tdf_header->Class_Terminate();
    unset($tdf_header);
    $tdf_footer->Class_Terminate();
    unset($tdf_footer);
    unset($buscar);
    unset($parcelas);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-E9B7037C
$tdf_header->Show();
$tdf_footer->Show();
$buscar->Show();
$parcelas->Show();
$servicio->Show();
$comentario2->Show();
$comentario1->Show();
$comentario3->Show();
$comentario4->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$OCMNI3J5E10O8B6I = "<center><font face=\"Arial\"><small>&#71;&#101;&#110;&#101;&#114;&#97;t&#101;&#100; <!-- SCC -->wit&#104; <!-- CCS -->Cod&#101;&#67;&#104;arg&#101; <!-- CCS -->&#83;t&#117;&#100;&#105;o.</small></font></center>";
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", $OCMNI3J5E10O8B6I . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", $OCMNI3J5E10O8B6I . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= $OCMNI3J5E10O8B6I;
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-B5C9D4C8
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($buscar);
unset($parcelas);
unset($Tpl);
//End Unload Page


?>
