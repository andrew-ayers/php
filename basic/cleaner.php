<?php

class Cleaner {
    private $ops;

    private $array;

    public function __construct($data) {
        $this->ops = explode(',', OPERATORS);

        $this->clean($data);
    }

    private function clean($data) {
        $this->lowercase_and_split($data);
        $this->remove_all_comments();
        $this->scrub_whitespace();
        $this->remove_line_delims();
    }

    public function get() {
        return $this->array;
    }

    private function lowercase_and_split($data) {
        $this->array = explode("\n", strtolower($data));
    }

    private function remove_all_comments() {
        $array = array();

        foreach ($this->array as $item) {
            if (substr($item, 0, 2) != '//' && substr($item, 0, 3) != 'rem') {
                $array[] = $item;
            }
        }

        $this->array = $array;
    }

    private function remove_line_delims() {
        foreach ($this->array as &$item) {
            $item = str_replace(';', '', $item);
        }
    }

    private function scrub_whitespace() {
        $array = array();

        foreach ($this->array as $item) {
            $item = rtrim(ltrim($item));

            if (!empty($item)) {
                foreach ($this->ops as $op) {
                    $item = str_replace(" {$op} ", $op, $item);
                }

                $array[] = $item;
            }
        }

        $this->array = $array;
    }
}