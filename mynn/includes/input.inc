<?php
class Input {
    private $weight;
    private $value;

    public function __construct($value = 0) {
        $this->set_weight(1);
        $this->set_value($value);

        return $this;
    }

    public function get() {
        return $this;
    }

    public function set_weight($weight = null) {
        if (!empty($weight))
            $this->weight = $weight;
        else
            $this->weight = (float) mt_rand() / (float) mt_getrandmax(); // weight = 0...1
    }

    public function set_value($value = null) {
        if (!empty($value) && ($value != $this->value))
            $this->value = $value;
    }

    public function compute() {
        return $this->weight * $this->value;
    }
}