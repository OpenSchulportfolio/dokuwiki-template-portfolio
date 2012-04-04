<?php
//check if we are running within the DokuWiki environment
if (!defined("DOKU_INC")){
    die();
}
// portfolio title
$meta["sitetitle"]    = array("string");
$meta["schoolname"]    = array("string");
$meta["barcolor"]    = array("string");
//site notice
$meta["sitenotice"]          = array("onoff");
$meta["sitenotice_location"] = array("string");
$meta["menuconf_sepchar"]    = array("string");

//infomail button?
//$meta["vector_infomail"]    = array("onoff");

//discussion pages
//$meta["discussion"]    = array("onoff");
//$meta["discussion_namespace"] = array("string", "_pattern" => "/^:.{1,}:$/");

//site notice
//$meta["vector_sitenotice"]          = array("onoff");
//$meta["vector_sitenotice_location"] = array("string");

$meta["winML_logout"]          = array("onoff");
$meta["winML_logout_argument"] = array("string");
$meta["winML_hide_loginlogout"] = array("onoff");
$meta["winML_hide_loginlogout_subnet"] = array("string");
$meta["closedwiki"]            = array("onoff");

