<?php

require 'request.php';

class Response
{

	public function send($text)
	{
		echo "$text\r\n";
	}

}

class Router
{

	private $request;
	private $response;

	public function __construct()
	{
//				$this->request = $request;
		$this->request	 = new Request();
		$this->response	 = new Response();
        echo "<pre>";
        var_dump($this->request);
        die();
	}

	private function findArguments($string, $value)
	{
		$first						 = strpos($string, "{");
		if ($first === FALSE)
			return FALSE;
		$last						 = strpos($string, "}");
		$key						 = substr($string, $first + 1, $last - 1);
		$this->request->params->$key = $value;
	}

	private function tokenizeRoute($route)
	{
		$token		 = array();
		$route_tok	 = strtok($route, "/");
		while ($route_tok !== false)
		{
			$token[]	 = $route_tok;
			$route_tok	 = strtok("/");
		}
		return $token;
	}

	private function checkRoute($route)
	{
		$route_token = $this->tokenizeRoute($route);
		$route_score = count($route_token);
		$uri_score	 = count($this->request->uri);
		if ($route_score != $uri_score)
			return FALSE;
		$route_info	 = array_combine($route_token, $this->request->uri);
		if (empty($route_info)) // root index request
			return TRUE;
		foreach ($route_info as $key => $value)
		{
			if (strpos($key, "{") !== FALSE)
			{ //is param
				$this->findArguments($key, $value);
			}
			else
			{
				if ($key != $value)
					return FALSE;
			}
		}
		return $route_token;

//				debug($route_obj);
	}

	public function GET($route, $function)
	{
		$is_route = $this->checkRoute($route);
		if ($is_route === FALSE)
			return;
		if (is_callable($function))
			$function($this->request, $this->response);
	}

}
