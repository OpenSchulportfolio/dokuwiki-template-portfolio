<?php

/**
 * Default options for the "portfolio2" DokuWiki template
 * Author:  Frank Schiebel <frank@linuxmuster.net>
 * License: GPLv2
 */


//check if we are running within the DokuWiki environment
if (!defined("DOKU_INC")){
    die();
}

// portfolio title
$lang["sitetitle"]    = "Portfolio title"; //TRUE: use/show user pages
$lang["schoolname"]    = "Portfolio subtitle, i.e. name of school or institution"; //TRUE: use/show user pages
$lang["closedwiki"]     = "Should navigation and page tools be hidden when no user ist logged in?";
//user pages
$lang["userpage"]    = "Use userpages?";
$lang["userpage_ns"] = "Namespace for the userpages";
//show infomail button?
$lang["infomail"]    = "Use infomail plugin when installed?";

//discussion pages
$lang["discuss"]    = "Use discussions?"; //TRUE: use/show discussion pages
$lang["discuss_ns"] = "Namespace for discussion pages."; //namespace to use for discussion page storage

//topmenu
$lang["topmenu"]          = "Show topmenu?";
$lang["topmenu_page"] = "Page to be included as topmenu";

//default sidebar
$lang["sidebar"]          = "Show sidebar"; //TRUE: use/show navigation
$lang["sidebar_page"] = "Page to be included as sidebar"; //page/article used to store the navigation

//exportbox ("print/export")
$lang["exportbox"]          = "Show exportbox in sidebar?"; //TRUE: use/show exportbox
$lang["print_new_window"]   = "Open print version of page in new browser-window/tab?";
//toolbox
$lang["toolbox"]          = "Show toolbox in sidebar?"; //TRUE: use/show toolbox

// Winmuster
$lang["winML_logout"]   = "Show logout button for Windows Musterlösung"; //Logout link according to WinMl SSO?
$lang["winML_logout_argument"] = "Argument to the logout link (WinML)"; // String to attach to url for logging out
$lang["winML_hide_loginlogout"] = "Hide login/logout when accessing the portfolio from the intranet"; // Hide login/logout functions
$lang["winML_hide_loginlogout_subnet"] = "IP addresses that are considered local: 10.1.x.x where x stands for a free octet."; // wehn hiding, for wicht subnets?

