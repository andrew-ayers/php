<?php
include_once('neuron.inc');

class Layer {
    private $neurons; // array of neuron objects

    public function __construct($count = 1, $function = 'Inpt', $gain = 1, $bias = 0) {
        $this->neurons = array();

        for ($i = 0; $i < $count; $i++) {
            $this->neurons[] = new Neuron($function, $gain, $bias);
        }

        $this->randomize();

        return $this->neurons;
    }

    public function get() {
        return $this->neurons;
    }

    public function set($neurons = array()) {
        $this->neurons = $neurons;
    }

    public function add_inputs($previous = null) {
        if (!empty($previous)) {
            foreach ($this->neurons as $neuron) {
                foreach ($previous->neurons as $previous_neuron) {
                    $neuron->add_input();
                }
            }
        }
    }

    public function randomize() {
        foreach ($this->neurons as $key => &$neuron) {
            $inputs = $neuron->get_inputs();

            foreach($inputs as $input)
                $input->set_weight();
        }
    }

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

    public function backpropagate() {
        // TODO
    }

    public function __sleep() {
        return array('neurons');
    }
}