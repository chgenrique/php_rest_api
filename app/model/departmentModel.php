<?php

require_once 'baseModel.php';

class departmentModel extends baseModel{
    
    private $name;
    private $id;
    
    function getName() {
        return $this->name;
    }

    function getId() {
        return $this->id;
    }

    function setName($pname) {
        $this->name = $pname;
    }

    function setId($pid) {
        $this->id = $pid;
    }
    
    function setNextId(){
        $sql = "SELECT max(id) as id FROM department";
        $res = $this->conn->getConn()->query($sql);
        if ($res->num_rows > 0) {
            while($row = $res->fetch_assoc()) {
                $this->id = $row['id']+1;
                return $row['id']+1;
            }
        }
        return false;
    }

    public function addDepartment(){
        $pName = $this->getName();
        $pId = $this->getId();
        if($pName && $pId){
            $sql = "INSERT INTO department (id,name) VALUES ($pId,'$pName')";
            if ($this->conn->getConn()->query($sql) === TRUE) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }
    
    public function getAllDepartments(){
        $sql = "SELECT id, name FROM department order by id asc";
        $result = array();
        $res = $this->conn->getConn()->query($sql);
        if ($res->num_rows > 0) {
            while($row = $res->fetch_assoc()) {
                $result[] = array($row["id"],$row["name"]);
            }
        }
        return $result;
    }
    
    public function deleteDepartments($ids){
        $dptoIds = implode(",", $ids);
        $sql = "DELETE FROM department WHERE id in (".$dptoIds.")";
        if ($this->conn->getConn()->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }
   
        
}
