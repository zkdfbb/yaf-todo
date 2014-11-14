<?php

define('APPLICATION_PATH', dirname(dirname(__FILE__)));

require_once  APPLICATION_PATH . '/application/vendor/autoload.php';

$application = new Yaf_Application( APPLICATION_PATH . "/conf/application.ini");

$application->bootstrap()->run();
?>
