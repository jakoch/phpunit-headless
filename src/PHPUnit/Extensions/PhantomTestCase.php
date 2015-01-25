<?php
/**
 * PHPUnit Extension Headless - PhantomJS TestCase
 *
 * The class provides a PHP wrapper to PhantomJS by Ariya Hidayat.
 * It's aabstract subclass of PHPUnit_Framework_TestCase.
 * Your test case classes will derive from this base class.
 *
 * PhantomJS is a headless WebKit, scriptable with JavaScript or CoffeeScript.
 * Use cases imply: headless webtesting, page automation, screen capturing and network monitoring.
 *
 * @link http://phantomjs.org/
 * @link https://github.com/ariya/phantomjs
 */
abstract class PHPUnit_Extensions_PhantomTestCase extends PHPUnit_Framework_TestCase
{
    /* @var $phantom PHPUnit_Extensions_Phantom_Driver */
    public $phantom;

    public function __construct($name = NULL, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->phantom = new PHPUnit_Extensions_Phantom_Driver($this);        
    }
    
    /**
     * Build a TestSuite from a TestCaseClass.
     * 
     * @param string $className
     * @return PHPUnit_Extensions_PhantomTestSuite
     */
    public static function suite($className)
    {
        return PHPUnit_Extensions_PhantomTestSuite::addTestsFromTestCaseClass($className);
    }

    /**
     * Magically delegate all method calls to the Phantom.
     *
     * @param  string $command
     * @param  array  $arguments
     * @return mixed
     */
    public function __call($command, $arguments)
    {       
        if ($this->phantom === null) {
            $msg = sprintf('There is currently no active Phantom session to execute the "%s" command.', $command);
            $msg .= ' You are probably trying to set some option in setUp() with an incorrect setter name.';
            $msg .= ' You may consider using setUpPage() instead.';
            throw new RuntimeException($msg);
        }

        $result = call_user_func_array(array($this->phantom, $command), $arguments);

        return $result;
    }

    /**
    * This is a setUp() method that is called after the phantom driver has been prepared.
    * You might start calling Phantom commands like url() here.
    */
    public function setUpPage()
    {

    }
}
