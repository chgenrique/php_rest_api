<?php

require_once 'app/model/connection.php';

class restApi
{
    protected $conn;
    protected $code = 200;
    
    public function __construct() {
        $this->conn = new Connection();
    }
    
    public function response($status, $message = null){
        $this->code = ($status)?$status:200;
        if($message) { $response=array( 'status' => $this->code, 'status_message' => $message ); }
        else { $response=array( 'status' => $this->code, 'status_message' => $this->get_status_message() ); }
        header('Content-Type: application/json'); 
        echo json_encode($response);
    }

    private function get_status_message(){
        $status = array(
                    100 => 'Continue',  
                    101 => 'Switching Protocols',  
                    200 => 'OK',
                    201 => 'Created',  
                    202 => 'Accepted',  
                    203 => 'Non-Authoritative Information',  
                    204 => 'No Content',  
                    205 => 'Reset Content',  
                    206 => 'Partial Content',  
                    300 => 'Multiple Choices',  
                    301 => 'Moved Permanently',  
                    302 => 'Found',  
                    303 => 'See Other',  
                    304 => 'Not Modified',  
                    305 => 'Use Proxy',  
                    306 => '(Unused)',  
                    307 => 'Temporary Redirect',  
                    400 => 'Bad Request',  
                    401 => 'Unauthorized',  
                    402 => 'Payment Required',  
                    403 => 'Forbidden',  
                    404 => 'Not Found',  
                    405 => 'Method Not Allowed',  
                    406 => 'Not Acceptable',  
                    407 => 'Proxy Authentication Required',  
                    408 => 'Request Timeout',  
                    409 => 'Conflict',  
                    410 => 'Gone',  
                    411 => 'Length Required',  
                    412 => 'Precondition Failed',  
                    413 => 'Request Entity Too Large',  
                    414 => 'Request-URI Too Long',  
                    415 => 'Unsupported Media Type',  
                    416 => 'Requested Range Not Satisfiable',  
                    417 => 'Expectation Failed',  
                    500 => 'Internal Server Error',  
                    501 => 'Not Implemented',  
                    502 => 'Bad Gateway',  
                    503 => 'Service Unavailable',  
                    504 => 'Gateway Timeout',  
                    505 => 'HTTP Version Not Supported');
        return ($status[$this->code])?$status[$this->code]:$status[500];
    }
}


class restApiDpto extends restApi
{
    
    function get_departments($departmentId = null){
        $res = array(); 
        $sql="SELECT * FROM department";
        if($departmentId != null) 
            { 
               $sql.=" WHERE id=$departmentId"; 
            } 
            $result= $this->conn->getConn()->query($sql); 
            while($row = $result->fetch_assoc()) {
                $res[]=$row;
            }
            header('Content-Type: application/json'); 
            echo json_encode($res);
    }

    function add_department(){
        
        $pName = false;

        //parse_str(file_get_contents("php://input"),$post_vars);
        
        $post_vars = json_decode(file_get_contents("php://input"));
        $pName = isset($post_vars) ? $post_vars->department_name : false;
        if(!$pName){
           $pName = isset($_POST['department_name']) ? $_POST['department_name'] : false; 
        }

        $pId = 0;
        $sql = "SELECT max(id) as id FROM department";
        $res = $this->conn->getConn()->query($sql);
        if ($res->num_rows > 0) {
            while($row = $res->fetch_assoc()) {
                $pId = $row['id']+1;
            }
        }
        $status = 417; // Expectation failed
        $message = null;
        if($pName && $pId){
            $sql = "INSERT INTO department (id,name) VALUES ($pId,'$pName')";
            if ($this->conn->getConn()->query($sql) === TRUE) {
                $status = 200;
                $message = 'Department Added Successfully.';
            }
        }
        return $this->response($status, $message);
    }
    
    function update_department($arguments){
      
        $status = 204;
        $departmentId = $arguments['department_id'];
        if($arguments['department_id']){
            $departmentName = $arguments['department'];
            $sql = "UPDATE department SET name = '$departmentName' WHERE id = $departmentId";
            if ($this->conn->getConn()->query($sql) === TRUE) {
                $status = 200;
            }else{
                $status = 304;
            }
        }
        return $this->response($status);
    }

    function delete_department($departmentId){
        $status = 204;
        if($departmentId)
        {
            $sql = "DELETE FROM department WHERE id = $departmentId";
            if ($this->conn->getConn()->query($sql) === TRUE) {
                $status = 200;
            }else{
                $status = 304;
            }
        }
        return $this->response($status);
    }
    
}