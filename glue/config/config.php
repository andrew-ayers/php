<?php namespace MyFramework;

    $routes = array(
        '/php/glue/' => 'index',
        '/php/glue/capture' => 'capture',
        '/php/glue/(\d+)' => 'capture',
        '/php/glue/([a-zA-Z0-9_]*)/(\d+)' => 'capture',
        '/php/glue/poster' => 'poster',
        '/php/glue/put' => 'extended',
        '/php/glue/delete/([a-zA-Z0-9_]*)' => 'extended',
    );
