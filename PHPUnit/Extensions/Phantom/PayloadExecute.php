<?php
/**
 * Class for creating a test which passes arbitrary payload to PhantomJS.
 */
class PHPUnit_Extensions_Phantom_PayloadExecute extends PHPUnit_Framework_TestCase
{
    public $payloadToExecute;
    private $success;

    public function __construct($name, $payloadToExecute = '')
    {
        parent::__construct($name);

        $this->name = $name;
        $this->payloadToExecute = $payloadToExecute;
    }

    public function setPayload($payloadToExecute)
    {
        $this->payloadToExecute = $payloadToExecute;
    }

    public function runTest()
    {
        $tab = "\t\t";
        
        $output = "var exception = undefined;\n";
        $output .= "try {\n";
        $output .= $tab . $this->payloadToExecute . "\n";
        $output .= "} catch (e) {\n";
        $output .= $tab . "exception = e;\n";
        $output .= "}\n";
        $output .= "tests[tests.length] = {\n";
        $output .= $tab . "'name': " . json_encode($this->name) . ",\n";
        $output .= $tab . "'pass': exception === undefined\n";
        $output .= "};\n";

        return $output;
    }
}