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
    
    public function testBasicRequiredValuesNotMet()
    {
        try {
            $params = AJAX::process('validFunction', array());
        } catch (Exception $exc) {
            return false;
        }
        $this->fail('This should not have passed. It did not have required');
    }

	public function testGreaterThan()
	{
		// Valid
		$params = AJAX::process('testingGreaterThan', array('greaterThan7' => 8));
		$this->assertEquals(8, $params['greaterThan7']);

		// Not valid		
		try {
			$params = AJAX::process('testingGreaterThan', array('greaterThan7' => 5));
		} catch (Exception $e) {
			return false;
		}
		$this->fail('5 is less than 7; this should have failed.');


	}

	public function testGreaterThanEquals()
	{

	}

	public function testLessThan()
	{

	}

	public function testLessThanEquals()
	{

	}
    public function testBasicRequiredValuesMet()
    {
        $params = AJAX::process('validFunction', array('key'=>'value'));
        $this->assertTrue(is_array($params));
        $this->assertArrayHasKey('key', ($params));
    }
}
