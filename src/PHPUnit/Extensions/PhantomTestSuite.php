<?php
/**
 * PHPUnit Extension Headless - PhantomJS TestSuite
 *
 * Copyright (c) 2014, Jens-André Koch <jakoch@web.de>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 * * Redistributions of source code must retain the above copyright
 * notice, this list of conditions and the following disclaimer.
 *
 * * Redistributions in binary form must reproduce the above copyright
 * notice, this list of conditions and the following disclaimer in
 * the documentation and/or other materials provided with the
 * distribution.
 *
 * * Neither the name of Sebastian Bergmann nor the names of his
 * contributors may be used to endorse or promote products derived
 * from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package PHPUnit_Headless
 * @author Jens-André Koch <jakoch@web.de>
 * @copyright 2014 Jens-André Koch <jakoch@web.de>
 * @license http://www.opensource.org/licenses/BSD-3-Clause The BSD 3-Clause License
 * @link http://github.com/jakoch/phpunit-headless
 * @link http://www.phpunit.de/
 */

/**
 * PHPUnit Extension Headless - TestSuite for PhantomJS
 *
 * This class aggregates several PhantomJS tests into a TestSuite.
 */
class PHPUnit_Extensions_PhantomTestSuite extends PHPUnit_Framework_TestSuite
{
    /**
     * Make a test method public.
     */
    public function addTestMethod(ReflectionClass $class, ReflectionMethod $method)
    {
        return parent::addTestMethod($class, $method);
    }

    /**
     * Composes a TestSuite from a TestCaseClass or uses $staticProperties['phantomPath']
     * for creation of a TestSuite from a folder.
     *
     * @param  string $className extending PHPUnit_Extensions_PhantomTestCase
     * @return PHPUnit_Extensions_PhantomTestSuite
     */
    public static function addTestsFromTestCaseClass($className)
    {
        $suite = new self();
        $suite->setName($className);

        // use Ref to allow access to class properties
        $class = new ReflectionClass($className);
        $classGroups = PHPUnit_Util_Test::getGroups($className);
        $staticProperties = $class->getStaticProperties();

        // Tests come from Folder.
        // create tests from a folder with phantom .js or .coffee files
        if (isset($staticProperties['phantomPath']) === true) {
            
            if (is_dir($staticProperties['phantomPath']) === true) {
                $files = array_merge(
                    self::getTestFilesFromFolder($staticProperties['phantomPath'], '.js'), 
                    self::getTestFilesFromFolder($staticProperties['phantomPath'], '.coffee')
                );
            } else {
                $files[] = realpath($staticProperties['phantomPath']);
            }

            // create tests from PhantomJS javascript or coffee script files
            foreach ($files as $file) {

                $basename = basename($file);

                $filename = str_replace(array('.js', '.coffee'), array('', ''), $basename);

                // exclude some javascript tests from execution, because:
                $excludedFiles = array(
                    'modernizr', 'jquery',                    // library dependency
                    'movies', 'seasonfood', 'outputEncoding', // broken test
                    'sleepsort', 'stdin-stdout-stderr',       // test needs CLI arguments or interaction
                    'universe'                                // is part of an include demo
                );
                if (in_array($filename, $excludedFiles) === true) {
                    continue;
                }

                // filename to testname
                $testname = 'test_' . str_replace('.', '_', $basename);

                // every Phantom test file gets its own test case (one executePhantomJS call each)
                $test = new PHPUnit_Extensions_Phantom_FileExecute($testname, array($file));

                $suite->addTest($test, $classGroups);
            }
        } else {
            // Test come from a TestCaseClass.
            // create tests for all methods of the test case class
            foreach ($class->getMethods() as $method) {
                $suite->addTestMethod($class, $method);
            }
        }

        return $suite;
    }

    /**
     * Returns the Phantom test files from a folder as an array.
     * 
     * @param  string $directory
     * @param  string $suffix
     * @return array
     */
    private static function getTestFilesFromFolder($directory, $suffix)
    {
        $facade = new File_Iterator_Facade;

        return $facade->getFilesAsArray($directory, $suffix);
    }
}
