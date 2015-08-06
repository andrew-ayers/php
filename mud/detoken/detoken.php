<?php
	function tokenize($str, $pattern, $strip = null) {
		// Splits the string ($str) into an array of multiple tokens (elements)
		$tokens = preg_split($pattern, $str, null, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
		
		// Strip off any characters from the tokens (elements) if needed
		array_walk($tokens, function(&$element, $key, $strip) {
			if (!empty($strip))
				$element = preg_replace($strip, '', $element);			
		}, $strip);

		// Remove any "empty" tokens (elements) to clean up
		$tokens2 = array();
		
		foreach($tokens as $key => $element) {
			if (!empty($element) && $element != '')
				$tokens2[] = $element;
		}
		
		$tokens = $tokens2;

		return $tokens;
	}

	/*************************************************************************/

	function parse($data) {
		// Tokenize data into an array - splits data into multiple elements
		// by CR, LF, and TAB, and removes all curly braces
		$tokens = tokenize($data, '/[\r\n\t]/', '/[\{\}]/');

		// ...then for each element in the array, split the element up into
		// another array, splitting the data into multiple elements by spaces,
		// while keeping quoted lines together; then remove ($) and (") from 
		// each element to clean up
		array_walk($tokens, function(&$element, $key) {
			$element = tokenize($element, '/([^\"]\S*|\".+?\")\s*/', '/[\$\"]/');
		});
		
		return $tokens;
	}

	/*************************************************************************/

	$data = file_get_contents('./examples.txt', true);

	$results = parse($data);
	
	print "<pre>";

	print_r($data);

	print "\n\n";
	print "*************************************************************************";
	print "\n\n";

	print_r($results);
	
	print "</pre>";
?>