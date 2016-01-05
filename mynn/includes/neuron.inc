<?php
include_once('input.inc');
include_once('activation.inc');
include_once('output.inc');

class Neuron {
    private $activation; // internal activation (threshold) function model
    private $th_bias;    // activation threshold bias value
    private $inputs;     // array of inputs
    private $output;     // single output of neuron

    public function __construct($type = 'Inpt', $gain = 1, $th_bias = 0) {
        $this->set_type($type, $gain);

        $this->set_th_bias($th_bias);

        $this->inputs = array();

        return $this;
    }

    public function get() {
        return $this;
    }

    public function set_th_bias($th_bias = 0) {
        $this->th_bias = $th_bias;
    }

    public function set_type($type = null, $gain = 1) {
        if (!empty($type))
            $this->activation = new Activation($type, $gain);
    }

    public function add_input() {
        $this->inputs[] = new Input();
    }

    public function set_input($number = null, $value = 0) {
        if (!empty($number)) {
            $this->inputs[$number] = $value;
        }
    }

    public function get_inputs() {
        return $this->inputs;
    }

    public function get_output() {
        return $this->output;
    }

    public function compute($value = 0) {
        $value = 0;

        foreach ($this->inputs as $input)
            $value += $input->compute();

        $value = $this->activation->compute($value + $this->th_bias);

        $this->output = new Output($value);

        return $this->output;
    }

    public function __sleep() {
        return array('activation', 'th_bias', 'inputs', 'output');
    }
}