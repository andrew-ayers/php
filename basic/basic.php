#!/usr/bin/php -q
<?php

require_once('common.php');
require_once('debug.php');
require_once('reader.php');
require_once('cleaner.php');
require_once('lexer.php');
require_once('interpreter.php');

try {
    //$filename = 'example.bsc';

    $filename = !empty($argv[1]) ? $argv[1] : "";

    $reader = new Reader($filename);
    $cleaner = new Cleaner($reader->get());
    $lexer = new Lexer($cleaner->get());

    throw new Debug(999, "Lexer output", $lexer->get());

    //$parser = new Parser($lexer->get());
}
catch (Debug $d) {
    die($d->getDebug());
}
catch (Exception $e) {
    if (VERBOSE) {
        $msg = var_dump(
            array(
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            )
        );
    }
    else {
        $msg = $e->getMessage();
    }

    die($msg . "\n");
}