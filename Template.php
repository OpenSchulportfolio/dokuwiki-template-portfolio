<?php

namespace dokuwiki\template\portfolio2;

use dokuwiki\Menu\Item\Edit;
use dokuwiki\Menu\Item\Revisions;

class Template
{

    protected $breadcrumbs;
    protected $youarehere;

    /**
     * Template constructor.
     *
     * This initializes everything right before the template begins to output stuff. It's the last
     * chance for registering events etc.
     */
    public function __construct()
    {
        global $conf;
        /** @var \Doku_Event_Handler $EVENT_HANDLER */
        global $EVENT_HANDLER;

        // disable default output of breadcumbs (we do it ourselves later)
        $this->breadcrumbs = $conf['breadcrumbs'];
        $this->youarehere = $conf['youarehere'];
        $conf['breadcrumbs'] = 0;
        $conf['youarehere'] = 0;

        // initialize the wiki state
        $EVENT_HANDLER->register_hook('MENU_ITEMS_ASSEMBLY', 'AFTER', $this, 'menuAssembly');
        $this->disableFeaturesOnClose();
    }

    /**
     * Called from the pageheader include
     */
    public function pageheader()
    {
        if ($this->isClosed()) return;

        global $ACT;

        $this->topActionBar();
        if ($ACT != 'media') {
            $this->topMenu();
            $this->topBreadcrumbs();
        }
    }

    /**
     * Called from the pagefooter include
     */
    public function pagefooter()
    {
        if ($this->isClosed()) return;

        $this->bottomBreadcrumbs();
    }

    /**
     * Called from the sidebarfooter include
     */
    public function sidebarfooter()
    {
        if (tpl_getConf('exportbox')) $this->boxExport();
        if (tpl_getConf('toolbox')) $this->boxTools();
    }

    /**
     * Handle the menu assembly event
     *
     * @param \Doku_Event $event
     * @return bool
     */
    public function menuAssembly(\Doku_Event $event)
    {
        // we want absolutely no menu items
        if ($this->isClosed()) {
            $event->data['items'] = [];
            $event->stopPropagation();
        }

        return true;
    }

    /**
     * We disable stuff when the wiki is closed
     */
    protected function disableFeaturesOnClose()
    {
        global $conf;
        if (!$this->isClosed()) return;

        $conf['disableactions'] .= ',search';
    }

    /**
     * Check if all utils should be closed because no user available
     *
     * @return bool
     */
    protected function isClosed()
    {
        global $INPUT;
        if (tpl_getConf('closedwiki') && !$INPUT->server->has('REMOTE_USER')) {
            return true;
        }
        return false;
    }

    /*
     * display the top action bar
     */
    protected function topActionBar()
    {
	global $INPUT;
	global $conf;

        echo '<div id="osp__topbar">';

        // plugin actions
        echo '<ul class="topbar-left">';
        if ($INPUT->server->has('REMOTE_USER')) {
            /** @var \helper_plugin_infomail $plugin */
            $plugin = plugin_load('helper', 'infomail');
            if ($plugin) {
                $link = $plugin->getLink();
                $link['attr']['class'] .= ' action';
                echo '<li><a ' . buildAttributes($link['attr']) . '>'
                    . $link['text'] . '</a></li>';
            }

            /** @var \syntax_plugin_talkpage $plugin */
            $plugin = plugin_load('syntax', 'talkpage');
            if ($plugin && $conf['plugin']['talkpage']['showbutton'] == 1 ) {
                $link = $plugin->getLink();
                $link['attr']['class'] .= ' action';
                echo '<li><a ' . buildAttributes($link['attr']) . '>'
                    . $link['text'] . '</a></li>';
            }
        }
        echo '</ul>';

        // page actions
        echo '<ul class="topbar-right">';
        $edit = new Edit();
        echo '<li>' . $edit->asHtmlLink('action ', false) . '</li>';
        $revs = new Revisions();
        echo '<li>' . $revs->asHtmlLink('action ', false) . '</li>';
        echo '</ul>';

        echo '</div>';
    }


    /**
     * include topmenu page
     */
    protected function topMenu()
    {
        $topMenu = trim(tpl_getConf('topmenu_page'));
        if ($topMenu === '') return;
        if (!page_exists($topMenu)) return;

        echo '<div class="osp_topmenu content">';
        tpl_include_page($topMenu, 1, 1);

        if (auth_quickaclcheck($topMenu) > AUTH_READ) {
            $link = wl($topMenu, array("do" => "edit"));
            echo '<a href="' . $link . '" class="editlink">' . tpl_getLang('edit_include') . '</a>';
        }
        echo '</div>';
    }

    /**
     * Output the youarehere breadcrumbs in the top bar
     */
    protected function topBreadcrumbs()
    {
        if (!$this->youarehere) return;
        global $conf;
        $conf['youarehere'] = $this->youarehere;

        echo '<div class="breadcrumbs">';
        echo '<div class="youarehere">';
        tpl_youarehere();
        echo '</div>';
        echo '</div>';

        $conf['youarehere'] = 0;
    }

    /**
     * Output breadcrumbs in the bottom of the page
     */
    protected function bottomBreadcrumbs()
    {
        if (!$this->breadcrumbs) return;
        global $conf;
        $conf['breadcrumbs'] = $this->breadcrumbs;

        echo '<div class="breadcrumbs bottom">';
        echo '<div class="youarehere">';
        tpl_breadcrumbs();
        echo '</div>';
        print '</div>';

        $conf['breadcrumbs'] = 0;
    }

    /**
     * Display links to export the current page
     */
    protected function boxExport()
    {
        global $ID;

        echo '<div class="osp_box">';
        echo '<h1>' . tpl_getLang('export_headline') . '</h1>';
        echo '<ul>';

        //ODT plugin see <http://www.dokuwiki.org/plugin:odt> for info
        if (file_exists(DOKU_PLUGIN . 'odt/syntax.php') && !plugin_isdisabled('odt')) {
            echo '<li><div class="li">';
            echo '<a href="' . wl($ID, ['do' => 'export_odt']) . '" rel="nofollow">' . tpl_getLang('export_odt') . '</a>';
            echo '</div></li>';
        }

        //dw2pdf plugin see <http://www.dokuwiki.org/plugin:dw2pdf> for info
        if (file_exists(DOKU_PLUGIN . 'dw2pdf/action.php') && !plugin_isdisabled('dw2pdf')) {
            echo '<li><div class="li">';
            echo '<a href="' . wl($ID, ['do' => 'export_pdf']) . '" rel="nofollow">' . tpl_getLang('export_pdf') . '</a>';
            echo '</div></li>';
        }

        //s5 plugin see <http://www.dokuwiki.org/plugin:s5> for info
        if (file_exists(DOKU_PLUGIN . 's5/syntax.php') && !plugin_isdisabled('s5')) {
            echo '<li><div class="li">';
            echo '<a href="' . wl($ID, ['do' => 'export_s5']) . '" rel="nofollow">' . tpl_getLang('export_s5') . '</a>';
            echo '</div></li>';
        }

        //bookcreator plugin
        if (file_exists(DOKU_PLUGIN . 'bookcreator/syntax.php') && !plugin_isdisabled('bookcreator')) {
            echo '<li><div class="li">';
            echo '<a href="#" rel="nofollow"  class="plugin_bookcreator_addtobook">' . tpl_getLang('export_book') . '</a>';
            echo '</div></li>';
        }

        // "print" view
        if (tpl_getConf('print_new_window')) {
            $new = 'target="_blank"';
        } else {
            $new = '';
        }
        echo '<li><div class="li">';
        echo '<a href="' . wl($ID, ['do' => 'export_html']) . '" rel="nofollow" ' . $new . '>' . tpl_getLang('export_print') . '</a>';
        echo '</div></li>';

        echo '</ul>';
        echo '</div>';
    }

    /**
     * Print some tools in a sidebar box
     */
    protected function boxTools()
    {
        global $ID;
        global $lang;

        echo '<div class="osp_box">';
        echo '<h1>' . tpl_getLang('tools_headline') . '</h1>';
        echo '<ul>';

        if (actionOK('backlink')) {
            echo '<li><div class="li">';
            echo '<a href="' . wl($ID, ['do' => 'backlink']) . '" rel="nofollow">' . tpl_getLang('tools_backlinks') . '</a>';
            echo '</div></li>';
        }

        if (actionOK('recent')) {
            echo '<li><div class="li">';
            echo '<a href="' . wl($ID, ['do' => 'recent']) . '" rel="nofollow">' . $lang['btn_recent'] . '</a>';
            echo '</div></li>';
        }

        if (actionOK('media')) {
            echo '<li><div class="li">';
            echo '<a href="' . wl($ID, ['do' => 'media', 'ns' => getNS($ID)]) . '" rel="nofollow">' . tpl_getLang('tools_upload') . '</a>';
            echo '</div></li>';
        }

        if (actionOK("index")) {
            echo '<li><div class="li">';
            echo '<a href="' . wl($ID, ['do' => 'index']) . '" rel="nofollow">' . tpl_getLang('tools_siteindex') . '</a>';
            echo '</div></li>';
        }

        if (auth_quickaclcheck('wiki:ebook') >= AUTH_READ) {
            echo '<li><div class="li">';
            echo '<a href="' . wl('wiki:ebook') . '" rel="nofollow">' . tpl_getLang('tools_bookselection') . '</a>';
            echo '</div></li>';
        }

        //shorturl plugin
        /** @var \helper_plugin_shorturl $plugin */
        $plugin = plugin_load('helper', 'shorturl');
        if (!plugin_isdisabled("shorturl") && auth_quickaclcheck($ID) >= AUTH_READ) {
            echo '<li><div class="li">';
            echo $plugin->shorturlPrintLink($ID);
            echo '</div></li>';
        }

        echo '</ul>';
        echo '</div>';
    }
}
