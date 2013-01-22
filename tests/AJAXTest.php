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
		// Valid
		$params = AJAX::process('testingGreaterThanEquals', array('greaterThanEqual7' => 7));
		$this->assertEquals(7, $params['greaterThanEqual7']);

		// Not valid		
		try {
			$params = AJAX::process('testingGreaterThanEquals', array('greaterThanEqual7' => 5));
		} catch (Exception $e) {
			return false;
		}
		$this->fail('5 is less than 7; this should have failed.');



	}

	public function testLessThan()
	{
		// Valid
		$params = AJAX::process('testingLessThan', array('lessThan5' => 4));
		$this->assertEquals(4, $params['lessThan5']);

		// Not valid		
		try {
			$params = AJAX::process('testingLessThan', array('lessThan5' => 8));
		} catch (Exception $e) {
			return false;
		}
		$this->fail('5 is less than 8; this should have failed.');



	}

	public function testLessThanEquals()
	{
		// Valid
		$params = AJAX::process('testingLessThanEquals', array('lessThanEqual5' => 5));
		$this->assertEquals(5, $params['lessThanEqual5']);

		// Not valid		
		try {
			$params = AJAX::process('testingLessThanEqual', array('lessThanEqual5' => 6));
		} catch (Exception $e) {
			return false;
		}
		$this->fail('5 is less than 6; this should have failed.');
	}

	public function testParamIsInt()
	{
		$params = AJAX::process('testingIsAnInt', array('int'=>5));
		$this->assertEquals(5, $params['int']);

		try {
			$params = AJAX::process('testingIsAnInt', array('int'=>'asdf'));
		} catch (Exception $e) {
			return false;
		}
	
		$this->fail('asdf is NOT an int');
	
	}
	public function testParamIsFloat(){}
	public function testParamIsEmail(){}
	public function testParamIsRegex(){}
	public function testParamIsIP(){}
	public function testParamIsUrl(){} 

    public function testBasicRequiredValuesMet()
    {
        $params = AJAX::process('validFunction', array('key'=>'value'));
        $this->assertTrue(is_array($params));
        $this->assertArrayHasKey('key', ($params));
    }
}
