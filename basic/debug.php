<?php

class Debug extends Exception {
    private $dump;

    public function __construct($code = 0, $message, $dump = null) {
        if (!empty($dump))
            $this->dump = $dump;

        parent::__construct($message, $code, null);
    }

    public function getDebug() {
        $message = 'DEBUG: ' . $this->getCode() . ' - ' . $this->getMessage() . "\nLOCATION: " . $this->getFile() . ' @ Line ' . $this->getLine() . "\n";

        if (!empty($this->dump))
            $message .= "DUMP:\n\n" . print_r($this->dump, true) . "\n";

        return $message;
    }
}