<?php
include_once('layer.inc');

/**
 * Class Network
 *
 * @author Andrew L. Ayers
 * @copyright Code and documentation copyright 2011-2015 Andrew L. Ayers. Code released under the MIT license. Docs released under Creative Commons Attribution 4.0 International Public License.
 */
class Network {
    private $layers = array(); // array of Layer objects

    public function __construct() {}

    /**
     * Add a new Layer to the network
     *
     * @param int $count        Number of Neuron objects in the layer
     * @param string $type      Neuron activation type to use - Inpt (default), Binary, Step, Linear, Sigmoid, Gaussian, AROS)
     */
    public function add($count = 1, $type = 'Inpt') {
        // Build a new layer
        $this->layers[] = new Layer($count, $type);

        $num_layers = count($this->layers);

        // If there are any previous layers, add inputs to this new
        // layer, one per each output (neuron) of the previous layer
        if ($num_layers > 1) {
            $curr_layer = $this->layers[$num_layers - 1];
            $prev_layer = $this->layers[$num_layers - 2];

            $curr_layer->add_inputs($prev_layer);
        }
    }

    /**
     * Return an array of Layer objects
     *
     * @return array Array of Layer objects
     */
    public function get() {
        return $this->layers;
    }

    /**
     * Perform forward-propagation of input neuron data through the network
     */
    public function propagate() {
        $prev_layer = null;

        foreach ($this->layers as $num => $layer) {
            if ($num > 0)
                if (!empty($prev_layer))
                    $layer->propagate($prev_layer);

            $prev_layer = $layer;
        }
    }

    /**
     * STUB for back-propagation (training only)
     */
    public function backpropagate() {
        // TODO
    }

    /**
     * Export JSON data of Layer objects
     *
     * @return string JSON encoded data of Layer objects
     */
    public function export() {
        return json_encode($this->layers, JSON_FORCE_OBJECT);
    }

    /**
     * Import JSON data of Layer objects
     *
     * @param string $layers - JSON encoded Layer object data
     * @return bool             TRUE on successful import of data
     * @throws Exception
     */
    public function import($layers = null) {
        if (!empty($layers)) {
            try {
                $this->layers = json_decode($layers);
            }
            catch (\Exception $e) {
                throw $e;
            }

            return true;
        }
    }

    /**
     * Needed for proper JSON encoding of private data
     *
     * @return array
     */
    public function __sleep() {
        return array('layers');
    }
}