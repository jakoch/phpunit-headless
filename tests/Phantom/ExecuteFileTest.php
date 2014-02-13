<?php

class ExecuteFileTest extends \PHPUnit_Extensions_PhantomTestCase
{
    private $execFileTest;

    public function setUp()
    {
        $name = 'testExecuteFile';
        $data = array(0 => TESTS_BASEDIR . '/PhantomJS-examples/version.js');

        $this->execFileTest = new PHPUnit_Extensions_Phantom_FileExecute($name, $data);
    }
    public function testExecuteFile()
    {
        $result = $this->execFileTest->runTest();

        $this->assertNotEmpty($result);
    }
}
