<?php
class clstdf_footer { //tdf_footer class @1-84BCE0B3

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

//Class_Initialize Event @1-B13A545A
    function clstdf_footer($RelativePath, $ComponentName, & $Parent)
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = $ComponentName;
        $this->RelativePath = $RelativePath;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->FileName = "tdf_footer.php";
        $this->Redirect = "";
        $this->TemplateFileName = "tdf_footer.html";
        $this->BlockToParse = "main";
        $this->TemplateEncoding = "CP1252";
        $this->ContentType = "text/html";
    }
//End Class_Initialize Event

//Class_Terminate Event @1-32FD4740
    function Class_Terminate()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUnload", $this);
    }
//End Class_Terminate Event

//BindEvents Method @1-9D74CEFE
    function BindEvents()
    {
        $this->debug->CCSEvents["BeforeShow"] = "tdf_footer_debug_BeforeShow";
        $this->CCSEvents["BeforeShow"] = "tdf_footer_BeforeShow";
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

//Initialize Method @1-8CF881C5
    function Initialize()
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInitialize", $this);
        if(!$this->Visible)
            return "";
        $this->Attributes = & $this->Parent->Attributes;

        // Create Components
        $this->debug = new clsPanel("debug", $this);
        $this->session = new clsControl(ccsLabel, "session", "session", ccsText, "", CCGetRequestParam("session", ccsGet, NULL), $this);
        $this->session->HTML = true;
        $this->get = new clsControl(ccsLabel, "get", "get", ccsText, "", CCGetRequestParam("get", ccsGet, NULL), $this);
        $this->get->HTML = true;
        $this->utiles = new clsControl(ccsLabel, "utiles", "utiles", ccsText, "", CCGetRequestParam("utiles", ccsGet, NULL), $this);
        $this->utiles->HTML = true;
        $this->debug->Visible = false;
        $this->debug->AddComponent("session", $this->session);
        $this->debug->AddComponent("get", $this->get);
        $this->debug->AddComponent("utiles", $this->utiles);
        $this->BindEvents();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnInitializeView", $this);
    }
//End Initialize Method

//Show Method @1-7C33DBF7
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
        $this->debug->Show();
        $Tpl->Parse();
        $Tpl->block_path = $block_path;
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeOutput", $this);
        $Tpl->SetVar($this->ComponentName, $Tpl->GetVar($this->ComponentName));
    }
//End Show Method

} //End tdf_footer Class @1-FCB6E20C

//Include Event File @1-EB1F6D87
include_once(RelativePath . "/tdf_footer_events.php");
//End Include Event File


?>
