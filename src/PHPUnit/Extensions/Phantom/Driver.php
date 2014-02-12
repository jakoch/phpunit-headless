<?php

/**
 * Driver for creating and running a PhantomJS session.
 */
class PHPUnit_Extensions_Phantom_Driver
{
    private $tests;
    private $testcase;

    public function __construct($testcase)
    {
        $this->testcase = $testcase;
        $this->tests = array();
    }

    public function assertTrue($name, $condition)
    {
        $this->tests[] = new PHPUnit_Extensions_Phantom_Assertion($name, $condition);
    }

    public function assertEquals($name, $value, $condition)
    {
        $this->tests[] = new PHPUnit_Extensions_Phantom_Assertion($name, '' . json_encode($value) . " == $condition");
    }

    public function exec($name, $payloadToExecute)
    {
        $this->tests[] = new PHPUnit_Extensions_Phantom_PayloadExecute($name, $payloadToExecute);
    }

    /**
     * Test uses Phantom's page.evaluate() for code evaluation.
     * All assertions are already transformed into PhantomJS javascript code.
     *
     * @param type $page_content
     */
    public function test($page_content)
    {
        $page_content = json_encode($page_content);

        $output = <<<EOT

var page = require('webpage').create();
/*console.log('The default user agent is ' + page.settings.userAgent);*/
page.content = $page_content;
page.onLoadFinished = function (status) {
    try {
        if (status == 'success') {
            var ua = page.evaluate(function () {
                var tests = [];

EOT;

        foreach ($this->tests as $test) {
            $output .= "\n" . $test->getJavascript();
        }

        $output .= <<<EOT

               return tests;
            });

            for (var i = 0, il = ua.length; i < il; i++) {
                var result = ua[i];
                console.log(result.name + ' [' + (result.pass ? 'OK' : 'FAIL') + ']');
            }
        } else {
            console.log('all [FAIL]');
        }
        } catch (e) {
            console.log(e + ' [FAIL]');
        }
        phantom.exit();
    };
EOT;

        #echo $output;

        $testResult = $this->executeTemporaryTestFile($output);
        
        $lines = explode("\n", $testResult);

        foreach ($lines as $line) {
            if (empty($line) === true) {
                continue;
            }

            $found_key = false;
            $number_of_tests = count($this->tests);

            for ($i = 0; $i < $number_of_tests; $i++) {
                $test = $this->tests[$i];
                if (preg_match('/(.*) \[((?:OK)|(?:FAIL))\]/', $line, $matches)) {
                    if ($test->getName() == $matches[1]) {
                        $test->setSuccess($matches[2] == "OK");
                        $this->tests[$i] = $test;
                        $found_key = true;
                    }
                }
            }

            if (!$found_key) {
                $this->testcase->fail($line); // = PHPUnit_Framework_TestCase->fail()
            }
        }

        foreach ($this->tests as $test) {
            $this->testcase->assertTrue($test->isSuccess(), $test->getName());
        }
    }
    
    /**
     * Creates a temporary JS file, executes it with PhantomJS, then deletes it!
     * 
     * @param string $content The JS Test Content.
     * @return string Test Result (stdout) of PhantomJS Test Run.
     */
    private function executeTemporaryTestFile($content)
    {
        $file = tempnam(sys_get_temp_dir(), "phantomjs_");

        if (false === $file) {
            throw new \RuntimeException('Could not create temp file. Check temp directory permissions.');
        }

        file_put_contents($file, $content);

        $stdout = self::executePhantomJS($file);

        unlink($file);

        return $stdout;
    }

    /**
     * Executes a PhantomJS test file.
     * The call invokes "phantomjs [options] [file] [arg1 [arg2 [...]]]".
     *
     * For linux system "phantomjs" is expected to be on path.
     * You face no problems on Travis-CI, where it is preinstalled and on path.
     *
     * Find the list of CLI Options here:
     * @link https://github.com/ariya/phantomjs/wiki/API-Reference#command-line-options
     *
     * @param  string $testFile The PhantomJS file you wish to execute.
     * @param  type   $args     CLI Args
     * @param  type   $options  CLI Options
     * @return string Test Result (stdout)
     */
    public static function executePhantomJS($testFile, $args = null, $options = null)
    {
        // determine PhantomJS binary, take windows into account
        if (DIRECTORY_SEPARATOR === '\\') {
            $bin_dir = dirname(dirname(dirname(__DIR__))) . '\bin\\';
            $cmd = $bin_dir . "phantomjs.exe";
        } else {
            $cmd = "phantomjs";
        }

        // PhantomJS binary was not found
        if ((is_file($cmd) === false) or (is_executable($cmd) === false)) {
            throw new Exception(
                'The PhantomJS binary was not found! ' .
                'Place it either on the environment path or into the /bin folder of your project.'
            );
        }

        // options
        $cmd .= (isset($options) === true) ? " " . escapeshellarg($options) : '';

        // filename to execute
        $cmd .= " " . escapeshellarg($testFile);

        // arguments
        $cmd .= (isset($args) === true) ? " " . escapeshellarg($args) : '';

        // the full cmd = phantomjs [options] somescript.js [arg1 [arg2 [...]]]
        $stdout = shell_exec($cmd);

        //exit(var_dump($stdout));

        return $stdout;
    }
}
