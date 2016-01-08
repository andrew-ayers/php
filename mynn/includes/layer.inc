<?php
include_once('neuron.inc');

/**
 * Class Layer
 *
 * @author Andrew L. Ayers
 * @copyright Code and documentation copyright 2011-2015 Andrew L. Ayers. Code released under the MIT license. Docs released under Creative Commons Attribution 4.0 International Public License.
 */
class Layer {
    protected $neurons; // array of Neuron objects

    /**
     * Instantiate one or more Neurons in the Layer
     *
     * @param int $count    Number of Neuron objects to build
     * @param string $type  Neuron activation type to use - Inpt (default), Binary, Step, Linear, Sigmoid, Gaussian, AROS)
     * @param int $gain     Gain value for Neuron object
     * @param int $bias     Bias value for Neuron object
     *
     * @return array        Array of Neuron objects
     */
    public function __construct($count = 1, $type = 'Inpt', $gain = 1, $bias = 0) {
        $this->neurons = array();

        for ($i = 0; $i < $count; $i++) {
            $this->neurons[] = new Neuron($type, $gain, $bias);
        }

        $this->randomize(); // set random weight values for the Neuron objects in this layer

        return $this->neurons;
    }

    /**
     * Return an array of Neuron objects
     *
     * @return array Array of Neuron objects
     */
    public function get() {
        return $this->neurons;
    }

    /**
     * Set the array of Neuron objects
     *
     * @param array $neurons Array of Neuron object data
     */
    public function set($neurons = array()) {
        $this->neurons = $neurons;
    }

    /**
     * Add inputs to the Layer, one per each output (neuron) of the previous layer
     *
     * @param null $previous Array of previous Neuron object data
     */
    public function add_inputs($previous = null) {
        if (!empty($previous)) {
            foreach ($this->neurons as $neuron) {
                foreach ($previous->neurons as $previous_neuron) {
                    $neuron->add_input();
                }
            }
        }
    }

    /**
     * Set random weight values for the Neuron objects in this layer
     */
    public function randomize() {
        foreach ($this->neurons as $key => &$neuron) {
            $inputs = $neuron->get_inputs();

            foreach ($inputs as $input)
                $input->set_weight();
        }
    }

    /**
     * Perform forward-propagation of input neuron data through the network
     */
    public function propagate($previous = null) {
        if (!empty($previous)) {
            foreach ($this->neurons as $neuron) {
                foreach ($previous->neurons as $number => $previous_neuron) {
                    $value = $previous_neuron->get_output();

                    $neuron->set_input($number, $value);
                }

                $neuron->compute();
            }
        }
    }

    /**
     * STUB for back-propagation (training only)
     */
    public function backpropagate() {
        // TODO
    }

    /**
     * Export the data of the Neuron objects
     *
     * @return array    Array of Neuron objects
     */
    public function export() {
        $data = array();

        foreach ($this->neurons as $neuron) {
            $data['neurons'][] = $neuron->export();
        }

        return $data;
    }

    /**
     * Import the data of Neuron objects
     *
     * @param array $data   Array of Neuron objects
     * @return bool         TRUE on successful import of data
     * @throws Exception
     */
    public function import($data = null) {
        if (!empty($data)) {
            try {
                $this->neurons = $data;

                foreach ($neurons as $neuron) {
                    $data = array(
                        'activation' => $neuron->activation,
                        'th_bias'    => $neuron->th_bias,
                        'inputs'     => $neuron->inputs,
                        'output'     => $neuron->output
                    );

                    $this->neurons[] = $neuron->import($data);
                }
            }
            catch (\Exception $e) {
                throw $e;
            }

            return true;
        }
    }
}