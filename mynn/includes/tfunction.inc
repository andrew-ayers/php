<?php
    class Binary {
        public function __construct() {}

        public function compute($value = 0) {
            return ($value >= 0.5 ? 1 : 0);
        }
    }

    class Sigmoid {
        public function __construct() {}

        public function compute($value = 0) {
        }
    }

    class Normal {
        public function __construct() {}

        public function compute($value = 0) {
        }
    }

    class Bias {
        private $bias = 1;

        public function __construct() {}

        public function compute($value = 0) {
            return ($value * $this->bias);
        }
    }

    /******************************************************************************************************************/

    class TFunction {
        private $function;  // threshold function

        public function __construct($function = 'Sigmoid') {
            $this->function = new $function();
        }

        public function get() {
            return $this;
        }

        public function compute($value = 0, $weight = 1) {
            return ($this->function->compute($value) * $weight);
        }
    }