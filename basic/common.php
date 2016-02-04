<?php

$constants = array(
    'END',
    'GOSUB',
    'GOTOO',
    'IFTHEL',
    'LABEL',
    'LET',
    'PRNT',
    'RETSUB',
);

foreach ($constants as $key => $constant) {
    define($constant, (pow(2, (int) $key)));
}

define('COMMANDS', 'end,gosub,goto,if,let,print,return');

define('OPERATORS', '>=,<=,<>,!=,>,<,!,++,--,+=,-=,*=,/=,=,+,-,*,/');