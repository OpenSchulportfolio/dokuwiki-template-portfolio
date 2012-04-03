<?php
/**
 * Template Functions
 *
 * This file provides template specific custom functions for the osp template
 * that are not provided by the DokuWiki core.
 * It is common practice to start each function with an underscore
 * to make sure it won't interfere with future core functions.
 */

// must be run from within DokuWiki
if (!defined('DOKU_INC')) die();

// get needed language array
include DOKU_TPLINC."lang/en/lang.php";
// overwrite english language values with available translations
if (!empty($conf["lang"]) &&
    $conf["lang"] !== "en" &&
    file_exists(DOKU_TPLINC."/lang/".$conf["lang"]."/lang.php")){
    //get language file (partially translated language files are no problem
    //cause non translated stuff is still existing as English array value)
    include DOKU_TPLINC."/lang/".$conf["lang"]."/lang.php";
}


/**
 * Read configuration for topbar contents and output appropriate html code
 *
 * @author Frank Schiebel <frank@linuxmuster.net>
 */
function _osp_topbar() {

    if (file_exists(DOKU_CONF."topbar.conf")) {
        $confFile = DOKU_CONF."topbar.conf";
    } else {
        $confFile = dirname(__FILE__).'/../conf/'."topbar.conf";
    }

    if (file_exists($confFile)) {
        $topbar_items = parse_ini_file("$confFile",true);
    } else {
        print "Konfigurationsdatei nicht gefunden";
    }

    foreach ($topbar_items as $name=>$more) {
            $fields = explode(">", $more);
            $item_type = $fields[0];
            $item_pos = $fields[2];

            switch ($item_type) {
                case "link":
                    $item_list["$item_pos"] .= _osp_get_link_item($name,$more);
                break;
                case "do":
                    $item_list["$item_pos"] .= _osp_get_link_item($name,$more,"do");
                break;
                case "form":
                break;
            }
    }
    print "<ul class=\"topbar-left\">" . $item_list["left"] . "</ul>";
    print "<ul class=\"topbar-right\">" . $item_list["right"] . "</ul>";

} /* end _osp_topbar() */




/**
 * get link list-item to a wiki page or external resource
 *
 * @author Frank Schiebel <frank@linuxmuster.net>
 */
function _osp_get_link_item($name,$args,$type="link") {
    global $ID;
    global $lang;

    $fields = explode(">", $args);
    $show = $fields[3];

    if ($type == "do" ) {
        $link = wl($ID,"do=$show");
    } else {
        if ($show == "page") {
            $target_page = $fields[4];
            if ($target_page == "id") {
                $link = wl($ID);
            } else {
                $link = wl(cleanID($fields[4]));
            }
        } 
    }
    if ($lang[$name] != "" ) {
        $displayname = $lang[$name];
    } else {
        $displayname = $name;
    }
    return "<li><a href=\"". $link . "\">". $displayname . "</a></li>";

}
