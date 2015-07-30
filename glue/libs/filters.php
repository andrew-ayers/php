<?php namespace MyFramework;

class Filters {
    private $filter = FILTER_SANITIZE_STRING;

    public function __construct($filter = NULL) {
    }

    public function set_filter($filter = NULL) {
        if (isset($filter))
            $this->filter = $filter;
    }

    public function get_filter() {
        return $this->filter;
    }

    public function filter_var($data = NULL, $filter = NULL, $options = NULL) {
        if (isset($filter))
            $this->filter = $filter;

        return filter_var($data, $this->filter);
    }

    public function filter_array($data = NULL, $filter = NULL, $options = NULL) {
        if (isset($filter))
            $this->filter = $filter;

        return filter_var_array($data, $this->filter);
    }

    public function filter_post($field = NULL, $filter = NULL, $options = NULL) {
        if (!isset($filter))
            $this->filter = $filter;

        return filter_input(INPUT_POST, $field, $this->filter, $options);
    }

    public function filter_cookie($field = NULL, $filter = NULL, $options = NULL) {
        if (!isset($filter))
            $this->filter = $filter;

        return filter_input(INPUT_COOKIE, $field, $this->filter, $options);
    }
}