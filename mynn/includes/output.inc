<?php

/**
 * Class Output
 *
 * @author Andrew L. Ayers
 * @copyright Code and documentation copyright 2011-2015 Andrew L. Ayers. Code released under the MIT license. Docs released under Creative Commons Attribution 4.0 International Public License.
 */
class Output {
    private $value; // output value

    /**
     * @param float $value
     *
     * @return Output   Output object
     */
    public function __construct($value = 0) {
        $this->set_value($value);

        return $this;
    }

    /**
     * Get Output object
     *
     * @return $this
     */
    public function get() {
        return $this;
    }

    /**
     * Set value of Output object
     *
     * @param float $value
     */
    public function set_value($value = null) {
        if (!empty($value) && ($value != $this->value))
            $this->value = $value;
    }
}