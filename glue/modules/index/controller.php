<?php
    class Index extends MyFramework\BaseController {
        function GET($matches = NULL) {
            echo "Hello, World!\n\n";

            echo $this->parent()->derp();
        }
    }