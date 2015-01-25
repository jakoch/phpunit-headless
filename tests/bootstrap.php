<?php
// Error Reporting Level
error_reporting(E_ALL | E_STRICT);

// Include Path for the systemUnderTest and Tests
$systemUnderTest = realpath(dirname(__DIR__));
$tests = realpath(__DIR__ . '/../tests');

defined('TESTS_DIR') || define('TESTS_DIR', $tests);

$paths = array(
    $systemUnderTest,
    $tests,
    get_include_path() // attach original include paths
);
set_include_path(implode(PATH_SEPARATOR, $paths));

// setup flag, showing that it is a PHPUNIT run
define('PHPUNIT_EXTENSION_PHANTOMJS_TESTRUN', true);

// Composer Autoloader
if (is_file(__DIR__ . '/../vendor/autoload.php')) {
    include_once __DIR__ . '/../vendor/autoload.php';
} else {
    echo 'Could not find "vendor/autoload.php". Did you forget to run "composer install --dev"?' . PHP_EOL;
    exit(1);
}
