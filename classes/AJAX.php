<?php
class AJAX
{
	static public function process($funcName, $params)
	{
		// grab the general comments for the given function
		try {
			$reflection = new ReflectionFunction($funcName);
			$comments = $reflection->getDocComment();
		} catch (Exception $e) {
			throw $e;
		}

		// Grab all the special comments for the funcion
		preg_match_all('%\s*(\w+)%', $comments, $matches, 2);
		if (count($matches) == 0) {
			throw new Exception('No Documentation available');
		}
	}
}
