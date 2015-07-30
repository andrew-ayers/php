<?php
$curTime = microtime(true);
require_once './route_test/router.php';
require_once './route_test/helper.php';

$router = new Router();

$router->GET('/', function() {
		echo "root\r\n";
});

$router->GET('/data/{id}', function($req, $res) {
		$res->send("this is data " . $req->params->id);
});

$router->GET('/users', function($req, $res)
{
	$res->send("users root");
});

$router->GET('/users/{id}', function($req, $res) {
		$res->send("fuck user " . $req->params->id);
});

getElapsed($curTime);