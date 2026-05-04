<?php
//Include Common Files @1-6B538334
define("RelativePath", "..");
define("PathToCurrentPage", "/services/");
define("FileName", "parcela_por_partida.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Initialize Page @1-619A8EAB
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
$TemplateFileName = "parcela_por_partida.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
//End Initialize Page

//Include events file @1-B924463F
include_once("./parcela_por_partida_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-24369416
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

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

//Go to destination page @1-FBA93089
if($Redirect)
{
  $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
  header("Location: " . $Redirect);
  unset($Tpl);
  exit;
}
//End Go to destination page

//Show Page @1-8CD22A0E
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
  $main_block = preg_replace("/<\/body>/i", implode(array("<center><font face=\"Arial\"><s", "mall>&#71;&#101;&#110;erat", "ed <!-- SCC -->wi&#116;h ", "<!-- CCS -->C&#111;&#100", ";e&#67;h&#97;r&#103;e <!", "-- SCC -->St&#117;&#100;i", "o.</small></font></center>"), "") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
  $main_block = preg_replace("/<\/html>/i", implode(array("<center><font face=\"Arial\"><s", "mall>&#71;&#101;&#110;erat", "ed <!-- SCC -->wi&#116;h ", "<!-- CCS -->C&#111;&#100", ";e&#67;h&#97;r&#103;e <!", "-- SCC -->St&#117;&#100;i", "o.</small></font></center>"), "") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
  $main_block .= implode(array("<center><font face=\"Arial\"><s", "mall>&#71;&#101;&#110;erat", "ed <!-- SCC -->wi&#116;h ", "<!-- CCS -->C&#111;&#100", ";e&#67;h&#97;r&#103;e <!", "-- SCC -->St&#117;&#100;i", "o.</small></font></center>"), "");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-74A7C1E7
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
unset($Tpl);
//End Unload Page


?>
