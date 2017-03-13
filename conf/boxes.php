<?php
/**
 * Default box configuration of the "portfolio2" DokuWiki template
 * derived from Andreas Haerters "vector" template.
 *
 * LICENSE: This file is open source software (OSS) and may be copied under
 *          certain conditions. See COPYING file for details or try to contact
 *          the author(s) of this file in doubt.
 *
 * @license GPLv2 (http://www.gnu.org/licenses/gpl2.html)
 * @author Andreas Haerter <andreas.haerter@dev.mail-node.com>
 * @author Frank Schiebel <frank@linuxmuster.net>
 * @link http://andreas-haerter.com/projects/dokuwiki-template-vector
 * @link http://www.dokuwiki.org/template:vector
 * @link http://www.dokuwiki.org/devel:configuration
 * @link http://www.openschulportfolio.de
 */



/******************************************************************************
 ********************************  ATTENTION  *********************************
         DO NOT MODIFY THIS FILE, IT WILL NOT BE PRESERVED ON UPDATES!
 ******************************************************************************
  If you want to add some own boxes, have a look at the README of this
  template and "/user/boxes.php". You have been warned!
 *****************************************************************************/


//check if we are running within the DokuWiki environment
if (!defined("DOKU_INC")){
    die();
}


//note: The boxes will be rendered in the order they were defined. Means:
//      first box will be rendered first, last box will be rendered at last.


global $lang;
global $INFO;
//exportbox ("print/export")
if (tpl_getConf("exportbox")) {
    //headline
    $boxes["export"]["headline"] = $lang["export_headline"];

    //define default, predefined exportbox
    $boxes["export"]["xhtml"] =  "<ul>\n";
    
    //ODT plugin see <http://www.dokuwiki.org/plugin:odt> for info
    if (file_exists(DOKU_PLUGIN."odt/syntax.php") && !plugin_isdisabled("odt")) {
        $boxes["export"]["xhtml"]  .= "<li id=\"export-odt\"><a href=\"".wl(cleanID(getId()), array("do" => "export_odt"))."\" rel=\"nofollow\">".hsc($lang["export_odt"])."</a></li>\n";
    }
    //dw2pdf plugin see <http://www.dokuwiki.org/plugin:dw2pdf> for info
    if (file_exists(DOKU_PLUGIN."dw2pdf/action.php") && !plugin_isdisabled("dw2pdf")) {
        $boxes["export"]["xhtml"]  .= "<li id=\"export-pdf\"><a href=\"".wl(cleanID(getId()), array("do" => "export_pdf"))."\" rel=\"nofollow\">".hsc($lang["export_pdf"])."</a></li>\n";
    //html2pdf plugin see <http://www.dokuwiki.org/plugin:html2pdf> for info
    } else if (file_exists(DOKU_PLUGIN."html2pdf/action.php") && !plugin_isdisabled("html2pdf")) {
        $boxes["export"]["xhtml"]  .= "<li id=\"export-pdf\"><a href=\"".wl(cleanID(getId()), array("do" => "export_pdf"))."\" rel=\"nofollow\">".hsc($lang["export_pdf"])."</a></li>\n";
    }
    //s5 plugin see <http://www.dokuwiki.org/plugin:s5> for info
    if (file_exists(DOKU_PLUGIN."s5/syntax.php") && !plugin_isdisabled("s5")) {
        $boxes["export"]["xhtml"]  .= "<li id=\"export-s5\"><a href=\"".wl(cleanID(getId()), array("do" => "export_s5"))."\" rel=\"nofollow\">".hsc($lang["export_s5"])."</a></li>\n";
    }
    //bookcreator plugin 
    if (file_exists(DOKU_PLUGIN."bookcreator/syntax.php") && !plugin_isdisabled("bookcreator")) {
        $boxes["export"]["xhtml"]  .= "<li id=\"export-book\"><a href=\"".wl(cleanID(getId()), array("do" => "addtobook"))."\" rel=\"nofollow\">".hsc($lang["export_book"])."</a></li>\n";
    }
    $target = "";
    if (tpl_getConf("print_new_window")) { $target=" target=\"_blank\" "; }
    $boxes["export"]["xhtml"] .=  "<li id=\"export-print\"><a href=\"".wl(cleanID(getId()), array("do" => "export_html"))."\" ". $target ." rel=\"nofollow\">".hsc($lang["export_print"])."</a></li>\n</ul>\n";
}

if (tpl_getConf("toolbox")) {
    //headline
    $boxes["tools"]["headline"] = $lang["tools_headline"];

    $boxes["tools"]["xhtml"] = "<ul>\n";
    if (actionOK("backlink")){ //check if action is disabled
        $boxes["tools"]["xhtml"] .= "<li><a href=\"".wl(cleanID(getId()), array("do" => "backlink"))."\">".hsc($lang["tools_backlinks"])."</a></li>\n";
    }
    if (actionOK("recent")){ //check if action is disabled
        $boxes["tools"]["xhtml"] .= "<li><a href=\"".wl("", array("do" => "recent"))."\" rel=\"nofollow\">".hsc($lang["btn_recent"])."</a></li>\n"; //language comes from DokuWiki core
    }
    $boxes["tools"]["xhtml"] .= "<li><a target=\"t-upload\" href=\"".DOKU_BASE."lib/exe/mediamanager.php?ns=".getNS(getID())."\" rel=\"nofollow\">".hsc($lang["tools_upload"])."</a></li>\n";
    if (actionOK("index")){ //check if action is disabled
        $boxes["tools"]["xhtml"] .= "        <li id=\"t-siteindex\"><a href=\"".wl("", array("do" => "index"))."\" rel=\"nofollow\">".hsc($lang["tools_siteindex"])."</a></li>\n";
    }
    if (empty($conf["useacl"]) || auth_quickaclcheck(cleanID("wiki:ebook")) >= AUTH_READ){ //current user got write access to start page?
        $boxes["tools"]["xhtml"] .= "        <li id=\"t-bookselection\"><a href=\"".wl(cleanID(":wiki:ebook"), array())."\" rel=\"nofollow\">".hsc($lang["tools_bookselection"])."</a></li>\n";
    }
    if ( $INFO['isadmin'] == 1) {
        $boxes["tools"]["xhtml"] .= "        <li id=\"t-special\"><a href=\"".wl(cleanID(getID()), array("do" => "admin", "page" => "pagemove"))."\" rel=\"nofollow\">Seite verschieben</a></li>\n";
    }
    //shorturl plugin
    if (!plugin_isdisabled("shorturl") && auth_quickaclcheck(cleanID(getID())) >= AUTH_READ){
        $shorturl =& plugin_load('helper', 'shorturl');
        $boxes["tools"]["xhtml"]  .= "        <li id=\"t-shorturl\">". $shorturl->shorturlPrintLink(getID()) ."</li>\n";
    }
}
/******************************************************************************
 ********************************  ATTENTION  *********************************
 DO NOT MODIFY THIS FILE, IT WILL NOT BE PRESERVED ON UPDATES!
 ******************************************************************************
 If you want to add some own boxes, have a look at the README of this
 template and "/user/boxes.php". You have been warned!
 *****************************************************************************/

