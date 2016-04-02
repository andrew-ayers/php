<?php namespace MyFramework;

    require_once('config/config.php');
    require_once('libs/glue.php');
    require_once('libs/base.php');
    require_once('libs/filters.php');

    try {
        session_start();

        glue::stick($routes);
    }
    catch(\Exception $e) {
        die('ERROR: '.$e->getMessage().' in ['.$e->getFile().'] @ line '.$e->getLine());
    }
