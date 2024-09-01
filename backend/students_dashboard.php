<?php 
require_once "inc/db.php";
require_once "inc/DatabaseHelper.php";
$request_method = $_SERVER['REQUEST_METHOD'];
$school_id = $_GET['school_id'];

if ($request_method == 'GET' ){
    $db = new Database();
    $orm = new DatabaseHelper($db);
    $code = $_GET['logincode'];
    $first_name = $_GET['first_name'];
    $last_name = $_GET['last_name'];
    $whereClause = 'school_id = ? AND logincode = ? AND first_name = ? AND last_name = ?';
    $parsms = [$school_id,$code,$first_name,$last_name];
    $object = $orm->selectWhere("Students",$whereClause,$parsms);
    if (!$object){
        header("HTTP/1.1 404 bad Not found");

			echo json_encode([
				"status" => "error",
				"message" => "No student match the query",
			]);
			exit;
    }
    $response = array_slice($object, 0, 1)[0];
		echo json_encode([
			"status" => "success",
			"message" => "Student retrieved successfully",
			"data" => $response,
		]);
	exit;


}
?>