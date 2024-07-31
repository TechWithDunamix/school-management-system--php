<?php

header('Content-Type: application/json');
require_once "inc/db.php";
require_once "inc/DatabaseHelper.php";
$school_id = $_GET['school_id'];
$database = new Database();
$orm = new DatabaseHelper($database);
$school = $orm->selectColumnsWhere('Users', ['school_name', 'ref_id'], 'ref_id = ?', [$school_id]);
if (!$school){
    header("HTTP/1.1 400 bad BAD REQUEST");
    
    echo "School not found";
    exit;
};

$request_method = $_SERVER['REQUEST_METHOD'];
if ($request_method == 'GET'){
    $database = new Database();
    $orm = new DatabaseHelper($database);
    $students = $orm->selectWhere('Students', 'school_id = ?', [$school_id]);
    echo  json_encode($students);

};
if ($request_method === 'POST'){
    $rawPostData = file_get_contents("php://input");
    $postdata = json_decode($rawPostData,true);
    $errors = [];
    if (!isset($postdata['first_name'])){
        $errors['first_name'] = 'Student first name is a required field';
    };
    if (!isset($postdata['last_name'])){
        $errors['last_name'] = 'Student last name is a required field';
    };
    

    if (!isset($postdata['parent_phone'])){
        $errors['parent_phone'] = 'Student parent phone is a required field';
    };
    if (!isset($postdata['parent_full_name'])){
        $errors['parent_full_name'] = 'Student  Parent full name is a required field';
    };
    if (!isset($postdata['age'])){
        $errors['age'] = 'Student age is a required field';
    };
    if (!isset($postdata['class'])){
        $errors['class'] = 'Student  class is a required field';
    };
    if (!isset($postdata['date_of_birth'])){
        $errors['date_of_birth'] = 'Student  class is a required field';
    };
    if (!isset($postdata['gender'])){
        $errors['gender'] = 'Gender is a required field';
    };
    if ($errors){
        header("HTTP/1.1 400  BAD REQUEST");

        echo json_encode($errors);
        exit ;
    };
    $date = new DateTime($postdata['date_of_birth']);

    // Format the date as a string (e.g., 'd/m/Y' for '31/12/2006')
    $formattedDate = $date->format('Y/m/d');

    $data = [
        "id" => bin2hex(random_bytes(16)),
        'first_name' => $postdata['first_name'],
        'last_name' => $postdata['last_name'],
        'gender' => $postdata['gender'],
        'age' => intval($postdata['age']),
        'parent_phone' => $postdata['parent_phone'],
        'parent_full_name' => $postdata['parent_full_name'],
        'class' => $postdata['class'],
        'date_of_birth' => $formattedDate,
        "school_id" => $school_id


    ];
    $database = new Database();
    $orm = new DatabaseHelper($database);
    $qs = $orm->insert("Students",$data);

    echo json_encode($data);
    


};


?>