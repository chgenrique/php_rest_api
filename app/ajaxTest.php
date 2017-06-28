<?php

require_once 'controller/testController.php';
$controller = new testController();

if(isset($_GET['operation']) && $_GET['operation']=='getInitialData')
{
    $initialData = $controller->getInitialData();
    echo json_encode($initialData);
}

if(isset($_POST['operation']) && $_POST['operation']=='addOffice')
{
    $result = $controller->addOffice($_POST['office']);
    echo json_encode($result);
}

if(isset($_POST['operation']) && $_POST['operation']=='deleteDpto')
{
    $result = $controller->deleteOffices($_POST['dptoToDelete']);
    $r = null;
    if($result) $r = 'ok'; 
    echo json_encode(array('status'=>$r));
}

if(isset($_POST['operation']) && $_POST['operation']=='addMember')
{
    $result = $controller->addMember($_POST['memberName'],$_POST['departmentId'],$_POST['hireDate']);
    echo json_encode($result);
}

if(isset($_POST['operation']) && $_POST['operation']=='deleteMember')
{
    $result = $controller->deleteMembers($_POST['memberToDelete']);
    $r = null;
    if($result) $r = 'ok'; 
    echo json_encode(array('status'=>$r));
}

?>