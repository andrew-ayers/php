<?php

require_once(__DIR__ . '/czar.php');

$czar    = new czar();
$mention = "unknown";
if (!empty($GLOBALS['HTTP_RAW_POST_DATA']))
	$raw_post = json_decode($GLOBALS['HTTP_RAW_POST_DATA']);

if (!empty($raw_post->item->message->from))
	$mention = $raw_post->item->message->from->mention_name;

$luck_one = $czar->get_random();

$response = array(
	'color'          => 'green',
	'message'        => "Herro @" . $mention . ", you should travel " . $luck_one['time_from_office'] . "(" . $luck_one['distance_from_offce'] . ") to " . $luck_one['address'] . " and enjoy some " . $luck_one['name'] . " (yey)",
	'notify'         => false,
	'message_format' => 'text',
);

header("Content-Type: Application/json");
echo json_encode($response);
