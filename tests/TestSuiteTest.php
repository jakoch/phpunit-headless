<?php
class Extensions_Phantom_Tests_MultipleTestCases extends PHPUnit_Extensions_PhantomTestCase
{
    public function testAKE() { $this->assertTrue(1); }
    public function testWIL() { $this->assertTrue(1); }
    public function testECE() { $this->assertTrue(1); }
    public function testSKF() { $this->assertTrue(1); }
    public function testOAA() { $this->assertTrue(1); }
    public function testMSN() { $this->assertTrue(1); }
    public function testEST() { $this->assertTrue(1); }
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
