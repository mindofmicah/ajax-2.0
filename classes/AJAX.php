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
        $matches = array();
        preg_match_all('%\s*(\w+)(?::([\w\'"]+))?%', $comments, $matches, 2);
        if (count($matches) == 0) {
            throw new Exception('No Documentation available');
        }

        $ret = array();
        
        // Loop through each line of comments
        foreach ($matches as $match) {
            // Check if the parameter is already in the param array
            if (!empty($params[$match[1]])) {
                $ret[$match[1]] = $params[$match[1]];
            } elseif (!empty($match[2])) {
                // hack to handle empty strings
                if ($match[2] == '\'\'' || $match[2] == '""') {
                    $match[2] = '';
                }
                // Set the parameter to the default value
                $ret[$match[1]] = $match[2];
            } else {
                // There is no default set
                throw new Exception('There is no value for $params[' . $match[1] . ']');
            }
        }
        return $ret;
    }
}
