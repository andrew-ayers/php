<?php
include_once('neuron.inc');

class Layer {
    private $layer = array();  // array of neuron objects

    public function __construct($count = 0, $function = 'Sigmoid') {
        $this->layer[] = new Neuron('Bias'); // first neuron is always the bias

        for ($i = 0; $i < $count; $i++) {
            $this->layer[] = new Neuron($function);
        }

        return $this->layer;
    }

    public function get() {
        return $this->layer;
    }

    public function randomize() {
        foreach($this->layer as $key => &$neuron) {
            if ($key > 0) // don't randomize the bias neuron!
                $neuron->set((float) mt_rand() / (float) mt_getrandmax());
        }
    }

    public function propagate() {

    }

    public function backpropagate() {

    }
}