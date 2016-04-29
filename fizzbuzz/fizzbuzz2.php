<?php
    /**************************************************************************/
    /* PHP Object-oriented FizzBuzz - Why? I don't know...
    /**************************************************************************/

    class FizzBuzz {
        public function _construct() {
        }
        
        public function run($trials = 100, $count = 1, $version = 1, $output = false) {
            $time = 0;

            for ($tr = 0; $tr < $trials; $tr++) {
                $start = microtime(true);

                for ($i = 1; $i <= $count; $i++) {
                    switch ($version) {
                        case 1:
                            $result = $this->v1($i);
                            break;
                            
                        case 2:
                            $result = $this->v2($i);
                            break;

                        case 3:
                            // break intentionally omitted
                        default:
                            $result = $this->v3($i);
                    }
                    
                    if ($output) {
                        switch ($result) {
                            case 1:
                                echo "$i: fizz\n";
                                break;

                            case 2:
                                echo "$i: buzz\n";
                                break;

                            case 3:
                                echo "$i: fizzbuzz\n";
                                break;
                                
                            default:
                                // do nothing
                        }
                     }
                }
                
                $time += (microtime(true) - $start);
            }
            
            return $time / $trials;
        }
        
        /**
         * Version 1 - Modulo w/ if-then
         */        
        public function v1($i = 0) {
            if (!($i % 3) && ($i % 5)) return 1;
            if (!($i % 5) && ($i % 3)) return 2;
            if (!($i % 5) && !($i % 3)) return 3;
            return 0;
        }

        /**
         * Version 2 - Modulo w/ multiply
         */        
        public function v2($i = 0) {
            $i = (!($i % 3) + (!($i % 5) * 2));

            return $i;
        }
        
        /**
         * Version 3 - Modulo w/ bitshift
         */
        public function v3($i = 0) {
            $i = (!($i % 3) + (!($i % 5) << 1));

            return $i;
        }

        public function frequency($count = 100) {
            $freq = array(0, 0, 0, 0);

            for ($i = 1; $i <= $count; $i++) {               
                $j = (!($i % 3) + (!($i % 5) * 2));
                $freq[$j]++;
            }
            
            return $freq;        
        }
    }
    
    /**************************************************************************/
    /* Using PHP, iterate through the integers between (inclusive) 1 and 100. */ 
    /* For each number, if it is divisible by 3 and not 5, print fizz. If it  */
    /* is divisible by 5 and not 3, print buzz. If it is divisible by both 3  */
    /* and 5, print fizzbuzz. If the number is divisible by neither 3 nor 5,  */
    /* do not print anything out.                                             */
    /**************************************************************************/
    
    $test = new FizzBuzz();
    
    // Testing
    echo "\nTesting:\n\n";
    
    $test->run(1, 15, 1, true);
    
    // Frequency of occurrances (sanity check)
    $fdist = array_combine(array('neither', 'fizz', 'buzz', 'fizzbuzz'), $test->frequency(100000));

    echo "\nFrequency:\n\n" . print_r($fdist, true) . "\n";
    
    // Time trials
    $times = array(
        'Version 1' => $test->run(10, 100000, 1),
        'Version 2' => $test->run(10, 100000, 2),
        'Version 3' => $test->run(10, 100000, 3),
    );

    echo "Times:\n\n" . print_r($times, true) . "\n";
?>
