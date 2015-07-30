<?php

function section($text) {
		echo "<pre>";
		echo str_repeat("-", 15) . "\r\n";
		echo $text . "\r\n";
		echo str_repeat("-", 15) . "\r\n";
		echo "</pre>";
}

function getElapsed($curTime) {
		$timeConsumed = round(microtime(true) - $curTime, 3) * 1000;
		section("ELAPSED: " . $timeConsumed);
}



function debug($thing) {
		die(var_dump($thing));
}

function clear() {
		echo "\x0C";
}