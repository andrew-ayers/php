<?php
class Output {
    private $value;

    public function __construct($value = 0) {
        $this->set_value($value);

        return $this;
    }

    public function get() {
        return $this;
    }

    public function set_value($value = null) {
        if (!empty($value) && ($value != $this->value))
            $this->value = $value;
    }
}