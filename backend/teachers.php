<?php 
header('Content-Type: application/json');
require_once "inc/db.php";
require_once "inc/DatabaseHelper.php";
$school_id = $_GET['school_id'];
if (!isset($school_id)){
    header("HTTP/1.1 400 BAD REQUEST");

    echo json_encode([
        "message" => "Include school_id as a get param"
    ]);

    exit ;
}
$database = new Database();
$orm = new DatabaseHelper($database);
$school = $orm->selectColumnsWhere('Users', ['school_name', 'ref_id'], 'ref_id = ?', [$school_id]);
if (!$school){
    header("HTTP/1.1 404 NOT FOUND");
    
    echo "School not found";
    exit;
};

$request_method = $_SERVER['REQUEST_METHOD'];

echo "done for ";

?>