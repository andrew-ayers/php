<?php
include_once('layer.inc');

class Network {
    private $layers = array(); // array of layer objects

    public function __construct() {}

    public function add($count = 1, $function = 'Inpt') {
        $this->layers[] = new Layer($count, $function);

        $num_layers = count($this->layers);

        if ($num_layers > 1) {
            $curr_layer = $this->layers[$num_layers - 1];
            $prev_layer = $this->layers[$num_layers - 2];

            $curr_layer->add_inputs($prev_layer);
        }
    }

    public function get() {
        return $this->layers;
    }

    public function propagate() {
        $prev_layer = null;

        foreach ($this->layers as $num => $layer) {
            if ($num > 0)
                if (!empty($prev_layer))
                    $layer->propagate($prev_layer);

            $prev_layer = $layer;
        }
    }

    public function backpropagate() {
        // TODO
    }

    public function export() {
        return json_encode($this->layers, JSON_FORCE_OBJECT);
    }

    public function import($layers = null) {
        if (!empty($layers))
            return json_decode($this->layers);
    }

    public function __sleep() {
        return array('layers');
    }
}