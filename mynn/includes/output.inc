<?php

/**
 * Class Output
 *
 * @author Andrew L. Ayers
 * @copyright Code and documentation copyright 2011-2015 Andrew L. Ayers. Code released under the MIT license. Docs released under Creative Commons Attribution 4.0 International Public License.
 */
class Output {
    protected $value; // output value

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
        if (isset($value) && ($value !== $this->value))
            $this->value = $value;
    }

    /**
     * Export the data of the output object
     *
     * @return float    Numeric value of output object
     */
    public function export() {
        return $this->value;
    }

    /**
     * Import the data of the Output object
     *
     * @param float $data   Numeric value of Output object
     * @return bool         TRUE on successful import of data
     * @throws Exception
     */
    public function import($data = null) {
        if (!empty($data)) {
            try {
                $this->value = $data;
            }
            catch (\Exception $e) {
                throw $e;
            }

            return true;
        }
    }
}