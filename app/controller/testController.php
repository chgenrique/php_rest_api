<?php

require_once 'model/departmentModel.php';
require_once 'model/memberModel.php';

class testController
{
    private $dptoModelInstance;
    private $memberModelInstance;
    private $urlInitialData;


    public function __construct() {
        $this->dptoModelInstance = new departmentModel();
        $this->memberModelInstance = new memberModel();
        $this->urlInitialData = "http://localhost/php_rest_api/api.php";
    }
    
    public function getInitialData(){
        $departmentsUrl = $this->urlInitialData;
        $departmentsJson = file_get_contents($departmentsUrl);
	$departmentsArray = json_decode($departmentsJson);
        if(count($departmentsArray)){
            foreach($departmentsArray as $element){
                $this->dptoModelInstance->setId($element->id); 
                $this->dptoModelInstance->setName($element->name); 
                $this->dptoModelInstance->addDepartment();
            }
        }
        return $this->getAllDepartments();
    }
    
    private function getAllDepartments(){
        $dptos = $this->dptoModelInstance->getAllDepartments();
        return $dptos;
    }
    
    public function addOffice($office){
        if($this->dptoModelInstance->setNextId()){
            $this->dptoModelInstance->setName($office); 
            $res = $this->dptoModelInstance->addDepartment();
            if($res) { return $this->getAllDepartments(); }
            return false; // If any problem
        } else
            return false;
    }
    
    public function deleteOffices($dptoIds){
        $membersInDpto = $this->memberModelInstance->getMemberByDepartament($dptoIds);
        $memberIds = array();
        foreach ($membersInDpto as $member){
            $memberIds[]=$member[0];
        }
        $this->memberModelInstance->deleteMembers($memberIds);
        $res = $this->dptoModelInstance->deleteDepartments($dptoIds);
        return $res;
    }
    
    public function addMember($memberName,$departmentId,$hireDate){
        $this->memberModelInstance->setMemberName($memberName);
        $this->memberModelInstance->setDepartamentId($departmentId);
        $this->memberModelInstance->setDateHire($hireDate);
        $this->memberModelInstance->addMember();
        return $this->getAllMembers();
    }
    
    private function getAllMembers(){
        $members = $this->memberModelInstance->getAllMembers();
        return $members;
    }
    
    public function deleteMembers($memberIds){
        $res = $this->memberModelInstance->deleteMembers($memberIds);
        return $res;
    }
    
}

