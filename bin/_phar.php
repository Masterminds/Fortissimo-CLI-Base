#!/usr/bin/env php
<?php

\Phar::mapPhar();

// The the path to the app so it is available elsewhere.
define('FORT_APP_PATH', 'phar://' . __FILE__);

require_once FORT_APP_PATH . '/bin/_shared.php';
__HALT_COMPILER();