<?php

include_once('actor.php');
include_once('sandbox.php');

$sandbox = new Sandbox();

$sandbox->run();

$best = $sandbox->get_best_fit(1);

print print_r($best[0], true) . "\n";

for ($i = 0; $i <= 100; $i++) {
    $problem = $i;

    $solution = sqrt($problem);

    $answer = $best[0]->evaluate($problem);

    echo "The square root of {$problem} equals {$solution}...I calculate it to be {$answer}.\n";
}

$code = $best[0]->get_code();

$end = strpos($code, '!');

echo "My code is: " . substr($code, 0, $end) . "\n";
