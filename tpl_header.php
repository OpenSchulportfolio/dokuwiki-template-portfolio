<!-- ********** HEADER ********** -->
<div id="dokuwiki__header"><div class="pad group">

    <?php html_msgarea() /* occasional error and info messages on top of the page */ ?>
    <?php _tpl_include('header.html') ?>

    <div class="headings group">
        <h1><?php tpl_link(
            wl(),
            '<img src="'.tpl_getFavicon(false, 'logo.png').'" width="64" height="64" alt="" /> <span>'.$conf['title'].'</span>',
            'accesskey="h" title="[H]"'
        ) /* @todo: obviously don't use tpl_getFavicon, but make a new function (or use a config option?) */ ?></h1>
        <?php if (tpl_getConf('tagline')): ?>
            <p class="claim"><?php echo tpl_getConf('tagline') ?></p>
        <?php endif ?>

        <ul class="a11y">
            <li><a href="#dokuwiki__content"><?php echo tpl_getLang('skip_to_content') ?></a></li>
        </ul>
    </div>

    <div class="tools group">
        <!-- USER TOOLS -->
        <?php if ($conf['useacl'] && $showTools): ?>
            <div id="dokuwiki__usertools">
                <h3 class="a11y"><?php echo tpl_getLang('user_tools') ?></h3>
                <ul>
                    <?php /* the optional second parameter of tpl_action() switches between a link and a button,
                             e.g. a button inside a <li> would be: tpl_action('edit',0,'li') */
                        if ($_SERVER['REMOTE_USER']) {
                            echo '<li class="user">';
                            tpl_userinfo(); /* 'Logged in as ...' */
                            echo '</li>';
                        }
                        tpl_action('admin', 1, 'li');
                        tpl_action('profile', 1, 'li');
                        tpl_action('register', 1, 'li');
                        tpl_action('login', 1, 'li');
                    ?>
                </ul>
            </div>
        <?php endif ?>

        <!-- SITE TOOLS -->
        <div id="dokuwiki__sitetools">
            <h3 class="a11y"><?php echo tpl_getLang('site_tools') ?></h3>
            <?php tpl_searchform() ?>
            <ul>
                <?php
                    tpl_action('recent', 1, 'li');
                    tpl_action('media', 1, 'li');
                    tpl_action('index', 1, 'li');
                ?>
            </ul>
        </div>

    </div>

    <!-- BREADCRUMBS -->
    <?php if($conf['breadcrumbs'] || $conf['youarehere']): ?>
        <div class="breadcrumbs">
            <?php if($conf['youarehere']): ?>
                <div class="youarehere"><?php tpl_youarehere() ?></div>
            <?php endif ?>
            <?php if($conf['breadcrumbs']): ?>
                <div class="trace"><?php tpl_breadcrumbs() ?></div>
            <?php endif ?>
        </div>
    <?php endif ?>

    <hr class="a11y" />
</div></div><!-- /header -->
