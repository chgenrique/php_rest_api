<?php

class memberModel extends baseModel {
    private $departamentId;
    private $memberName;
    private $dateHire;
    
    function getDepartamentId() {
        return $this->departamentId;
    }

    function getMemberName() {
        return $this->memberName;
    }

    function getDateHire() {
        return $this->dateHire;
    }

    function setDepartamentId($departamentId) {
        $this->departamentId = $departamentId;
    }

    function setMemberName($memberName) {
        $this->memberName = $memberName;
    }

    function setDateHire($dateHire) {
        $this->dateHire = $dateHire;
    }
    
    public function addMember(){
        $departmentId = $this->getDepartamentId();
        $memberName = $this->getMemberName();
        $dateHire = $this->getDateHire();
        
        if($memberName && $departmentId){
            $sql = "INSERT INTO staff_member (departament_id,member_name,date_hire) VALUES ($departmentId,'$memberName','$dateHire')";
            if ($this->conn->getConn()->query($sql) === TRUE) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }
    
    public function getMemberByDepartament($departamentIds){
        $dptoIds = implode(",", $departamentIds);
        $sql = "SELECT id, member_name, date_hire FROM staff_member where departament_id in (".$dptoIds.")";
        $result = array();
        $res = $this->conn->getConn()->query($sql);
        if ($res->num_rows > 0) {
            while($row = $res->fetch_assoc()) {
                $result[] = array($row["id"],$row["member_name"],$row["date_hire"]);
            }
        }
        return $result;
    }
    
    public function getAllMembers(){
        $sql = "SELECT staff_member.id, staff_member.member_name, department.name as dpto, staff_member.date_hire FROM department, staff_member where staff_member.departament_id = department.id order by staff_member.id asc";
        $result = array();
        $res = $this->conn->getConn()->query($sql);
        if ($res->num_rows > 0) {
            while($row = $res->fetch_assoc()) {
                $result[] = array($row["id"],$row["member_name"],$row["dpto"],$row["date_hire"]);
            }
        }
        return $result;
    }
    
    public function deleteMembers($ids){
        $memberIds = implode(",", $ids);
        $sql = "DELETE FROM staff_member WHERE id in (".$memberIds.")";
        if ($this->conn->getConn()->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }
    
    
}
