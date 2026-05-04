<?php
//Include Common Files @1-4BF1F250
define("RelativePath", "..");
define("PathToCurrentPage", "/previsado/");
define("FileName", "previsados_consola.php");
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

class clsGridprevisados_cargas { //previsados_cargas class @4-9E0F350E

//Variables @4-4CD45F7D

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
    public $Sorter_previsado_carga_proc;
    public $Sorter_previsado_tipo_plano_id;
    public $Sorter_previsado_carga_ubica_cat;
    public $Sorter_previsado_tipo_estado_carga_id;
//End Variables

//Class_Initialize Event @4-E6AD4C8E
    function clsGridprevisados_cargas($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "previsados_cargas";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid previsados_cargas";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsprevisados_cargasDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 15;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;
        $this->SorterName = CCGetParam("previsados_cargasOrder", "");
        $this->SorterDirection = CCGetParam("previsados_cargasDir", "");

        $this->previsado_carga_proc = new clsControl(ccsLabel, "previsado_carga_proc", "previsado_carga_proc", ccsDate, array("dd", "/", "mm", "/", "yyyy"), CCGetRequestParam("previsado_carga_proc", ccsGet, NULL), $this);
        $this->previsado_titular = new clsControl(ccsLabel, "previsado_titular", "previsado_titular", ccsText, "", CCGetRequestParam("previsado_titular", ccsGet, NULL), $this);
        $this->previsado_titular->HTML = true;
        $this->previsado_tipo_plano_descrip = new clsControl(ccsLabel, "previsado_tipo_plano_descrip", "previsado_tipo_plano_descrip", ccsText, "", CCGetRequestParam("previsado_tipo_plano_descrip", ccsGet, NULL), $this);
        $this->previsado_nombre_archivo_org = new clsControl(ccsLabel, "previsado_nombre_archivo_org", "previsado_nombre_archivo_org", ccsText, "", CCGetRequestParam("previsado_nombre_archivo_org", ccsGet, NULL), $this);
        $this->previsado_tipo_estado_carga_id = new clsControl(ccsLabel, "previsado_tipo_estado_carga_id", "previsado_tipo_estado_carga_id", ccsInteger, "", CCGetRequestParam("previsado_tipo_estado_carga_id", ccsGet, NULL), $this);
        $this->previsado_tipo_estado_carga_id->HTML = true;
        $this->ImageLink1 = new clsControl(ccsImageLink, "ImageLink1", "ImageLink1", ccsText, "", CCGetRequestParam("ImageLink1", ccsGet, NULL), $this);
        $this->ImageLink1->Page = "previsados_cargas.php";
        $this->ImageLink2 = new clsControl(ccsLabel, "ImageLink2", "ImageLink2", ccsText, "", CCGetRequestParam("ImageLink2", ccsGet, NULL), $this);
        $this->ImageLink2->HTML = true;
        $this->resultado = new clsControl(ccsLabel, "resultado", "resultado", ccsText, "", CCGetRequestParam("resultado", ccsGet, NULL), $this);
        $this->resultado->HTML = true;
        $this->pdf_respuesta = new clsControl(ccsLabel, "pdf_respuesta", "pdf_respuesta", ccsText, "", CCGetRequestParam("pdf_respuesta", ccsGet, NULL), $this);
        $this->pdf_respuesta->HTML = true;
        $this->nomenclatura_origen = new clsControl(ccsLabel, "nomenclatura_origen", "nomenclatura_origen", ccsText, "", CCGetRequestParam("nomenclatura_origen", ccsGet, NULL), $this);
        $this->nomenclatura_origen->HTML = true;
        $this->icono = new clsControl(ccsLabel, "icono", "icono", ccsText, "", CCGetRequestParam("icono", ccsGet, NULL), $this);
        $this->icono->HTML = true;
        $this->cant = new clsControl(ccsLabel, "cant", "cant", ccsText, "", CCGetRequestParam("cant", ccsGet, NULL), $this);
        $this->cant->HTML = true;
        $this->nomenclatura_destino = new clsControl(ccsLabel, "nomenclatura_destino", "nomenclatura_destino", ccsText, "", CCGetRequestParam("nomenclatura_destino", ccsGet, NULL), $this);
        $this->nomenclatura_destino->HTML = true;
        $this->Sorter_previsado_carga_proc = new clsSorter($this->ComponentName, "Sorter_previsado_carga_proc", $FileName, $this);
        $this->Sorter_previsado_tipo_plano_id = new clsSorter($this->ComponentName, "Sorter_previsado_tipo_plano_id", $FileName, $this);
        $this->Sorter_previsado_carga_ubica_cat = new clsSorter($this->ComponentName, "Sorter_previsado_carga_ubica_cat", $FileName, $this);
        $this->Sorter_previsado_tipo_estado_carga_id = new clsSorter($this->ComponentName, "Sorter_previsado_tipo_estado_carga_id", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpSimple, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
    }
//End Class_Initialize Event

//Initialize Method @4-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @4-F5CB0609
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["sesuser_id"] = CCGetSession("user_id", NULL);
        $this->DataSource->Parameters["urls_previsado_carga_proc"] = CCGetFromGet("s_previsado_carga_proc", NULL);
        $this->DataSource->Parameters["urls_previsado_tipo_plano_id"] = CCGetFromGet("s_previsado_tipo_plano_id", NULL);
        $this->DataSource->Parameters["urls_tipo_depto_parc_id_o"] = CCGetFromGet("s_tipo_depto_parc_id_o", NULL);
        $this->DataSource->Parameters["urls_parcela_seccion_o"] = CCGetFromGet("s_parcela_seccion_o", NULL);
        $this->DataSource->Parameters["urls_parcela_chacra_o"] = CCGetFromGet("s_parcela_chacra_o", NULL);
        $this->DataSource->Parameters["urls_parcela_quinta_o"] = CCGetFromGet("s_parcela_quinta_o", NULL);
        $this->DataSource->Parameters["urls_parcela_macizo_o"] = CCGetFromGet("s_parcela_macizo_o", NULL);
        $this->DataSource->Parameters["urls_parcela_fraccion_o"] = CCGetFromGet("s_parcela_fraccion_o", NULL);
        $this->DataSource->Parameters["urls_parcela_parcela_o"] = CCGetFromGet("s_parcela_parcela_o", NULL);
        $this->DataSource->Parameters["urls_parcela_uf_o"] = CCGetFromGet("s_parcela_uf_o", NULL);
        $this->DataSource->Parameters["urls_previsado_titular"] = CCGetFromGet("s_previsado_titular", NULL);
        $this->DataSource->Parameters["urls_tipo_depto_parc_id_d"] = CCGetFromGet("s_tipo_depto_parc_id_d", NULL);
        $this->DataSource->Parameters["urls_parcela_seccion_d"] = CCGetFromGet("s_parcela_seccion_d", NULL);
        $this->DataSource->Parameters["urls_parcela_chacra_d"] = CCGetFromGet("s_parcela_chacra_d", NULL);
        $this->DataSource->Parameters["urls_parcela_quinta_d"] = CCGetFromGet("s_parcela_quinta_d", NULL);
        $this->DataSource->Parameters["urls_parcela_macizo_d"] = CCGetFromGet("s_parcela_macizo_d", NULL);
        $this->DataSource->Parameters["urls_parcela_fraccion_d"] = CCGetFromGet("s_parcela_fraccion_d", NULL);
        $this->DataSource->Parameters["urls_parcela_parcela_d"] = CCGetFromGet("s_parcela_parcela_d", NULL);
        $this->DataSource->Parameters["urls_parcela_uf_d"] = CCGetFromGet("s_parcela_uf_d", NULL);

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
            $this->ControlsVisible["previsado_carga_proc"] = $this->previsado_carga_proc->Visible;
            $this->ControlsVisible["previsado_titular"] = $this->previsado_titular->Visible;
            $this->ControlsVisible["previsado_tipo_plano_descrip"] = $this->previsado_tipo_plano_descrip->Visible;
            $this->ControlsVisible["previsado_nombre_archivo_org"] = $this->previsado_nombre_archivo_org->Visible;
            $this->ControlsVisible["previsado_tipo_estado_carga_id"] = $this->previsado_tipo_estado_carga_id->Visible;
            $this->ControlsVisible["ImageLink1"] = $this->ImageLink1->Visible;
            $this->ControlsVisible["ImageLink2"] = $this->ImageLink2->Visible;
            $this->ControlsVisible["resultado"] = $this->resultado->Visible;
            $this->ControlsVisible["pdf_respuesta"] = $this->pdf_respuesta->Visible;
            $this->ControlsVisible["nomenclatura_origen"] = $this->nomenclatura_origen->Visible;
            $this->ControlsVisible["icono"] = $this->icono->Visible;
            $this->ControlsVisible["cant"] = $this->cant->Visible;
            $this->ControlsVisible["nomenclatura_destino"] = $this->nomenclatura_destino->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->previsado_carga_proc->SetValue($this->DataSource->previsado_carga_proc->GetValue());
                $this->previsado_tipo_plano_descrip->SetValue($this->DataSource->previsado_tipo_plano_descrip->GetValue());
                $this->previsado_nombre_archivo_org->SetValue($this->DataSource->previsado_nombre_archivo_org->GetValue());
                $this->previsado_tipo_estado_carga_id->SetValue($this->DataSource->previsado_tipo_estado_carga_id->GetValue());
                $this->ImageLink1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "previsado_carga_id", $this->DataSource->f("previsado_carga_id"));
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->previsado_carga_proc->Show();
                $this->previsado_titular->Show();
                $this->previsado_tipo_plano_descrip->Show();
                $this->previsado_nombre_archivo_org->Show();
                $this->previsado_tipo_estado_carga_id->Show();
                $this->ImageLink1->Show();
                $this->ImageLink2->Show();
                $this->resultado->Show();
                $this->pdf_respuesta->Show();
                $this->nomenclatura_origen->Show();
                $this->icono->Show();
                $this->cant->Show();
                $this->nomenclatura_destino->Show();
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
        $this->Sorter_previsado_carga_proc->Show();
        $this->Sorter_previsado_tipo_plano_id->Show();
        $this->Sorter_previsado_carga_ubica_cat->Show();
        $this->Sorter_previsado_tipo_estado_carga_id->Show();
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @4-4A8BD42C
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->previsado_carga_proc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->previsado_titular->Errors->ToString());
        $errors = ComposeStrings($errors, $this->previsado_tipo_plano_descrip->Errors->ToString());
        $errors = ComposeStrings($errors, $this->previsado_nombre_archivo_org->Errors->ToString());
        $errors = ComposeStrings($errors, $this->previsado_tipo_estado_carga_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ImageLink1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ImageLink2->Errors->ToString());
        $errors = ComposeStrings($errors, $this->resultado->Errors->ToString());
        $errors = ComposeStrings($errors, $this->pdf_respuesta->Errors->ToString());
        $errors = ComposeStrings($errors, $this->nomenclatura_origen->Errors->ToString());
        $errors = ComposeStrings($errors, $this->icono->Errors->ToString());
        $errors = ComposeStrings($errors, $this->cant->Errors->ToString());
        $errors = ComposeStrings($errors, $this->nomenclatura_destino->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End previsados_cargas Class @4-FCB6E20C

class clsprevisados_cargasDataSource extends clsDBtdf_nuevo {  //previsados_cargasDataSource Class @4-D9184292

//DataSource Variables @4-FFFF0EA5
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $previsado_carga_proc;
    public $previsado_tipo_plano_descrip;
    public $previsado_nombre_archivo_org;
    public $previsado_tipo_estado_carga_id;
//End DataSource Variables

//DataSourceClass_Initialize Event @4-9C45F323
    function clsprevisados_cargasDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid previsados_cargas";
        $this->Initialize();
        $this->previsado_carga_proc = new clsField("previsado_carga_proc", ccsDate, $this->DateFormat);
        
        $this->previsado_tipo_plano_descrip = new clsField("previsado_tipo_plano_descrip", ccsText, "");
        
        $this->previsado_nombre_archivo_org = new clsField("previsado_nombre_archivo_org", ccsText, "");
        
        $this->previsado_tipo_estado_carga_id = new clsField("previsado_tipo_estado_carga_id", ccsInteger, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @4-C47076AE
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "previsados_cargas.previsado_carga_proc desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_previsado_carga_proc" => array("previsado_carga_proc", ""), 
            "Sorter_previsado_tipo_plano_id" => array("previsado_tipo_plano_id", ""), 
            "Sorter_previsado_carga_ubica_cat" => array("previsado_carga_ubica_cat", ""), 
            "Sorter_previsado_tipo_estado_carga_id" => array("previsado_tipo_estado_carga_id", "")));
    }
//End SetOrder Method

//Prepare Method @4-DFFDBD4B
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "sesuser_id", ccsInteger, "", "", $this->Parameters["sesuser_id"], "", false);
        $this->wp->AddParameter("2", "urls_previsado_carga_proc", ccsDate, array("dd", "/", "mm", "/", "yyyy"), array("yyyy", "-", "mm", "-", "dd", " ", "HH", ":", "nn", ":", "ss"), $this->Parameters["urls_previsado_carga_proc"], "", false);
        $this->wp->AddParameter("3", "urls_previsado_tipo_plano_id", ccsInteger, "", "", $this->Parameters["urls_previsado_tipo_plano_id"], "", false);
        $this->wp->AddParameter("4", "urls_tipo_depto_parc_id_o", ccsInteger, "", "", $this->Parameters["urls_tipo_depto_parc_id_o"], "", false);
        $this->wp->AddParameter("5", "urls_parcela_seccion_o", ccsText, "", "", $this->Parameters["urls_parcela_seccion_o"], "", false);
        $this->wp->AddParameter("6", "urls_parcela_chacra_o", ccsText, "", "", $this->Parameters["urls_parcela_chacra_o"], "", false);
        $this->wp->AddParameter("7", "urls_parcela_quinta_o", ccsText, "", "", $this->Parameters["urls_parcela_quinta_o"], "", false);
        $this->wp->AddParameter("8", "urls_parcela_macizo_o", ccsText, "", "", $this->Parameters["urls_parcela_macizo_o"], "", false);
        $this->wp->AddParameter("9", "urls_parcela_fraccion_o", ccsText, "", "", $this->Parameters["urls_parcela_fraccion_o"], "", false);
        $this->wp->AddParameter("10", "urls_parcela_parcela_o", ccsText, "", "", $this->Parameters["urls_parcela_parcela_o"], "", false);
        $this->wp->AddParameter("11", "urls_parcela_uf_o", ccsText, "", "", $this->Parameters["urls_parcela_uf_o"], "", false);
        $this->wp->AddParameter("12", "urls_previsado_titular", ccsText, "", "", $this->Parameters["urls_previsado_titular"], "", false);
        $this->wp->AddParameter("13", "urls_tipo_depto_parc_id_d", ccsInteger, "", "", $this->Parameters["urls_tipo_depto_parc_id_d"], "", false);
        $this->wp->AddParameter("14", "urls_parcela_seccion_d", ccsText, "", "", $this->Parameters["urls_parcela_seccion_d"], "", false);
        $this->wp->AddParameter("15", "urls_parcela_chacra_d", ccsText, "", "", $this->Parameters["urls_parcela_chacra_d"], "", false);
        $this->wp->AddParameter("16", "urls_parcela_quinta_d", ccsText, "", "", $this->Parameters["urls_parcela_quinta_d"], "", false);
        $this->wp->AddParameter("17", "urls_parcela_macizo_d", ccsText, "", "", $this->Parameters["urls_parcela_macizo_d"], "", false);
        $this->wp->AddParameter("18", "urls_parcela_fraccion_d", ccsText, "", "", $this->Parameters["urls_parcela_fraccion_d"], "", false);
        $this->wp->AddParameter("19", "urls_parcela_parcela_d", ccsText, "", "", $this->Parameters["urls_parcela_parcela_d"], "", false);
        $this->wp->AddParameter("20", "urls_parcela_uf_d", ccsText, "", "", $this->Parameters["urls_parcela_uf_d"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "previsados_cargas.user_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "previsados_cargas.previsado_carga_proc", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsDate),false);
        $this->wp->Criterion[3] = $this->wp->Operation(opEqual, "previsados_cargas.previsado_tipo_plano_id", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsInteger),false);
        $this->wp->Criterion[4] = $this->wp->Operation(opEqual, "previsados_parcelas_origenes.tipo_depto_parc_id", $this->wp->GetDBValue("4"), $this->ToSQL($this->wp->GetDBValue("4"), ccsInteger),false);
        $this->wp->Criterion[5] = $this->wp->Operation(opEqual, "previsados_parcelas_origenes.parcela_seccion", $this->wp->GetDBValue("5"), $this->ToSQL($this->wp->GetDBValue("5"), ccsText),false);
        $this->wp->Criterion[6] = $this->wp->Operation(opEqual, "previsados_parcelas_origenes.parcela_chacra", $this->wp->GetDBValue("6"), $this->ToSQL($this->wp->GetDBValue("6"), ccsText),false);
        $this->wp->Criterion[7] = $this->wp->Operation(opEqual, "previsados_parcelas_origenes.parcela_quinta", $this->wp->GetDBValue("7"), $this->ToSQL($this->wp->GetDBValue("7"), ccsText),false);
        $this->wp->Criterion[8] = $this->wp->Operation(opEqual, "previsados_parcelas_origenes.parcela_macizo", $this->wp->GetDBValue("8"), $this->ToSQL($this->wp->GetDBValue("8"), ccsText),false);
        $this->wp->Criterion[9] = $this->wp->Operation(opEqual, "previsados_parcelas_origenes.parcela_fraccion", $this->wp->GetDBValue("9"), $this->ToSQL($this->wp->GetDBValue("9"), ccsText),false);
        $this->wp->Criterion[10] = $this->wp->Operation(opEqual, "previsados_parcelas_origenes.parcela_parcela", $this->wp->GetDBValue("10"), $this->ToSQL($this->wp->GetDBValue("10"), ccsText),false);
        $this->wp->Criterion[11] = $this->wp->Operation(opEqual, "previsados_parcelas_origenes.parcela_uf", $this->wp->GetDBValue("11"), $this->ToSQL($this->wp->GetDBValue("11"), ccsText),false);
        $this->wp->Criterion[12] = $this->wp->Operation(opEqual, "previsados_titulares.previsado_titular_nombre", $this->wp->GetDBValue("12"), $this->ToSQL($this->wp->GetDBValue("12"), ccsText),false);
        $this->wp->Criterion[13] = $this->wp->Operation(opEqual, "previsados_parcelas_destinos.tipo_depto_parc_id", $this->wp->GetDBValue("13"), $this->ToSQL($this->wp->GetDBValue("13"), ccsInteger),false);
        $this->wp->Criterion[14] = $this->wp->Operation(opEqual, "previsados_parcelas_destinos.parcela_seccion", $this->wp->GetDBValue("14"), $this->ToSQL($this->wp->GetDBValue("14"), ccsText),false);
        $this->wp->Criterion[15] = $this->wp->Operation(opEqual, "previsados_parcelas_destinos.parcela_chacra", $this->wp->GetDBValue("15"), $this->ToSQL($this->wp->GetDBValue("15"), ccsText),false);
        $this->wp->Criterion[16] = $this->wp->Operation(opEqual, "previsados_parcelas_destinos.parcela_quinta", $this->wp->GetDBValue("16"), $this->ToSQL($this->wp->GetDBValue("16"), ccsText),false);
        $this->wp->Criterion[17] = $this->wp->Operation(opEqual, "previsados_parcelas_destinos.parcela_macizo", $this->wp->GetDBValue("17"), $this->ToSQL($this->wp->GetDBValue("17"), ccsText),false);
        $this->wp->Criterion[18] = $this->wp->Operation(opEqual, "previsados_parcelas_destinos.parcela_fraccion", $this->wp->GetDBValue("18"), $this->ToSQL($this->wp->GetDBValue("18"), ccsText),false);
        $this->wp->Criterion[19] = $this->wp->Operation(opEqual, "previsados_parcelas_destinos.parcela_parcela", $this->wp->GetDBValue("19"), $this->ToSQL($this->wp->GetDBValue("19"), ccsText),false);
        $this->wp->Criterion[20] = $this->wp->Operation(opEqual, "previsados_parcelas_origenes.parcela_uf", $this->wp->GetDBValue("20"), $this->ToSQL($this->wp->GetDBValue("20"), ccsText),false);
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
             $this->wp->Criterion[13]), 
             $this->wp->Criterion[14]), 
             $this->wp->Criterion[15]), 
             $this->wp->Criterion[16]), 
             $this->wp->Criterion[17]), 
             $this->wp->Criterion[18]), 
             $this->wp->Criterion[19]), 
             $this->wp->Criterion[20]);
    }
//End Prepare Method

//Open Method @4-C735FBCE
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT previsados_cargas.*, previsado_tipo_plano_descrip, previsados_parcelas_origenes.parcela_seccion AS previsados_parcelas_origenes_parcela_seccion,\n\n" .
        "previsados_parcelas_origenes.parcela_chacra AS previsados_parcelas_origenes_parcela_chacra, previsados_parcelas_origenes.parcela_quinta AS previsados_parcelas_origenes_parcela_quinta,\n\n" .
        "previsados_parcelas_origenes.parcela_macizo AS previsados_parcelas_origenes_parcela_macizo, previsados_parcelas_origenes.parcela_fraccion AS previsados_parcelas_origenes_parcela_fraccion,\n\n" .
        "previsados_parcelas_origenes.parcela_parcela AS previsados_parcelas_origenes_parcela_parcela, previsados_parcelas_origenes.parcela_uf AS previsados_parcelas_origenes_parcela_uf,\n\n" .
        "previsado_titular_nombre, previsados_parcelas_destinos.tipo_depto_parc_id AS previsados_parcelas_destinos_tipo_depto_parc_id,\n\n" .
        "previsados_parcelas_destinos.parcela_seccion AS previsados_parcelas_destinos_parcela_seccion, previsados_parcelas_destinos.parcela_chacra AS previsados_parcelas_destinos_parcela_chacra,\n\n" .
        "previsados_parcelas_destinos.parcela_quinta AS previsados_parcelas_destinos_parcela_quinta, previsados_parcelas_destinos.parcela_macizo AS previsados_parcelas_destinos_parcela_macizo,\n\n" .
        "previsados_parcelas_destinos.parcela_fraccion AS previsados_parcelas_destinos_parcela_fraccion, previsados_parcelas_destinos.parcela_parcela AS previsados_parcelas_destinos_parcela_parcela,\n\n" .
        "previsados_parcelas_destinos.parcela_uf AS previsados_parcelas_destinos_parcela_uf \n\n" .
        "FROM (((previsados_cargas LEFT JOIN previsados_tipos_planos ON\n\n" .
        "previsados_cargas.previsado_tipo_plano_id = previsados_tipos_planos.previsado_tipo_plano_id) LEFT JOIN previsados_parcelas_origenes ON\n\n" .
        "previsados_cargas.previsado_carga_id = previsados_parcelas_origenes.previsado_carga_id) LEFT JOIN previsados_titulares ON\n\n" .
        "previsados_cargas.previsado_carga_id = previsados_titulares.previsado_carga_id) LEFT JOIN previsados_parcelas_destinos ON\n\n" .
        "previsados_cargas.previsado_carga_id = previsados_parcelas_destinos.previsado_carga_id {SQL_Where}\n\n" .
        "GROUP BY previsados_cargas.previsado_carga_id {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @4-A9E8209C
    function SetValues()
    {
        $this->previsado_carga_proc->SetDBValue(trim($this->f("previsado_carga_alta")));
        $this->previsado_tipo_plano_descrip->SetDBValue($this->f("previsado_tipo_plano_descrip"));
        $this->previsado_nombre_archivo_org->SetDBValue($this->f("previsado_nombre_archivo_org"));
        $this->previsado_tipo_estado_carga_id->SetDBValue(trim($this->f("previsado_tipo_estado_carga_id")));
    }
//End SetValues Method

} //End previsados_cargasDataSource Class @4-FCB6E20C

class clsRecordprevisados_cargasSearch { //previsados_cargasSearch Class @5-CE037FB3

//Variables @5-9E315808

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

//Class_Initialize Event @5-127A6A45
    function clsRecordprevisados_cargasSearch($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record previsados_cargasSearch/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "previsados_cargasSearch";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
            $this->s_previsado_titular = new clsControl(ccsTextBox, "s_previsado_titular", "s_previsado_titular", ccsText, "", CCGetRequestParam("s_previsado_titular", $Method, NULL), $this);
            $this->s_previsado_tipo_plano_id = new clsControl(ccsListBox, "s_previsado_tipo_plano_id", "s_previsado_tipo_plano_id", ccsInteger, "", CCGetRequestParam("s_previsado_tipo_plano_id", $Method, NULL), $this);
            $this->s_previsado_tipo_plano_id->DSType = dsTable;
            $this->s_previsado_tipo_plano_id->DataSource = new clsDBtdf_nuevo();
            $this->s_previsado_tipo_plano_id->ds = & $this->s_previsado_tipo_plano_id->DataSource;
            $this->s_previsado_tipo_plano_id->DataSource->SQL = "SELECT * \n" .
"FROM previsados_tipos_planos {SQL_Where} {SQL_OrderBy}";
            list($this->s_previsado_tipo_plano_id->BoundColumn, $this->s_previsado_tipo_plano_id->TextColumn, $this->s_previsado_tipo_plano_id->DBFormat) = array("previsado_tipo_plano_id", "previsado_tipo_plano_descrip", "");
            $this->Button1 = new clsButton("Button1", $Method, $this);
            $this->Link1 = new clsControl(ccsImageLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", $Method, NULL), $this);
            $this->Link1->Parameters = CCGetQueryString("QueryString", array("previsado_carga_id", "mensaje", "uploadOk", "ccsForm"));
            $this->Link1->Page = "previsados_cargas.php";
            $this->s_parcela_seccion_o = new clsControl(ccsTextBox, "s_parcela_seccion_o", "s_parcela_seccion_o", ccsText, "", CCGetRequestParam("s_parcela_seccion_o", $Method, NULL), $this);
            $this->s_parcela_chacra_o = new clsControl(ccsTextBox, "s_parcela_chacra_o", "s_parcela_chacra_o", ccsText, "", CCGetRequestParam("s_parcela_chacra_o", $Method, NULL), $this);
            $this->s_parcela_quinta_o = new clsControl(ccsTextBox, "s_parcela_quinta_o", "s_parcela_quinta_o", ccsText, "", CCGetRequestParam("s_parcela_quinta_o", $Method, NULL), $this);
            $this->s_parcela_macizo_o = new clsControl(ccsTextBox, "s_parcela_macizo_o", "s_parcela_macizo_o", ccsText, "", CCGetRequestParam("s_parcela_macizo_o", $Method, NULL), $this);
            $this->s_parcela_fraccion_o = new clsControl(ccsTextBox, "s_parcela_fraccion_o", "s_parcela_fraccion_o", ccsText, "", CCGetRequestParam("s_parcela_fraccion_o", $Method, NULL), $this);
            $this->s_parcela_parcela_o = new clsControl(ccsTextBox, "s_parcela_parcela_o", "s_parcela_parcela_o", ccsText, "", CCGetRequestParam("s_parcela_parcela_o", $Method, NULL), $this);
            $this->s_parcela_uf_o = new clsControl(ccsTextBox, "s_parcela_uf_o", "s_parcela_uf_o", ccsText, "", CCGetRequestParam("s_parcela_uf_o", $Method, NULL), $this);
            $this->s_previsado_carga_proc = new clsControl(ccsTextBox, "s_previsado_carga_proc", "s_previsado_carga_proc", ccsDate, array("dd", "/", "mm", "/", "yyyy"), CCGetRequestParam("s_previsado_carga_proc", $Method, NULL), $this);
            $this->DatePicker_s_previsado_carga_proc = new clsDatePicker("DatePicker_s_previsado_carga_proc", "previsados_cargasSearch", "s_previsado_carga_proc", $this);
            $this->s_tipo_depto_parc_id_o = new clsControl(ccsListBox, "s_tipo_depto_parc_id_o", "s_tipo_depto_parc_id_o", ccsInteger, "", CCGetRequestParam("s_tipo_depto_parc_id_o", $Method, NULL), $this);
            $this->s_tipo_depto_parc_id_o->DSType = dsTable;
            $this->s_tipo_depto_parc_id_o->DataSource = new clsDBtdf_nuevo();
            $this->s_tipo_depto_parc_id_o->ds = & $this->s_tipo_depto_parc_id_o->DataSource;
            $this->s_tipo_depto_parc_id_o->DataSource->SQL = "SELECT * \n" .
"FROM tipos_deptos_parcela {SQL_Where} {SQL_OrderBy}";
            list($this->s_tipo_depto_parc_id_o->BoundColumn, $this->s_tipo_depto_parc_id_o->TextColumn, $this->s_tipo_depto_parc_id_o->DBFormat) = array("tipo_depto_parc_id", "tipo_depto_parc_abrev", "");
            $this->s_tipo_depto_parc_id_d = new clsControl(ccsListBox, "s_tipo_depto_parc_id_d", "s_tipo_depto_parc_id_d", ccsInteger, "", CCGetRequestParam("s_tipo_depto_parc_id_d", $Method, NULL), $this);
            $this->s_tipo_depto_parc_id_d->DSType = dsTable;
            $this->s_tipo_depto_parc_id_d->DataSource = new clsDBtdf_nuevo();
            $this->s_tipo_depto_parc_id_d->ds = & $this->s_tipo_depto_parc_id_d->DataSource;
            $this->s_tipo_depto_parc_id_d->DataSource->SQL = "SELECT * \n" .
"FROM tipos_deptos_parcela {SQL_Where} {SQL_OrderBy}";
            list($this->s_tipo_depto_parc_id_d->BoundColumn, $this->s_tipo_depto_parc_id_d->TextColumn, $this->s_tipo_depto_parc_id_d->DBFormat) = array("tipo_depto_parc_id", "tipo_depto_parc_abrev", "");
            $this->s_parcela_seccion_d = new clsControl(ccsTextBox, "s_parcela_seccion_d", "s_parcela_seccion_d", ccsText, "", CCGetRequestParam("s_parcela_seccion_d", $Method, NULL), $this);
            $this->s_parcela_chacra_d = new clsControl(ccsTextBox, "s_parcela_chacra_d", "s_parcela_chacra_d", ccsText, "", CCGetRequestParam("s_parcela_chacra_d", $Method, NULL), $this);
            $this->s_parcela_quinta_d = new clsControl(ccsTextBox, "s_parcela_quinta_d", "s_parcela_quinta_d", ccsText, "", CCGetRequestParam("s_parcela_quinta_d", $Method, NULL), $this);
            $this->s_parcela_macizo_d = new clsControl(ccsTextBox, "s_parcela_macizo_d", "s_parcela_macizo_d", ccsText, "", CCGetRequestParam("s_parcela_macizo_d", $Method, NULL), $this);
            $this->s_parcela_fraccion_d = new clsControl(ccsTextBox, "s_parcela_fraccion_d", "s_parcela_fraccion_d", ccsText, "", CCGetRequestParam("s_parcela_fraccion_d", $Method, NULL), $this);
            $this->s_parcela_parcela_d = new clsControl(ccsTextBox, "s_parcela_parcela_d", "s_parcela_parcela_d", ccsText, "", CCGetRequestParam("s_parcela_parcela_d", $Method, NULL), $this);
            $this->s_parcela_uf_d = new clsControl(ccsTextBox, "s_parcela_uf_d", "s_parcela_uf_d", ccsText, "", CCGetRequestParam("s_parcela_uf_d", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Validate Method @5-98F46145
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_previsado_titular->Validate() && $Validation);
        $Validation = ($this->s_previsado_tipo_plano_id->Validate() && $Validation);
        $Validation = ($this->s_parcela_seccion_o->Validate() && $Validation);
        $Validation = ($this->s_parcela_chacra_o->Validate() && $Validation);
        $Validation = ($this->s_parcela_quinta_o->Validate() && $Validation);
        $Validation = ($this->s_parcela_macizo_o->Validate() && $Validation);
        $Validation = ($this->s_parcela_fraccion_o->Validate() && $Validation);
        $Validation = ($this->s_parcela_parcela_o->Validate() && $Validation);
        $Validation = ($this->s_parcela_uf_o->Validate() && $Validation);
        $Validation = ($this->s_previsado_carga_proc->Validate() && $Validation);
        $Validation = ($this->s_tipo_depto_parc_id_o->Validate() && $Validation);
        $Validation = ($this->s_tipo_depto_parc_id_d->Validate() && $Validation);
        $Validation = ($this->s_parcela_seccion_d->Validate() && $Validation);
        $Validation = ($this->s_parcela_chacra_d->Validate() && $Validation);
        $Validation = ($this->s_parcela_quinta_d->Validate() && $Validation);
        $Validation = ($this->s_parcela_macizo_d->Validate() && $Validation);
        $Validation = ($this->s_parcela_fraccion_d->Validate() && $Validation);
        $Validation = ($this->s_parcela_parcela_d->Validate() && $Validation);
        $Validation = ($this->s_parcela_uf_d->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_previsado_titular->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_previsado_tipo_plano_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_seccion_o->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_chacra_o->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_quinta_o->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_macizo_o->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_fraccion_o->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_parcela_o->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_uf_o->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_previsado_carga_proc->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_tipo_depto_parc_id_o->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_tipo_depto_parc_id_d->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_seccion_d->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_chacra_d->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_quinta_d->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_macizo_d->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_fraccion_d->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_parcela_d->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_uf_d->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @5-7DC8A5AF
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_previsado_titular->Errors->Count());
        $errors = ($errors || $this->s_previsado_tipo_plano_id->Errors->Count());
        $errors = ($errors || $this->Link1->Errors->Count());
        $errors = ($errors || $this->s_parcela_seccion_o->Errors->Count());
        $errors = ($errors || $this->s_parcela_chacra_o->Errors->Count());
        $errors = ($errors || $this->s_parcela_quinta_o->Errors->Count());
        $errors = ($errors || $this->s_parcela_macizo_o->Errors->Count());
        $errors = ($errors || $this->s_parcela_fraccion_o->Errors->Count());
        $errors = ($errors || $this->s_parcela_parcela_o->Errors->Count());
        $errors = ($errors || $this->s_parcela_uf_o->Errors->Count());
        $errors = ($errors || $this->s_previsado_carga_proc->Errors->Count());
        $errors = ($errors || $this->DatePicker_s_previsado_carga_proc->Errors->Count());
        $errors = ($errors || $this->s_tipo_depto_parc_id_o->Errors->Count());
        $errors = ($errors || $this->s_tipo_depto_parc_id_d->Errors->Count());
        $errors = ($errors || $this->s_parcela_seccion_d->Errors->Count());
        $errors = ($errors || $this->s_parcela_chacra_d->Errors->Count());
        $errors = ($errors || $this->s_parcela_quinta_d->Errors->Count());
        $errors = ($errors || $this->s_parcela_macizo_d->Errors->Count());
        $errors = ($errors || $this->s_parcela_fraccion_d->Errors->Count());
        $errors = ($errors || $this->s_parcela_parcela_d->Errors->Count());
        $errors = ($errors || $this->s_parcela_uf_d->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @5-ED598703
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

//Operation Method @5-2CFA3357
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
            } else if($this->Button1->Pressed) {
                $this->PressedButton = "Button1";
            }
        }
        $Redirect = "previsados_consola.php";
        if($this->PressedButton == "Button1") {
            if(!CCGetEvent($this->Button1->CCSEvents, "OnClick", $this->Button1)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "previsados_consola.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y", "Button1", "Button1_x", "Button1_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @5-99304230
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

        $this->s_previsado_tipo_plano_id->Prepare();
        $this->s_tipo_depto_parc_id_o->Prepare();
        $this->s_tipo_depto_parc_id_d->Prepare();

        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->s_previsado_titular->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_previsado_tipo_plano_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Link1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_seccion_o->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_chacra_o->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_quinta_o->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_macizo_o->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_fraccion_o->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_parcela_o->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_uf_o->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_previsado_carga_proc->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DatePicker_s_previsado_carga_proc->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_tipo_depto_parc_id_o->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_tipo_depto_parc_id_d->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_seccion_d->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_chacra_d->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_quinta_d->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_macizo_d->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_fraccion_d->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_parcela_d->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_uf_d->Errors->ToString());
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
        $this->s_previsado_titular->Show();
        $this->s_previsado_tipo_plano_id->Show();
        $this->Button1->Show();
        $this->Link1->Show();
        $this->s_parcela_seccion_o->Show();
        $this->s_parcela_chacra_o->Show();
        $this->s_parcela_quinta_o->Show();
        $this->s_parcela_macizo_o->Show();
        $this->s_parcela_fraccion_o->Show();
        $this->s_parcela_parcela_o->Show();
        $this->s_parcela_uf_o->Show();
        $this->s_previsado_carga_proc->Show();
        $this->DatePicker_s_previsado_carga_proc->Show();
        $this->s_tipo_depto_parc_id_o->Show();
        $this->s_tipo_depto_parc_id_d->Show();
        $this->s_parcela_seccion_d->Show();
        $this->s_parcela_chacra_d->Show();
        $this->s_parcela_quinta_d->Show();
        $this->s_parcela_macizo_d->Show();
        $this->s_parcela_fraccion_d->Show();
        $this->s_parcela_parcela_d->Show();
        $this->s_parcela_uf_d->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End previsados_cargasSearch Class @5-FCB6E20C

class clsRecordpresentacion { //presentacion Class @41-C9F5A726

//Variables @41-9E315808

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

//Class_Initialize Event @41-793BD221
    function clsRecordpresentacion($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record presentacion/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "presentacion";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->profesional = new clsControl(ccsLabel, "profesional", "profesional", ccsText, "", CCGetRequestParam("profesional", $Method, NULL), $this);
            $this->Button1 = new clsButton("Button1", $Method, $this);
            $this->plantilla = new clsControl(ccsLabel, "plantilla", "plantilla", ccsText, "", CCGetRequestParam("plantilla", $Method, NULL), $this);
            $this->plantilla->HTML = true;
            $this->archivo = new clsControl(ccsLabel, "archivo", "archivo", ccsText, "", CCGetRequestParam("archivo", $Method, NULL), $this);
            $this->archivo->HTML = true;
            $this->plano = new clsControl(ccsLabel, "plano", "plano", ccsText, "", CCGetRequestParam("plano", $Method, NULL), $this);
            $this->plano->HTML = true;
            $this->puntos = new clsControl(ccsLabel, "puntos", "puntos", ccsText, "", CCGetRequestParam("puntos", $Method, NULL), $this);
            $this->puntos->HTML = true;
        }
    }
//End Class_Initialize Event

//Validate Method @41-367945B8
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @41-E834B8D1
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->profesional->Errors->Count());
        $errors = ($errors || $this->plantilla->Errors->Count());
        $errors = ($errors || $this->archivo->Errors->Count());
        $errors = ($errors || $this->plano->Errors->Count());
        $errors = ($errors || $this->puntos->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @41-ED598703
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

//Operation Method @41-22F60C1B
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
            $this->PressedButton = "Button1";
            if($this->Button1->Pressed) {
                $this->PressedButton = "Button1";
            }
        }
        $Redirect = $FileName;
        if($this->Validate()) {
            if($this->PressedButton == "Button1") {
                if(!CCGetEvent($this->Button1->CCSEvents, "OnClick", $this->Button1)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @41-3E6C0E75
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

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->profesional->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plantilla->Errors->ToString());
            $Error = ComposeStrings($Error, $this->archivo->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano->Errors->ToString());
            $Error = ComposeStrings($Error, $this->puntos->Errors->ToString());
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

        $this->profesional->Show();
        $this->Button1->Show();
        $this->plantilla->Show();
        $this->archivo->Show();
        $this->plano->Show();
        $this->puntos->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End presentacion Class @41-FCB6E20C

//Initialize Page @1-F6D441C2
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
$TemplateFileName = "previsados_consola.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-B0B36B13
include_once("./previsados_consola_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-7A612970
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$previsados_cargas = new clsGridprevisados_cargas("", $MainPage);
$previsados_cargasSearch = new clsRecordprevisados_cargasSearch("", $MainPage);
$presentacion = new clsRecordpresentacion("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->previsados_cargas = & $previsados_cargas;
$MainPage->previsados_cargasSearch = & $previsados_cargasSearch;
$MainPage->presentacion = & $presentacion;
$previsados_cargas->Initialize();

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

//Execute Components @1-1D9A2EE0
$tdf_header->Operations();
$tdf_footer->Operations();
$previsados_cargasSearch->Operation();
$presentacion->Operation();
//End Execute Components

//Go to destination page @1-40BD7579
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    header("Location: " . $Redirect);
    $tdf_header->Class_Terminate();
    unset($tdf_header);
    $tdf_footer->Class_Terminate();
    unset($tdf_footer);
    unset($previsados_cargas);
    unset($previsados_cargasSearch);
    unset($presentacion);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-BF0514CB
$tdf_header->Show();
$tdf_footer->Show();
$previsados_cargas->Show();
$previsados_cargasSearch->Show();
$presentacion->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", "<center><font face=\"Ari" . "al\"><small>G&#101;n&#" . "101;rat&#101;d <!--" . " CCS -->with <!-- SCC" . " -->&#67;&#111;d&#101;" . "&#67;ha&#114;&#103;" . "e <!-- CCS -->St&#117;" . "dio.</small></font></" . "center>" . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", "<center><font face=\"Ari" . "al\"><small>G&#101;n&#" . "101;rat&#101;d <!--" . " CCS -->with <!-- SCC" . " -->&#67;&#111;d&#101;" . "&#67;ha&#114;&#103;" . "e <!-- CCS -->St&#117;" . "dio.</small></font></" . "center>" . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= "<center><font face=\"Ari" . "al\"><small>G&#101;n&#" . "101;rat&#101;d <!--" . " CCS -->with <!-- SCC" . " -->&#67;&#111;d&#101;" . "&#67;ha&#114;&#103;" . "e <!-- CCS -->St&#117;" . "dio.</small></font></" . "center>";
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-6156FA44
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($previsados_cargas);
unset($previsados_cargasSearch);
unset($presentacion);
unset($Tpl);
//End Unload Page


?>
