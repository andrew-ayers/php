<?php
  // Using PHP, iterate through the integers between (inclusive) 1 and 100. For 
  // each number, if it is divisible by 3 and not 5, print fizz. If it is 
  // divisible by 5 and not 3, print buzz. If it is divisible by both 3 and 5, 
  // print fizzbuzz. If the number is divisible by neither 3 nor 5, do not print 
  // anything out.

  // Frequency of occurrances (sanity check)
  $c1 = $c2 = $c3 = $c4 = 0;
  
  for ($i=1; $i <= 100000; $i++) {
       if (($i % 5) && ($i % 3)) $c1++;
       if (!($i % 3) && ($i % 5)) $c2++;
       if (!($i % 5) && ($i % 3)) $c3++;
       if (!($i % 5) && !($i % 3)) $c4++;
  }

  echo "non: $c1\n";
  echo "fizz: $c2\n";
  echo "buzz: $c3\n";
  echo "fizzbuzz: $c4\n";
  
  // Time trials  
  $av1 = $av2 = $av3 = 0;
  
  for ($tr = 0; $tr < 10; $tr++) {
    $start = microtime(true);

    for ($i = 1; $i <= 100000; $i++) {
        if (!($i % 3) && ($i % 5)) echo "$i: fizz\n";
        if (!($i % 5) && ($i % 3)) echo "$i: buzz\n";
        if (!($i % 5) && !($i % 3)) echo "$i: fizzbuzz\n";
    }

    $av1 += (microtime(true) - $start);
  }
  
  // Version 2
  for ($tr = 0; $tr < 10; $tr++) {
    $start = microtime(true);

    for ($i = 1; $i <= 100000; $i++) {
        $j = (!($i % 3) + (!($i % 5) * 2));

        if ($j == 1) {
            echo "$i: fizz\n";
            continue;
        }
            
        if ($j == 2) {
            echo "$i: buzz\n"; 
            continue;
        }

        if ($j == 3) echo "$i: fizzbuzz\n";
    }

    $av2 += (microtime(true) - $start);
  }

  // Version 3    
  for ($tr = 0; $tr < 10; $tr++) {
    $start = microtime(true);

    for ($i = 1; $i <= 100000; $i++) {
        $j = (!($i % 3) + (!($i % 5) * 2));

        if (!$j) continue;
    
        echo $j == 1 ? "$i: fizz\n" : ($j == 2 ? "$i: buzz\n" : "$i: fizzbuzz\n");
    }

    $av3 += (microtime(true) - $start);
  }
  
  // Averages  
  echo  "Version 1: " . ($av1 / 10) . "\n";
  echo  "Version 2: " . ($av2 / 10) . "\n";
  echo  "Version 3: " . ($av3 / 10) . "\n";  
?>
