<?php
class Extensions_Phantom_Tests_MultipleTestCases extends PHPUnit_Extensions_PhantomTestCase
{
    public function testAKE() {}
    public function testWIL() {}
    public function testECE() {}
    public function testSKF() {}
    public function testOAA() {}
    public function testMSN() {}
    public function testEST() {}
}

class Extensions_Phantom_Tests_TestSuiteTest extends PHPUnit_Framework_TestCase
{
    public function testCreateTestSuiteFromTestCaseClass()
    {
        $suite = Extensions_Phantom_Tests_MultipleTestCases::suite('Extensions_Phantom_Tests_MultipleTestCases');
        
        $this->assertInstanceOf('PHPUnit_Framework_TestSuite', $suite);
        $this->assertEquals(7, count($suite->tests()));
    }
}
