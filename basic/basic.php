<?php

require_once('common.php');
require_once('debug.php');
require_once('reader.php');
require_once('cleaner.php');
require_once('lexer.php');
require_once('interpreter.php');

try {
    $reader = new Reader('example.bsc');
    //throw new Debug(999, "Reader output", $reader->get());
    $cleaner = new Cleaner($reader->get());
    //throw new Debug(999, "Cleaner output", $cleaner->get());
    $lexer = new Lexer($cleaner->get());
    throw new Debug(999, "Lexer output", $lexer->get());
    $parser = new Parser($lexer->get());
}
catch (Debug $d) {
    die($d->getDebug());
}
catch (Exception $e) {
    die(
        var_dump(
            array(
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            )
        )
    );
}