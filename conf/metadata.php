<?php
/**
 * Types of the different option values for the "portfolio2" DokuWiki template
 */


//check if we are running within the DokuWiki environment
if (!defined("DOKU_INC")){
    die();
}
// portfolio title
$meta["sitetitle"]    = array("string"); 
$meta["schoolname"]    = array("string"); 
$meta["closedwiki"]     = array("onoff");

//ns search
$meta["searchnamespaces"] = array("string");

//user pages
$meta["userpage"]    = array("onoff");
$meta["userpage_ns"] = array("string", "_pattern" => "/^:.{1,}:$/");

//infomail button?
$meta["infomail"]    = array("onoff");

//discussion pages
$meta["discuss"]    = array("onoff");
$meta["discuss_ns"] = array("string", "_pattern" => "/^:.{1,}:$/");

//topmenu
$meta["topmenu"]          = array("onoff");
$meta["topmenu_page"] = array("string");

//navigation
$meta["sidebar"]          = array("onoff");
$meta["sidebar_page"] = array("string");

//exportbox ("print/export")
$meta["exportbox"]          = array("onoff");
$meta["print_new_window"]   = array("onoff");

//toolbox
$meta["toolbox"]          = array("onoff");

$meta["winML_logout"]          = array("onoff"); 
$meta["winML_logout_argument"] = array("string");
$meta["winML_hide_loginlogout"] = array("onoff");
$meta["winML_hide_loginlogout_subnet"] = array("string");

