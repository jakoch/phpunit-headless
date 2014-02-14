<?php

class Extensions_Phantom_Tests_TestSuiteFromFolderTest extends PHPUnit_Extensions_PhantomTestCase
{
    // The PhantomJS examples reside in "/Tests/PhantomJS-examples".
    // PHPUnit's filefinder (File_Iterator_Facade) will find them.
    // @see PHPUnit_Extensions_PhantomTestSuite::getPhantomFiles()
    private static $phantomPath = __DIR__;
    
}
