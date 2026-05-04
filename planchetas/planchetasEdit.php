<?php
//Include Common Files @1-5D1067ED
define("RelativePath", "..");
define("PathToCurrentPage", "/planchetas/");
define("FileName", "planchetasEdit.php");
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

class clsRecordplanchetas { //planchetas Class @6-FE14F440

//Variables @6-9E315808

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

//Class_Initialize Event @6-F5EF1952
    function clsRecordplanchetas($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record planchetas/Error";
        $this->DataSource = new clsplanchetasDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->DeleteAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "planchetas";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->EditMode = ($FormMethod == "Edit");
            $this->FormEnctype = "multipart/form-data";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_Insert = new clsButton("Button_Insert", $Method, $this);
            $this->Button_Update = new clsButton("Button_Update", $Method, $this);
            $this->Button_Delete = new clsButton("Button_Delete", $Method, $this);
            $this->Button_Cancel = new clsButton("Button_Cancel", $Method, $this);
            $this->tipo_depto_parc_id = new clsControl(ccsListBox, "tipo_depto_parc_id", "Departamento", ccsInteger, "", CCGetRequestParam("tipo_depto_parc_id", $Method, NULL), $this);
            $this->tipo_depto_parc_id->DSType = dsTable;
            $this->tipo_depto_parc_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_depto_parc_id->ds = & $this->tipo_depto_parc_id->DataSource;
            $this->tipo_depto_parc_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_deptos_parcela {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_depto_parc_id->BoundColumn, $this->tipo_depto_parc_id->TextColumn, $this->tipo_depto_parc_id->DBFormat) = array("tipo_depto_parc_id", "tipo_depto_parc_desc", "");
            $this->tipo_depto_parc_id->Required = true;
            $this->tipo_padron_parc_id = new clsControl(ccsListBox, "tipo_padron_parc_id", "Padrón", ccsInteger, "", CCGetRequestParam("tipo_padron_parc_id", $Method, NULL), $this);
            $this->tipo_padron_parc_id->DSType = dsTable;
            $this->tipo_padron_parc_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_padron_parc_id->ds = & $this->tipo_padron_parc_id->DataSource;
            $this->tipo_padron_parc_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_padrones_parcela {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_padron_parc_id->BoundColumn, $this->tipo_padron_parc_id->TextColumn, $this->tipo_padron_parc_id->DBFormat) = array("tipo_padron_parc_id", "tipo_padron_parc_desc", "");
            $this->tipo_padron_parc_id->Required = true;
            $this->plancheta_scc = new clsControl(ccsTextBox, "plancheta_scc", "Sección", ccsText, "", CCGetRequestParam("plancheta_scc", $Method, NULL), $this);
            $this->plancheta_scc->Required = true;
            $this->plancheta_qta = new clsControl(ccsTextBox, "plancheta_qta", "Qta", ccsText, "", CCGetRequestParam("plancheta_qta", $Method, NULL), $this);
            $this->plancheta_cha = new clsControl(ccsTextBox, "plancheta_cha", "Cha", ccsText, "", CCGetRequestParam("plancheta_cha", $Method, NULL), $this);
            $this->plancheta_mzo = new clsControl(ccsTextBox, "plancheta_mzo", "Mzo", ccsText, "", CCGetRequestParam("plancheta_mzo", $Method, NULL), $this);
            $this->plancheta_par = new clsControl(ccsTextBox, "plancheta_par", "Par", ccsText, "", CCGetRequestParam("plancheta_par", $Method, NULL), $this);
            $this->plancheta_hoja = new clsControl(ccsTextBox, "plancheta_hoja", "Hoja", ccsInteger, "", CCGetRequestParam("plancheta_hoja", $Method, NULL), $this);
            $this->plancheta_ruta = new clsControl(ccsTextBox, "plancheta_ruta", "Ruta", ccsText, "", CCGetRequestParam("plancheta_ruta", $Method, NULL), $this);
            $this->plancheta_obs = new clsControl(ccsTextBox, "plancheta_obs", "Obs", ccsText, "", CCGetRequestParam("plancheta_obs", $Method, NULL), $this);
            $this->FileUpload1 = new clsFileUpload("FileUpload1", "Archivo", "../tmp/", "./archivos/", "*.jpg;*.gif;*.png", "", 3000000, $this);
            $this->plancheta_f_act = new clsControl(ccsHidden, "plancheta_f_act", "plancheta_f_act", ccsText, "", CCGetRequestParam("plancheta_f_act", $Method, NULL), $this);
            $this->html = new clsControl(ccsLabel, "html", "html", ccsText, "", CCGetRequestParam("html", $Method, NULL), $this);
            $this->html->HTML = true;
        }
    }
//End Class_Initialize Event

//Initialize Method @6-A7FC2167
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlplancheta_id"] = CCGetFromGet("plancheta_id", NULL);
    }
//End Initialize Method

//Validate Method @6-09351166
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->tipo_depto_parc_id->Validate() && $Validation);
        $Validation = ($this->tipo_padron_parc_id->Validate() && $Validation);
        $Validation = ($this->plancheta_scc->Validate() && $Validation);
        $Validation = ($this->plancheta_qta->Validate() && $Validation);
        $Validation = ($this->plancheta_cha->Validate() && $Validation);
        $Validation = ($this->plancheta_mzo->Validate() && $Validation);
        $Validation = ($this->plancheta_par->Validate() && $Validation);
        $Validation = ($this->plancheta_hoja->Validate() && $Validation);
        $Validation = ($this->plancheta_ruta->Validate() && $Validation);
        $Validation = ($this->plancheta_obs->Validate() && $Validation);
        $Validation = ($this->FileUpload1->Validate() && $Validation);
        $Validation = ($this->plancheta_f_act->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->tipo_depto_parc_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_padron_parc_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->plancheta_scc->Errors->Count() == 0);
        $Validation =  $Validation && ($this->plancheta_qta->Errors->Count() == 0);
        $Validation =  $Validation && ($this->plancheta_cha->Errors->Count() == 0);
        $Validation =  $Validation && ($this->plancheta_mzo->Errors->Count() == 0);
        $Validation =  $Validation && ($this->plancheta_par->Errors->Count() == 0);
        $Validation =  $Validation && ($this->plancheta_hoja->Errors->Count() == 0);
        $Validation =  $Validation && ($this->plancheta_ruta->Errors->Count() == 0);
        $Validation =  $Validation && ($this->plancheta_obs->Errors->Count() == 0);
        $Validation =  $Validation && ($this->FileUpload1->Errors->Count() == 0);
        $Validation =  $Validation && ($this->plancheta_f_act->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @6-7A372BF9
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->tipo_depto_parc_id->Errors->Count());
        $errors = ($errors || $this->tipo_padron_parc_id->Errors->Count());
        $errors = ($errors || $this->plancheta_scc->Errors->Count());
        $errors = ($errors || $this->plancheta_qta->Errors->Count());
        $errors = ($errors || $this->plancheta_cha->Errors->Count());
        $errors = ($errors || $this->plancheta_mzo->Errors->Count());
        $errors = ($errors || $this->plancheta_par->Errors->Count());
        $errors = ($errors || $this->plancheta_hoja->Errors->Count());
        $errors = ($errors || $this->plancheta_ruta->Errors->Count());
        $errors = ($errors || $this->plancheta_obs->Errors->Count());
        $errors = ($errors || $this->FileUpload1->Errors->Count());
        $errors = ($errors || $this->plancheta_f_act->Errors->Count());
        $errors = ($errors || $this->html->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @6-ED598703
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

//Operation Method @6-57C78EAB
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

        $this->FileUpload1->Upload();

        if($this->FormSubmitted) {
            $this->PressedButton = $this->EditMode ? "Button_Update" : "Button_Insert";
            if($this->Button_Insert->Pressed) {
                $this->PressedButton = "Button_Insert";
            } else if($this->Button_Update->Pressed) {
                $this->PressedButton = "Button_Update";
            } else if($this->Button_Delete->Pressed) {
                $this->PressedButton = "Button_Delete";
            } else if($this->Button_Cancel->Pressed) {
                $this->PressedButton = "Button_Cancel";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Delete") {
            $Redirect = "planchetasGrid.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
            if(!CCGetEvent($this->Button_Delete->CCSEvents, "OnClick", $this->Button_Delete) || !$this->DeleteRow()) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Button_Cancel") {
            $Redirect = "planchetasGrid.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
            if(!CCGetEvent($this->Button_Cancel->CCSEvents, "OnClick", $this->Button_Cancel)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_Insert") {
                $Redirect = "planchetasGrid.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
                if(!CCGetEvent($this->Button_Insert->CCSEvents, "OnClick", $this->Button_Insert) || !$this->InsertRow()) {
                    $Redirect = "";
                }
            } else if($this->PressedButton == "Button_Update") {
                $Redirect = "planchetasGrid.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
                if(!CCGetEvent($this->Button_Update->CCSEvents, "OnClick", $this->Button_Update) || !$this->UpdateRow()) {
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

//InsertRow Method @6-F8164E6D
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->tipo_depto_parc_id->SetValue($this->tipo_depto_parc_id->GetValue(true));
        $this->DataSource->tipo_padron_parc_id->SetValue($this->tipo_padron_parc_id->GetValue(true));
        $this->DataSource->plancheta_scc->SetValue($this->plancheta_scc->GetValue(true));
        $this->DataSource->plancheta_qta->SetValue($this->plancheta_qta->GetValue(true));
        $this->DataSource->plancheta_cha->SetValue($this->plancheta_cha->GetValue(true));
        $this->DataSource->plancheta_mzo->SetValue($this->plancheta_mzo->GetValue(true));
        $this->DataSource->plancheta_par->SetValue($this->plancheta_par->GetValue(true));
        $this->DataSource->plancheta_hoja->SetValue($this->plancheta_hoja->GetValue(true));
        $this->DataSource->plancheta_ruta->SetValue($this->plancheta_ruta->GetValue(true));
        $this->DataSource->plancheta_obs->SetValue($this->plancheta_obs->GetValue(true));
        $this->DataSource->FileUpload1->SetValue($this->FileUpload1->GetValue(true));
        $this->DataSource->plancheta_f_act->SetValue($this->plancheta_f_act->GetValue(true));
        $this->DataSource->html->SetValue($this->html->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        if($this->DataSource->Errors->Count() == 0) {
            $this->FileUpload1->Move();
        }
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @6-A0C73637
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->tipo_depto_parc_id->SetValue($this->tipo_depto_parc_id->GetValue(true));
        $this->DataSource->tipo_padron_parc_id->SetValue($this->tipo_padron_parc_id->GetValue(true));
        $this->DataSource->plancheta_scc->SetValue($this->plancheta_scc->GetValue(true));
        $this->DataSource->plancheta_qta->SetValue($this->plancheta_qta->GetValue(true));
        $this->DataSource->plancheta_cha->SetValue($this->plancheta_cha->GetValue(true));
        $this->DataSource->plancheta_mzo->SetValue($this->plancheta_mzo->GetValue(true));
        $this->DataSource->plancheta_par->SetValue($this->plancheta_par->GetValue(true));
        $this->DataSource->plancheta_hoja->SetValue($this->plancheta_hoja->GetValue(true));
        $this->DataSource->plancheta_ruta->SetValue($this->plancheta_ruta->GetValue(true));
        $this->DataSource->plancheta_obs->SetValue($this->plancheta_obs->GetValue(true));
        $this->DataSource->FileUpload1->SetValue($this->FileUpload1->GetValue(true));
        $this->DataSource->plancheta_f_act->SetValue($this->plancheta_f_act->GetValue(true));
        $this->DataSource->html->SetValue($this->html->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        if($this->DataSource->Errors->Count() == 0) {
            $this->FileUpload1->Move();
        }
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//DeleteRow Method @6-2B077D44
    function DeleteRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDelete", $this);
        if(!$this->DeleteAllowed) return false;
        $this->DataSource->Delete();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDelete", $this);
        if($this->DataSource->Errors->Count() == 0) {
            $this->FileUpload1->Delete();
        }
        return (!$this->CheckErrors());
    }
//End DeleteRow Method

//Show Method @6-48379382
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
        if($this->EditMode) {
            if($this->DataSource->Errors->Count()){
                $this->Errors->AddErrors($this->DataSource->Errors);
                $this->DataSource->Errors->clear();
            }
            $this->DataSource->Open();
            if($this->DataSource->Errors->Count() == 0 && $this->DataSource->next_record()) {
                $this->DataSource->SetValues();
                if(!$this->FormSubmitted){
                    $this->tipo_depto_parc_id->SetValue($this->DataSource->tipo_depto_parc_id->GetValue());
                    $this->tipo_padron_parc_id->SetValue($this->DataSource->tipo_padron_parc_id->GetValue());
                    $this->plancheta_scc->SetValue($this->DataSource->plancheta_scc->GetValue());
                    $this->plancheta_qta->SetValue($this->DataSource->plancheta_qta->GetValue());
                    $this->plancheta_cha->SetValue($this->DataSource->plancheta_cha->GetValue());
                    $this->plancheta_mzo->SetValue($this->DataSource->plancheta_mzo->GetValue());
                    $this->plancheta_par->SetValue($this->DataSource->plancheta_par->GetValue());
                    $this->plancheta_hoja->SetValue($this->DataSource->plancheta_hoja->GetValue());
                    $this->plancheta_ruta->SetValue($this->DataSource->plancheta_ruta->GetValue());
                    $this->plancheta_obs->SetValue($this->DataSource->plancheta_obs->GetValue());
                    $this->FileUpload1->SetValue($this->DataSource->FileUpload1->GetValue());
                    $this->plancheta_f_act->SetValue($this->DataSource->plancheta_f_act->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->tipo_depto_parc_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_padron_parc_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plancheta_scc->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plancheta_qta->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plancheta_cha->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plancheta_mzo->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plancheta_par->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plancheta_hoja->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plancheta_ruta->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plancheta_obs->Errors->ToString());
            $Error = ComposeStrings($Error, $this->FileUpload1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plancheta_f_act->Errors->ToString());
            $Error = ComposeStrings($Error, $this->html->Errors->ToString());
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
        $this->Button_Update->Visible = $this->EditMode && $this->UpdateAllowed;
        $this->Button_Delete->Visible = $this->EditMode && $this->DeleteAllowed;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_Insert->Show();
        $this->Button_Update->Show();
        $this->Button_Delete->Show();
        $this->Button_Cancel->Show();
        $this->tipo_depto_parc_id->Show();
        $this->tipo_padron_parc_id->Show();
        $this->plancheta_scc->Show();
        $this->plancheta_qta->Show();
        $this->plancheta_cha->Show();
        $this->plancheta_mzo->Show();
        $this->plancheta_par->Show();
        $this->plancheta_hoja->Show();
        $this->plancheta_ruta->Show();
        $this->plancheta_obs->Show();
        $this->FileUpload1->Show();
        $this->plancheta_f_act->Show();
        $this->html->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End planchetas Class @6-FCB6E20C

class clsplanchetasDataSource extends clsDBtdf_nuevo {  //planchetasDataSource Class @6-A652C867

//DataSource Variables @6-6550C4C0
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $InsertParameters;
    public $UpdateParameters;
    public $DeleteParameters;
    public $wp;
    public $AllParametersSet;

    public $InsertFields = array();
    public $UpdateFields = array();

    // Datasource fields
    public $tipo_depto_parc_id;
    public $tipo_padron_parc_id;
    public $plancheta_scc;
    public $plancheta_qta;
    public $plancheta_cha;
    public $plancheta_mzo;
    public $plancheta_par;
    public $plancheta_hoja;
    public $plancheta_ruta;
    public $plancheta_obs;
    public $FileUpload1;
    public $plancheta_f_act;
    public $html;
//End DataSource Variables

//DataSourceClass_Initialize Event @6-6676715E
    function clsplanchetasDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record planchetas/Error";
        $this->Initialize();
        $this->tipo_depto_parc_id = new clsField("tipo_depto_parc_id", ccsInteger, "");
        
        $this->tipo_padron_parc_id = new clsField("tipo_padron_parc_id", ccsInteger, "");
        
        $this->plancheta_scc = new clsField("plancheta_scc", ccsText, "");
        
        $this->plancheta_qta = new clsField("plancheta_qta", ccsText, "");
        
        $this->plancheta_cha = new clsField("plancheta_cha", ccsText, "");
        
        $this->plancheta_mzo = new clsField("plancheta_mzo", ccsText, "");
        
        $this->plancheta_par = new clsField("plancheta_par", ccsText, "");
        
        $this->plancheta_hoja = new clsField("plancheta_hoja", ccsInteger, "");
        
        $this->plancheta_ruta = new clsField("plancheta_ruta", ccsText, "");
        
        $this->plancheta_obs = new clsField("plancheta_obs", ccsText, "");
        
        $this->FileUpload1 = new clsField("FileUpload1", ccsText, "");
        
        $this->plancheta_f_act = new clsField("plancheta_f_act", ccsText, "");
        
        $this->html = new clsField("html", ccsText, "");
        

        $this->InsertFields["tipo_depto_parc_id"] = array("Name" => "tipo_depto_parc_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_padron_parc_id"] = array("Name" => "tipo_padron_parc_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["plancheta_scc"] = array("Name" => "plancheta_scc", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["plancheta_qta"] = array("Name" => "plancheta_qta", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["plancheta_cha"] = array("Name" => "plancheta_cha", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["plancheta_mzo"] = array("Name" => "plancheta_mzo", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["plancheta_par"] = array("Name" => "plancheta_par", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["plancheta_hoja"] = array("Name" => "plancheta_hoja", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["plancheta_ruta"] = array("Name" => "plancheta_ruta", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["plancheta_obs"] = array("Name" => "plancheta_obs", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["plancheta_file"] = array("Name" => "plancheta_file", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["plancheta_f_act"] = array("Name" => "plancheta_f_act", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_depto_parc_id"] = array("Name" => "tipo_depto_parc_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_padron_parc_id"] = array("Name" => "tipo_padron_parc_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["plancheta_scc"] = array("Name" => "plancheta_scc", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["plancheta_qta"] = array("Name" => "plancheta_qta", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["plancheta_cha"] = array("Name" => "plancheta_cha", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["plancheta_mzo"] = array("Name" => "plancheta_mzo", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["plancheta_par"] = array("Name" => "plancheta_par", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["plancheta_hoja"] = array("Name" => "plancheta_hoja", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["plancheta_ruta"] = array("Name" => "plancheta_ruta", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["plancheta_obs"] = array("Name" => "plancheta_obs", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["plancheta_file"] = array("Name" => "plancheta_file", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["plancheta_f_act"] = array("Name" => "plancheta_f_act", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @6-2318B90C
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlplancheta_id", ccsInteger, "", "", $this->Parameters["urlplancheta_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "plancheta_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @6-C993CAC7
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM planchetas {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @6-E8B72E42
    function SetValues()
    {
        $this->tipo_depto_parc_id->SetDBValue(trim($this->f("tipo_depto_parc_id")));
        $this->tipo_padron_parc_id->SetDBValue(trim($this->f("tipo_padron_parc_id")));
        $this->plancheta_scc->SetDBValue($this->f("plancheta_scc"));
        $this->plancheta_qta->SetDBValue($this->f("plancheta_qta"));
        $this->plancheta_cha->SetDBValue($this->f("plancheta_cha"));
        $this->plancheta_mzo->SetDBValue($this->f("plancheta_mzo"));
        $this->plancheta_par->SetDBValue($this->f("plancheta_par"));
        $this->plancheta_hoja->SetDBValue(trim($this->f("plancheta_hoja")));
        $this->plancheta_ruta->SetDBValue($this->f("plancheta_ruta"));
        $this->plancheta_obs->SetDBValue($this->f("plancheta_obs"));
        $this->FileUpload1->SetDBValue($this->f("plancheta_file"));
        $this->plancheta_f_act->SetDBValue($this->f("plancheta_f_act"));
    }
//End SetValues Method

//Insert Method @6-1453448A
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["tipo_depto_parc_id"]["Value"] = $this->tipo_depto_parc_id->GetDBValue(true);
        $this->InsertFields["tipo_padron_parc_id"]["Value"] = $this->tipo_padron_parc_id->GetDBValue(true);
        $this->InsertFields["plancheta_scc"]["Value"] = $this->plancheta_scc->GetDBValue(true);
        $this->InsertFields["plancheta_qta"]["Value"] = $this->plancheta_qta->GetDBValue(true);
        $this->InsertFields["plancheta_cha"]["Value"] = $this->plancheta_cha->GetDBValue(true);
        $this->InsertFields["plancheta_mzo"]["Value"] = $this->plancheta_mzo->GetDBValue(true);
        $this->InsertFields["plancheta_par"]["Value"] = $this->plancheta_par->GetDBValue(true);
        $this->InsertFields["plancheta_hoja"]["Value"] = $this->plancheta_hoja->GetDBValue(true);
        $this->InsertFields["plancheta_ruta"]["Value"] = $this->plancheta_ruta->GetDBValue(true);
        $this->InsertFields["plancheta_obs"]["Value"] = $this->plancheta_obs->GetDBValue(true);
        $this->InsertFields["plancheta_file"]["Value"] = $this->FileUpload1->GetDBValue(true);
        $this->InsertFields["plancheta_f_act"]["Value"] = $this->plancheta_f_act->GetDBValue(true);
        $this->SQL = CCBuildInsert("planchetas", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @6-3FB7DFB0
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["tipo_depto_parc_id"]["Value"] = $this->tipo_depto_parc_id->GetDBValue(true);
        $this->UpdateFields["tipo_padron_parc_id"]["Value"] = $this->tipo_padron_parc_id->GetDBValue(true);
        $this->UpdateFields["plancheta_scc"]["Value"] = $this->plancheta_scc->GetDBValue(true);
        $this->UpdateFields["plancheta_qta"]["Value"] = $this->plancheta_qta->GetDBValue(true);
        $this->UpdateFields["plancheta_cha"]["Value"] = $this->plancheta_cha->GetDBValue(true);
        $this->UpdateFields["plancheta_mzo"]["Value"] = $this->plancheta_mzo->GetDBValue(true);
        $this->UpdateFields["plancheta_par"]["Value"] = $this->plancheta_par->GetDBValue(true);
        $this->UpdateFields["plancheta_hoja"]["Value"] = $this->plancheta_hoja->GetDBValue(true);
        $this->UpdateFields["plancheta_ruta"]["Value"] = $this->plancheta_ruta->GetDBValue(true);
        $this->UpdateFields["plancheta_obs"]["Value"] = $this->plancheta_obs->GetDBValue(true);
        $this->UpdateFields["plancheta_file"]["Value"] = $this->FileUpload1->GetDBValue(true);
        $this->UpdateFields["plancheta_f_act"]["Value"] = $this->plancheta_f_act->GetDBValue(true);
        $this->SQL = CCBuildUpdate("planchetas", $this->UpdateFields, $this);
        $this->SQL .= strlen($this->Where) ? " WHERE " . $this->Where : $this->Where;
        if (!strlen($this->Where) && $this->Errors->Count() == 0) 
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate", $this->Parent);
        }
    }
//End Update Method

//Delete Method @6-5D07627B
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $this->SQL = "DELETE FROM planchetas";
        $this->SQL = CCBuildSQL($this->SQL, $this->Where, "");
        if (!strlen($this->Where) && $this->Errors->Count() == 0) 
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteDelete", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteDelete", $this->Parent);
        }
    }
//End Delete Method

} //End planchetasDataSource Class @6-FCB6E20C

//Initialize Page @1-725A6DD1
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
$TemplateFileName = "planchetasEdit.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-9EB423E3
include_once("./planchetasEdit_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-E3C13F61
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$planchetas = new clsRecordplanchetas("", $MainPage);
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

//Execute Components @1-51EFE79C
$tdf_header->Operations();
$tdf_footer->Operations();
$tdf_menu->Operations();
$planchetas->Operation();
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

//Show Page @1-15ADD00A
$tdf_header->Show();
$tdf_footer->Show();
$tdf_menu->Show();
$planchetas->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", implode(array("<center><font fa", "ce=\"Arial\"><smal", "l>G&#101;n&#10", "1;r&#97;t&#101;", "&#100; <!-- CCS", " -->w&#105;&#116;", "&#104; <!-- SCC", " -->C&#111;&#100;e", "Ch&#97;&#114;&#103;", "e <!-- SCC -->St", "u&#100;&#105;&#11", "1;.</small></fo", "nt></center>"), "") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", implode(array("<center><font fa", "ce=\"Arial\"><smal", "l>G&#101;n&#10", "1;r&#97;t&#101;", "&#100; <!-- CCS", " -->w&#105;&#116;", "&#104; <!-- SCC", " -->C&#111;&#100;e", "Ch&#97;&#114;&#103;", "e <!-- SCC -->St", "u&#100;&#105;&#11", "1;.</small></fo", "nt></center>"), "") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= implode(array("<center><font fa", "ce=\"Arial\"><smal", "l>G&#101;n&#10", "1;r&#97;t&#101;", "&#100; <!-- CCS", " -->w&#105;&#116;", "&#104; <!-- SCC", " -->C&#111;&#100;e", "Ch&#97;&#114;&#103;", "e <!-- SCC -->St", "u&#100;&#105;&#11", "1;.</small></fo", "nt></center>"), "");
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
