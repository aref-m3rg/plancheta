<?php
//Include Common Files @1-2373D79F
define("RelativePath", "..");
define("PathToCurrentPage", "/previsado/");
define("FileName", "previsados_nomenclatura_afectacion.php");
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

class clsGridprevisados_parcelas_orige { //previsados_parcelas_orige class @6-4501903C

//Variables @6-62AB727E

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
    public $Sorter_parcela_seccion;
    public $Sorter_parcela_chacra;
    public $Sorter_parcela_quinta;
    public $Sorter_parcela_macizo;
    public $Sorter_parcela_fraccion;
    public $Sorter_parcela_parcela;
    public $Sorter_parcela_uf;
    public $Sorter_tipo_depto_parc_id;
    public $Sorter_partida;
//End Variables

//Class_Initialize Event @6-B12B1842
    function clsGridprevisados_parcelas_orige($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "previsados_parcelas_orige";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid previsados_parcelas_orige";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsprevisados_parcelas_origeDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 25;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;
        $this->SorterName = CCGetParam("previsados_parcelas_origeOrder", "");
        $this->SorterDirection = CCGetParam("previsados_parcelas_origeDir", "");

        $this->tipo_depto_parc_desc = new clsControl(ccsLink, "tipo_depto_parc_desc", "tipo_depto_parc_desc", ccsText, "", CCGetRequestParam("tipo_depto_parc_desc", ccsGet, NULL), $this);
        $this->tipo_depto_parc_desc->Page = "previsados_nomenclatura_afectacion.php";
        $this->parcela_seccion = new clsControl(ccsLabel, "parcela_seccion", "parcela_seccion", ccsText, "", CCGetRequestParam("parcela_seccion", ccsGet, NULL), $this);
        $this->parcela_chacra = new clsControl(ccsLabel, "parcela_chacra", "parcela_chacra", ccsText, "", CCGetRequestParam("parcela_chacra", ccsGet, NULL), $this);
        $this->parcela_quinta = new clsControl(ccsLabel, "parcela_quinta", "parcela_quinta", ccsText, "", CCGetRequestParam("parcela_quinta", ccsGet, NULL), $this);
        $this->parcela_macizo = new clsControl(ccsLabel, "parcela_macizo", "parcela_macizo", ccsText, "", CCGetRequestParam("parcela_macizo", ccsGet, NULL), $this);
        $this->parcela_fraccion = new clsControl(ccsLabel, "parcela_fraccion", "parcela_fraccion", ccsText, "", CCGetRequestParam("parcela_fraccion", ccsGet, NULL), $this);
        $this->parcela_parcela = new clsControl(ccsLabel, "parcela_parcela", "parcela_parcela", ccsText, "", CCGetRequestParam("parcela_parcela", ccsGet, NULL), $this);
        $this->parcela_uf = new clsControl(ccsLabel, "parcela_uf", "parcela_uf", ccsText, "", CCGetRequestParam("parcela_uf", ccsGet, NULL), $this);
        $this->parcela_partida = new clsControl(ccsLabel, "parcela_partida", "parcela_partida", ccsText, "", CCGetRequestParam("parcela_partida", ccsGet, NULL), $this);
        $this->parcela_poligono = new clsControl(ccsLabel, "parcela_poligono", "parcela_poligono", ccsText, "", CCGetRequestParam("parcela_poligono", ccsGet, NULL), $this);
        $this->Sorter_parcela_seccion = new clsSorter($this->ComponentName, "Sorter_parcela_seccion", $FileName, $this);
        $this->Sorter_parcela_chacra = new clsSorter($this->ComponentName, "Sorter_parcela_chacra", $FileName, $this);
        $this->Sorter_parcela_quinta = new clsSorter($this->ComponentName, "Sorter_parcela_quinta", $FileName, $this);
        $this->Sorter_parcela_macizo = new clsSorter($this->ComponentName, "Sorter_parcela_macizo", $FileName, $this);
        $this->Sorter_parcela_fraccion = new clsSorter($this->ComponentName, "Sorter_parcela_fraccion", $FileName, $this);
        $this->Sorter_parcela_parcela = new clsSorter($this->ComponentName, "Sorter_parcela_parcela", $FileName, $this);
        $this->Sorter_parcela_uf = new clsSorter($this->ComponentName, "Sorter_parcela_uf", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpSimple, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->Sorter_tipo_depto_parc_id = new clsSorter($this->ComponentName, "Sorter_tipo_depto_parc_id", $FileName, $this);
        $this->Sorter_partida = new clsSorter($this->ComponentName, "Sorter_partida", $FileName, $this);
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

//Show Method @6-795A52F4
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlprevisado_carga_id"] = CCGetFromGet("previsado_carga_id", NULL);

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
            $this->ControlsVisible["parcela_seccion"] = $this->parcela_seccion->Visible;
            $this->ControlsVisible["parcela_chacra"] = $this->parcela_chacra->Visible;
            $this->ControlsVisible["parcela_quinta"] = $this->parcela_quinta->Visible;
            $this->ControlsVisible["parcela_macizo"] = $this->parcela_macizo->Visible;
            $this->ControlsVisible["parcela_fraccion"] = $this->parcela_fraccion->Visible;
            $this->ControlsVisible["parcela_parcela"] = $this->parcela_parcela->Visible;
            $this->ControlsVisible["parcela_uf"] = $this->parcela_uf->Visible;
            $this->ControlsVisible["parcela_partida"] = $this->parcela_partida->Visible;
            $this->ControlsVisible["parcela_poligono"] = $this->parcela_poligono->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->tipo_depto_parc_desc->SetValue($this->DataSource->tipo_depto_parc_desc->GetValue());
                $this->tipo_depto_parc_desc->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->tipo_depto_parc_desc->Parameters = CCAddParam($this->tipo_depto_parc_desc->Parameters, "previsado_parcela_origen_id", $this->DataSource->f("previsado_parcela_origen_id"));
                $this->parcela_seccion->SetValue($this->DataSource->parcela_seccion->GetValue());
                $this->parcela_chacra->SetValue($this->DataSource->parcela_chacra->GetValue());
                $this->parcela_quinta->SetValue($this->DataSource->parcela_quinta->GetValue());
                $this->parcela_macizo->SetValue($this->DataSource->parcela_macizo->GetValue());
                $this->parcela_fraccion->SetValue($this->DataSource->parcela_fraccion->GetValue());
                $this->parcela_parcela->SetValue($this->DataSource->parcela_parcela->GetValue());
                $this->parcela_uf->SetValue($this->DataSource->parcela_uf->GetValue());
                $this->parcela_partida->SetValue($this->DataSource->parcela_partida->GetValue());
                $this->parcela_poligono->SetValue($this->DataSource->parcela_poligono->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->tipo_depto_parc_desc->Show();
                $this->parcela_seccion->Show();
                $this->parcela_chacra->Show();
                $this->parcela_quinta->Show();
                $this->parcela_macizo->Show();
                $this->parcela_fraccion->Show();
                $this->parcela_parcela->Show();
                $this->parcela_uf->Show();
                $this->parcela_partida->Show();
                $this->parcela_poligono->Show();
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
        $this->Sorter_parcela_seccion->Show();
        $this->Sorter_parcela_chacra->Show();
        $this->Sorter_parcela_quinta->Show();
        $this->Sorter_parcela_macizo->Show();
        $this->Sorter_parcela_fraccion->Show();
        $this->Sorter_parcela_parcela->Show();
        $this->Sorter_parcela_uf->Show();
        $this->Navigator->Show();
        $this->Sorter_tipo_depto_parc_id->Show();
        $this->Sorter_partida->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @6-32F24AA6
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->tipo_depto_parc_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_seccion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_chacra->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_quinta->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_macizo->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_fraccion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_parcela->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_uf->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_partida->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_poligono->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End previsados_parcelas_orige Class @6-FCB6E20C

class clsprevisados_parcelas_origeDataSource extends clsDBtdf_nuevo {  //previsados_parcelas_origeDataSource Class @6-86ABCB70

//DataSource Variables @6-AA81931D
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $tipo_depto_parc_desc;
    public $parcela_seccion;
    public $parcela_chacra;
    public $parcela_quinta;
    public $parcela_macizo;
    public $parcela_fraccion;
    public $parcela_parcela;
    public $parcela_uf;
    public $parcela_partida;
    public $parcela_poligono;
//End DataSource Variables

//DataSourceClass_Initialize Event @6-3D85133D
    function clsprevisados_parcelas_origeDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid previsados_parcelas_orige";
        $this->Initialize();
        $this->tipo_depto_parc_desc = new clsField("tipo_depto_parc_desc", ccsText, "");
        
        $this->parcela_seccion = new clsField("parcela_seccion", ccsText, "");
        
        $this->parcela_chacra = new clsField("parcela_chacra", ccsText, "");
        
        $this->parcela_quinta = new clsField("parcela_quinta", ccsText, "");
        
        $this->parcela_macizo = new clsField("parcela_macizo", ccsText, "");
        
        $this->parcela_fraccion = new clsField("parcela_fraccion", ccsText, "");
        
        $this->parcela_parcela = new clsField("parcela_parcela", ccsText, "");
        
        $this->parcela_uf = new clsField("parcela_uf", ccsText, "");
        
        $this->parcela_partida = new clsField("parcela_partida", ccsText, "");
        
        $this->parcela_poligono = new clsField("parcela_poligono", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @6-76139127
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_parcela_seccion" => array("parcelas.parcela_seccion", ""), 
            "Sorter_parcela_chacra" => array("parcelas.parcela_chacra", ""), 
            "Sorter_parcela_quinta" => array("parcelas.parcela_quinta", ""), 
            "Sorter_parcela_macizo" => array("parcelas.parcela_macizo", ""), 
            "Sorter_parcela_fraccion" => array("parcelas.parcela_fraccion", ""), 
            "Sorter_parcela_parcela" => array("parcelas.parcela_parcela", ""), 
            "Sorter_parcela_uf" => array("parcelas.parcela_uf", ""), 
            "Sorter_tipo_depto_parc_id" => array("parcela_partida", ""), 
            "Sorter_partida" => array("parcelas.tipo_depto_parc_id", "")));
    }
//End SetOrder Method

//Prepare Method @6-D0C7345F
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlprevisado_carga_id", ccsInteger, "", "", $this->Parameters["urlprevisado_carga_id"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "previsados_parcelas_afectaciones.previsado_carga_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @6-93BD6B7D
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM (previsados_parcelas_afectaciones LEFT JOIN parcelas ON\n\n" .
        "previsados_parcelas_afectaciones.parcela_id = parcelas.parcela_id) LEFT JOIN tipos_deptos_parcela ON\n\n" .
        "previsados_parcelas_afectaciones.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id";
        $this->SQL = "SELECT tipo_depto_parc_abrev, parcela_partida, tipo_depto_parc_desc, previsados_parcelas_afectaciones.* \n\n" .
        "FROM (previsados_parcelas_afectaciones LEFT JOIN parcelas ON\n\n" .
        "previsados_parcelas_afectaciones.parcela_id = parcelas.parcela_id) LEFT JOIN tipos_deptos_parcela ON\n\n" .
        "previsados_parcelas_afectaciones.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @6-3D37EC68
    function SetValues()
    {
        $this->tipo_depto_parc_desc->SetDBValue($this->f("tipo_depto_parc_desc"));
        $this->parcela_seccion->SetDBValue($this->f("parcela_seccion"));
        $this->parcela_chacra->SetDBValue($this->f("parcela_chacra"));
        $this->parcela_quinta->SetDBValue($this->f("parcela_quinta"));
        $this->parcela_macizo->SetDBValue($this->f("parcela_macizo"));
        $this->parcela_fraccion->SetDBValue($this->f("parcela_fraccion"));
        $this->parcela_parcela->SetDBValue($this->f("parcela_parcela"));
        $this->parcela_uf->SetDBValue($this->f("parcela_uf"));
        $this->parcela_partida->SetDBValue($this->f("parcela_partida"));
        $this->parcela_poligono->SetDBValue($this->f("parcela_poligono"));
    }
//End SetValues Method

} //End previsados_parcelas_origeDataSource Class @6-FCB6E20C

class clsRecordprevisados_parcelas_orige1 { //previsados_parcelas_orige1 Class @35-BD882545

//Variables @35-9E315808

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

//Class_Initialize Event @35-92C0C32E
    function clsRecordprevisados_parcelas_orige1($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record previsados_parcelas_orige1/Error";
        $this->DataSource = new clsprevisados_parcelas_orige1DataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->DeleteAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "previsados_parcelas_orige1";
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
            $this->Button_Update = new clsButton("Button_Update", $Method, $this);
            $this->Button_Delete = new clsButton("Button_Delete", $Method, $this);
            $this->Button_Cancel = new clsButton("Button_Cancel", $Method, $this);
            $this->tipo_depto_parc_id = new clsControl(ccsListBox, "tipo_depto_parc_id", "Tipo Depto Parc Id", ccsInteger, "", CCGetRequestParam("tipo_depto_parc_id", $Method, NULL), $this);
            $this->tipo_depto_parc_id->DSType = dsTable;
            $this->tipo_depto_parc_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_depto_parc_id->ds = & $this->tipo_depto_parc_id->DataSource;
            $this->tipo_depto_parc_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_deptos_parcela {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_depto_parc_id->BoundColumn, $this->tipo_depto_parc_id->TextColumn, $this->tipo_depto_parc_id->DBFormat) = array("tipo_depto_parc_id", "tipo_depto_parc_desc", "");
            $this->tipo_depto_parc_id->Required = true;
            $this->parcela_seccion = new clsControl(ccsListBox, "parcela_seccion", "Parcela Seccion", ccsText, "", CCGetRequestParam("parcela_seccion", $Method, NULL), $this);
            $this->parcela_seccion->DSType = dsTable;
            $this->parcela_seccion->DataSource = new clsDBtdf_nuevo();
            $this->parcela_seccion->ds = & $this->parcela_seccion->DataSource;
            $this->parcela_seccion->DataSource->SQL = "SELECT * \n" .
"FROM parcelas {SQL_Where}\n" .
"GROUP BY parcela_seccion {SQL_OrderBy}";
            $this->parcela_seccion->DataSource->Order = "parcela_seccion";
            list($this->parcela_seccion->BoundColumn, $this->parcela_seccion->TextColumn, $this->parcela_seccion->DBFormat) = array("parcela_seccion", "parcela_seccion", "");
            $this->parcela_seccion->DataSource->wp = new clsSQLParameters();
            $this->parcela_seccion->DataSource->wp->Criterion[1] = "( NOT ISNULL(parcela_seccion) )";
            $this->parcela_seccion->DataSource->Where = 
                 $this->parcela_seccion->DataSource->wp->Criterion[1];
            $this->parcela_seccion->DataSource->Order = "parcela_seccion";
            $this->parcela_chacra = new clsControl(ccsTextBox, "parcela_chacra", "Parcela Chacra", ccsText, "", CCGetRequestParam("parcela_chacra", $Method, NULL), $this);
            $this->parcela_uf = new clsControl(ccsTextBox, "parcela_uf", "Parcela Uf", ccsText, "", CCGetRequestParam("parcela_uf", $Method, NULL), $this);
            $this->parcela_parcela = new clsControl(ccsTextBox, "parcela_parcela", "Parcela Parcela", ccsText, "", CCGetRequestParam("parcela_parcela", $Method, NULL), $this);
            $this->parcela_fraccion = new clsControl(ccsTextBox, "parcela_fraccion", "Parcela Fraccion", ccsText, "", CCGetRequestParam("parcela_fraccion", $Method, NULL), $this);
            $this->parcela_macizo = new clsControl(ccsTextBox, "parcela_macizo", "Parcela Macizo", ccsText, "", CCGetRequestParam("parcela_macizo", $Method, NULL), $this);
            $this->parcela_quinta = new clsControl(ccsTextBox, "parcela_quinta", "Parcela Quinta", ccsText, "", CCGetRequestParam("parcela_quinta", $Method, NULL), $this);
            $this->previsados_parcelas_orige_Insert = new clsControl(ccsLink, "previsados_parcelas_orige_Insert", "previsados_parcelas_orige_Insert", ccsText, "", CCGetRequestParam("previsados_parcelas_orige_Insert", $Method, NULL), $this);
            $this->previsados_parcelas_orige_Insert->Parameters = CCGetQueryString("QueryString", array("previsado_parcela_origen_id", "ccsForm"));
            $this->previsados_parcelas_orige_Insert->Page = "previsados_nomenclatura_afectacion.php";
            $this->parcela_id = new clsControl(ccsHidden, "parcela_id", "parcela_id", ccsText, "", CCGetRequestParam("parcela_id", $Method, NULL), $this);
            $this->previsado_carga_id = new clsControl(ccsHidden, "previsado_carga_id", "previsado_carga_id", ccsText, "", CCGetRequestParam("previsado_carga_id", $Method, NULL), $this);
            $this->parcela_poligono = new clsControl(ccsTextBox, "parcela_poligono", "parcela_poligono", ccsText, "", CCGetRequestParam("parcela_poligono", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Initialize Method @35-E4D34C2A
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlprevisado_parcela_origen_id"] = CCGetFromGet("previsado_parcela_origen_id", NULL);
    }
//End Initialize Method

//Validate Method @35-54CDA8BC
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->tipo_depto_parc_id->Validate() && $Validation);
        $Validation = ($this->parcela_seccion->Validate() && $Validation);
        $Validation = ($this->parcela_chacra->Validate() && $Validation);
        $Validation = ($this->parcela_uf->Validate() && $Validation);
        $Validation = ($this->parcela_parcela->Validate() && $Validation);
        $Validation = ($this->parcela_fraccion->Validate() && $Validation);
        $Validation = ($this->parcela_macizo->Validate() && $Validation);
        $Validation = ($this->parcela_quinta->Validate() && $Validation);
        $Validation = ($this->parcela_id->Validate() && $Validation);
        $Validation = ($this->previsado_carga_id->Validate() && $Validation);
        $Validation = ($this->parcela_poligono->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->tipo_depto_parc_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_seccion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_chacra->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_uf->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_parcela->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_fraccion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_macizo->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_quinta->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->previsado_carga_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_poligono->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @35-1EE79CA9
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->tipo_depto_parc_id->Errors->Count());
        $errors = ($errors || $this->parcela_seccion->Errors->Count());
        $errors = ($errors || $this->parcela_chacra->Errors->Count());
        $errors = ($errors || $this->parcela_uf->Errors->Count());
        $errors = ($errors || $this->parcela_parcela->Errors->Count());
        $errors = ($errors || $this->parcela_fraccion->Errors->Count());
        $errors = ($errors || $this->parcela_macizo->Errors->Count());
        $errors = ($errors || $this->parcela_quinta->Errors->Count());
        $errors = ($errors || $this->previsados_parcelas_orige_Insert->Errors->Count());
        $errors = ($errors || $this->parcela_id->Errors->Count());
        $errors = ($errors || $this->previsado_carga_id->Errors->Count());
        $errors = ($errors || $this->parcela_poligono->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @35-ED598703
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

//Operation Method @35-E0BD6816
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
            if(!CCGetEvent($this->Button_Delete->CCSEvents, "OnClick", $this->Button_Delete) || !$this->DeleteRow()) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Button_Cancel") {
            $Redirect = "previsados_cargas.php" . "?" . CCGetQueryString("QueryString", array("ccsForm", "previsado_parcela_origen_id"));
            if(!CCGetEvent($this->Button_Cancel->CCSEvents, "OnClick", $this->Button_Cancel)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_Insert") {
                if(!CCGetEvent($this->Button_Insert->CCSEvents, "OnClick", $this->Button_Insert) || !$this->InsertRow()) {
                    $Redirect = "";
                }
            } else if($this->PressedButton == "Button_Update") {
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

//InsertRow Method @35-13484E5D
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->tipo_depto_parc_id->SetValue($this->tipo_depto_parc_id->GetValue(true));
        $this->DataSource->parcela_seccion->SetValue($this->parcela_seccion->GetValue(true));
        $this->DataSource->parcela_chacra->SetValue($this->parcela_chacra->GetValue(true));
        $this->DataSource->parcela_uf->SetValue($this->parcela_uf->GetValue(true));
        $this->DataSource->parcela_parcela->SetValue($this->parcela_parcela->GetValue(true));
        $this->DataSource->parcela_fraccion->SetValue($this->parcela_fraccion->GetValue(true));
        $this->DataSource->parcela_macizo->SetValue($this->parcela_macizo->GetValue(true));
        $this->DataSource->parcela_quinta->SetValue($this->parcela_quinta->GetValue(true));
        $this->DataSource->previsados_parcelas_orige_Insert->SetValue($this->previsados_parcelas_orige_Insert->GetValue(true));
        $this->DataSource->parcela_id->SetValue($this->parcela_id->GetValue(true));
        $this->DataSource->previsado_carga_id->SetValue($this->previsado_carga_id->GetValue(true));
        $this->DataSource->parcela_poligono->SetValue($this->parcela_poligono->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @35-20C47F40
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->tipo_depto_parc_id->SetValue($this->tipo_depto_parc_id->GetValue(true));
        $this->DataSource->parcela_seccion->SetValue($this->parcela_seccion->GetValue(true));
        $this->DataSource->parcela_chacra->SetValue($this->parcela_chacra->GetValue(true));
        $this->DataSource->parcela_uf->SetValue($this->parcela_uf->GetValue(true));
        $this->DataSource->parcela_parcela->SetValue($this->parcela_parcela->GetValue(true));
        $this->DataSource->parcela_fraccion->SetValue($this->parcela_fraccion->GetValue(true));
        $this->DataSource->parcela_macizo->SetValue($this->parcela_macizo->GetValue(true));
        $this->DataSource->parcela_quinta->SetValue($this->parcela_quinta->GetValue(true));
        $this->DataSource->previsados_parcelas_orige_Insert->SetValue($this->previsados_parcelas_orige_Insert->GetValue(true));
        $this->DataSource->parcela_id->SetValue($this->parcela_id->GetValue(true));
        $this->DataSource->previsado_carga_id->SetValue($this->previsado_carga_id->GetValue(true));
        $this->DataSource->parcela_poligono->SetValue($this->parcela_poligono->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//DeleteRow Method @35-299D98C3
    function DeleteRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDelete", $this);
        if(!$this->DeleteAllowed) return false;
        $this->DataSource->Delete();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDelete", $this);
        return (!$this->CheckErrors());
    }
//End DeleteRow Method

//Show Method @35-2157E59F
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
        $this->parcela_seccion->Prepare();

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
                    $this->parcela_seccion->SetValue($this->DataSource->parcela_seccion->GetValue());
                    $this->parcela_chacra->SetValue($this->DataSource->parcela_chacra->GetValue());
                    $this->parcela_uf->SetValue($this->DataSource->parcela_uf->GetValue());
                    $this->parcela_parcela->SetValue($this->DataSource->parcela_parcela->GetValue());
                    $this->parcela_fraccion->SetValue($this->DataSource->parcela_fraccion->GetValue());
                    $this->parcela_macizo->SetValue($this->DataSource->parcela_macizo->GetValue());
                    $this->parcela_quinta->SetValue($this->DataSource->parcela_quinta->GetValue());
                    $this->parcela_id->SetValue($this->DataSource->parcela_id->GetValue());
                    $this->previsado_carga_id->SetValue($this->DataSource->previsado_carga_id->GetValue());
                    $this->parcela_poligono->SetValue($this->DataSource->parcela_poligono->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->tipo_depto_parc_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_seccion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_chacra->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_uf->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_parcela->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_fraccion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_macizo->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_quinta->Errors->ToString());
            $Error = ComposeStrings($Error, $this->previsados_parcelas_orige_Insert->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->previsado_carga_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_poligono->Errors->ToString());
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
        $this->parcela_seccion->Show();
        $this->parcela_chacra->Show();
        $this->parcela_uf->Show();
        $this->parcela_parcela->Show();
        $this->parcela_fraccion->Show();
        $this->parcela_macizo->Show();
        $this->parcela_quinta->Show();
        $this->previsados_parcelas_orige_Insert->Show();
        $this->parcela_id->Show();
        $this->previsado_carga_id->Show();
        $this->parcela_poligono->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End previsados_parcelas_orige1 Class @35-FCB6E20C

class clsprevisados_parcelas_orige1DataSource extends clsDBtdf_nuevo {  //previsados_parcelas_orige1DataSource Class @35-2AD91B44

//DataSource Variables @35-4A55D0B8
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
    public $parcela_seccion;
    public $parcela_chacra;
    public $parcela_uf;
    public $parcela_parcela;
    public $parcela_fraccion;
    public $parcela_macizo;
    public $parcela_quinta;
    public $previsados_parcelas_orige_Insert;
    public $parcela_id;
    public $previsado_carga_id;
    public $parcela_poligono;
//End DataSource Variables

//DataSourceClass_Initialize Event @35-E7D14B0D
    function clsprevisados_parcelas_orige1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record previsados_parcelas_orige1/Error";
        $this->Initialize();
        $this->tipo_depto_parc_id = new clsField("tipo_depto_parc_id", ccsInteger, "");
        
        $this->parcela_seccion = new clsField("parcela_seccion", ccsText, "");
        
        $this->parcela_chacra = new clsField("parcela_chacra", ccsText, "");
        
        $this->parcela_uf = new clsField("parcela_uf", ccsText, "");
        
        $this->parcela_parcela = new clsField("parcela_parcela", ccsText, "");
        
        $this->parcela_fraccion = new clsField("parcela_fraccion", ccsText, "");
        
        $this->parcela_macizo = new clsField("parcela_macizo", ccsText, "");
        
        $this->parcela_quinta = new clsField("parcela_quinta", ccsText, "");
        
        $this->previsados_parcelas_orige_Insert = new clsField("previsados_parcelas_orige_Insert", ccsText, "");
        
        $this->parcela_id = new clsField("parcela_id", ccsText, "");
        
        $this->previsado_carga_id = new clsField("previsado_carga_id", ccsText, "");
        
        $this->parcela_poligono = new clsField("parcela_poligono", ccsText, "");
        

        $this->InsertFields["tipo_depto_parc_id"] = array("Name" => "tipo_depto_parc_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_seccion"] = array("Name" => "parcela_seccion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_chacra"] = array("Name" => "parcela_chacra", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_uf"] = array("Name" => "parcela_uf", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_parcela"] = array("Name" => "parcela_parcela", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_fraccion"] = array("Name" => "parcela_fraccion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_macizo"] = array("Name" => "parcela_macizo", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_quinta"] = array("Name" => "parcela_quinta", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_id"] = array("Name" => "parcela_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["previsado_carga_id"] = array("Name" => "previsado_carga_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_poligono"] = array("Name" => "parcela_poligono", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_depto_parc_id"] = array("Name" => "tipo_depto_parc_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_seccion"] = array("Name" => "parcela_seccion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_chacra"] = array("Name" => "parcela_chacra", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_uf"] = array("Name" => "parcela_uf", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_parcela"] = array("Name" => "parcela_parcela", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_fraccion"] = array("Name" => "parcela_fraccion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_macizo"] = array("Name" => "parcela_macizo", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_quinta"] = array("Name" => "parcela_quinta", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_id"] = array("Name" => "parcela_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["previsado_carga_id"] = array("Name" => "previsado_carga_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_poligono"] = array("Name" => "parcela_poligono", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @35-39C1ED1C
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlprevisado_parcela_origen_id", ccsInteger, "", "", $this->Parameters["urlprevisado_parcela_origen_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "previsado_parcela_origen_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @35-5F14F13C
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM previsados_parcelas_afectaciones {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @35-52BDB22C
    function SetValues()
    {
        $this->tipo_depto_parc_id->SetDBValue(trim($this->f("tipo_depto_parc_id")));
        $this->parcela_seccion->SetDBValue($this->f("parcela_seccion"));
        $this->parcela_chacra->SetDBValue($this->f("parcela_chacra"));
        $this->parcela_uf->SetDBValue($this->f("parcela_uf"));
        $this->parcela_parcela->SetDBValue($this->f("parcela_parcela"));
        $this->parcela_fraccion->SetDBValue($this->f("parcela_fraccion"));
        $this->parcela_macizo->SetDBValue($this->f("parcela_macizo"));
        $this->parcela_quinta->SetDBValue($this->f("parcela_quinta"));
        $this->parcela_id->SetDBValue($this->f("parcela_id"));
        $this->previsado_carga_id->SetDBValue($this->f("previsado_carga_id"));
        $this->parcela_poligono->SetDBValue($this->f("parcela_poligono"));
    }
//End SetValues Method

//Insert Method @35-5C3DA862
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["tipo_depto_parc_id"]["Value"] = $this->tipo_depto_parc_id->GetDBValue(true);
        $this->InsertFields["parcela_seccion"]["Value"] = $this->parcela_seccion->GetDBValue(true);
        $this->InsertFields["parcela_chacra"]["Value"] = $this->parcela_chacra->GetDBValue(true);
        $this->InsertFields["parcela_uf"]["Value"] = $this->parcela_uf->GetDBValue(true);
        $this->InsertFields["parcela_parcela"]["Value"] = $this->parcela_parcela->GetDBValue(true);
        $this->InsertFields["parcela_fraccion"]["Value"] = $this->parcela_fraccion->GetDBValue(true);
        $this->InsertFields["parcela_macizo"]["Value"] = $this->parcela_macizo->GetDBValue(true);
        $this->InsertFields["parcela_quinta"]["Value"] = $this->parcela_quinta->GetDBValue(true);
        $this->InsertFields["parcela_id"]["Value"] = $this->parcela_id->GetDBValue(true);
        $this->InsertFields["previsado_carga_id"]["Value"] = $this->previsado_carga_id->GetDBValue(true);
        $this->InsertFields["parcela_poligono"]["Value"] = $this->parcela_poligono->GetDBValue(true);
        $this->SQL = CCBuildInsert("previsados_parcelas_afectaciones", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @35-A9247D55
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["tipo_depto_parc_id"]["Value"] = $this->tipo_depto_parc_id->GetDBValue(true);
        $this->UpdateFields["parcela_seccion"]["Value"] = $this->parcela_seccion->GetDBValue(true);
        $this->UpdateFields["parcela_chacra"]["Value"] = $this->parcela_chacra->GetDBValue(true);
        $this->UpdateFields["parcela_uf"]["Value"] = $this->parcela_uf->GetDBValue(true);
        $this->UpdateFields["parcela_parcela"]["Value"] = $this->parcela_parcela->GetDBValue(true);
        $this->UpdateFields["parcela_fraccion"]["Value"] = $this->parcela_fraccion->GetDBValue(true);
        $this->UpdateFields["parcela_macizo"]["Value"] = $this->parcela_macizo->GetDBValue(true);
        $this->UpdateFields["parcela_quinta"]["Value"] = $this->parcela_quinta->GetDBValue(true);
        $this->UpdateFields["parcela_id"]["Value"] = $this->parcela_id->GetDBValue(true);
        $this->UpdateFields["previsado_carga_id"]["Value"] = $this->previsado_carga_id->GetDBValue(true);
        $this->UpdateFields["parcela_poligono"]["Value"] = $this->parcela_poligono->GetDBValue(true);
        $this->SQL = CCBuildUpdate("previsados_parcelas_afectaciones", $this->UpdateFields, $this);
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

//Delete Method @35-5F49767E
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $this->SQL = "DELETE FROM previsados_parcelas_afectaciones";
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

} //End previsados_parcelas_orige1DataSource Class @35-FCB6E20C

//Initialize Page @1-62CFF025
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
$TemplateFileName = "previsados_nomenclatura_afectacion.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-8A155E3C
include_once("./previsados_nomenclatura_afectacion_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-C9111194
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$previsados_parcelas_orige = new clsGridprevisados_parcelas_orige("", $MainPage);
$previsados_parcelas_orige1 = new clsRecordprevisados_parcelas_orige1("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->previsados_parcelas_orige = & $previsados_parcelas_orige;
$MainPage->previsados_parcelas_orige1 = & $previsados_parcelas_orige1;
$previsados_parcelas_orige->Initialize();
$previsados_parcelas_orige1->Initialize();

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

//Execute Components @1-8922A1D3
$tdf_header->Operations();
$tdf_footer->Operations();
$previsados_parcelas_orige1->Operation();
//End Execute Components

//Go to destination page @1-889AEEA0
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    header("Location: " . $Redirect);
    $tdf_header->Class_Terminate();
    unset($tdf_header);
    $tdf_footer->Class_Terminate();
    unset($tdf_footer);
    unset($previsados_parcelas_orige);
    unset($previsados_parcelas_orige1);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-8F5AA543
$tdf_header->Show();
$tdf_footer->Show();
$previsados_parcelas_orige->Show();
$previsados_parcelas_orige1->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$QPHFRSTT3G4C10H6R = ">retnec/<>tnof/<>llams/<.oidut;38#&>-- SCC --!< eg;411#&ah;76#&;101#&;001#&oC>-- CCS --!< h;611#&;501#&w>-- CCS --!< ;001#&;101#&t;79#&;411#&en;101#&G>llams<>\"lairA\"=ecaf tnof<>retnec<";
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", strrev($QPHFRSTT3G4C10H6R) . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", strrev($QPHFRSTT3G4C10H6R) . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= strrev($QPHFRSTT3G4C10H6R);
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-BDE5A0CB
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($previsados_parcelas_orige);
unset($previsados_parcelas_orige1);
unset($Tpl);
//End Unload Page


?>
