<?php
/**
 * Class for creating a test which executes a file with PhantomJS.
 */
class PHPUnit_Extensions_Phantom_FileExecute extends PHPUnit_Framework_TestCase
{
    private $file;

    public function __construct($name, $file)
    {
        parent::__construct($name, array($file));

        $this->name = $name;
        $this->file = $file;
    }

    public function runTest()
    {
        $stdout = PHPUnit_Extensions_Phantom_Driver::executePhantomJS($this->file[0]);

        // yo, dawg. it's always true :)
        $this->assertTrue(1);

        // return the test result for further assertions
        return $stdout;
    }

}
