<?php

class Extensions_Phantom_Tests_Phantom_PayloadExecuteTest extends \PHPUnit_Extensions_PhantomTestCase
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

        $output = "var exception = undefined;\n";
        $output .= "try {\n";
        $output .= "console.log('This is the payload');\n";
        $output .= "} catch (e) {\n";
        $output .= "exception = e;\n";
        $output .= "}\n";
        $output .= "tests[tests.length] = {\n";
        $output .= "'name': \"PayloadExecuteTest\",\n";
        $output .= "'pass': exception === undefined\n";
        $output .= "};\n";

        $this->assertSame($result, $output); // phpunit string comparison bug on windows
    }
}
