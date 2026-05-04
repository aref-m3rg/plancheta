<?php
//Include Common Files @1-174DCFC0
define("RelativePath", "..");
define("PathToCurrentPage", "/reportes/");
define("FileName", "rpt_nomenclatura_ph.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
include_once(RelativePath . "/Services.php");
//End Include Common Files

//parcelas_parcelas_tipos_p ReportGroup class @2-788FDB5A
class clsReportGroupparcelas_parcelas_tipos_p {
    var $GroupType;
    var $mode; //1 - open, 2 - close
    var $dpto_desc, $_dpto_descAttributes;
    var $parcela_seccion, $_parcela_seccionAttributes;
    var $parcela_macizo, $_parcela_macizoAttributes;
    var $parcela_parcela, $_parcela_parcelaAttributes;
    var $parcela_chacra, $_parcela_chacraAttributes;
    var $parcela_quinta, $_parcela_quintaAttributes;
    var $parcela_fraccion, $_parcela_fraccionAttributes;
    var $parcela_uf, $_parcela_ufAttributes;
    var $parcela_partida, $_parcela_partidaAttributes;
    var $parc_uso_desc, $_parc_uso_descAttributes;
    var $parcela_val_mejora, $_parcela_val_mejoraAttributes;
    var $parcela_sup_uf, $_parcela_sup_ufAttributes;
    var $parcela_val_tierra, $_parcela_val_tierraAttributes;
    var $parcela_val_total, $_parcela_val_totalAttributes;
    var $tmp_plano, $_tmp_planoAttributes;
    var $parcela_restr, $_parcela_restrAttributes;
    var $parcela_notas_nom, $_parcela_notas_nomAttributes;
    var $uni_med_htm, $_uni_med_htmAttributes;
    var $parcela_porc_uf, $_parcela_porc_ufAttributes;
    var $obs, $_obsAttributes;
    var $ImageLink1, $_ImageLink1Page, $_ImageLink1Parameters, $_ImageLink1Attributes;
    var $restricciones, $_restriccionesPage, $_restriccionesParameters, $_restriccionesAttributes;
    var $notas, $_notasPage, $_notasParameters, $_notasAttributes;
    var $ImageLink2, $_ImageLink2Page, $_ImageLink2Parameters, $_ImageLink2Attributes;
    var $observaciones, $_observacionesPage, $_observacionesParameters, $_observacionesAttributes;
    var $Attributes;
    var $ReportTotalIndex = 0;
    var $PageTotalIndex;
    var $PageNumber;
    var $RowNumber;
    var $Parent;

    function clsReportGroupparcelas_parcelas_tipos_p(& $parent) {
        $this->Parent = & $parent;
        $this->Attributes = $this->Parent->Attributes->GetAsArray();
    }
    function SetControls($PrevGroup = "") {
        $this->dpto_desc = $this->Parent->dpto_desc->Value;
        $this->parcela_seccion = $this->Parent->parcela_seccion->Value;
        $this->parcela_macizo = $this->Parent->parcela_macizo->Value;
        $this->parcela_parcela = $this->Parent->parcela_parcela->Value;
        $this->parcela_chacra = $this->Parent->parcela_chacra->Value;
        $this->parcela_quinta = $this->Parent->parcela_quinta->Value;
        $this->parcela_fraccion = $this->Parent->parcela_fraccion->Value;
        $this->parcela_uf = $this->Parent->parcela_uf->Value;
        $this->parcela_partida = $this->Parent->parcela_partida->Value;
        $this->parc_uso_desc = $this->Parent->parc_uso_desc->Value;
        $this->parcela_val_mejora = $this->Parent->parcela_val_mejora->Value;
        $this->parcela_sup_uf = $this->Parent->parcela_sup_uf->Value;
        $this->parcela_val_tierra = $this->Parent->parcela_val_tierra->Value;
        $this->parcela_val_total = $this->Parent->parcela_val_total->Value;
        $this->tmp_plano = $this->Parent->tmp_plano->Value;
        $this->parcela_restr = $this->Parent->parcela_restr->Value;
        $this->parcela_notas_nom = $this->Parent->parcela_notas_nom->Value;
        $this->uni_med_htm = $this->Parent->uni_med_htm->Value;
        $this->parcela_porc_uf = $this->Parent->parcela_porc_uf->Value;
        $this->obs = $this->Parent->obs->Value;
        $this->ImageLink1 = $this->Parent->ImageLink1->Value;
        $this->restricciones = $this->Parent->restricciones->Value;
        $this->notas = $this->Parent->notas->Value;
        $this->ImageLink2 = $this->Parent->ImageLink2->Value;
        $this->observaciones = $this->Parent->observaciones->Value;
    }

    function SetTotalControls($mode = "", $PrevGroup = "") {
        $this->_ImageLink1Page = $this->Parent->ImageLink1->Page;
        $this->_ImageLink1Parameters = $this->Parent->ImageLink1->Parameters;
        $this->_restriccionesPage = $this->Parent->restricciones->Page;
        $this->_restriccionesParameters = $this->Parent->restricciones->Parameters;
        $this->_notasPage = $this->Parent->notas->Page;
        $this->_notasParameters = $this->Parent->notas->Parameters;
        $this->_ImageLink2Page = $this->Parent->ImageLink2->Page;
        $this->_ImageLink2Parameters = $this->Parent->ImageLink2->Parameters;
        $this->_observacionesPage = $this->Parent->observaciones->Page;
        $this->_observacionesParameters = $this->Parent->observaciones->Parameters;
        $this->_dpto_descAttributes = $this->Parent->dpto_desc->Attributes->GetAsArray();
        $this->_parcela_seccionAttributes = $this->Parent->parcela_seccion->Attributes->GetAsArray();
        $this->_parcela_macizoAttributes = $this->Parent->parcela_macizo->Attributes->GetAsArray();
        $this->_parcela_parcelaAttributes = $this->Parent->parcela_parcela->Attributes->GetAsArray();
        $this->_parcela_chacraAttributes = $this->Parent->parcela_chacra->Attributes->GetAsArray();
        $this->_parcela_quintaAttributes = $this->Parent->parcela_quinta->Attributes->GetAsArray();
        $this->_parcela_fraccionAttributes = $this->Parent->parcela_fraccion->Attributes->GetAsArray();
        $this->_parcela_ufAttributes = $this->Parent->parcela_uf->Attributes->GetAsArray();
        $this->_parcela_partidaAttributes = $this->Parent->parcela_partida->Attributes->GetAsArray();
        $this->_parc_uso_descAttributes = $this->Parent->parc_uso_desc->Attributes->GetAsArray();
        $this->_parcela_val_mejoraAttributes = $this->Parent->parcela_val_mejora->Attributes->GetAsArray();
        $this->_parcela_sup_ufAttributes = $this->Parent->parcela_sup_uf->Attributes->GetAsArray();
        $this->_parcela_val_tierraAttributes = $this->Parent->parcela_val_tierra->Attributes->GetAsArray();
        $this->_parcela_val_totalAttributes = $this->Parent->parcela_val_total->Attributes->GetAsArray();
        $this->_tmp_planoAttributes = $this->Parent->tmp_plano->Attributes->GetAsArray();
        $this->_parcela_restrAttributes = $this->Parent->parcela_restr->Attributes->GetAsArray();
        $this->_parcela_notas_nomAttributes = $this->Parent->parcela_notas_nom->Attributes->GetAsArray();
        $this->_uni_med_htmAttributes = $this->Parent->uni_med_htm->Attributes->GetAsArray();
        $this->_parcela_porc_ufAttributes = $this->Parent->parcela_porc_uf->Attributes->GetAsArray();
        $this->_obsAttributes = $this->Parent->obs->Attributes->GetAsArray();
        $this->_ImageLink1Attributes = $this->Parent->ImageLink1->Attributes->GetAsArray();
        $this->_restriccionesAttributes = $this->Parent->restricciones->Attributes->GetAsArray();
        $this->_notasAttributes = $this->Parent->notas->Attributes->GetAsArray();
        $this->_ImageLink2Attributes = $this->Parent->ImageLink2->Attributes->GetAsArray();
        $this->_observacionesAttributes = $this->Parent->observaciones->Attributes->GetAsArray();
    }
    function SyncWithHeader(& $Header) {
        $this->dpto_desc = $Header->dpto_desc;
        $Header->_dpto_descAttributes = $this->_dpto_descAttributes;
        $this->Parent->dpto_desc->Value = $Header->dpto_desc;
        $this->Parent->dpto_desc->Attributes->RestoreFromArray($Header->_dpto_descAttributes);
        $this->parcela_seccion = $Header->parcela_seccion;
        $Header->_parcela_seccionAttributes = $this->_parcela_seccionAttributes;
        $this->Parent->parcela_seccion->Value = $Header->parcela_seccion;
        $this->Parent->parcela_seccion->Attributes->RestoreFromArray($Header->_parcela_seccionAttributes);
        $this->parcela_macizo = $Header->parcela_macizo;
        $Header->_parcela_macizoAttributes = $this->_parcela_macizoAttributes;
        $this->Parent->parcela_macizo->Value = $Header->parcela_macizo;
        $this->Parent->parcela_macizo->Attributes->RestoreFromArray($Header->_parcela_macizoAttributes);
        $this->parcela_parcela = $Header->parcela_parcela;
        $Header->_parcela_parcelaAttributes = $this->_parcela_parcelaAttributes;
        $this->Parent->parcela_parcela->Value = $Header->parcela_parcela;
        $this->Parent->parcela_parcela->Attributes->RestoreFromArray($Header->_parcela_parcelaAttributes);
        $this->parcela_chacra = $Header->parcela_chacra;
        $Header->_parcela_chacraAttributes = $this->_parcela_chacraAttributes;
        $this->Parent->parcela_chacra->Value = $Header->parcela_chacra;
        $this->Parent->parcela_chacra->Attributes->RestoreFromArray($Header->_parcela_chacraAttributes);
        $this->parcela_quinta = $Header->parcela_quinta;
        $Header->_parcela_quintaAttributes = $this->_parcela_quintaAttributes;
        $this->Parent->parcela_quinta->Value = $Header->parcela_quinta;
        $this->Parent->parcela_quinta->Attributes->RestoreFromArray($Header->_parcela_quintaAttributes);
        $this->parcela_fraccion = $Header->parcela_fraccion;
        $Header->_parcela_fraccionAttributes = $this->_parcela_fraccionAttributes;
        $this->Parent->parcela_fraccion->Value = $Header->parcela_fraccion;
        $this->Parent->parcela_fraccion->Attributes->RestoreFromArray($Header->_parcela_fraccionAttributes);
        $this->parcela_uf = $Header->parcela_uf;
        $Header->_parcela_ufAttributes = $this->_parcela_ufAttributes;
        $this->Parent->parcela_uf->Value = $Header->parcela_uf;
        $this->Parent->parcela_uf->Attributes->RestoreFromArray($Header->_parcela_ufAttributes);
        $this->parcela_partida = $Header->parcela_partida;
        $Header->_parcela_partidaAttributes = $this->_parcela_partidaAttributes;
        $this->Parent->parcela_partida->Value = $Header->parcela_partida;
        $this->Parent->parcela_partida->Attributes->RestoreFromArray($Header->_parcela_partidaAttributes);
        $this->parc_uso_desc = $Header->parc_uso_desc;
        $Header->_parc_uso_descAttributes = $this->_parc_uso_descAttributes;
        $this->Parent->parc_uso_desc->Value = $Header->parc_uso_desc;
        $this->Parent->parc_uso_desc->Attributes->RestoreFromArray($Header->_parc_uso_descAttributes);
        $this->parcela_val_mejora = $Header->parcela_val_mejora;
        $Header->_parcela_val_mejoraAttributes = $this->_parcela_val_mejoraAttributes;
        $this->Parent->parcela_val_mejora->Value = $Header->parcela_val_mejora;
        $this->Parent->parcela_val_mejora->Attributes->RestoreFromArray($Header->_parcela_val_mejoraAttributes);
        $this->parcela_sup_uf = $Header->parcela_sup_uf;
        $Header->_parcela_sup_ufAttributes = $this->_parcela_sup_ufAttributes;
        $this->Parent->parcela_sup_uf->Value = $Header->parcela_sup_uf;
        $this->Parent->parcela_sup_uf->Attributes->RestoreFromArray($Header->_parcela_sup_ufAttributes);
        $this->parcela_val_tierra = $Header->parcela_val_tierra;
        $Header->_parcela_val_tierraAttributes = $this->_parcela_val_tierraAttributes;
        $this->Parent->parcela_val_tierra->Value = $Header->parcela_val_tierra;
        $this->Parent->parcela_val_tierra->Attributes->RestoreFromArray($Header->_parcela_val_tierraAttributes);
        $this->parcela_val_total = $Header->parcela_val_total;
        $Header->_parcela_val_totalAttributes = $this->_parcela_val_totalAttributes;
        $this->Parent->parcela_val_total->Value = $Header->parcela_val_total;
        $this->Parent->parcela_val_total->Attributes->RestoreFromArray($Header->_parcela_val_totalAttributes);
        $this->tmp_plano = $Header->tmp_plano;
        $Header->_tmp_planoAttributes = $this->_tmp_planoAttributes;
        $this->Parent->tmp_plano->Value = $Header->tmp_plano;
        $this->Parent->tmp_plano->Attributes->RestoreFromArray($Header->_tmp_planoAttributes);
        $this->parcela_restr = $Header->parcela_restr;
        $Header->_parcela_restrAttributes = $this->_parcela_restrAttributes;
        $this->Parent->parcela_restr->Value = $Header->parcela_restr;
        $this->Parent->parcela_restr->Attributes->RestoreFromArray($Header->_parcela_restrAttributes);
        $this->parcela_notas_nom = $Header->parcela_notas_nom;
        $Header->_parcela_notas_nomAttributes = $this->_parcela_notas_nomAttributes;
        $this->Parent->parcela_notas_nom->Value = $Header->parcela_notas_nom;
        $this->Parent->parcela_notas_nom->Attributes->RestoreFromArray($Header->_parcela_notas_nomAttributes);
        $this->uni_med_htm = $Header->uni_med_htm;
        $Header->_uni_med_htmAttributes = $this->_uni_med_htmAttributes;
        $this->Parent->uni_med_htm->Value = $Header->uni_med_htm;
        $this->Parent->uni_med_htm->Attributes->RestoreFromArray($Header->_uni_med_htmAttributes);
        $this->parcela_porc_uf = $Header->parcela_porc_uf;
        $Header->_parcela_porc_ufAttributes = $this->_parcela_porc_ufAttributes;
        $this->Parent->parcela_porc_uf->Value = $Header->parcela_porc_uf;
        $this->Parent->parcela_porc_uf->Attributes->RestoreFromArray($Header->_parcela_porc_ufAttributes);
        $this->obs = $Header->obs;
        $Header->_obsAttributes = $this->_obsAttributes;
        $this->Parent->obs->Value = $Header->obs;
        $this->Parent->obs->Attributes->RestoreFromArray($Header->_obsAttributes);
        $this->ImageLink1 = $Header->ImageLink1;
        $this->_ImageLink1Page = $Header->_ImageLink1Page;
        $this->_ImageLink1Parameters = $Header->_ImageLink1Parameters;
        $Header->_ImageLink1Attributes = $this->_ImageLink1Attributes;
        $this->Parent->ImageLink1->Value = $Header->ImageLink1;
        $this->Parent->ImageLink1->Attributes->RestoreFromArray($Header->_ImageLink1Attributes);
        $this->restricciones = $Header->restricciones;
        $this->_restriccionesPage = $Header->_restriccionesPage;
        $this->_restriccionesParameters = $Header->_restriccionesParameters;
        $Header->_restriccionesAttributes = $this->_restriccionesAttributes;
        $this->Parent->restricciones->Value = $Header->restricciones;
        $this->Parent->restricciones->Attributes->RestoreFromArray($Header->_restriccionesAttributes);
        $this->notas = $Header->notas;
        $this->_notasPage = $Header->_notasPage;
        $this->_notasParameters = $Header->_notasParameters;
        $Header->_notasAttributes = $this->_notasAttributes;
        $this->Parent->notas->Value = $Header->notas;
        $this->Parent->notas->Attributes->RestoreFromArray($Header->_notasAttributes);
        $this->ImageLink2 = $Header->ImageLink2;
        $this->_ImageLink2Page = $Header->_ImageLink2Page;
        $this->_ImageLink2Parameters = $Header->_ImageLink2Parameters;
        $Header->_ImageLink2Attributes = $this->_ImageLink2Attributes;
        $this->Parent->ImageLink2->Value = $Header->ImageLink2;
        $this->Parent->ImageLink2->Attributes->RestoreFromArray($Header->_ImageLink2Attributes);
        $this->observaciones = $Header->observaciones;
        $this->_observacionesPage = $Header->_observacionesPage;
        $this->_observacionesParameters = $Header->_observacionesParameters;
        $Header->_observacionesAttributes = $this->_observacionesAttributes;
        $this->Parent->observaciones->Value = $Header->observaciones;
        $this->Parent->observaciones->Attributes->RestoreFromArray($Header->_observacionesAttributes);
    }
    function ChangeTotalControls() {
    }
}
//End parcelas_parcelas_tipos_p ReportGroup class

//parcelas_parcelas_tipos_p GroupsCollection class @2-FD249499
class clsGroupsCollectionparcelas_parcelas_tipos_p {
    var $Groups;
    var $mPageCurrentHeaderIndex;
    var $PageSize;
    var $TotalPages = 0;
    var $TotalRows = 0;
    var $CurrentPageSize = 0;
    var $Pages;
    var $Parent;
    var $LastDetailIndex;

    function clsGroupsCollectionparcelas_parcelas_tipos_p(& $parent) {
        $this->Parent = & $parent;
        $this->Groups = array();
        $this->Pages  = array();
        $this->mReportTotalIndex = 0;
        $this->mPageTotalIndex = 1;
    }

    function & InitGroup() {
        $group = new clsReportGroupparcelas_parcelas_tipos_p($this->Parent);
        $group->RowNumber = $this->TotalRows + 1;
        $group->PageNumber = $this->TotalPages;
        $group->PageTotalIndex = $this->mPageCurrentHeaderIndex;
        return $group;
    }

    function RestoreValues() {
        $this->Parent->dpto_desc->Value = $this->Parent->dpto_desc->initialValue;
        $this->Parent->parcela_seccion->Value = $this->Parent->parcela_seccion->initialValue;
        $this->Parent->parcela_macizo->Value = $this->Parent->parcela_macizo->initialValue;
        $this->Parent->parcela_parcela->Value = $this->Parent->parcela_parcela->initialValue;
        $this->Parent->parcela_chacra->Value = $this->Parent->parcela_chacra->initialValue;
        $this->Parent->parcela_quinta->Value = $this->Parent->parcela_quinta->initialValue;
        $this->Parent->parcela_fraccion->Value = $this->Parent->parcela_fraccion->initialValue;
        $this->Parent->parcela_uf->Value = $this->Parent->parcela_uf->initialValue;
        $this->Parent->parcela_partida->Value = $this->Parent->parcela_partida->initialValue;
        $this->Parent->parc_uso_desc->Value = $this->Parent->parc_uso_desc->initialValue;
        $this->Parent->parcela_val_mejora->Value = $this->Parent->parcela_val_mejora->initialValue;
        $this->Parent->parcela_sup_uf->Value = $this->Parent->parcela_sup_uf->initialValue;
        $this->Parent->parcela_val_tierra->Value = $this->Parent->parcela_val_tierra->initialValue;
        $this->Parent->parcela_val_total->Value = $this->Parent->parcela_val_total->initialValue;
        $this->Parent->tmp_plano->Value = $this->Parent->tmp_plano->initialValue;
        $this->Parent->parcela_restr->Value = $this->Parent->parcela_restr->initialValue;
        $this->Parent->parcela_notas_nom->Value = $this->Parent->parcela_notas_nom->initialValue;
        $this->Parent->uni_med_htm->Value = $this->Parent->uni_med_htm->initialValue;
        $this->Parent->parcela_porc_uf->Value = $this->Parent->parcela_porc_uf->initialValue;
        $this->Parent->obs->Value = $this->Parent->obs->initialValue;
        $this->Parent->ImageLink1->Value = $this->Parent->ImageLink1->initialValue;
        $this->Parent->restricciones->Value = $this->Parent->restricciones->initialValue;
        $this->Parent->notas->Value = $this->Parent->notas->initialValue;
        $this->Parent->ImageLink2->Value = $this->Parent->ImageLink2->initialValue;
        $this->Parent->observaciones->Value = $this->Parent->observaciones->initialValue;
    }

    function OpenPage() {
        $this->TotalPages++;
        $Group = & $this->InitGroup();
        $this->Parent->Page_Header->CCSEventResult = CCGetEvent($this->Parent->Page_Header->CCSEvents, "OnInitialize", $this->Parent->Page_Header);
        if ($this->Parent->Page_Header->Visible)
            $this->CurrentPageSize = $this->CurrentPageSize + $this->Parent->Page_Header->Height;
        $Group->SetTotalControls("GetNextValue");
        $this->Parent->Page_Header->CCSEventResult = CCGetEvent($this->Parent->Page_Header->CCSEvents, "OnCalculate", $this->Parent->Page_Header);
        $Group->SetControls();
        $Group->Mode = 1;
        $Group->GroupType = "Page";
        $Group->PageTotalIndex = count($this->Groups);
        $this->mPageCurrentHeaderIndex = count($this->Groups);
        $this->Groups[] =  & $Group;
        $this->Pages[] =  count($this->Groups) == 2 ? 0 : count($this->Groups) - 1;
    }

    function OpenGroup($groupName) {
        $Group = "";
        $OpenFlag = false;
        if ($groupName == "Report") {
            $Group = & $this->InitGroup(true);
            $this->Parent->Report_Header->CCSEventResult = CCGetEvent($this->Parent->Report_Header->CCSEvents, "OnInitialize", $this->Parent->Report_Header);
            if ($this->Parent->Report_Header->Visible) 
                $this->CurrentPageSize = $this->CurrentPageSize + $this->Parent->Report_Header->Height;
                $Group->SetTotalControls("GetNextValue");
            $this->Parent->Report_Header->CCSEventResult = CCGetEvent($this->Parent->Report_Header->CCSEvents, "OnCalculate", $this->Parent->Report_Header);
            $Group->SetControls();
            $Group->Mode = 1;
            $Group->GroupType = "Report";
            $this->Groups[] = & $Group;
            $this->OpenPage();
        }
    }

    function ClosePage() {
        $Group = & $this->InitGroup();
        $this->Parent->Page_Footer->CCSEventResult = CCGetEvent($this->Parent->Page_Footer->CCSEvents, "OnInitialize", $this->Parent->Page_Footer);
        $Group->SetTotalControls("GetPrevValue");
        $Group->SyncWithHeader($this->Groups[$this->mPageCurrentHeaderIndex]);
        $this->Parent->Page_Footer->CCSEventResult = CCGetEvent($this->Parent->Page_Footer->CCSEvents, "OnCalculate", $this->Parent->Page_Footer);
        $Group->SetControls();
        $this->RestoreValues();
        $this->CurrentPageSize = 0;
        $Group->Mode = 2;
        $Group->GroupType = "Page";
        $this->Groups[] = & $Group;
    }

    function CloseGroup($groupName)
    {
        $Group = "";
        if ($groupName == "Report") {
            $Group = & $this->InitGroup(true);
            $this->Parent->Report_Footer->CCSEventResult = CCGetEvent($this->Parent->Report_Footer->CCSEvents, "OnInitialize", $this->Parent->Report_Footer);
            if ($this->Parent->Page_Footer->Visible) 
                $OverSize = $this->Parent->Report_Footer->Height + $this->Parent->Page_Footer->Height;
            else
                $OverSize = $this->Parent->Report_Footer->Height;
            if (($this->PageSize > 0) and $this->Parent->Report_Footer->Visible and ($this->CurrentPageSize + $OverSize > $this->PageSize)) {
                $this->ClosePage();
                $this->OpenPage();
            }
            $Group->SetTotalControls("GetPrevValue");
            $Group->SyncWithHeader($this->Groups[0]);
            if ($this->Parent->Report_Footer->Visible)
                $this->CurrentPageSize = $this->CurrentPageSize + $this->Parent->Report_Footer->Height;
            $this->Parent->Report_Footer->CCSEventResult = CCGetEvent($this->Parent->Report_Footer->CCSEvents, "OnCalculate", $this->Parent->Report_Footer);
            $Group->SetControls();
            $this->RestoreValues();
            $Group->Mode = 2;
            $Group->GroupType = "Report";
            $this->Groups[] = & $Group;
            $this->ClosePage();
            return;
        }
    }

    function AddItem()
    {
        $Group = & $this->InitGroup(true);
        $this->Parent->Detail->CCSEventResult = CCGetEvent($this->Parent->Detail->CCSEvents, "OnInitialize", $this->Parent->Detail);
        if ($this->Parent->Page_Footer->Visible) 
            $OverSize = $this->Parent->Detail->Height + $this->Parent->Page_Footer->Height;
        else
            $OverSize = $this->Parent->Detail->Height;
        if (($this->PageSize > 0) and $this->Parent->Detail->Visible and ($this->CurrentPageSize + $OverSize > $this->PageSize)) {
            $this->ClosePage();
            $this->OpenPage();
        }
        $this->TotalRows++;
        if ($this->LastDetailIndex)
            $PrevGroup = & $this->Groups[$this->LastDetailIndex];
        else
            $PrevGroup = "";
        $Group->SetTotalControls("", $PrevGroup);
        if ($this->Parent->Detail->Visible)
            $this->CurrentPageSize = $this->CurrentPageSize + $this->Parent->Detail->Height;
        $this->Parent->Detail->CCSEventResult = CCGetEvent($this->Parent->Detail->CCSEvents, "OnCalculate", $this->Parent->Detail);
        $Group->SetControls($PrevGroup);
        $this->LastDetailIndex = count($this->Groups);
        $this->Groups[] = & $Group;
    }
}
//End parcelas_parcelas_tipos_p GroupsCollection class

class clsReportparcelas_parcelas_tipos_p { //parcelas_parcelas_tipos_p Class @2-CEBBD4D4

//parcelas_parcelas_tipos_p Variables @2-87F7EA53

    var $ComponentType = "Report";
    var $PageSize;
    var $ComponentName;
    var $Visible;
    var $Errors;
    var $CCSEvents = array();
    var $CCSEventResult;
    var $RelativePath = "";
    var $ViewMode = "Web";
    var $TemplateBlock;
    var $PageNumber;
    var $RowNumber;
    var $TotalRows;
    var $TotalPages;
    var $ControlsVisible = array();
    var $IsEmpty;
    var $Attributes;
    var $DetailBlock, $Detail;
    var $Report_FooterBlock, $Report_Footer;
    var $Report_HeaderBlock, $Report_Header;
    var $Page_FooterBlock, $Page_Footer;
    var $Page_HeaderBlock, $Page_Header;
    var $SorterName, $SorterDirection;

    var $ds;
    var $DataSource;
    var $UseClientPaging = false;

    //Report Controls
    var $StaticControls, $RowControls, $Report_FooterControls, $Report_HeaderControls;
    var $Page_FooterControls, $Page_HeaderControls;
//End parcelas_parcelas_tipos_p Variables

//Class_Initialize Event @2-145A35C1
    function clsReportparcelas_parcelas_tipos_p($RelativePath = "", & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "parcelas_parcelas_tipos_p";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->Detail = new clsSection($this);
        $MinPageSize = 0;
        $MaxSectionSize = 0;
        $this->Detail->Height = 1;
        $MaxSectionSize = max($MaxSectionSize, $this->Detail->Height);
        $this->Report_Footer = new clsSection($this);
        $this->Report_Header = new clsSection($this);
        $this->Page_Footer = new clsSection($this);
        $this->Page_Footer->Height = 2;
        $MinPageSize += $this->Page_Footer->Height;
        $this->Page_Header = new clsSection($this);
        $this->Page_Header->Height = 1;
        $MinPageSize += $this->Page_Header->Height;
        $this->Errors = new clsErrors();
        $this->DataSource = new clsparcelas_parcelas_tipos_pDataSource($this);
        $this->ds = & $this->DataSource;
        $this->ViewMode = CCGetParam("ViewMode", "Web");
        $PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(is_numeric($PageSize) && $PageSize > 0) {
            $this->PageSize = $PageSize;
        } else if($this->ViewMode == "Print") {
            if (!is_numeric($PageSize) || $PageSize < 0)
                $this->PageSize = 50;
             else if ($PageSize == "0")
                $this->PageSize = 0;
             else 
                $this->PageSize = $PageSize;
        } else {
            if (!is_numeric($PageSize) || $PageSize < 0)
                $this->PageSize = 40;
             else if ($PageSize == "0")
                $this->PageSize = 100;
             else 
                $this->PageSize = min(100, $PageSize);
        }
        $MinPageSize += $MaxSectionSize;
        if ($this->PageSize && $MinPageSize && $this->PageSize < $MinPageSize)
            $this->PageSize = $MinPageSize;
        $this->PageNumber = $this->ViewMode == "Print" ? 1 : intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0 ) {
            $this->PageNumber = 1;
        }

        $this->dpto_desc = & new clsControl(ccsReportLabel, "dpto_desc", "dpto_desc", ccsText, "", "", $this);
        $this->dpto_desc->EmptyText = "-";
        $this->parcela_seccion = & new clsControl(ccsReportLabel, "parcela_seccion", "parcela_seccion", ccsText, "", "", $this);
        $this->parcela_seccion->EmptyText = "-";
        $this->parcela_macizo = & new clsControl(ccsReportLabel, "parcela_macizo", "parcela_macizo", ccsText, "", "", $this);
        $this->parcela_macizo->EmptyText = "-";
        $this->parcela_parcela = & new clsControl(ccsReportLabel, "parcela_parcela", "parcela_parcela", ccsText, "", "", $this);
        $this->parcela_parcela->EmptyText = "-";
        $this->parcela_chacra = & new clsControl(ccsReportLabel, "parcela_chacra", "parcela_chacra", ccsText, "", "", $this);
        $this->parcela_chacra->EmptyText = "-";
        $this->parcela_quinta = & new clsControl(ccsReportLabel, "parcela_quinta", "parcela_quinta", ccsText, "", "", $this);
        $this->parcela_quinta->EmptyText = "-";
        $this->parcela_fraccion = & new clsControl(ccsReportLabel, "parcela_fraccion", "parcela_fraccion", ccsText, "", "", $this);
        $this->parcela_fraccion->EmptyText = "-";
        $this->parcela_uf = & new clsControl(ccsReportLabel, "parcela_uf", "parcela_uf", ccsText, "", "", $this);
        $this->parcela_uf->EmptyText = "-";
        $this->parcela_partida = & new clsControl(ccsReportLabel, "parcela_partida", "parcela_partida", ccsInteger, "", "", $this);
        $this->parc_uso_desc = & new clsControl(ccsReportLabel, "parc_uso_desc", "parc_uso_desc", ccsText, "", "", $this);
        $this->parcela_val_mejora = & new clsControl(ccsReportLabel, "parcela_val_mejora", "parcela_val_mejora", ccsFloat, array(False, 2, ",", "", False, "\$ ", "", 1, True, ""), "", $this);
        $this->parcela_sup_uf = & new clsControl(ccsReportLabel, "parcela_sup_uf", "parcela_sup_uf", ccsFloat, array(False, 2, ",", "", False, "", "", 1, True, ""), "", $this);
        $this->parcela_val_tierra = & new clsControl(ccsReportLabel, "parcela_val_tierra", "parcela_val_tierra", ccsFloat, array(False, 2, ",", "", False, "\$ ", "", 1, True, ""), "", $this);
        $this->parcela_val_total = & new clsControl(ccsReportLabel, "parcela_val_total", "parcela_val_total", ccsFloat, array(False, 2, ",", "", False, "\$ ", "", 1, True, ""), "", $this);
        $this->tmp_plano = & new clsControl(ccsTextBox, "tmp_plano", "tmp_plano", ccsText, "", CCGetRequestParam("tmp_plano", ccsGet, NULL), $this);
        $this->parcela_restr = & new clsControl(ccsReportLabel, "parcela_restr", "parcela_restr", ccsText, "", "", $this);
        $this->parcela_notas_nom = & new clsControl(ccsReportLabel, "parcela_notas_nom", "parcela_notas_nom", ccsText, "", "", $this);
        $this->uni_med_htm = & new clsControl(ccsReportLabel, "uni_med_htm", "uni_med_htm", ccsText, "", "", $this);
        $this->uni_med_htm->HTML = true;
        $this->parcela_porc_uf = & new clsControl(ccsReportLabel, "parcela_porc_uf", "parcela_porc_uf", ccsFloat, array(False, 2, ",", "", False, "", "", 1, True, ""), "", $this);
        $this->obs = & new clsControl(ccsTextArea, "obs", "obs", ccsText, "", CCGetRequestParam("obs", ccsGet, NULL), $this);
        $this->NoRecords = & new clsPanel("NoRecords", $this);
        $this->PageBreak = & new clsPanel("PageBreak", $this);
        $this->panel = & new clsPanel("panel", $this);
        $this->ImageLink1 = & new clsControl(ccsImageLink, "ImageLink1", "ImageLink1", ccsText, "", CCGetRequestParam("ImageLink1", ccsGet, NULL), $this);
        $this->ImageLink1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
        $this->ImageLink1->Page = "rpt_nomenclatura_ph.php";
        $this->restricciones = & new clsControl(ccsImageLink, "restricciones", "restricciones", ccsText, "", CCGetRequestParam("restricciones", ccsGet, NULL), $this);
        $this->restricciones->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
        $this->restricciones->Parameters = CCAddParam($this->restricciones->Parameters, "parcela_id", CCGetFromGet("parcela_id", NULL));
        $this->restricciones->Page = "../actualizacion/ac_parcelaRestr.php";
        $this->notas = & new clsControl(ccsImageLink, "notas", "notas", ccsText, "", CCGetRequestParam("notas", ccsGet, NULL), $this);
        $this->notas->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
        $this->notas->Parameters = CCAddParam($this->notas->Parameters, "parcela_id", CCGetFromGet("parcela_id", NULL));
        $this->notas->Page = "../actualizacion/ac_parcelaNotas.php";
        $this->ImageLink2 = & new clsControl(ccsImageLink, "ImageLink2", "ImageLink2", ccsText, "", CCGetRequestParam("ImageLink2", ccsGet, NULL), $this);
        $this->ImageLink2->Page = "";
        $this->observaciones = & new clsControl(ccsImageLink, "observaciones", "observaciones", ccsText, "", CCGetRequestParam("observaciones", ccsGet, NULL), $this);
        $this->observaciones->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
        $this->observaciones->Parameters = CCAddParam($this->observaciones->Parameters, "parcela_id", CCGetFromGet("parcela_id", NULL));
        $this->observaciones->Page = "../actualizacion/ac_parcelaObs.php";
        $this->panel->Visible = false;
        $this->panel->AddComponent("ImageLink1", $this->ImageLink1);
        $this->panel->AddComponent("restricciones", $this->restricciones);
        $this->panel->AddComponent("notas", $this->notas);
        $this->panel->AddComponent("ImageLink2", $this->ImageLink2);
        $this->panel->AddComponent("observaciones", $this->observaciones);
    }
//End Class_Initialize Event

//Initialize Method @2-6C59EE65
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = $this->PageSize;
        $this->DataSource->AbsolutePage = $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//CheckErrors Method @2-F4E99F33
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->dpto_desc->Errors->Count());
        $errors = ($errors || $this->parcela_seccion->Errors->Count());
        $errors = ($errors || $this->parcela_macizo->Errors->Count());
        $errors = ($errors || $this->parcela_parcela->Errors->Count());
        $errors = ($errors || $this->parcela_chacra->Errors->Count());
        $errors = ($errors || $this->parcela_quinta->Errors->Count());
        $errors = ($errors || $this->parcela_fraccion->Errors->Count());
        $errors = ($errors || $this->parcela_uf->Errors->Count());
        $errors = ($errors || $this->parcela_partida->Errors->Count());
        $errors = ($errors || $this->parc_uso_desc->Errors->Count());
        $errors = ($errors || $this->parcela_val_mejora->Errors->Count());
        $errors = ($errors || $this->parcela_sup_uf->Errors->Count());
        $errors = ($errors || $this->parcela_val_tierra->Errors->Count());
        $errors = ($errors || $this->parcela_val_total->Errors->Count());
        $errors = ($errors || $this->tmp_plano->Errors->Count());
        $errors = ($errors || $this->parcela_restr->Errors->Count());
        $errors = ($errors || $this->parcela_notas_nom->Errors->Count());
        $errors = ($errors || $this->uni_med_htm->Errors->Count());
        $errors = ($errors || $this->parcela_porc_uf->Errors->Count());
        $errors = ($errors || $this->obs->Errors->Count());
        $errors = ($errors || $this->ImageLink1->Errors->Count());
        $errors = ($errors || $this->restricciones->Errors->Count());
        $errors = ($errors || $this->notas->Errors->Count());
        $errors = ($errors || $this->ImageLink2->Errors->Count());
        $errors = ($errors || $this->observaciones->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//GetErrors Method @2-5489070B
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->dpto_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_seccion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_macizo->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_parcela->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_chacra->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_quinta->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_fraccion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_uf->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_partida->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parc_uso_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_val_mejora->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_sup_uf->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_val_tierra->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_val_total->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tmp_plano->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_restr->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_notas_nom->Errors->ToString());
        $errors = ComposeStrings($errors, $this->uni_med_htm->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_porc_uf->Errors->ToString());
        $errors = ComposeStrings($errors, $this->obs->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ImageLink1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->restricciones->Errors->ToString());
        $errors = ComposeStrings($errors, $this->notas->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ImageLink2->Errors->ToString());
        $errors = ComposeStrings($errors, $this->observaciones->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

//Show Method @2-59D4BE03
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $ShownRecords = 0;

        $this->DataSource->Parameters["urlparcela_id"] = CCGetFromGet("parcela_id", NULL);

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);


        $this->DataSource->Prepare();
        $this->DataSource->Open();

        $Groups = new clsGroupsCollectionparcelas_parcelas_tipos_p($this);
        $Groups->PageSize = $this->PageSize > 0 ? $this->PageSize : 0;

        $is_next_record = $this->DataSource->next_record();
        $this->IsEmpty = ! $is_next_record;
        while($is_next_record) {
            $this->DataSource->SetValues();
            $this->dpto_desc->SetValue($this->DataSource->dpto_desc->GetValue());
            $this->parcela_seccion->SetValue($this->DataSource->parcela_seccion->GetValue());
            $this->parcela_macizo->SetValue($this->DataSource->parcela_macizo->GetValue());
            $this->parcela_parcela->SetValue($this->DataSource->parcela_parcela->GetValue());
            $this->parcela_chacra->SetValue($this->DataSource->parcela_chacra->GetValue());
            $this->parcela_quinta->SetValue($this->DataSource->parcela_quinta->GetValue());
            $this->parcela_fraccion->SetValue($this->DataSource->parcela_fraccion->GetValue());
            $this->parcela_uf->SetValue($this->DataSource->parcela_uf->GetValue());
            $this->parcela_partida->SetValue($this->DataSource->parcela_partida->GetValue());
            $this->parc_uso_desc->SetValue($this->DataSource->parc_uso_desc->GetValue());
            $this->parcela_val_mejora->SetValue($this->DataSource->parcela_val_mejora->GetValue());
            $this->parcela_sup_uf->SetValue($this->DataSource->parcela_sup_uf->GetValue());
            $this->parcela_val_tierra->SetValue($this->DataSource->parcela_val_tierra->GetValue());
            $this->parcela_val_total->SetValue($this->DataSource->parcela_val_total->GetValue());
            $this->tmp_plano->SetValue($this->DataSource->tmp_plano->GetValue());
            $this->parcela_restr->SetValue($this->DataSource->parcela_restr->GetValue());
            $this->parcela_notas_nom->SetValue($this->DataSource->parcela_notas_nom->GetValue());
            $this->uni_med_htm->SetValue($this->DataSource->uni_med_htm->GetValue());
            $this->parcela_porc_uf->SetValue($this->DataSource->parcela_porc_uf->GetValue());
            $this->ImageLink2->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
            $this->ImageLink2->Parameters = CCAddParam($this->ImageLink2->Parameters, "imprimir", 1);
            if (count($Groups->Groups) == 0) $Groups->OpenGroup("Report");
            $Groups->AddItem();
            $is_next_record = $this->DataSource->next_record();
        }
        if (!count($Groups->Groups)) 
            $Groups->OpenGroup("Report");
        else
            $this->NoRecords->Visible = false;
        $Groups->CloseGroup("Report");
        $this->TotalPages = $Groups->TotalPages;
        $this->TotalRows = $Groups->TotalRows;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        if(!$this->Visible) return;

        $this->Attributes->Show();
        $ReportBlock = "Report " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $ReportBlock;

        if($this->CheckErrors()) {
            $Tpl->replaceblock("", $this->GetErrors());
            $Tpl->block_path = $ParentPath;
            return;
        } else {
            $items = & $Groups->Groups;
            $i = $Groups->Pages[min($this->PageNumber, $Groups->TotalPages) - 1];
            $this->ControlsVisible["dpto_desc"] = $this->dpto_desc->Visible;
            $this->ControlsVisible["parcela_seccion"] = $this->parcela_seccion->Visible;
            $this->ControlsVisible["parcela_macizo"] = $this->parcela_macizo->Visible;
            $this->ControlsVisible["parcela_parcela"] = $this->parcela_parcela->Visible;
            $this->ControlsVisible["parcela_chacra"] = $this->parcela_chacra->Visible;
            $this->ControlsVisible["parcela_quinta"] = $this->parcela_quinta->Visible;
            $this->ControlsVisible["parcela_fraccion"] = $this->parcela_fraccion->Visible;
            $this->ControlsVisible["parcela_uf"] = $this->parcela_uf->Visible;
            $this->ControlsVisible["parcela_partida"] = $this->parcela_partida->Visible;
            $this->ControlsVisible["parc_uso_desc"] = $this->parc_uso_desc->Visible;
            $this->ControlsVisible["parcela_val_mejora"] = $this->parcela_val_mejora->Visible;
            $this->ControlsVisible["parcela_sup_uf"] = $this->parcela_sup_uf->Visible;
            $this->ControlsVisible["parcela_val_tierra"] = $this->parcela_val_tierra->Visible;
            $this->ControlsVisible["parcela_val_total"] = $this->parcela_val_total->Visible;
            $this->ControlsVisible["tmp_plano"] = $this->tmp_plano->Visible;
            $this->ControlsVisible["parcela_restr"] = $this->parcela_restr->Visible;
            $this->ControlsVisible["parcela_notas_nom"] = $this->parcela_notas_nom->Visible;
            $this->ControlsVisible["uni_med_htm"] = $this->uni_med_htm->Visible;
            $this->ControlsVisible["parcela_porc_uf"] = $this->parcela_porc_uf->Visible;
            $this->ControlsVisible["obs"] = $this->obs->Visible;
            do {
                $this->Attributes->RestoreFromArray($items[$i]->Attributes);
                $this->RowNumber = $items[$i]->RowNumber;
                switch ($items[$i]->GroupType) {
                    Case "":
                        $Tpl->block_path = $ParentPath . "/" . $ReportBlock . "/Section Detail";
                        $this->dpto_desc->SetValue($items[$i]->dpto_desc);
                        $this->dpto_desc->Attributes->RestoreFromArray($items[$i]->_dpto_descAttributes);
                        $this->parcela_seccion->SetValue($items[$i]->parcela_seccion);
                        $this->parcela_seccion->Attributes->RestoreFromArray($items[$i]->_parcela_seccionAttributes);
                        $this->parcela_macizo->SetValue($items[$i]->parcela_macizo);
                        $this->parcela_macizo->Attributes->RestoreFromArray($items[$i]->_parcela_macizoAttributes);
                        $this->parcela_parcela->SetValue($items[$i]->parcela_parcela);
                        $this->parcela_parcela->Attributes->RestoreFromArray($items[$i]->_parcela_parcelaAttributes);
                        $this->parcela_chacra->SetValue($items[$i]->parcela_chacra);
                        $this->parcela_chacra->Attributes->RestoreFromArray($items[$i]->_parcela_chacraAttributes);
                        $this->parcela_quinta->SetValue($items[$i]->parcela_quinta);
                        $this->parcela_quinta->Attributes->RestoreFromArray($items[$i]->_parcela_quintaAttributes);
                        $this->parcela_fraccion->SetValue($items[$i]->parcela_fraccion);
                        $this->parcela_fraccion->Attributes->RestoreFromArray($items[$i]->_parcela_fraccionAttributes);
                        $this->parcela_uf->SetValue($items[$i]->parcela_uf);
                        $this->parcela_uf->Attributes->RestoreFromArray($items[$i]->_parcela_ufAttributes);
                        $this->parcela_partida->SetValue($items[$i]->parcela_partida);
                        $this->parcela_partida->Attributes->RestoreFromArray($items[$i]->_parcela_partidaAttributes);
                        $this->parc_uso_desc->SetValue($items[$i]->parc_uso_desc);
                        $this->parc_uso_desc->Attributes->RestoreFromArray($items[$i]->_parc_uso_descAttributes);
                        $this->parcela_val_mejora->SetValue($items[$i]->parcela_val_mejora);
                        $this->parcela_val_mejora->Attributes->RestoreFromArray($items[$i]->_parcela_val_mejoraAttributes);
                        $this->parcela_sup_uf->SetValue($items[$i]->parcela_sup_uf);
                        $this->parcela_sup_uf->Attributes->RestoreFromArray($items[$i]->_parcela_sup_ufAttributes);
                        $this->parcela_val_tierra->SetValue($items[$i]->parcela_val_tierra);
                        $this->parcela_val_tierra->Attributes->RestoreFromArray($items[$i]->_parcela_val_tierraAttributes);
                        $this->parcela_val_total->SetValue($items[$i]->parcela_val_total);
                        $this->parcela_val_total->Attributes->RestoreFromArray($items[$i]->_parcela_val_totalAttributes);
                        $this->tmp_plano->SetValue($items[$i]->tmp_plano);
                        $this->tmp_plano->Attributes->RestoreFromArray($items[$i]->_tmp_planoAttributes);
                        $this->parcela_restr->SetValue($items[$i]->parcela_restr);
                        $this->parcela_restr->Attributes->RestoreFromArray($items[$i]->_parcela_restrAttributes);
                        $this->parcela_notas_nom->SetValue($items[$i]->parcela_notas_nom);
                        $this->parcela_notas_nom->Attributes->RestoreFromArray($items[$i]->_parcela_notas_nomAttributes);
                        $this->uni_med_htm->SetValue($items[$i]->uni_med_htm);
                        $this->uni_med_htm->Attributes->RestoreFromArray($items[$i]->_uni_med_htmAttributes);
                        $this->parcela_porc_uf->SetValue($items[$i]->parcela_porc_uf);
                        $this->parcela_porc_uf->Attributes->RestoreFromArray($items[$i]->_parcela_porc_ufAttributes);
                        $this->obs->SetValue($items[$i]->obs);
                        $this->obs->Attributes->RestoreFromArray($items[$i]->_obsAttributes);
                        $this->Detail->CCSEventResult = CCGetEvent($this->Detail->CCSEvents, "BeforeShow", $this->Detail);
                        $this->Attributes->Show();
                        $this->dpto_desc->Show();
                        $this->parcela_seccion->Show();
                        $this->parcela_macizo->Show();
                        $this->parcela_parcela->Show();
                        $this->parcela_chacra->Show();
                        $this->parcela_quinta->Show();
                        $this->parcela_fraccion->Show();
                        $this->parcela_uf->Show();
                        $this->parcela_partida->Show();
                        $this->parc_uso_desc->Show();
                        $this->parcela_val_mejora->Show();
                        $this->parcela_sup_uf->Show();
                        $this->parcela_val_tierra->Show();
                        $this->parcela_val_total->Show();
                        $this->tmp_plano->Show();
                        $this->parcela_restr->Show();
                        $this->parcela_notas_nom->Show();
                        $this->uni_med_htm->Show();
                        $this->parcela_porc_uf->Show();
                        $this->obs->Show();
                        $Tpl->block_path = $ParentPath . "/" . $ReportBlock;
                        if ($this->Detail->Visible)
                            $Tpl->parseto("Section Detail", true, "Section Detail");
                        break;
                    case "Report":
                        if ($items[$i]->Mode == 1) {
                            $this->Report_Header->CCSEventResult = CCGetEvent($this->Report_Header->CCSEvents, "BeforeShow", $this->Report_Header);
                            if ($this->Report_Header->Visible) {
                                $Tpl->block_path = $ParentPath . "/" . $ReportBlock . "/Section Report_Header";
                                $this->Attributes->Show();
                                $Tpl->block_path = $ParentPath . "/" . $ReportBlock;
                                $Tpl->parseto("Section Report_Header", true, "Section Detail");
                            }
                        }
                        if ($items[$i]->Mode == 2) {
                            $this->Report_Footer->CCSEventResult = CCGetEvent($this->Report_Footer->CCSEvents, "BeforeShow", $this->Report_Footer);
                            if ($this->Report_Footer->Visible) {
                                $Tpl->block_path = $ParentPath . "/" . $ReportBlock . "/Section Report_Footer";
                                $this->NoRecords->Show();
                                $this->Attributes->Show();
                                $Tpl->block_path = $ParentPath . "/" . $ReportBlock;
                                $Tpl->parseto("Section Report_Footer", true, "Section Detail");
                            }
                        }
                        break;
                    case "Page":
                        if ($items[$i]->Mode == 1) {
                            $this->Page_Header->CCSEventResult = CCGetEvent($this->Page_Header->CCSEvents, "BeforeShow", $this->Page_Header);
                            if ($this->Page_Header->Visible) {
                                $Tpl->block_path = $ParentPath . "/" . $ReportBlock . "/Section Page_Header";
                                $this->Attributes->Show();
                                $Tpl->block_path = $ParentPath . "/" . $ReportBlock;
                                $Tpl->parseto("Section Page_Header", true, "Section Detail");
                            }
                        }
                        if ($items[$i]->Mode == 2 && !$this->UseClientPaging || $items[$i]->Mode == 1 && $this->UseClientPaging) {
                            $this->PageBreak->Visible = (($i < count($items) - 1) && ($this->ViewMode == "Print"));
                            $this->ImageLink1->SetValue($items[$i]->ImageLink1);
                            $this->ImageLink1->Page = $items[$i]->_ImageLink1Page;
                            $this->ImageLink1->Parameters = $items[$i]->_ImageLink1Parameters;
                            $this->ImageLink1->Attributes->RestoreFromArray($items[$i]->_ImageLink1Attributes);
                            $this->restricciones->SetValue($items[$i]->restricciones);
                            $this->restricciones->Page = $items[$i]->_restriccionesPage;
                            $this->restricciones->Parameters = $items[$i]->_restriccionesParameters;
                            $this->restricciones->Attributes->RestoreFromArray($items[$i]->_restriccionesAttributes);
                            $this->notas->SetValue($items[$i]->notas);
                            $this->notas->Page = $items[$i]->_notasPage;
                            $this->notas->Parameters = $items[$i]->_notasParameters;
                            $this->notas->Attributes->RestoreFromArray($items[$i]->_notasAttributes);
                            $this->ImageLink2->SetValue($items[$i]->ImageLink2);
                            $this->ImageLink2->Page = $items[$i]->_ImageLink2Page;
                            $this->ImageLink2->Parameters = $items[$i]->_ImageLink2Parameters;
                            $this->ImageLink2->Attributes->RestoreFromArray($items[$i]->_ImageLink2Attributes);
                            $this->observaciones->SetValue($items[$i]->observaciones);
                            $this->observaciones->Page = $items[$i]->_observacionesPage;
                            $this->observaciones->Parameters = $items[$i]->_observacionesParameters;
                            $this->observaciones->Attributes->RestoreFromArray($items[$i]->_observacionesAttributes);
                            $this->Page_Footer->CCSEventResult = CCGetEvent($this->Page_Footer->CCSEvents, "BeforeShow", $this->Page_Footer);
                            if ($this->Page_Footer->Visible) {
                                $Tpl->block_path = $ParentPath . "/" . $ReportBlock . "/Section Page_Footer";
                                $this->PageBreak->Show();
                                $this->panel->Show();
                                $this->Attributes->Show();
                                $Tpl->block_path = $ParentPath . "/" . $ReportBlock;
                                $Tpl->parseto("Section Page_Footer", true, "Section Detail");
                            }
                        }
                        break;
                }
                $i++;
            } while ($i < count($items) && ($this->ViewMode == "Print" ||  !($i > 1 && $items[$i]->GroupType == 'Page' && $items[$i]->Mode == 1)));
            $Tpl->block_path = $ParentPath;
            $Tpl->parse($ReportBlock);
            $this->DataSource->close();
        }

    }
//End Show Method

} //End parcelas_parcelas_tipos_p Class @2-FCB6E20C

class clsparcelas_parcelas_tipos_pDataSource extends clsDBcatastro {  //parcelas_parcelas_tipos_pDataSource Class @2-4C36A803

//DataSource Variables @2-30FA7040
    var $Parent = "";
    var $CCSEvents = "";
    var $CCSEventResult;
    var $ErrorBlock;
    var $CmdExecution;

    var $wp;


    // Datasource fields
    var $dpto_desc;
    var $parcela_seccion;
    var $parcela_macizo;
    var $parcela_parcela;
    var $parcela_chacra;
    var $parcela_quinta;
    var $parcela_fraccion;
    var $parcela_uf;
    var $parcela_partida;
    var $parc_uso_desc;
    var $parcela_val_mejora;
    var $parcela_sup_uf;
    var $parcela_val_tierra;
    var $parcela_val_total;
    var $tmp_plano;
    var $parcela_restr;
    var $parcela_notas_nom;
    var $uni_med_htm;
    var $parcela_porc_uf;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-232C0007
    function clsparcelas_parcelas_tipos_pDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Report parcelas_parcelas_tipos_p";
        $this->Initialize();
        $this->dpto_desc = new clsField("dpto_desc", ccsText, "");
        
        $this->parcela_seccion = new clsField("parcela_seccion", ccsText, "");
        
        $this->parcela_macizo = new clsField("parcela_macizo", ccsText, "");
        
        $this->parcela_parcela = new clsField("parcela_parcela", ccsText, "");
        
        $this->parcela_chacra = new clsField("parcela_chacra", ccsText, "");
        
        $this->parcela_quinta = new clsField("parcela_quinta", ccsText, "");
        
        $this->parcela_fraccion = new clsField("parcela_fraccion", ccsText, "");
        
        $this->parcela_uf = new clsField("parcela_uf", ccsText, "");
        
        $this->parcela_partida = new clsField("parcela_partida", ccsInteger, "");
        
        $this->parc_uso_desc = new clsField("parc_uso_desc", ccsText, "");
        
        $this->parcela_val_mejora = new clsField("parcela_val_mejora", ccsFloat, "");
        
        $this->parcela_sup_uf = new clsField("parcela_sup_uf", ccsFloat, "");
        
        $this->parcela_val_tierra = new clsField("parcela_val_tierra", ccsFloat, "");
        
        $this->parcela_val_total = new clsField("parcela_val_total", ccsFloat, "");
        
        $this->tmp_plano = new clsField("tmp_plano", ccsText, "");
        
        $this->parcela_restr = new clsField("parcela_restr", ccsText, "");
        
        $this->parcela_notas_nom = new clsField("parcela_notas_nom", ccsText, "");
        
        $this->uni_med_htm = new clsField("uni_med_htm", ccsText, "");
        
        $this->parcela_porc_uf = new clsField("parcela_porc_uf", ccsFloat, "");
        

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

//Open Method @2-0183BC01
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT dpto_desc, parc_tip_desc, parc_uso_desc, parc_uso_abrev, parc_tip_abrev, parcela_partida, parcela_seccion, parcela_macizo,\n" .
        "parcela_parcela, parcela_chacra, parcela_quinta, parcela_fraccion, parcela_uf, parcela_predio, parcela_superficie, parcela_val_tierra,\n" .
        "parcela_val_mejora, parcela_val_total, plano_nro, parcela_observa, parcela_notas_nom, parcela_restr, tmp_plano, IF(plano_nro,CONCAT('T.F. ',CONCAT_WS('-',dpto_plano_nro,CONCAT(plano_tipo_abrev,plano_nro),RIGHT(plano_anio,2))),'') AS plano,\n" .
        "uni_med_abrev, uni_med_htm, parcela_porc_uf, parcela_sup_uf \n" .
        "FROM (((((parcelas LEFT JOIN parcelas_tipos ON\n" .
        "parcelas.parc_tip_id = parcelas_tipos.parc_tip_id) LEFT JOIN parcelas_usos ON\n" .
        "parcelas.parc_uso_id = parcelas_usos.parc_uso_id) INNER JOIN departamentos ON\n" .
        "parcelas.dpto_id = departamentos.dpto_id) LEFT JOIN planos ON\n" .
        "parcelas.plano_id = planos.plano_id) LEFT JOIN unidades_medida ON\n" .
        "parcelas.uni_med_id = unidades_medida.uni_med_id) LEFT JOIN planos_tipos ON\n" .
        "planos.plano_tipo_id = planos_tipos.plano_tipo_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-99278403
    function SetValues()
    {
        $this->dpto_desc->SetDBValue($this->f("dpto_desc"));
        $this->parcela_seccion->SetDBValue($this->f("parcela_seccion"));
        $this->parcela_macizo->SetDBValue($this->f("parcela_macizo"));
        $this->parcela_parcela->SetDBValue($this->f("parcela_parcela"));
        $this->parcela_chacra->SetDBValue($this->f("parcela_chacra"));
        $this->parcela_quinta->SetDBValue($this->f("parcela_quinta"));
        $this->parcela_fraccion->SetDBValue($this->f("parcela_fraccion"));
        $this->parcela_uf->SetDBValue($this->f("parcela_uf"));
        $this->parcela_partida->SetDBValue(trim($this->f("parcela_partida")));
        $this->parc_uso_desc->SetDBValue($this->f("parc_uso_desc"));
        $this->parcela_val_mejora->SetDBValue(trim($this->f("parcela_val_mejora")));
        $this->parcela_sup_uf->SetDBValue(trim($this->f("parcela_sup_uf")));
        $this->parcela_val_tierra->SetDBValue(trim($this->f("parcela_val_tierra")));
        $this->parcela_val_total->SetDBValue(trim($this->f("parcela_val_total")));
        $this->tmp_plano->SetDBValue($this->f("plano"));
        $this->parcela_restr->SetDBValue($this->f("parcela_restr"));
        $this->parcela_notas_nom->SetDBValue($this->f("parcela_notas_nom"));
        $this->uni_med_htm->SetDBValue($this->f("uni_med_htm"));
        $this->parcela_porc_uf->SetDBValue(trim($this->f("parcela_porc_uf")));
    }
//End SetValues Method

} //End parcelas_parcelas_tipos_pDataSource Class @2-FCB6E20C

//Initialize Page @1-7DEB62F0
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
$TemplateFileName = "rpt_nomenclatura_ph.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Authenticate User @1-FDEC8154
CCSecurityRedirect("", "../tdf_restricted.php");
//End Authenticate User

//Include events file @1-87C0582A
include_once("./rpt_nomenclatura_ph_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-81F04FDD
$DBcatastro = new clsDBcatastro();
$MainPage->Connections["catastro"] = & $DBcatastro;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$parcelas_parcelas_tipos_p = & new clsReportparcelas_parcelas_tipos_p("", $MainPage);
$MainPage->parcelas_parcelas_tipos_p = & $parcelas_parcelas_tipos_p;
$parcelas_parcelas_tipos_p->Initialize();

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

//Go to destination page @1-420A80A9
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBcatastro->close();
    header("Location: " . $Redirect);
    unset($parcelas_parcelas_tipos_p);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-1053D611
$parcelas_parcelas_tipos_p->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", "<center><font fac" . "e=\"Arial\"><small>&#7" . "1;&#101;nerated <!-" . "- CCS -->w&#105;th <!-" . "- SCC -->C&#111;de&#6" . "7;har&#103;&#101; <!" . "-- CCS -->&#83;&#116" . ";&#117;&#100;&#105;o.<" . "/small></font></cent" . "er>" . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", "<center><font fac" . "e=\"Arial\"><small>&#7" . "1;&#101;nerated <!-" . "- CCS -->w&#105;th <!-" . "- SCC -->C&#111;de&#6" . "7;har&#103;&#101; <!" . "-- CCS -->&#83;&#116" . ";&#117;&#100;&#105;o.<" . "/small></font></cent" . "er>" . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= "<center><font fac" . "e=\"Arial\"><small>&#7" . "1;&#101;nerated <!-" . "- CCS -->w&#105;th <!-" . "- SCC -->C&#111;de&#6" . "7;har&#103;&#101; <!" . "-- CCS -->&#83;&#116" . ";&#117;&#100;&#105;o.<" . "/small></font></cent" . "er>";
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-3C208C9C
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBcatastro->close();
unset($parcelas_parcelas_tipos_p);
unset($Tpl);
//End Unload Page


?>
