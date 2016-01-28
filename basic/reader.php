<?php

class Reader {
    private $data;

    public function __construct($filename) {
        try {
            $this->read($filename);
        }
        catch (Exception $e) {
            throw $e;
        }
    }

    public function get() {
        return $this->data;
    }

    private function read($filename) {
        if (!file_exists($filename)) throw new Exception('Invalid filename: ' . $filename);

        try {
            $this->data = file_get_contents($filename);
        }
        catch (Exception $e) {
            throw new Exception('Unable to load file: ' . $e->getMessage());
        }

        if (empty($this->data)) throw new Exception('File empty or invalid.');
    }
}