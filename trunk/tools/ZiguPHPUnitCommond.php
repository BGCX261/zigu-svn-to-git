<?php

define('ZIGU_PROJECT_ROOTDIR', dirname(dirname(__FILE__)));
//define('ZIGU_TEST_DIR', ZIGU_PROJECT_ROOTDIR . DIRECTORY_SEPARATOR . 'tests');

set_include_path(
    get_include_path() . PATH_SEPARATOR
    . ZIGU_PROJECT_ROOTDIR . DIRECTORY_SEPARATOR . 'src' . PATH_SEPARATOR 
    . ZIGU_PROJECT_ROOTDIR . DIRECTORY_SEPARATOR . 'libs' . PATH_SEPARATOR
    . ZIGU_PROJECT_ROOTDIR . DIRECTORY_SEPARATOR . 'tests' . PATH_SEPARATOR
);

require_once 'PHPUnit/Util/Filter.php';
PHPUnit_Util_Filter::addFileToFilter(__FILE__, 'PHPUNIT');

require 'PHPUnit/TextUI/Command.php';
define('PHPUnit_MAIN_METHOD', 'PHPUnit_TextUI_Command::main');
PHPUnit_TextUI_Command::main();

