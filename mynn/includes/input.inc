<?php

/**
 * Class Input
 *
 * @author Andrew L. Ayers
 * @copyright Code and documentation copyright 2011-2015 Andrew L. Ayers. Code released under the MIT license. Docs released under Creative Commons Attribution 4.0 International Public License.
 */
class Input {
    private $weight;    // internal Input weighting
    private $value;     // Input value

    /**
     * Set default weighting (1) and value
     *
     * @param int $value    Input value
     */
    public function __construct($value = 0) {
        $this->set_weight(1);
        $this->set_value($value);

        return $this;
    }

    /**
     * Get Input object
     *
     * @return $this
     */
    public function get() {
        return $this;
    }

    /**
     * Set internal Input weighting value
     *
     * @param float $weight   Weighting value - if not passed, weight is set ot a random value (0...1)
     */
    public function set_weight($weight = null) {
        if (!empty($weight))
            $this->weight = $weight;
        else
            $this->weight = (float) mt_rand() / (float) mt_getrandmax(); // weight = 0...1
    }

    /**
     * Set Input value
     *
     * @param int $value    Input value
     */
    public function set_value($value = null) {
        if (!empty($value) && ($value != $this->value))
            $this->value = $value;
    }

    /**
     * Compute and return weighted Input value
     *
     * @return float    Weighted Input value
     */
    public function compute() {
        return $this->weight * $this->value;
    }
}