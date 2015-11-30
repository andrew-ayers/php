<?php
	for ($x=1; $x <= 150; $x++) {
		$y = pow(2, $x) - 1;
		$prime = true;
		for ($d=2; $d <= sqrt($y); $d++) {
			if (($y / $d) == (int) ($y / $d)) {
				$prime = false;
				break;
			}
		}

		if ($prime == false) {
			echo "$y\n";
		}
		else {
			echo "$y = PRIME\n";
		}
	}
?>
