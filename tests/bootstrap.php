<?php
$lib = getenv("LIB_DIR");
if( $lib == ''){
    $lib = realpath(dirname(__FILE__).'/../').'/';
}
$lib = str_replace('\\','/', $lib);

require_once $lib.'src/autoloader.php';
require_once $lib.'tests/Grafikon_Test.php';