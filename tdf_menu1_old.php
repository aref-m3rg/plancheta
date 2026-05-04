<?php
class clsMenutdf_menu1_oldMenu2 extends clsMenu { //Menu2 class @7-152375CF

//Class_Initialize Event @7-C14374D9
    function clsMenutdf_menu1_oldMenu2($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "Menu2";
        $this->Visible = True;
        $this->controls = array();
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->ErrorBlock = "Menu Menu2";


        $this->DataSource = new clstdf_menu1_oldMenu2DataSource($this);
        $this->ds = & $this->DataSource;

        parent::clsMenu("menu_parent_id", "menu_id", null);

        $this->ItemLink = new clsControl(ccsLink, "ItemLink", "ItemLink", ccsText, "", CCGetRequestParam("ItemLink", ccsGet, NULL), $this);
        $this->controls["ItemLink"] = & $this->ItemLink;
        $this->ItemLink->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
    }
//End Class_Initialize Event

//SetControlValues Method @7-FD6E0749
    function SetControlValues() {
        $this->ItemLink->SetValue($this->DataSource->ItemLink->GetValue());
        $this->ItemLink->Page = $this->DataSource->f("menu_link");
        $this->Attributes->SetValue("Target", $this->DataSource->f("menu_id"));
        $this->Attributes->SetValue("Title", $this->DataSource->f("menu_title"));
    }
//End SetControlValues Method

//ShowAttributes @7-B3976F38
    function ShowAttributes() {
        $this->Attributes->SetValue("Target", $this->DataSource->f("menu_id"));
        $this->Attributes->SetValue("Title", $this->DataSource->f("menu_title"));
        $this->Attributes->SetValue("MenuType", "menu_htb");
        $this->Attributes->Show();
    }
//End ShowAttributes

} //End Menu2 Class @7-FCB6E20C

class clstdf_menu1_oldMenu2DataSource extends clsDBtdf_nuevo {  //Menu2DataSource Class @7-327BA181

//DataSource Variables @7-6571FD5C
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $wp;

    public $FieldsList = array();

    // Datasource fields
    public $ItemLink;
//End DataSource Variables

//DataSourceClass_Initialize Event @7-72DD54FD
    function clstdf_menu1_oldMenu2DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Menu Menu2";
        $this->Initialize();
        $this->ItemLink = new clsField("ItemLink", ccsText, "");
        $this->FieldsList["ItemLink"] = & $this->ItemLink;

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @7-9E1383D1
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @7-14D6CD9D
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
    }
//End Prepare Method

//Open Method @7-7377D82B
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM menu {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @7-53C7EACA
    function SetValues()
    {
        $this->ItemLink->SetDBValue($this->f("menu_descripcion"));
    }
//End SetValues Method

} //End Menu2DataSource Class @7-FCB6E20C

class clstdf_menu1_old { //tdf_menu1_old class @1-555DBA18

//Variables @1-51D7F06F
    public $ComponentType = "IncludablePage";
    public $Connections = array();
    public $FileName = "";
    public $Redirect = "";
    public $Tpl = "";
    public $TemplateFileName = "";
    public $BlockToParse = "";
    public $ComponentName = "";
    public $Attributes = "";

    // Events;
    public $CCSEvents = "";
    public $CCSEventResult = "";
    public $RelativePath;
    public $Visible;
    public $Parent;
//End Variables

//Class_Initialize Event @1-982B9D96
    function clstdf_menu1_old($RelativePath, $ComponentName, & $Parent)
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = $ComponentName;
        $this->RelativePath = $RelativePath;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->FileName = "tdf_menu1_old.php";
        $this->Redirect = "";
        $this->TemplateFileName = "tdf_menu1_old.html";
        $this->BlockToParse = "main";
        $this->TemplateEncoding = "CP1252";
        $this->ContentType = "text/html";
    }
//End Class_Initialize Event

//Class_Terminate Event @1-C0C96EFC
    function Class_Terminate()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUnload", $this);
        unset($this->Menu2);
    }
//End Class_Terminate Event

//BindEvents Method @1-ACC75BD6
    function BindEvents()
    {
        $this->Menu2->CCSEvents["BeforeShowRow"] = "tdf_menu1_old_Menu2_BeforeShowRow";
        $this->CCSEvents["AfterInitialize"] = "tdf_menu1_old_AfterInitialize";
        $this->CCSEvents["BeforeShow"] = "tdf_menu1_old_BeforeShow";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInitialize", $this);
    }
//End BindEvents Method

//Operations Method @1-7E2A14CF
    function Operations()
    {
        global $Redirect;
        if(!$this->Visible)
            return "";
    }
//End Operations Method

//Initialize Method @1-64E92056
    function Initialize()
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CCSEvents["BeforeInitialize"] = "tdf_menu1_old_BeforeInitialize";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInitialize", $this);
        if(!$this->Visible)
            return "";
        $this->DBtdf_nuevo = new clsDBtdf_nuevo();
        $this->Connections["tdf_nuevo"] = & $this->DBtdf_nuevo;
        $this->Attributes = & $this->Parent->Attributes;

        // Create Components
        $this->Menu2 = new clsMenutdf_menu1_oldMenu2($this->RelativePath, $this);
        $this->Menu2->Initialize();
        $this->BindEvents();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnInitializeView", $this);
    }
//End Initialize Method

//Show Method @1-1CB777B6
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        $block_path = $Tpl->block_path;
        $Tpl->LoadTemplate("/" . $this->TemplateFileName, $this->ComponentName, $this->TemplateEncoding, "remove");
        $Tpl->block_path = $Tpl->block_path . "/" . $this->ComponentName;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        if(!$this->Visible) {
            $Tpl->block_path = $block_path;
            $Tpl->SetVar($this->ComponentName, "");
            return "";
        }
        $this->Attributes->Show();
        $this->Menu2->Show();
        $Tpl->Parse();
        $Tpl->block_path = $block_path;
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeOutput", $this);
        $Tpl->SetVar($this->ComponentName, $Tpl->GetVar($this->ComponentName));
    }
//End Show Method

} //End tdf_menu1_old Class @1-FCB6E20C

//Include Event File @1-4F497CE4
include_once(RelativePath . "/tdf_menu1_old_events.php");
//End Include Event File
?>
