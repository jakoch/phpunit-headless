<?php

class Extensions_Phantom_Tests_Phantom_ExecuteFileTest extends \PHPUnit_Extensions_PhantomTestCase
{
    private $execFileTest;

    public function setUp()
    {
        $name = 'testExecuteFile';
        $data = array(0 => $tests . '/PhantomJS-examples/version.js');

        $this->execFileTest = new Extensions_Phantom_Tests_Phantom_ExecuteFileTest($name, $data);
    }
    public function testExecuteFile()
    {
        $result = $this->execFileTest->runTest();

        $this->assertNotEmpty($result);
    }
}
