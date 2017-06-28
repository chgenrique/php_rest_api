<?php
class Connection
{
    private $conn;
    public function __construct() {
        $this->conn = new mysqli('localhost', 'root', 'root', 'company');
        
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
    
    public function getConn(){
        return $this->conn;
    }
    
    public function __destruct() {
        if($this->conn) { $this->conn->close(); }
    }
    
}

?>