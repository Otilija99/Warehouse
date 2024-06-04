<?php

namespace Warehouse\Utilities;

class FileStorage {
    private $file;

    public function __construct($file) {
        $this->file = $file;
    }

    public function read() {
        if (!file_exists($this->file)) {
            return [];
        }
        $content = file_get_contents($this->file);
        return json_decode($content, true);
    }

    public function write($data) {
        file_put_contents($this->file, json_encode($data, JSON_PRETTY_PRINT));
    }
}
