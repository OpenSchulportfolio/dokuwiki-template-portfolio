<?php

namespace dokuwiki\template\osp;

use dokuwiki\Menu\Item\Edit;
use dokuwiki\Menu\Item\Revisions;

class Template
{

    protected $breadcrumbs;
    protected $youarehere;

    public function __construct()
    {
        global $conf;

        // disable default output of breadcumbs (we do it ourselves later)
        $this->breadcrumbs = $conf['breadcrumbs'];
        $this->youarehere = $conf['youarehere'];
        $conf['breadcrumbs'] = 0;
        $conf['youarehere'] = 0;
    }

    /**
     * Called from the pageheader include
     */
    public function pageheader()
    {
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
        $this->bottomBreadcrumbs();
    }


    /*
     * display the top action bar
     */
    protected function topActionBar()
    {
        global $INPUT;

        // no top bar for anonymous users on closed wikis
        if (tpl_getConf('closedwiki') && !$INPUT->server->has('REMOTE_USER')) {
            echo '<br />';
            return;
        }


        echo '<div id="topbar">';

        // plugin actions
        echo '<ul class="topbar-left">';
        if ($INPUT->server->has('REMOTE_USER')) {
            // info mail
            $plugin = plugin_load('action', 'infomail');
            if ($plugin) {
                echo '<li>Infomail FIXME</li>';
            }

            /** @var \syntax_plugin_talkpage $plugin */
            $plugin = plugin_load('syntax', 'talkpage');
            $link = $plugin->getLink();
            echo '<li><a href="' . wl($link['goto']) . '" ' . buildAttributes($link['attr']) .
                ' class="action talkpage">' . $link['text'] . '</a></li>';
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
        $topMenu = tpl_getConf('topmenu_page');
        if (!page_exists($topMenu)) return;

        echo '<div class="topmenu content">';
        echo '<div class="include_edit">';

        tpl_include_page($topMenu, 1, 1);

        if (auth_quickaclcheck($topMenu) > AUTH_READ) {
            $link = wl($topMenu, array("do" => "edit"));
            echo '<a href="' . $link . '" class="editlink">' . tpl_getLang('edit_include') . '</a>';
        }

        echo '</div>';
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

        echo '<div class="breadcrumbs">';
        echo '<div class="youarehere">';
        tpl_breadcrumbs();
        echo '</div>';
        print '</div>';

        $conf['breadcrumbs'] = 0;
    }
}
