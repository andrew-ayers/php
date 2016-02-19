<?php

define('VERBOSE', 0);

define('OPERATORS', '>=,<=,<>,!=,>,<,!,++,--,+=,-=,*=,/=,=,+,-,*,/');

class Common {
    public $symbols;
    public $order;
    public $statements;

    public function __construct() {
        $this->symbols = array(
            array('match'  => 'else',   'label' => 'else',   'tokenize_order' => 3),
            array('match'  => 'end',    'label' => 'end',    'tokenize_order' => 5),
            array('match'  => 'gosub',  'label' => 'gosub',  'tokenize_order' => 2),
            array('match'  => 'goto',   'label' => 'goto',   'tokenize_order' => 1),
            array('match'  => 'if',     'label' => 'if',     'tokenize_order' => 4),
            array('match'  => NULL,     'label' => 'label',  'tokenize_order' => 0),
            array('match'  => 'let',    'label' => 'let',    'tokenize_order' => 6),
            array('match'  => 'print',  'label' => 'print',  'tokenize_order' => 7),
            array('match'  => 'return', 'label' => 'return', 'tokenize_order' => 8)
        );

        array_walk($this->symbols, function($value, $key) {
            $this->order[$value['tokenize_order']] = array(
                'label' => $value['label'],
                'match' => $value['match'],
                'token' => 'TKN_' . strtoupper($value['label'])
            );
        });

        ksort($this->order);

        foreach ($this->order as $key => $value) {
            define($value['token'], (pow(2, (int) $key)));

            $this->statements[] = $value['label'];
        }
    }
}