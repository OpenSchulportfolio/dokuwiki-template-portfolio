<?php

/**
 * Default options for the "portfolio2" DokuWiki template
 */


//check if we are running within the DokuWiki environment
if (!defined("DOKU_INC")){
    die();
}

// portfolio title
$lang["sitetitle"]    = "Titel des Portfoliowikis"; //TRUE: use/show user pages
$lang["schoolname"]    = "Untertitel des Portfoliowikis, z.B. der Schulname"; //TRUE: use/show user pages
$lang["closedwiki"]     = "Sollen die Navigationselemente und Seitenwerkzeuge für nicht angemeldete Benutzer versteckt werden?";
// ns search
$lang["searchnamespaces"] = "Namensräume, die zur Suche ausgewählt werden können. Schreibweise: namensraum>Anzuzeigende Bezeichnung. Durch Kommata getrennt.";

//user pages
$lang["userpage"]    = "Benutzerseiten verwenden?";
$lang["userpage_ns"] = "Namensraum, in dem die Benutzerseiten angelegt werden.";
//show infomail button?
$lang["infomail"]    = "Infomailfunktion verwenden?";

//discussion pages
$lang["discuss"]    = "Diskussionsseiten verwenden?"; //TRUE: use/show discussion pages
$lang["discuss_ns"] = "Namensraum, in dem die Diskussionsseiten angelegt werden."; //namespace to use for discussion page storage

//topmenu
$lang["topmenu"]          = "Topmenü anzeigen?";
$lang["topmenu_page"] = "Seite, die als Topmenü verwendet wird.";

//default sidebar
$lang["sidebar"]          = "Sidebar anzeigen?"; //TRUE: use/show navigation
$lang["sidebar_page"] = "Seite, die als Sidebar verwendet wird."; //page/article used to store the navigation

//exportbox ("print/export")
$lang["exportbox"]          = "Exportfunktionen in der Sidebar anzeigen?"; //TRUE: use/show exportbox
$lang["print_new_window"]   = "Druckversion in neuem Browserfenster/tab öffnen?";


//toolbox
$lang["toolbox"]          = "Werkzeugfunktionen in der Sidebar anzeigen?"; //TRUE: use/show toolbox

// Winmuster
$lang["winML_logout"]   = "Logout Link für Windows Musterlösung SSO anpassen?"; //Logout link according to WinMl SSO?
$lang["winML_logout_argument"] = "Welches Argument soll der Windows Logout Link haben?"; // String to attach to url for logging out
$lang["winML_hide_loginlogout"] = "Sollen die Login/Logout Links versteckt werden, wenn der Benutzer von einem Rechner im Intranet zugreift?"; // Hide login/logout functions
$lang["winML_hide_loginlogout_subnet"] = "Welche Adressen befinden sich im Intranet? Beliebige Stellen mit 'x' angeben."; // wehn hiding, for wicht subnets?

