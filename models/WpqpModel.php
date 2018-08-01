<?php

class WpqpModelNoIdentityException extends Exception {}

class WpqpModel {
    protected $db;

    protected function __construct() {
        global $wpdb;
        $this->db =& $wpdb;
    }

    public function getIdentity() {
        throw new WpqpModelNoIdentityException();
    }
}