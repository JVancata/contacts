<?php

abstract class BaseModel {
    protected static ?Database $database = null;

    public function __construct() {
        if (!$this::$database) {
            $this::$database = new Database();
        }
    }
}
