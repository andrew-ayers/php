<?php
    class Capture extends MyFramework\BaseController {
        function GET($matches = NULL) {
            if (isset($matches[1])) {
                echo "The magic number is: " . $matches[1] . "\n\n";
            } else {
                echo "You did not enter a number.\n\n";
            }
        }
    }