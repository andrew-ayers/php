<?php
include_once('input.inc');
include_once('activation.inc');
include_once('output.inc');

/**
 * Class Neuron
 *
 * @author Andrew L. Ayers
 * @copyright Code and documentation copyright 2011-2015 Andrew L. Ayers. Code released under the MIT license. Docs released under Creative Commons Attribution 4.0 International Public License.
 */
class Neuron {
    private $activation; // internal activation (threshold) model
    private $th_bias;    // activation threshold bias value
    private $inputs;     // array of Input objects (inputs)
    private $output;     // single Output object for neuron (output)

    /**
     * @param string $type  Activation type to use - Inpt (default), Binary, Step, Linear, Sigmoid, Gaussian, AROS)
     * @param int $gain     Gain value
     * @param int $bias     Bias value
     *
     * @return Neuron object
     */
    public function __construct($type = 'Inpt', $gain = 1, $bias = 0) {
        $this->set_type($type, $gain);

        $this->set_th_bias($bias);

        $this->inputs = array();

        return $this;
    }

    /**
     * Get Neuron object
     *
     * @return $this
     */
    public function get() {
        return $this;
    }

    /**
     * Set the activation threshold bias value
     *
     * @param int $bias
     */
    public function set_th_bias($bias = 0) {
        $this->th_bias = $bias;
    }

    /**
     * Instantiate an Activation type for the Neuron
     *
     * @param string $type  Activation type to use - Inpt (default), Binary, Step, Linear, Sigmoid, Gaussian, AROS)
     * @param int $gain     Gain value
     */
    public function set_type($type = null, $gain = 1) {
        if (!empty($type))
            $this->activation = new Activation($type, $gain);
    }

    /**
     * Add an Input object to the Neuron
     */
    public function add_input() {
        $this->inputs[] = new Input();
    }

    /**
     * Set the Neuron input-value for a defined Input
     *
     * @param int $number   Input to set
     * @param int $value    Value to set the Input to
     */
    public function set_input($number = null, $value = 0) {
        if (!empty($number)) {
            $this->inputs[$number]->set_value($value);
        }
    }

    /**
     * Return an array of Input objects
     *
     * @return array Array of Input objects
     */
    public function get_inputs() {
        return $this->inputs;
    }

    /**
     * Return an Output object
     *
     * @return object Output object
     */
    public function get_output() {
        return $this->output;
    }

    /**
     * Perform computation for forward-propagation, setting Neuron output
     *
     * @param int $value    Value to compute the output fromj
     * @return Output       Output object
     */
    public function compute($value = 0) {
        $value = 0;

        foreach ($this->inputs as $input)
            $value += $input->compute();

        $value = $this->activation->compute($value + $this->th_bias);

        $this->output = new Output($value);

        return $this->output;
    }

    /**
     * Needed for proper JSON encoding of private data
     *
     * @return array
     */
    public function __sleep() {
        return array('activation', 'th_bias', 'inputs', 'output');
    }
}