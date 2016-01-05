<?php

    /**
    * Class Inpt - placeholder activation class type for input nodes (no computation)
    */
    class Inpt {
        public function __construct() {}

        public function compute($value = 0) {
            return $value;
        }
    }

    class Binary {
        public function __construct() {}

        public function compute($value = 0) {
            return ($value > 0 ? 1 : 0);
        }
    }

    class Step {
        public function __construct() {}

        public function compute($value = 0) {
            if ($value < 0) return 0;
            if ($value == 0) return 0.5;
            return 1.0;
        }
    }

    class Linear {
        private $gain;

        public function __construct($gain = 1) {
            $this->gain = $gain;
        }

        public function compute($value = 0) {
            if ($value < -10 / $gain) return 0;
            if ($value > 10 / $gain) return 1.0;

            return (0.5 + $value * $gain / 20);
        }
    }

    class Sigmoid {
        private $gain;

        public function __construct($gain = 1) {
            $this->gain = $gain;
        }

        public function compute($value = 0) {
            return (1.0 / (1.0 + exp(-$gain * $value)));
        }
    }

    // aka Gaussian
    class Normal {
        private $gain;

        public function __construct($gain = 1) {
            $this->gain = $gain;
        }

        public function compute($value = 0) {
            $temp = 0.5 * $gain * $value;

            return (exp(-0.5 * $temp * $temp));
        }
    }

    // Augmented Ratio of Squares
    class AROS {
        private $gain;

        public function __construct($gain = 1) {
            $this->gain = $gain;
        }

        public function compute($value = 0) {
            $temp = ($gain * $value) * ($gain * value);

            return ($temp / (1.0 + $temp));
        }
    }

    /******************************************************************************************************************/

    class Activation {
        private $type;      // type of activation object
        private $object;    // activation object

        public function __construct($type = 'Input', $gain = 1) {
            $this->type = $type;
            $this->object = new $type($gain);
        }

        public function get() {
            return $this;
        }

        public function compute($value = 0) {
            return $this->object->compute($value);
        }
    }