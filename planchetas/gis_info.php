<?php
//Include Common Files @1-C8D48503
define("RelativePath", "..");
define("PathToCurrentPage", "/planchetas/");
define("FileName", "gis_info.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsGriddepartamentos_doc_tipos_f { //departamentos_doc_tipos_f class @2-00393D1D

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

//Class_Initialize Event @2-98F7BB56
    function clsGriddepartamentos_doc_tipos_f($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "departamentos_doc_tipos_f";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid departamentos_doc_tipos_f";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsdepartamentos_doc_tipos_fDataSource($this);
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

        $this->tipo_documento_abrev = new clsControl(ccsLabel, "tipo_documento_abrev", "tipo_documento_abrev", ccsText, "", CCGetRequestParam("tipo_documento_abrev", ccsGet, NULL), $this);
        $this->persona_nro_doc = new clsControl(ccsLabel, "persona_nro_doc", "persona_nro_doc", ccsInteger, "", CCGetRequestParam("persona_nro_doc", ccsGet, NULL), $this);
        $this->persona_denominacion = new clsControl(ccsLabel, "persona_denominacion", "persona_denominacion", ccsText, "", CCGetRequestParam("persona_denominacion", ccsGet, NULL), $this);
        $this->tipo_persona_parcela_descrip = new clsControl(ccsLabel, "tipo_persona_parcela_descrip", "tipo_persona_parcela_descrip", ccsText, "", CCGetRequestParam("tipo_persona_parcela_descrip", ccsGet, NULL), $this);
        $this->persona_conyuge = new clsControl(ccsLabel, "persona_conyuge", "persona_conyuge", ccsText, "", CCGetRequestParam("persona_conyuge", ccsGet, NULL), $this);
        $this->persona_parcela_dominio = new clsControl(ccsLabel, "persona_parcela_dominio", "persona_parcela_dominio", ccsFloat, "", CCGetRequestParam("persona_parcela_dominio", ccsGet, NULL), $this);
        $this->instrumento = new clsControl(ccsLabel, "instrumento", "instrumento", ccsText, "", CCGetRequestParam("instrumento", ccsGet, NULL), $this);
        $this->tipo_estado_descrip = new clsControl(ccsLabel, "tipo_estado_descrip", "tipo_estado_descrip", ccsText, "", CCGetRequestParam("tipo_estado_descrip", ccsGet, NULL), $this);
        $this->parcela_partida = new clsControl(ccsLabel, "parcela_partida", "parcela_partida", ccsInteger, "", CCGetRequestParam("parcela_partida", ccsGet, NULL), $this);
        $this->parcela_seccion = new clsControl(ccsLabel, "parcela_seccion", "parcela_seccion", ccsText, "", CCGetRequestParam("parcela_seccion", ccsGet, NULL), $this);
        $this->parcela_parcela = new clsControl(ccsLabel, "parcela_parcela", "parcela_parcela", ccsText, "", CCGetRequestParam("parcela_parcela", ccsGet, NULL), $this);
        $this->parcela_chacra = new clsControl(ccsLabel, "parcela_chacra", "parcela_chacra", ccsText, "", CCGetRequestParam("parcela_chacra", ccsGet, NULL), $this);
        $this->parcela_macizo = new clsControl(ccsLabel, "parcela_macizo", "parcela_macizo", ccsText, "", CCGetRequestParam("parcela_macizo", ccsGet, NULL), $this);
        $this->parcela_quinta = new clsControl(ccsLabel, "parcela_quinta", "parcela_quinta", ccsText, "", CCGetRequestParam("parcela_quinta", ccsGet, NULL), $this);
        $this->parcela_fraccion = new clsControl(ccsLabel, "parcela_fraccion", "parcela_fraccion", ccsText, "", CCGetRequestParam("parcela_fraccion", ccsGet, NULL), $this);
        $this->parcela_uf = new clsControl(ccsLabel, "parcela_uf", "parcela_uf", ccsText, "", CCGetRequestParam("parcela_uf", ccsGet, NULL), $this);
        $this->parcela_predio = new clsControl(ccsLabel, "parcela_predio", "parcela_predio", ccsText, "", CCGetRequestParam("parcela_predio", ccsGet, NULL), $this);
        $this->parcela_rte = new clsControl(ccsLabel, "parcela_rte", "parcela_rte", ccsText, "", CCGetRequestParam("parcela_rte", ccsGet, NULL), $this);
        $this->dpto_desc = new clsControl(ccsLabel, "dpto_desc", "dpto_desc", ccsText, "", CCGetRequestParam("dpto_desc", ccsGet, NULL), $this);
        $this->parcela_superficie = new clsControl(ccsLabel, "parcela_superficie", "parcela_superficie", ccsFloat, "", CCGetRequestParam("parcela_superficie", ccsGet, NULL), $this);
        $this->parcela_sup_uf = new clsControl(ccsLabel, "parcela_sup_uf", "parcela_sup_uf", ccsFloat, "", CCGetRequestParam("parcela_sup_uf", ccsGet, NULL), $this);
        $this->parcela_val_tierra = new clsControl(ccsLabel, "parcela_val_tierra", "parcela_val_tierra", ccsFloat, array(False, 2, Null, "", False, "\$", "", 1, True, ""), CCGetRequestParam("parcela_val_tierra", ccsGet, NULL), $this);
        $this->parcela_val_mejora = new clsControl(ccsLabel, "parcela_val_mejora", "parcela_val_mejora", ccsFloat, array(False, 2, Null, "", False, "\$", "", 1, True, ""), CCGetRequestParam("parcela_val_mejora", ccsGet, NULL), $this);
        $this->parcela_val_ampliac = new clsControl(ccsLabel, "parcela_val_ampliac", "parcela_val_ampliac", ccsFloat, array(False, 2, Null, "", False, "\$", "", 1, True, ""), CCGetRequestParam("parcela_val_ampliac", ccsGet, NULL), $this);
        $this->parcela_val_total = new clsControl(ccsLabel, "parcela_val_total", "parcela_val_total", ccsFloat, array(False, 2, Null, "", False, "\$", "", 1, True, ""), CCGetRequestParam("parcela_val_total", ccsGet, NULL), $this);
        $this->uni_med_htm = new clsControl(ccsLabel, "uni_med_htm", "uni_med_htm", ccsText, "", CCGetRequestParam("uni_med_htm", ccsGet, NULL), $this);
        $this->uni_med_htm->HTML = true;
        $this->tipo_est_parc_descr = new clsControl(ccsLabel, "tipo_est_parc_descr", "tipo_est_parc_descr", ccsText, "", CCGetRequestParam("tipo_est_parc_descr", ccsGet, NULL), $this);
        $this->tipo_parcela_descrip = new clsControl(ccsLabel, "tipo_parcela_descrip", "tipo_parcela_descrip", ccsText, "", CCGetRequestParam("tipo_parcela_descrip", ccsGet, NULL), $this);
        $this->tipo_parcela_uso_descrip = new clsControl(ccsLabel, "tipo_parcela_uso_descrip", "tipo_parcela_uso_descrip", ccsText, "", CCGetRequestParam("tipo_parcela_uso_descrip", ccsGet, NULL), $this);
        $this->tipo_padron_parc_desc = new clsControl(ccsLabel, "tipo_padron_parc_desc", "tipo_padron_parc_desc", ccsText, "", CCGetRequestParam("tipo_padron_parc_desc", ccsGet, NULL), $this);
        $this->tipo_instrumento_abrev = new clsControl(ccsLabel, "tipo_instrumento_abrev", "tipo_instrumento_abrev", ccsText, "", CCGetRequestParam("tipo_instrumento_abrev", ccsGet, NULL), $this);
        $this->tipo_instrumento_abrev->HTML = true;
        $this->parcela_instrumento = new clsControl(ccsLabel, "parcela_instrumento", "parcela_instrumento", ccsText, "", CCGetRequestParam("parcela_instrumento", ccsGet, NULL), $this);
        $this->parcela_instrumento->HTML = true;
        $this->tipo_restricc_parcela_desc = new clsControl(ccsLabel, "tipo_restricc_parcela_desc", "tipo_restricc_parcela_desc", ccsText, "", CCGetRequestParam("tipo_restricc_parcela_desc", ccsGet, NULL), $this);
        $this->plano_est_desc = new clsControl(ccsLabel, "plano_est_desc", "plano_est_desc", ccsText, "", CCGetRequestParam("plano_est_desc", ccsGet, NULL), $this);
        $this->planete = new clsControl(ccsLabel, "planete", "planete", ccsText, "", CCGetRequestParam("planete", ccsGet, NULL), $this);
        $this->planete->HTML = true;
        $this->lista_afectaciones = new clsControl(ccsLabel, "lista_afectaciones", "lista_afectaciones", ccsText, "", CCGetRequestParam("lista_afectaciones", ccsGet, NULL), $this);
        $this->lista_afectaciones->HTML = true;
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

//Show Method @2-1A0D25B2
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlparcela_id"] = CCGetFromGet("parcela_id", NULL);

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
            $this->ControlsVisible["tipo_documento_abrev"] = $this->tipo_documento_abrev->Visible;
            $this->ControlsVisible["persona_nro_doc"] = $this->persona_nro_doc->Visible;
            $this->ControlsVisible["persona_denominacion"] = $this->persona_denominacion->Visible;
            $this->ControlsVisible["tipo_persona_parcela_descrip"] = $this->tipo_persona_parcela_descrip->Visible;
            $this->ControlsVisible["persona_conyuge"] = $this->persona_conyuge->Visible;
            $this->ControlsVisible["persona_parcela_dominio"] = $this->persona_parcela_dominio->Visible;
            $this->ControlsVisible["instrumento"] = $this->instrumento->Visible;
            $this->ControlsVisible["tipo_estado_descrip"] = $this->tipo_estado_descrip->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->persona_nro_doc->SetValue($this->DataSource->persona_nro_doc->GetValue());
                $this->persona_denominacion->SetValue($this->DataSource->persona_denominacion->GetValue());
                $this->persona_conyuge->SetValue($this->DataSource->persona_conyuge->GetValue());
                $this->persona_parcela_dominio->SetValue($this->DataSource->persona_parcela_dominio->GetValue());
                $this->tipo_estado_descrip->SetValue($this->DataSource->tipo_estado_descrip->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->tipo_documento_abrev->Show();
                $this->persona_nro_doc->Show();
                $this->persona_denominacion->Show();
                $this->tipo_persona_parcela_descrip->Show();
                $this->persona_conyuge->Show();
                $this->persona_parcela_dominio->Show();
                $this->instrumento->Show();
                $this->tipo_estado_descrip->Show();
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
        $this->parcela_partida->SetValue($this->DataSource->parcela_partida->GetValue());
        $this->parcela_seccion->SetValue($this->DataSource->parcela_seccion->GetValue());
        $this->parcela_parcela->SetValue($this->DataSource->parcela_parcela->GetValue());
        $this->parcela_chacra->SetValue($this->DataSource->parcela_chacra->GetValue());
        $this->parcela_macizo->SetValue($this->DataSource->parcela_macizo->GetValue());
        $this->parcela_quinta->SetValue($this->DataSource->parcela_quinta->GetValue());
        $this->parcela_fraccion->SetValue($this->DataSource->parcela_fraccion->GetValue());
        $this->parcela_uf->SetValue($this->DataSource->parcela_uf->GetValue());
        $this->parcela_predio->SetValue($this->DataSource->parcela_predio->GetValue());
        $this->parcela_rte->SetValue($this->DataSource->parcela_rte->GetValue());
        $this->dpto_desc->SetValue($this->DataSource->dpto_desc->GetValue());
        $this->parcela_superficie->SetValue($this->DataSource->parcela_superficie->GetValue());
        $this->parcela_sup_uf->SetValue($this->DataSource->parcela_sup_uf->GetValue());
        $this->uni_med_htm->SetValue($this->DataSource->uni_med_htm->GetValue());
        $this->tipo_est_parc_descr->SetValue($this->DataSource->tipo_est_parc_descr->GetValue());
        $this->tipo_parcela_descrip->SetValue($this->DataSource->tipo_parcela_descrip->GetValue());
        $this->tipo_parcela_uso_descrip->SetValue($this->DataSource->tipo_parcela_uso_descrip->GetValue());
        $this->tipo_padron_parc_desc->SetValue($this->DataSource->tipo_padron_parc_desc->GetValue());
        $this->parcela_instrumento->SetValue($this->DataSource->parcela_instrumento->GetValue());
        $this->tipo_restricc_parcela_desc->SetValue($this->DataSource->tipo_restricc_parcela_desc->GetValue());
        $this->parcela_partida->Show();
        $this->parcela_seccion->Show();
        $this->parcela_parcela->Show();
        $this->parcela_chacra->Show();
        $this->parcela_macizo->Show();
        $this->parcela_quinta->Show();
        $this->parcela_fraccion->Show();
        $this->parcela_uf->Show();
        $this->parcela_predio->Show();
        $this->parcela_rte->Show();
        $this->dpto_desc->Show();
        $this->parcela_superficie->Show();
        $this->parcela_sup_uf->Show();
        $this->parcela_val_tierra->Show();
        $this->parcela_val_mejora->Show();
        $this->parcela_val_ampliac->Show();
        $this->parcela_val_total->Show();
        $this->uni_med_htm->Show();
        $this->tipo_est_parc_descr->Show();
        $this->tipo_parcela_descrip->Show();
        $this->tipo_parcela_uso_descrip->Show();
        $this->tipo_padron_parc_desc->Show();
        $this->tipo_instrumento_abrev->Show();
        $this->parcela_instrumento->Show();
        $this->tipo_restricc_parcela_desc->Show();
        $this->plano_est_desc->Show();
        $this->planete->Show();
        $this->lista_afectaciones->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @2-4272E809
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->tipo_documento_abrev->Errors->ToString());
        $errors = ComposeStrings($errors, $this->persona_nro_doc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->persona_denominacion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_persona_parcela_descrip->Errors->ToString());
        $errors = ComposeStrings($errors, $this->persona_conyuge->Errors->ToString());
        $errors = ComposeStrings($errors, $this->persona_parcela_dominio->Errors->ToString());
        $errors = ComposeStrings($errors, $this->instrumento->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_estado_descrip->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End departamentos_doc_tipos_f Class @2-FCB6E20C

class clsdepartamentos_doc_tipos_fDataSource extends clsDBtdf_nuevo {  //departamentos_doc_tipos_fDataSource Class @2-3EE7C0BA

//DataSource Variables @2-83ADF1EF
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $parcela_partida;
    public $parcela_seccion;
    public $parcela_parcela;
    public $parcela_chacra;
    public $parcela_macizo;
    public $parcela_quinta;
    public $parcela_fraccion;
    public $parcela_uf;
    public $parcela_predio;
    public $parcela_rte;
    public $dpto_desc;
    public $parcela_superficie;
    public $parcela_sup_uf;
    public $uni_med_htm;
    public $tipo_est_parc_descr;
    public $tipo_parcela_descrip;
    public $tipo_parcela_uso_descrip;
    public $tipo_padron_parc_desc;
    public $parcela_instrumento;
    public $tipo_restricc_parcela_desc;
    public $persona_nro_doc;
    public $persona_denominacion;
    public $persona_conyuge;
    public $persona_parcela_dominio;
    public $tipo_estado_descrip;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-44EC212B
    function clsdepartamentos_doc_tipos_fDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid departamentos_doc_tipos_f";
        $this->Initialize();
        $this->parcela_partida = new clsField("parcela_partida", ccsInteger, "");
        
        $this->parcela_seccion = new clsField("parcela_seccion", ccsText, "");
        
        $this->parcela_parcela = new clsField("parcela_parcela", ccsText, "");
        
        $this->parcela_chacra = new clsField("parcela_chacra", ccsText, "");
        
        $this->parcela_macizo = new clsField("parcela_macizo", ccsText, "");
        
        $this->parcela_quinta = new clsField("parcela_quinta", ccsText, "");
        
        $this->parcela_fraccion = new clsField("parcela_fraccion", ccsText, "");
        
        $this->parcela_uf = new clsField("parcela_uf", ccsText, "");
        
        $this->parcela_predio = new clsField("parcela_predio", ccsText, "");
        
        $this->parcela_rte = new clsField("parcela_rte", ccsText, "");
        
        $this->dpto_desc = new clsField("dpto_desc", ccsText, "");
        
        $this->parcela_superficie = new clsField("parcela_superficie", ccsFloat, "");
        
        $this->parcela_sup_uf = new clsField("parcela_sup_uf", ccsFloat, "");
        
        $this->uni_med_htm = new clsField("uni_med_htm", ccsText, "");
        
        $this->tipo_est_parc_descr = new clsField("tipo_est_parc_descr", ccsText, "");
        
        $this->tipo_parcela_descrip = new clsField("tipo_parcela_descrip", ccsText, "");
        
        $this->tipo_parcela_uso_descrip = new clsField("tipo_parcela_uso_descrip", ccsText, "");
        
        $this->tipo_padron_parc_desc = new clsField("tipo_padron_parc_desc", ccsText, "");
        
        $this->parcela_instrumento = new clsField("parcela_instrumento", ccsText, "");
        
        $this->tipo_restricc_parcela_desc = new clsField("tipo_restricc_parcela_desc", ccsText, "");
        
        $this->persona_nro_doc = new clsField("persona_nro_doc", ccsInteger, "");
        
        $this->persona_denominacion = new clsField("persona_denominacion", ccsText, "");
        
        $this->persona_conyuge = new clsField("persona_conyuge", ccsText, "");
        
        $this->persona_parcela_dominio = new clsField("persona_parcela_dominio", ccsFloat, "");
        
        $this->tipo_estado_descrip = new clsField("tipo_estado_descrip", ccsText, "");
        

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

//Prepare Method @2-034FFE49
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlparcela_id", ccsInteger, "", "", $this->Parameters["urlparcela_id"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "parcelas.parcela_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-F5E6CB33
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM (((((((((parcelas LEFT JOIN tipos_estados_parcela ON\n\n" .
        "parcelas.tipo_est_parc_id = tipos_estados_parcela.tipo_est_parc_id) LEFT JOIN unidades_medidas ON\n\n" .
        "parcelas.unidades_medidas_id = unidades_medidas.unidades_medidas_id AND parcelas.unidades_medidas_id = unidades_medidas.unidades_medidas_id) LEFT JOIN tipos_parcelas ON\n\n" .
        "parcelas.tipo_parcela_id = tipos_parcelas.tipo_parcela_id AND parcelas.tipo_parcela_id = tipos_parcelas.tipo_parcela_id) LEFT JOIN tipos_parcelas_usos ON\n\n" .
        "parcelas.tipo_parcela_uso_id = tipos_parcelas_usos.tipo_parcela_uso_id AND parcelas.tipo_parcela_uso_id = tipos_parcelas_usos.tipo_parcela_uso_id) LEFT JOIN tipos_deptos_parcela ON\n\n" .
        "parcelas.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id) LEFT JOIN tipos_padrones_parcela ON\n\n" .
        "parcelas.tipo_padron_parc_id = tipos_padrones_parcela.tipo_padron_parc_id) LEFT JOIN tipos_restricc_parcela ON\n\n" .
        "parcelas.tipo_restricc_parcela_id = tipos_restricc_parcela.tipo_restricc_parcela_id) LEFT JOIN personas_parcelas ON\n\n" .
        "personas_parcelas.parcela_id = parcelas.parcela_id) LEFT JOIN personas ON\n\n" .
        "personas_parcelas.persona_id = personas.persona_id) LEFT JOIN tipos_estados ON\n\n" .
        "personas_parcelas.tipo_estado_id = tipos_estados.tipo_estado_id";
        $this->SQL = "SELECT parcelas.*, tipos_estados_parcela.*, unidades_medidas.*, tipos_parcelas.*, tipos_parcelas_usos.*, tipos_deptos_parcela.*, tipos_padrones_parcela.*,\n\n" .
        "tipos_restricc_parcela.*, personas_parcelas.*, personas.*, tipo_estado_descrip \n\n" .
        "FROM (((((((((parcelas LEFT JOIN tipos_estados_parcela ON\n\n" .
        "parcelas.tipo_est_parc_id = tipos_estados_parcela.tipo_est_parc_id) LEFT JOIN unidades_medidas ON\n\n" .
        "parcelas.unidades_medidas_id = unidades_medidas.unidades_medidas_id AND parcelas.unidades_medidas_id = unidades_medidas.unidades_medidas_id) LEFT JOIN tipos_parcelas ON\n\n" .
        "parcelas.tipo_parcela_id = tipos_parcelas.tipo_parcela_id AND parcelas.tipo_parcela_id = tipos_parcelas.tipo_parcela_id) LEFT JOIN tipos_parcelas_usos ON\n\n" .
        "parcelas.tipo_parcela_uso_id = tipos_parcelas_usos.tipo_parcela_uso_id AND parcelas.tipo_parcela_uso_id = tipos_parcelas_usos.tipo_parcela_uso_id) LEFT JOIN tipos_deptos_parcela ON\n\n" .
        "parcelas.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id) LEFT JOIN tipos_padrones_parcela ON\n\n" .
        "parcelas.tipo_padron_parc_id = tipos_padrones_parcela.tipo_padron_parc_id) LEFT JOIN tipos_restricc_parcela ON\n\n" .
        "parcelas.tipo_restricc_parcela_id = tipos_restricc_parcela.tipo_restricc_parcela_id) LEFT JOIN personas_parcelas ON\n\n" .
        "personas_parcelas.parcela_id = parcelas.parcela_id) LEFT JOIN personas ON\n\n" .
        "personas_parcelas.persona_id = personas.persona_id) LEFT JOIN tipos_estados ON\n\n" .
        "personas_parcelas.tipo_estado_id = tipos_estados.tipo_estado_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-314D63A7
    function SetValues()
    {
        $this->parcela_partida->SetDBValue(trim($this->f("parcela_partida")));
        $this->parcela_seccion->SetDBValue($this->f("parcela_seccion"));
        $this->parcela_parcela->SetDBValue($this->f("parcela_parcela"));
        $this->parcela_chacra->SetDBValue($this->f("parcela_chacra"));
        $this->parcela_macizo->SetDBValue($this->f("parcela_macizo"));
        $this->parcela_quinta->SetDBValue($this->f("parcela_quinta"));
        $this->parcela_fraccion->SetDBValue($this->f("parcela_fraccion"));
        $this->parcela_uf->SetDBValue($this->f("parcela_uf"));
        $this->parcela_predio->SetDBValue($this->f("parcela_predio"));
        $this->parcela_rte->SetDBValue($this->f("parcela_rte"));
        $this->dpto_desc->SetDBValue($this->f("tipo_depto_parc_desc"));
        $this->parcela_superficie->SetDBValue(trim($this->f("parcela_super_mensura")));
        $this->parcela_sup_uf->SetDBValue(trim($this->f("parcela_sup_uf")));
        $this->uni_med_htm->SetDBValue($this->f("unidades_medidas_htm"));
        $this->tipo_est_parc_descr->SetDBValue($this->f("tipo_est_parc_descr"));
        $this->tipo_parcela_descrip->SetDBValue($this->f("tipo_parcela_descrip"));
        $this->tipo_parcela_uso_descrip->SetDBValue($this->f("tipo_parcela_uso_descrip"));
        $this->tipo_padron_parc_desc->SetDBValue($this->f("tipo_padron_parc_desc"));
        $this->parcela_instrumento->SetDBValue($this->f("parcela_instrumento"));
        $this->tipo_restricc_parcela_desc->SetDBValue($this->f("tipo_restricc_parcela_desc"));
        $this->persona_nro_doc->SetDBValue(trim($this->f("persona_nro_doc")));
        $this->persona_denominacion->SetDBValue($this->f("persona_denominacion"));
        $this->persona_conyuge->SetDBValue($this->f("persona_conyuge"));
        $this->persona_parcela_dominio->SetDBValue(trim($this->f("persona_parcela_dominio")));
        $this->tipo_estado_descrip->SetDBValue($this->f("tipo_estado_descrip"));
    }
//End SetValues Method

} //End departamentos_doc_tipos_fDataSource Class @2-FCB6E20C

class clsGridmejoras { //mejoras class @456-9A327A2E

//Variables @456-29DF4C1C

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
    public $Sorter_tipo_mejora_id;
    public $Sorter_tipo_mejora_estado_id;
    public $Sorter_tipo_mejora_destino_id;
    public $Sorter_tipo_mejora_conserva_id;
    public $Sorter_mejora_nro_nota;
    public $Sorter_mejora_sup_cub;
    public $Sorter_mejora_anio_construccion;
    public $Sorter_tipo_mejora_cat_id;
//End Variables

//Class_Initialize Event @456-7B01BFA7
    function clsGridmejoras($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "mejoras";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid mejoras";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsmejorasDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 50;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;
        $this->SorterName = CCGetParam("mejorasOrder", "");
        $this->SorterDirection = CCGetParam("mejorasDir", "");

        $this->tipo_mejora_descrip = new clsControl(ccsLabel, "tipo_mejora_descrip", "tipo_mejora_descrip", ccsText, "", CCGetRequestParam("tipo_mejora_descrip", ccsGet, NULL), $this);
        $this->tipo_mejora_estado_descrip = new clsControl(ccsLabel, "tipo_mejora_estado_descrip", "tipo_mejora_estado_descrip", ccsText, "", CCGetRequestParam("tipo_mejora_estado_descrip", ccsGet, NULL), $this);
        $this->tipo_mejora_destino_descrip = new clsControl(ccsLabel, "tipo_mejora_destino_descrip", "tipo_mejora_destino_descrip", ccsText, "", CCGetRequestParam("tipo_mejora_destino_descrip", ccsGet, NULL), $this);
        $this->tipo_mejora_conserva_descrip = new clsControl(ccsLabel, "tipo_mejora_conserva_descrip", "tipo_mejora_conserva_descrip", ccsText, "", CCGetRequestParam("tipo_mejora_conserva_descrip", ccsGet, NULL), $this);
        $this->mejora_nro_nota = new clsControl(ccsLabel, "mejora_nro_nota", "mejora_nro_nota", ccsInteger, "", CCGetRequestParam("mejora_nro_nota", ccsGet, NULL), $this);
        $this->mejora_sup_cub = new clsControl(ccsLabel, "mejora_sup_cub", "mejora_sup_cub", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("mejora_sup_cub", ccsGet, NULL), $this);
        $this->mejora_anio_construccion = new clsControl(ccsLabel, "mejora_anio_construccion", "mejora_anio_construccion", ccsInteger, "", CCGetRequestParam("mejora_anio_construccion", ccsGet, NULL), $this);
        $this->tipo_mejora_cat_descript = new clsControl(ccsLabel, "tipo_mejora_cat_descript", "tipo_mejora_cat_descript", ccsText, "", CCGetRequestParam("tipo_mejora_cat_descript", ccsGet, NULL), $this);
        $this->Sorter_tipo_mejora_id = new clsSorter($this->ComponentName, "Sorter_tipo_mejora_id", $FileName, $this);
        $this->Sorter_tipo_mejora_estado_id = new clsSorter($this->ComponentName, "Sorter_tipo_mejora_estado_id", $FileName, $this);
        $this->Sorter_tipo_mejora_destino_id = new clsSorter($this->ComponentName, "Sorter_tipo_mejora_destino_id", $FileName, $this);
        $this->Sorter_tipo_mejora_conserva_id = new clsSorter($this->ComponentName, "Sorter_tipo_mejora_conserva_id", $FileName, $this);
        $this->Sorter_mejora_nro_nota = new clsSorter($this->ComponentName, "Sorter_mejora_nro_nota", $FileName, $this);
        $this->Sorter_mejora_sup_cub = new clsSorter($this->ComponentName, "Sorter_mejora_sup_cub", $FileName, $this);
        $this->Sorter_mejora_anio_construccion = new clsSorter($this->ComponentName, "Sorter_mejora_anio_construccion", $FileName, $this);
        $this->Sorter_tipo_mejora_cat_id = new clsSorter($this->ComponentName, "Sorter_tipo_mejora_cat_id", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpSimple, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
    }
//End Class_Initialize Event

//Initialize Method @456-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @456-581EA8DC
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["expr478"] = 1;
        $this->DataSource->Parameters["urlparcela_id"] = CCGetFromGet("parcela_id", NULL);

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
            $this->ControlsVisible["tipo_mejora_descrip"] = $this->tipo_mejora_descrip->Visible;
            $this->ControlsVisible["tipo_mejora_estado_descrip"] = $this->tipo_mejora_estado_descrip->Visible;
            $this->ControlsVisible["tipo_mejora_destino_descrip"] = $this->tipo_mejora_destino_descrip->Visible;
            $this->ControlsVisible["tipo_mejora_conserva_descrip"] = $this->tipo_mejora_conserva_descrip->Visible;
            $this->ControlsVisible["mejora_nro_nota"] = $this->mejora_nro_nota->Visible;
            $this->ControlsVisible["mejora_sup_cub"] = $this->mejora_sup_cub->Visible;
            $this->ControlsVisible["mejora_anio_construccion"] = $this->mejora_anio_construccion->Visible;
            $this->ControlsVisible["tipo_mejora_cat_descript"] = $this->tipo_mejora_cat_descript->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->tipo_mejora_descrip->SetValue($this->DataSource->tipo_mejora_descrip->GetValue());
                $this->tipo_mejora_estado_descrip->SetValue($this->DataSource->tipo_mejora_estado_descrip->GetValue());
                $this->tipo_mejora_destino_descrip->SetValue($this->DataSource->tipo_mejora_destino_descrip->GetValue());
                $this->tipo_mejora_conserva_descrip->SetValue($this->DataSource->tipo_mejora_conserva_descrip->GetValue());
                $this->mejora_nro_nota->SetValue($this->DataSource->mejora_nro_nota->GetValue());
                $this->mejora_sup_cub->SetValue($this->DataSource->mejora_sup_cub->GetValue());
                $this->mejora_anio_construccion->SetValue($this->DataSource->mejora_anio_construccion->GetValue());
                $this->tipo_mejora_cat_descript->SetValue($this->DataSource->tipo_mejora_cat_descript->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->tipo_mejora_descrip->Show();
                $this->tipo_mejora_estado_descrip->Show();
                $this->tipo_mejora_destino_descrip->Show();
                $this->tipo_mejora_conserva_descrip->Show();
                $this->mejora_nro_nota->Show();
                $this->mejora_sup_cub->Show();
                $this->mejora_anio_construccion->Show();
                $this->tipo_mejora_cat_descript->Show();
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
        $this->Sorter_tipo_mejora_id->Show();
        $this->Sorter_tipo_mejora_estado_id->Show();
        $this->Sorter_tipo_mejora_destino_id->Show();
        $this->Sorter_tipo_mejora_conserva_id->Show();
        $this->Sorter_mejora_nro_nota->Show();
        $this->Sorter_mejora_sup_cub->Show();
        $this->Sorter_mejora_anio_construccion->Show();
        $this->Sorter_tipo_mejora_cat_id->Show();
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @456-0FA05F6D
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->tipo_mejora_descrip->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_mejora_estado_descrip->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_mejora_destino_descrip->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_mejora_conserva_descrip->Errors->ToString());
        $errors = ComposeStrings($errors, $this->mejora_nro_nota->Errors->ToString());
        $errors = ComposeStrings($errors, $this->mejora_sup_cub->Errors->ToString());
        $errors = ComposeStrings($errors, $this->mejora_anio_construccion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_mejora_cat_descript->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End mejoras Class @456-FCB6E20C

class clsmejorasDataSource extends clsDBtdf_nuevo {  //mejorasDataSource Class @456-A728D50A

//DataSource Variables @456-BA2238A8
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $tipo_mejora_descrip;
    public $tipo_mejora_estado_descrip;
    public $tipo_mejora_destino_descrip;
    public $tipo_mejora_conserva_descrip;
    public $mejora_nro_nota;
    public $mejora_sup_cub;
    public $mejora_anio_construccion;
    public $tipo_mejora_cat_descript;
//End DataSource Variables

//DataSourceClass_Initialize Event @456-757670E6
    function clsmejorasDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid mejoras";
        $this->Initialize();
        $this->tipo_mejora_descrip = new clsField("tipo_mejora_descrip", ccsText, "");
        
        $this->tipo_mejora_estado_descrip = new clsField("tipo_mejora_estado_descrip", ccsText, "");
        
        $this->tipo_mejora_destino_descrip = new clsField("tipo_mejora_destino_descrip", ccsText, "");
        
        $this->tipo_mejora_conserva_descrip = new clsField("tipo_mejora_conserva_descrip", ccsText, "");
        
        $this->mejora_nro_nota = new clsField("mejora_nro_nota", ccsInteger, "");
        
        $this->mejora_sup_cub = new clsField("mejora_sup_cub", ccsFloat, "");
        
        $this->mejora_anio_construccion = new clsField("mejora_anio_construccion", ccsInteger, "");
        
        $this->tipo_mejora_cat_descript = new clsField("tipo_mejora_cat_descript", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @456-F1BFB17C
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "mejoras.mejora_anio_construccion desc, mejoras.mejora_anio_construccion_3 desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_tipo_mejora_id" => array("tipo_mejora_id", ""), 
            "Sorter_tipo_mejora_estado_id" => array("tipo_mejora_estado_id", ""), 
            "Sorter_tipo_mejora_destino_id" => array("tipo_mejora_destino_id", ""), 
            "Sorter_tipo_mejora_conserva_id" => array("tipo_mejora_conserva_id", ""), 
            "Sorter_mejora_nro_nota" => array("mejora_nro_nota", ""), 
            "Sorter_mejora_sup_cub" => array("mejora_sup_cub", ""), 
            "Sorter_mejora_anio_construccion" => array("mejora_anio_construccion", ""), 
            "Sorter_tipo_mejora_cat_id" => array("tipo_mejora_cat_id", "")));
    }
//End SetOrder Method

//Prepare Method @456-26328BFD
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "expr478", ccsInteger, "", "", $this->Parameters["expr478"], "", false);
        $this->wp->AddParameter("2", "urlparcela_id", ccsInteger, "", "", $this->Parameters["urlparcela_id"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "mejoras.tipo_estado_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "mejoras.parcela_id", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
        $this->Where = $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]);
    }
//End Prepare Method

//Open Method @456-1F2EECD3
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM (((((mejoras INNER JOIN parcelas ON\n\n" .
        "mejoras.parcela_id = parcelas.parcela_id) LEFT JOIN tipos_mejoras ON\n\n" .
        "mejoras.tipo_mejora_id = tipos_mejoras.tipo_mejora_id) LEFT JOIN tipos_mejoras_estados ON\n\n" .
        "mejoras.tipo_mejora_estado_id = tipos_mejoras_estados.tipo_mejora_estado_id) LEFT JOIN tipos_mejoras_destinos ON\n\n" .
        "mejoras.tipo_mejora_destino_id = tipos_mejoras_destinos.tipo_mejora_destino_id) LEFT JOIN tipos_mejoras_cat ON\n\n" .
        "mejoras.tipo_mejora_cat_id = tipos_mejoras_cat.tipo_mejora_cat_id) LEFT JOIN tipos_mejoras_conserva ON\n\n" .
        "mejoras.tipo_mejora_conserva_id = tipos_mejoras_conserva.tipo_mejora_conserva_id";
        $this->SQL = "SELECT mejoras.*, parcela_partida, tipo_depto_parc_id, tipo_mejora_descrip, tipo_mejora_estado_descrip, tipo_mejora_destino_descrip,\n\n" .
        "tipo_mejora_cat_descript, tipo_mejora_conserva_descrip \n\n" .
        "FROM (((((mejoras INNER JOIN parcelas ON\n\n" .
        "mejoras.parcela_id = parcelas.parcela_id) LEFT JOIN tipos_mejoras ON\n\n" .
        "mejoras.tipo_mejora_id = tipos_mejoras.tipo_mejora_id) LEFT JOIN tipos_mejoras_estados ON\n\n" .
        "mejoras.tipo_mejora_estado_id = tipos_mejoras_estados.tipo_mejora_estado_id) LEFT JOIN tipos_mejoras_destinos ON\n\n" .
        "mejoras.tipo_mejora_destino_id = tipos_mejoras_destinos.tipo_mejora_destino_id) LEFT JOIN tipos_mejoras_cat ON\n\n" .
        "mejoras.tipo_mejora_cat_id = tipos_mejoras_cat.tipo_mejora_cat_id) LEFT JOIN tipos_mejoras_conserva ON\n\n" .
        "mejoras.tipo_mejora_conserva_id = tipos_mejoras_conserva.tipo_mejora_conserva_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @456-5696971E
    function SetValues()
    {
        $this->tipo_mejora_descrip->SetDBValue($this->f("tipo_mejora_descrip"));
        $this->tipo_mejora_estado_descrip->SetDBValue($this->f("tipo_mejora_estado_descrip"));
        $this->tipo_mejora_destino_descrip->SetDBValue($this->f("tipo_mejora_destino_descrip"));
        $this->tipo_mejora_conserva_descrip->SetDBValue($this->f("tipo_mejora_conserva_descrip"));
        $this->mejora_nro_nota->SetDBValue(trim($this->f("mejora_nro_nota")));
        $this->mejora_sup_cub->SetDBValue(trim($this->f("mejora_sup_cub")));
        $this->mejora_anio_construccion->SetDBValue(trim($this->f("mejora_anio_construccion")));
        $this->tipo_mejora_cat_descript->SetDBValue($this->f("tipo_mejora_cat_descript"));
    }
//End SetValues Method

} //End mejorasDataSource Class @456-FCB6E20C

//Initialize Page @1-7B92CE27
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
$TemplateFileName = "gis_info.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-4F830738
include_once("./gis_info_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-054C1FCF
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$departamentos_doc_tipos_f = new clsGriddepartamentos_doc_tipos_f("", $MainPage);
$mejoras = new clsGridmejoras("", $MainPage);
$MainPage->departamentos_doc_tipos_f = & $departamentos_doc_tipos_f;
$MainPage->mejoras = & $mejoras;
$departamentos_doc_tipos_f->Initialize();
$mejoras->Initialize();

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

//Go to destination page @1-57E4284B
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    header("Location: " . $Redirect);
    unset($departamentos_doc_tipos_f);
    unset($mejoras);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-D2C77718
$departamentos_doc_tipos_f->Show();
$mejoras->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", "<center><font face=\"Arial\"><small>Ge&#110;er&#97;t&#101;&#100; <!-- SCC -->&#119;i&#116;h <!-- CCS -->&#67;od&#101;C&#104;&#97;r&#103;e <!-- CCS -->&#83;&#116;u&#100;&#105;o.</small></font></center>" . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", "<center><font face=\"Arial\"><small>Ge&#110;er&#97;t&#101;&#100; <!-- SCC -->&#119;i&#116;h <!-- CCS -->&#67;od&#101;C&#104;&#97;r&#103;e <!-- CCS -->&#83;&#116;u&#100;&#105;o.</small></font></center>" . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= "<center><font face=\"Arial\"><small>Ge&#110;er&#97;t&#101;&#100; <!-- SCC -->&#119;i&#116;h <!-- CCS -->&#67;od&#101;C&#104;&#97;r&#103;e <!-- CCS -->&#83;&#116;u&#100;&#105;o.</small></font></center>";
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-295F4291
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
unset($departamentos_doc_tipos_f);
unset($mejoras);
unset($Tpl);
//End Unload Page


?>
