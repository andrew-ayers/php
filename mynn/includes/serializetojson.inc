<?php

abstract class SerializeToJson implements JsonSerializable {
    public function jsonSerialize() {
        $vars = get_object_vars($this);

        return $vars;
    }
}