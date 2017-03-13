<?php

/**
 * Default options for the "portfolio2" DokuWiki template
 */


//check if we are running within the DokuWiki environment
if (!defined("DOKU_INC")){
    die();
}

// portfolio title
$conf["sitetitle"]    = "Schulportfolio"; //TRUE: use/show user pages
$conf["schoolname"]    = "Schulname hier eintragen"; //TRUE: use/show user pages
$conf["closedwiki"]     = true;

//user pages
$conf["userpage"]    = false; //TRUE: use/show user pages
$conf["userpage_ns"] = ":wiki:benutzer"; //namespace to use for user page storage
//show infomail button?
$conf["infomail"]    = true;
//discussion pages
$conf["discuss"]    = false; //TRUE: use/show discussion pages
$conf["discuss_ns"] = ":wiki:discussion:"; //namespace to use for discussion page storage
//topmenu
$conf["topmenu"]          = true; //TRUE: use/show sitenotice
$conf["topmenu_page"] = ":wiki:topmenu"; //page/article used to store the sitenotice
//default sidebar
$conf["sidebar"]          = true; //TRUE: use/show navigation
$conf["sidebar_page"] = ":wiki:sidebar"; //page/article used to store the navigation
//exportbox ("print/export")
$conf["exportbox"]          = true; //TRUE: use/show exportbox
$conf["print_new_window"]   = false;
//toolbox
$conf["toolbox"]          = true; //TRUE: use/show toolbox
// Winmuster
$conf["winML_logout"]   = false; //Logout link according to WinMl SSO?
$conf["winML_logout_argument"] = "CMD=logoff"; // String to attach to url for logging out
$conf["winML_hide_loginlogout"] = false; // Hide login/logout functions
$conf["winML_hide_loginlogout_subnet"] = "10.1.x.x"; // wehn hiding, for wicht subnets?

