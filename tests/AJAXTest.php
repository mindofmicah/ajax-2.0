<?php
require 'bootstrap.php';
require 'tests/functions.php';

class AJAXTest extends PHPUnit_Framework_TestCase
{

    public function testNoFunctionByThatName()
    {
        try {
            AJAX::process('thisisnotthenameofafunction', array());
        } catch (Exception $e) {
            return true;
        }
        $this->fail('There should have been an exception because this function is not real');
    }

    public function testThrowExceptionIfNoComments()
    {
        try {
            AJAX::process('noCommentFunc', array());
        } catch (Exception $e) {
            return true;
        }
        $this->fail('This should have thrown an exception');
    }

    public function testDefaultValuesNotUsed()
    {
        $params = AJAX::process('thisFunctionHasDefaultValues', array());
        $this->assertEquals($params['value'], 'defaultValue');
        $this->assertEquals($params['emptySingleString'], '');
        $this->assertEquals($params['emptyDoubleString'], '');
    }
    
    public function testDefaultValuesUsed()
    {
        $params = AJAX::process('thisFunctionHasDefaultValues', array('value'=>'Apples'));
        $this->assertEquals($params['value'], 'Apples');
    }
    
    public function testBasicRequiredValues()
    {
        
    }
    
    public function testValidFunctionWithComments()
    {
        $params = AJAX::process('validFunction', array());
        $this->assertTrue(is_array($params));
    }
}
