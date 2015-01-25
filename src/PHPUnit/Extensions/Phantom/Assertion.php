<?php
/**
 * PHPUnit_Extensions_Phantom_Assertion
 *
 * The class stores the name and condition of a Phantom Assertion.
 * The assertion is represented as Javascript.
 * You might embed multiple Assertions in one code evaluation run.
 */
class PHPUnit_Extensions_Phantom_Assertion
{
    private $name;
    private $condition;
    private $success;

    public function __construct($name, $condition)
    {
        $this->name      = $name;
        $this->condition = $condition;
        $this->success   = false;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setSuccess($success)
    {
        $this->success = $success;
    }

    public function isSuccess()
    {
        return $this->success;
    }

    public function getJavascript()
    {
        $tab = "\t\t";
        
        $output = $tab . "tests[tests.length] = {\n";
        $output .= $tab . "    'name': " . json_encode($this->name) . ",\n";
        $output .= $tab . "    'pass': " . $this->condition . "\n";
        $output .= $tab . "};\n";

        return $output;
    }
}
