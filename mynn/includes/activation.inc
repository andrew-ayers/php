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
    protected $gain;

    public function __construct($gain = 1) {
        $this->gain = $gain;
    }

    public function compute($value = 0) {
        if ($value < -10 / $gain) return 0;
        if ($value > 10 / $gain) return 1.0;

        return (0.5 + $value * $gain / 20);
    }

    /**
     * Export the data of the activation object
     *
     * @return array    Array of activation object data
     */
    public function export() {
        return array('gain' => $this->gain);
    }
}

/**
 * Class Sigmoid - classic sigmoid curve activation object and computation
 */
class Sigmoid {
    protected $gain;

    public function __construct($gain = 1) {
        $this->gain = $gain;
    }

    public function compute($value = 0) {
        return (1.0 / (1.0 + exp(-$gain * $value)));
    }

    /**
     * Export the data of the activation object
     *
     * @return array    Array of activation object data
     */
    public function export() {
        return array('gain' => $this->gain);
    }
}

/**
 * Class Gaussian (aka Normal) - classic gaussian/normal (bell curve distribution) activation object and computation
 */
class Gaussian {
    protected $gain;

    public function __construct($gain = 1) {
        $this->gain = $gain;
    }

    public function compute($value = 0) {
        $temp = 0.5 * $gain * $value;

        return (exp(-0.5 * $temp * $temp));
    }

    /**
     * Export the data of the activation object
     *
     * @return array    Array of activation object data
     */
    public function export() {
        return array('gain' => $this->gain);
    }
}

/**
 * Class AROS (Augmented Ratio of Squares) - AROS activation object and computation
 */
class AROS {
    protected $gain;

    public function __construct($gain = 1) {
        $this->gain = $gain;
    }

    public function compute($value = 0) {
        $temp = ($gain * $value) * ($gain * value);

        return ($temp / (1.0 + $temp));
    }

    /**
     * Export the data of the activation object
     *
     * @return array    Array of activation object data
     */
    public function export() {
        return array('gain' => $this->gain);
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
    protected $type;      // type of activation object
    protected $object;    // activation object

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

    /**
     * Export the data of the Activation object
     *
     * @return array    Array of Neuron object data
     */
    public function export() {
        $data = array(
            'type'   => $this->type,
        );

        if (method_exists($this->object, 'export')) {
            $data['object'] = $this->object->export();
        }

        return $data;
    }

    /**
     * Import the data of the Activation object
     *
     * @param array $data   Array of data for the Activation object
     * @return bool         TRUE on successful import of data
     * @throws Exception
     */
    public function import($data = null) {
        if (!empty($data)) {
            try {
                $type = $data['type'];

                $this->type = $type;

                $this->object = new $type($data['object']['gein']);
            }
            catch (\Exception $e) {
                throw $e;
            }

            return true;
        }
    }
}