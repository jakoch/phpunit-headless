<?php
class DriverTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->driver = new PHPUnit_Extensions_Phantom_Driver('DriverTests');
    }

    public function testExecutePhantomJs()
    {
        $testFile = TESTS_DIR . '/PhantomJS-examples/version.js';
        $result = PHPUnit_Extensions_Phantom_Driver::executePhantomJS($testFile);
        
    	$this->assertContains('using PhantomJS version ', $result);
    }
}
