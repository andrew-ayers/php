<?php
include_once('tfunction.inc');

class Neuron {
    private $function;
    private $threshold; // internal threshold function model
    private $weight;

    public function __construct($function = 'Sigmoid') {
        $this->set(1, $function);

        return $this;
    }

    public function set($weight = null, $function = null) {
        if (!empty($weight) && ($weight != $this->weight))
            $this->weight = $weight;

        if (!empty($function) && ($function != $this->function)) {
            $this->function = $function;

            $this->threshold = new TFunction($function);
        }
    }

    public function get() {
        return $this;
    }

    public function compute($value = 0) {
        return $this->threshold->compute($value, $this->weight);
    }
}