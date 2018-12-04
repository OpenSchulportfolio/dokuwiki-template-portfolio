<?php

global $conf;
global $TPL;
$TPL = new \dokuwiki\template\osp\Template();

set_include_path(__DIR__);
include(__DIR__ . '/../dokuwiki/mediamanager.php');
