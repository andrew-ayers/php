<?php

class Request {

		public $uri;
		public $params;

		public function __construct($uri = NULL) {
				if (is_null($uri))
						$uri = $_SERVER['REQUEST_URI'];
				$this->uri = $this->tokenizeURI($uri);
				$this->params = (Object) array();
		}

		public function tokenizeURI($uri) {
				$tokenz = array();
				$uri_tok = strtok($uri, "/");
				while ($uri_tok !== false) {
						$tokenz[] = $uri_tok;
						$uri_tok = strtok("/");
				}
				return $tokenz;
		}

}
