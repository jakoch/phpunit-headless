<?php
class DriverTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {

    }

    public function testExecutePhantomJs()
    {
        $testFile = TESTS_BASEDIR . '/PhantomJS-examples/version.js';
        $result = PHPUnit_Extensions_Phantom_Driver::executePhantomJS($testFile);
        
    	$this->assertContains('using PhantomJS version ', $result);
    }
}
