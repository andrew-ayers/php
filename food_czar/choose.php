<?php

require_once(__DIR__ . '/czar.php');
$czar = new czar();
echo "\f";

$food_places = $czar->get_places(true);

if (empty($food_places))
	die("There was an error loading food places (there weren't any found)\n");

echo "Loaded Information From:\r\n";
foreach ($food_places as $fp)
	echo "\t" . $fp['name'] . "\r\n";

$lucky_one = $czar->get_random();

echo "\n\n\nThe lucky food place is!\n";
print_r($lucky_one);
