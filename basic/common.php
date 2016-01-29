<?php

$constants = array(
    'END',
    'GOSUB',
    'GOTOO',
    'IFELSE',
    'IFTHEN',
    'LABEL',
    'LET',
    'PRNT',
    'RETSUB',
);

foreach ($constants as $key => $constant) {
    define($constant, (pow(2, (int) $key)));
}

define('COMMANDS', 'else,end,gosub,goto,if,let,print,return');

define('OPERATORS', '>=,<=,<>,!=,>,<,!,++,--,+=,-=,*=,/=,=,+,-,*,/');