<?php
/**
 * Various activation class types for threshold computation
 *
 * @author Andrew L. Ayers
 * @copyright Code and documentation copyright 2011-2015 Andrew L. Ayers. Code released under the MIT license. Docs released under Creative Commons Attribution 4.0 International Public License.
 */

/**
 * Class Inpt - placeholder activation class type for input nodes (no computation)
 */
class Inpt {
    public function __construct() {}

    public function compute($value = 0) {
        return $value;
    }
}

/**
 * Class Binary - binary activation object and computation
 */
class Binary {
    public function __construct() {}

    public function compute($value = 0) {
        return ($value > 0 ? 1 : 0);
    }
}

/**
 * Class Step = discrete step activation object and computation
 */
class Step {
    public function __construct() {}

    public function compute($value = 0) {
        if ($value < 0) return 0;
        if ($value == 0) return 0.5;
        return 1.0;
    }
}

/**
 * Class Linear - linear activation object and computation
 */
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

/**
 * Class Sigmoid - classic sigmoid curve activation object and computation
 */
class Sigmoid {
    private $gain;

    public function __construct($gain = 1) {
        $this->gain = $gain;
    }

    public function compute($value = 0) {
        return (1.0 / (1.0 + exp(-$gain * $value)));
    }
}

/**
 * Class Gaussian (aka Normal) - classic gaussian/normal (bell curve distribution) activation object and computation
 */
class Gaussian {
    private $gain;

    public function __construct($gain = 1) {
        $this->gain = $gain;
    }

    public function compute($value = 0) {
        $temp = 0.5 * $gain * $value;

        return (exp(-0.5 * $temp * $temp));
    }
}

/**
 * Class AROS (Augmented Ratio of Squares) - AROS activation object and computation
 */
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

/**
 * Class Activation
 *
 * @author Andrew L. Ayers
 * @copyright Code and documentation copyright 2011-2015 Andrew L. Ayers. Code released under the MIT license. Docs released under Creative Commons Attribution 4.0 International Public License.
 */
class Activation {
    private $type;      // type of activation object
    private $object;    // activation object

    /**
     * @param string $type  Activation type to use - Inpt (default), Binary, Step, Linear, Sigmoid, Gaussian, AROS)
     * @param int $gain     Gain value
     */
    public function __construct($type = 'Input', $gain = 1) {
        $this->type = $type;
        $this->object = new $type($gain); // dynamic activation class type object instantiation and assignment
    }

    /**
     * Get Activation object
     *
     * @return $this
     */
    public function get() {
        return $this;
    }

    /**
     * Compute and return activation (threshold) value
     *
     * @return float    Computed activation value
     */
    public function compute($value = 0) {
        return $this->object->compute($value);
    }
}