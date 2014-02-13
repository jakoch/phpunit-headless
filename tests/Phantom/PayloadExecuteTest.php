<?php

class PayloadExecuteTest extends \PHPUnit_Extensions_PhantomTestCase
{
    private $payloadExecute;

    public function setUp()
    {
        $this->payloadExecute = new PHPUnit_Extensions_Phantom_PayloadExecute('PayloadExecuteTest');
    }

    public function testRunTest()
    {
        $payload = "console.log('This is the payload');";

        $this->payloadExecute->setPayload($payload);
        $this->assertEquals($payload, $this->payloadExecute->payloadToExecute);

        $result = $this->payloadExecute->runTest();
        
        $tab = "\t\t";
       
        $output = "var exception = undefined;\n";
        $output .= "try {\n";
        $output .= $tab . "console.log('This is the payload');\n";
        $output .= "} catch (e) {\n";
        $output .= $tab . "exception = e;\n";
        $output .= "}\n";
        $output .= "tests[tests.length] = {\n";
        $output .= $tab . "'name': \"PayloadExecuteTest\",\n";
        $output .= $tab . "'pass': exception === undefined\n";
        $output .= "};\n";

        $this->assertSame($result, $output); // phpunit string comparison bug on windows
    }
}
