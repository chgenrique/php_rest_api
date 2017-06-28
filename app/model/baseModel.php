<?php
require_once 'connection.php';

class baseModel {
    protected $conn;
    
    public function __construct() {
        $this->conn = new Connection();
    }
}
