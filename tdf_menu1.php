<?php

class clsMenutdf_menu1Menu1 extends clsMenu { //Menu1 class @42-F10D96CD

//Class_Initialize Event @42-92914AF0
    function clsMenutdf_menu1Menu1($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "Menu1";
        $this->Visible = True;
        $this->controls = array();
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->ErrorBlock = "Menu Menu1";


        $this->DataSource = new clstdf_menu1Menu1DataSource($this);
        $this->ds = & $this->DataSource;

        parent::clsMenu("menu_parent_id", "menu_id", null);

        $this->ItemLink = new clsControl(ccsLink, "ItemLink", "ItemLink", ccsText, "", CCGetRequestParam("ItemLink", ccsGet, NULL), $this);
        $this->controls["ItemLink"] = & $this->ItemLink;
        $this->ItemLink->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
    }
//End Class_Initialize Event

//SetControlValues Method @42-2AF1EE79
    function SetControlValues() {
        $this->ItemLink->SetValue($this->DataSource->ItemLink->GetValue());
        $this->ItemLink->Page = $this->DataSource->f("menu_link");
        $this->Attributes->SetValue("Target", "");
        $this->Attributes->SetValue("Title", $this->DataSource->f("menu_title"));
    }
//End SetControlValues Method

//ShowAttributes @42-3EFFAF2D
    function ShowAttributes() {
        $this->Attributes->SetValue("Target", "");
        $this->Attributes->SetValue("Title", $this->DataSource->f("menu_title"));
        $this->Attributes->SetValue("MenuType", "menu_htb");
        $this->Attributes->Show();
    }
//End ShowAttributes

} //End Menu1 Class @42-FCB6E20C

class clstdf_menu1Menu1DataSource extends clsDBtdf_nuevo {  //Menu1DataSource Class @42-6F2B970A

//DataSource Variables @42-6571FD5C
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

//DataSourceClass_Initialize Event @42-0F5AF041
    function clstdf_menu1Menu1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Menu Menu1";
        $this->Initialize();
        $this->ItemLink = new clsField("ItemLink", ccsText, "");
        $this->FieldsList["ItemLink"] = & $this->ItemLink;

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @42-85DF5A3B
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "menu_orden";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @42-14D6CD9D
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
    }
//End Prepare Method

//Open Method @42-7377D82B
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

//SetValues Method @42-53C7EACA
    function SetValues()
    {
        $this->ItemLink->SetDBValue($this->f("menu_descripcion"));
    }
//End SetValues Method

} //End Menu1DataSource Class @42-FCB6E20C

class clstdf_menu1 { //tdf_menu1 class @1-33C9D88A

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

//Class_Initialize Event @1-61DE3DB4
    function clstdf_menu1($RelativePath, $ComponentName, & $Parent)
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = $ComponentName;
        $this->RelativePath = $RelativePath;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->FileName = "tdf_menu1.php";
        $this->Redirect = "";
        $this->TemplateFileName = "tdf_menu1.html";
        $this->BlockToParse = "main";
        $this->TemplateEncoding = "CP1252";
        $this->ContentType = "text/html";
    }
//End Class_Initialize Event

//Class_Terminate Event @1-D27CC112
    function Class_Terminate()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUnload", $this);
        unset($this->Menu1);
    }
//End Class_Terminate Event

//BindEvents Method @1-46A4E337
    function BindEvents()
    {
        $this->Menu1->CCSEvents["BeforeShowRow"] = "tdf_menu1_Menu1_BeforeShowRow";
        $this->CCSEvents["AfterInitialize"] = "tdf_menu1_AfterInitialize";
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

//Initialize Method @1-4F174DB1
    function Initialize()
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInitialize", $this);
        if(!$this->Visible)
            return "";
        $this->DBtdf_nuevo = new clsDBtdf_nuevo();
        $this->Connections["tdf_nuevo"] = & $this->DBtdf_nuevo;
        $this->Attributes = & $this->Parent->Attributes;

        // Create Components
        $this->banner = new clsControl(ccsLabel, "banner", "banner", ccsText, "", CCGetRequestParam("banner", ccsGet, NULL), $this);
        $this->banner->HTML = true;
        $this->banner0 = new clsControl(ccsLabel, "banner0", "banner0", ccsText, "", CCGetRequestParam("banner0", ccsGet, NULL), $this);
        $this->banner0->HTML = true;
        $this->banner2 = new clsControl(ccsLabel, "banner2", "banner2", ccsText, "", CCGetRequestParam("banner2", ccsGet, NULL), $this);
        $this->banner2->HTML = true;
        $this->Menu1 = new clsMenutdf_menu1Menu1($this->RelativePath, $this);
        $this->Menu1->Initialize();
        $this->BindEvents();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnInitializeView", $this);
    }
//End Initialize Method

//Show Method @1-AF2A7B2C
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
        $this->Menu1->Show();
        $this->banner->Show();
        $this->banner0->Show();
        $this->banner2->Show();
        $Tpl->Parse();
        $Tpl->block_path = $block_path;
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeOutput", $this);
        $Tpl->SetVar($this->ComponentName, $Tpl->GetVar($this->ComponentName));
    }
//End Show Method

} //End tdf_menu1 Class @1-FCB6E20C

//Include Event File @1-8547792B
include_once(RelativePath . "/tdf_menu1_events.php");
//End Include Event File


?>
