<?php

class Extensions_Phantom_Tests_BasicTest extends PHPUnit_Extensions_PhantomTestCase
{
    public function testLoadJqueryAndUseJquerySelectors()
    {
        $html = '<html><body><h1>Hi</h1>';
        $html .= '<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>';
        $html .= '</body></html>';

        // jQuery() or $() functions will only be defined if they are already loaded into the current document
        $this->phantom->assertTrue("h1 exists", "$('h1').length == 1");
        $this->phantom->assertTrue("h1 value is Hi", "$('h1').html() == 'Hi'");
        
        $this->phantom->assertEquals('h1 value is Hi', "$('h1').html()", "Hi");
        
        $this->phantom->assertEqualsNot('jQuery is loaded', "(typeof jQuery)", 'undefined');
        
        $this->phantom->test($html);
    }
}
