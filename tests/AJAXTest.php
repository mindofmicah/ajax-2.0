<?php
require 'classes/AJAX.php';
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
		} catch(Exception $e) {
			return true;
		}
		$this->fail('This should have thrown an exception');
	}

	public function testValidFunctionWithComments()
	{
		$params = AJAX::process('validFunction', array());
		$this->assertTrue(is_array($params));
	}
}
