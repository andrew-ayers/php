<?php
include 'router.php';
include 'request.php';
require 'helper.php';
//clear();
$curTime = microtime(true);


$uri = "/data/4";
//$uri = "/users";

section("Original URI: $uri");
$request = new Request($uri);


$router = new Router($request);

$router->GET('/', function($req, $res) {
		$res->send("root");
});

$router->GET('/data/{id}', function($req, $res) {
		$res->send("fuck data " . $req->params->id);
});

$router->GET('/users', function($req, $res) {
		echo "users root\r\n";
});

$router->GET('/users/{id}', function($req, $res) {
		$res->send("fuck user " . $req->params->id);
});


getElapsed($curTime);