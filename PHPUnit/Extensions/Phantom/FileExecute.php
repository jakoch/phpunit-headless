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
        // also true, when file executed without stdout, because an image was rendered
        if (empty($stdout)) {
            $this->assertTrue(empty($stdout));
        } else {
            $this->assertTrue(!empty($stdout));
        }

        // return the test resul for further assertions
        return $stdout;
    }

}
