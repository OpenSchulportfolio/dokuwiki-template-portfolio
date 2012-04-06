<?php
/**
 * DokuWiki StyleSheet creator
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Andreas Gohr <andi@splitbrain.org>
 */

if(!defined('DOKU_INC')) define('DOKU_INC',dirname(__FILE__).'/../../../../');
if(!defined('NOSESSION')) define('NOSESSION',true); // we do not use a session or authentication here (better caching)
require_once(DOKU_INC.'inc/init.php');

header('Content-Type: text/css; charset=utf-8');
css_out();

/**
 * Output all needed Styles
 *
 * @author Frank Schiebel <frank@linuxuster.net>
 */
function css_out() {
    global $conf;
    global $lang;

    $tpl = $conf['template'];
    $tconf = tpl_loadConfig();
    $file =  dirname(__FILE__) . "/../mod/screen.css";

    if(!@file_exists($file)) return '';
    $css = io_readFile($file);
    foreach ($tconf as $key=>$value) {
        if (strpos($key, "css_") !== 0) continue;
        $value = tpl_getConf("$key");
        $css = str_replace("__".$key."__", $value, $css);
    }
    $css = css_compress($css);
    print $css;

}

/**
 * Very simple CSS optimizer
 *
 * @author Andreas Gohr <andi@splitbrain.org>
 */
function css_compress($css){
    //strip comments through a callback
    $css = preg_replace_callback('#(/\*)(.*?)(\*/)#s','css_comment_cb',$css);

    //strip (incorrect but common) one line comments
    $css = preg_replace('/(?<!:)\/\/.*$/m','',$css);

    // strip whitespaces
    $css = preg_replace('![\r\n\t ]+!',' ',$css);
    $css = preg_replace('/ ?([;,{}\/]) ?/','\\1',$css);
    $css = preg_replace('/ ?: /',':',$css);

    // shorten colors
    $css = preg_replace("/#([0-9a-fA-F]{1})\\1([0-9a-fA-F]{1})\\2([0-9a-fA-F]{1})\\3/", "#\\1\\2\\3",$css);

    return $css;
}

function css_comment_cb($matches){
    if(strlen($matches[2]) > 4) return '';
    return $matches[0];
}



//Setup VIM: ex: et ts=4 :
