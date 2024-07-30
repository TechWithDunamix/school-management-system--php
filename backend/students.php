<?php

header('Content-Type: application/json');
require_once "inc/db.php";
require_once "inc/DatabaseHelper.php";
$school_id = $_GET['school_id'];
$database = new Database();
$orm = new DatabaseHelper($database);
$school = $orm->selectColumnsWhere('Users', ['school_name', 'ref_id'], 'ref_id = ?', [$school_id]);
if (!$school){
    header("HTTP/1.1 404 bad BAD REQUEST");
    
    echo "School not found";
    exit;
};
$orm;
$request_method = $_SERVER['REQUEST_METHOD'];
if ($request_method === 'POST'){
    $errors = [];
    if (!isset($_POST['first_name'])){
        $errors['first_name'] = 'Student first name is a required field';
    };
    if (!isset($_POST['last_name'])){
        $errors['last_name'] = 'Student last name is a required field';
    };
    

    if (!isset($_POST['parent_phone'])){
        $errors['parent_phone'] = 'Student parent phone is a required field';
    };
    if (!isset($_POST['parent_full_name'])){
        $errors['parent_full_name'] = 'Student  Parent full name is a required field';
    };
    if (!isset($_POST['age'])){
        $errors['age'] = 'Student age is a required field';
    };
    if (!isset($_POST['class'])){
        $errors['class'] = 'Student  class is a required field';
    };
    if (!isset($_POST['date_of_birth'])){
        $errors['date_of_birth'] = 'Student  class is a required field';
    };
    if ($errors){
        header("HTTP/1.1 400  BAD REQUEST");

        echo json_encode($errors);
        exit ;
    };

    $data = [
        "id" => bin2hex(random_bytes(16)),
        'full_name' => $_POST['full_name'],
        'last_name' => $_POST['last_name'],
        'gender' => $_POST['gender'],
        'age' => intval($_POST['age']),
        'parent_phone' => $_POST['parent_phone'],
        'parent_full_name' => $_POST['parent_full_name'],
        'class' => $_POST['class'],
        'date_of_birth' => $_POST['date_of_birth']


    ];
    


};


?>