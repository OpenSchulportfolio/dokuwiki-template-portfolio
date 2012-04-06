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

// get language array
include DOKU_TPLINC."lang/en/lang.php";
// overwrite english language values with available translations
if (!empty($conf["lang"]) &&
    $conf["lang"] !== "en" &&
    file_exists(DOKU_TPLINC."/lang/".$conf["lang"]."/lang.php")){
    include DOKU_TPLINC."/lang/".$conf["lang"]."/lang.php";
}


/**
 * Read configuration for topbar contents and output appropriate html code
 *
 * @author Frank Schiebel <frank@linuxmuster.net>
 */
function _osp_topbar() {

    global $lang;

    if (tpl_getConf('closedwiki') &&
        !isset($_SERVER["REMOTE_USER"])) {
            return;
    }

    $separator = tpl_getConf("menuconf_sepchar");

    if (file_exists(DOKU_CONF."topbar.conf")) {
        $confFile = DOKU_CONF."topbar.conf";
    } else {
        $confFile = dirname(__FILE__).'/../conf/'."topbar.conf";
    }

    if (file_exists($confFile)) {
        $topbar_categories = parse_ini_file("$confFile",true);
    } else {
        print "Konfigurationsdatei nicht gefunden";
    }

    foreach ($topbar_categories as $item_pos=>$topbar_items){
        foreach ($topbar_items as $name=>$more) {
                $fields = explode("$separator", $more);
                $item_type = $fields[0];

                $item_list["$item_pos"] .= _osp_get_link_item($name,$more,$item_type);
        }
    }
    print "<ul class=\"topbar-left\">" . $item_list["left"] . "</ul>";
    print "$ACT <ul class=\"topbar-right\">" . $item_list["right"] . "</ul>";

} /* end _osp_topbar() */


/**
 * Read configuration for sidebar contents and output appropriate html code
 *
 * @author Frank Schiebel <frank@linuxmuster.net>
 */
function _osp_sidebar() {
    global $lang;

    $html = "<div id=\"sidebar\">";

    if (tpl_getConf('closedwiki') &&
        !isset($_SERVER["REMOTE_USER"])) {
            $html .= "<h2>" . $lang["osp_closed_sidebar_msg"] ."</h2>";
            $html .= "</div>";
            print $html;
            return;
    }

    $separator = tpl_getConf("menuconf_sepchar");

    if (file_exists(DOKU_CONF."sidebar.conf")) {
        $confFile = DOKU_CONF."sidebar.conf";
    } else {
        $confFile = dirname(__FILE__).'/../conf/'."sidebar.conf";
    }

    if (file_exists($confFile)) {
        $sidebar_categories = parse_ini_file("$confFile",true);
    } else {
        print "Konfigurationsdatei nicht gefunden";
    }


    foreach ($sidebar_categories as $item_cat=>$sidebar_items){
        $heading_text = $sidebar_categories[$item_cat]["heading"];
        foreach ($sidebar_items as $name=>$more) {
                $fields = explode("$separator", $more);
                $item_type = $fields[0];

                $item_list["$item_cat"] .= _osp_get_link_item($name,$more,$item_type);
        }
    $html .= "<h2>" . $heading_text . "</h2>";
    $html .="<ul>" . $item_list["$item_cat"] . "</ul>";
    }
    $html .= "</div>";
    print $html;

}

/**
 * get link list-item to a wiki page or external resource
 *
 * @author Frank Schiebel <frank@linuxmuster.net>
 */
function _osp_get_link_item($name,$args,$type="link") {
    global $ID;
    global $lang;
    global $ACT;

    $separator = tpl_getConf("menuconf_sepchar");
    $fields = explode("$separator", $args);

    $plugin_req = $fields[1];
    if ($plugin_req != "none" && plugin_isdisabled("$plugin_req")) {
        return;
    }

    $command = $fields[2];
    $command_def = _check_command($name,$command);
    $name = $command_def[0];
    $command = $command_def[1];

    if ($type == "do") {
        if (actionOK($command) && $command != "disabled") {
            $link = wl(cleanID($ID), array("do"=>"$command"));
            if ($ACT == $command) {
                $class = " class=\"active\"";
            }
        } else {
            return "";
        }
    } elseif ($type == "link") {
        if ($command == "page") {
            $target_page = $fields[3];
            if ($target_page == "id") {
                $link = wl(cleanID($ID));
                if ($ACT == "show") {
                    $class = " class=\"active\"";
                }
            } else {
                $link = wl(cleanID($fields[3]));
                if (cleanID($fields[3]) == cleanID(getID())) {
                    $class = " class=\"nav-active\"";
                }
            }
        }
    } elseif ($type == "form") {
            if ($command == "infomail") {
                $form  = "<form class=\"button btn_infomail\" action=\"";
                $form .= wl(cleanID($ID)) ."\" method=\"get\">";
                $form .= "<input type=\"hidden\" value=\"infomail\" name=\"do\">";
                $form .= "<input type=\"hidden\" value=\"".cleanID($ID)."\" name=\"id\">";
                $form .= "<input class=\"button\" type=\"submit\" title=\"".$lang["osp_infomail"]."\" value=\"Infomail\">";
                $form .= "</form>";
                return "<li class=\"infomail\">". $form . "</li>\n";
            }
    }

    if ($lang[$name] != "" ) {
        $displayname = $lang[$name];
    } else {
        $displayname = $name;
    }

    return "<li".$class."><a href=\"". $link . "\">". $displayname . "</a></li>\n";
}

/**
 * check command in given context
 *
 * @author Frank Schiebel <frank@linuxmuster.net>
 */
function _check_command($name,$command) {
    global $INFO;
    $command_def = array();

    if ($command == "edit") {
        if (!empty($INFO["writable"])) {
            if (!empty($INFO["draft"])){
                $command_def[]="draft";
                $command_def[]="draft";
                return $command_def;
            }
            if(!empty($INFO["exists"])){
                $command_def[]="osp_editpage";
                $command_def[]="edit";
                return $command_def;
            } else {
                $command_def[]="osp_createpage";
                $command_def[]="edit";
                return $command_def;
            }
        } else {
                $command_def[]="btn_source";
                $command_def[]="edit";
                return $command_def;
        }
    }

    if ($command == "revisions" && empty($INFO["exists"])) {
        $command_def[]="disabled";
        $command_def[]="disabled";
        return $command_def;
    }

    $command_def[]=$name;
    $command_def[]=$command;
    return $command_def;
}

/**
 * print sitenotice
 *
 * @author Andreas Haerter
 * @author Frank Schiebel <frank@linuxmuster.net>
 */
function _osp_show_sitenotice() {
    global $conf;
    global $lang;


    if (!tpl_getConf("sitenotice")) {
        return;
    }

    $sitenotice_page_id = cleanID(tpl_getConf("sitenotice_location"));
    $html .= $sitenotice_page_id;
    if (!empty($conf["useacl"]) && auth_quickaclcheck($sitenotice_page_id) < AUTH_READ) {
        return;
    }

    //get the rendered content of the defined wiki article to use as sitenotice.
    $html = tpl_include_page($sitenotice_page_id, false);
    if ($html === "" || $html === false){
        //show creation/edit link if the defined page got no content
        echo "[&#160;";
              tpl_pagelink(tpl_getConf("vector_sitenotice_location"), hsc($lang["vector_fillplaceholder"]." (".tpl_getConf("vector_sitenotice_location").")"));
              echo "&#160;]<br />";
    } else {
        if (auth_quickaclcheck($sitenotice_page_id) > AUTH_READ) {
            $link = wl($sitenotice_page_id, array("do"=>"edit"));
            $html .= "<a href=\"". $link . "\" class=\"smalledit\">". $lang["osp_edit_sitenotice"] . "</a>\n";
        }

    }
    return $html;

}

/**
 * print sitenotice
 *
 * @author Frank Schiebel <frank@linuxmuster.net>
 */
function _osp_csslink() {
    $link =  "<link rel=\"stylesheet\" media=\"all\" type=\"text/css\" href=\"" . DOKU_TPL."exe/css.php". "\" />\n";
    print $link;
}

function _osp_get_logopic () {
    global $conf;

    $html = "<a href=\"".wl()."\"><img src=\"";

    if (file_exists($conf['savedir']."/media/wiki/logo/logo.png")) {
          //user defined PNG as Media upload
          $html .=  DOKU_URL."/lib/exe/fetch.php?media=wiki:logo:logo.png";
      } elseif (file_exists($conf['savedir']."/media/wiki/logo/logo.jpg")) {
          $html .=  DOKU_URL."/lib/exe/fetch.php?media=wiki:logo:logo.jpg";
      } elseif (file_exists($conf['savedir']."/media/wiki/logo/logo.gif")) {
          $html .=  DOKU_URL."/lib/exe/fetch.php?media=wiki:logo:logo.gif";
      } else {
          $html .= DOKU_TPL."images/logo.png";
      }
    $html .=  "\" /></a>\n";
    print $html;
}
