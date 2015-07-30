<?php namespace MyFramework;

    $routes = array(
        '/andrew/php/glue/' => 'index',
        '/andrew/php/glue/capture' => 'capture',
        '/andrew/php/glue/(\d+)' => 'capture',
        '/andrew/php/glue/([a-zA-Z0-9_]*)/(\d+)' => 'capture',
        '/andrew/php/glue/poster' => 'poster',
        '/andrew/php/glue/put' => 'extended',
        '/andrew/php/glue/delete/([a-zA-Z0-9_]*)' => 'extended',
    );