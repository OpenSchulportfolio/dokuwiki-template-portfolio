<?php

global $conf;
global $TPL;
$TPL = new \dokuwiki\template\portfolio2\Template();

set_include_path(__DIR__);
include(__DIR__ . '/../dokuwiki/detail.php');
