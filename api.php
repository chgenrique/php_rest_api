<?php
require_once 'functionsApi.php';

$method = $_SERVER['REQUEST_METHOD'];
$apiDpto = new restApiDpto();

switch ($method) {
    case 'GET': 
    if(isset($_GET["department_id"]) && !empty($_GET["department_id"])) 
    { 
        $department_id=$_GET["department_id"]; 
        $apiDpto->get_departments($department_id); 
    }else { $apiDpto->get_departments(); } 
    break; 
    case 'POST':
        $apiDpto->add_department(); 
        break;
    case 'PUT': 
        parse_str(file_get_contents("php://input"),$post_vars);
        $apiDpto->update_department($post_vars);
        break; 
    case 'DELETE':
        $post_vars = json_decode(file_get_contents("php://input"));
        $department_id = isset($post_vars) ? $post_vars->department_id : false;
        if(!$department_id){
           $department_id= isset($_GET["department_id"]) ? $_GET["department_id"] : false;
        }
        $apiDpto->delete_department($department_id); 
        break; 
    default:
        header("HTTP/1.0 405 Method Not Allowed"); 
        break;
}