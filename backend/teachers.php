<?php

header('Content-Type: application/json');
require_once "inc/db.php";
require_once "inc/DatabaseHelper.php";
$school_id = $_GET['school_id'];
$database = new Database();
$orm = new DatabaseHelper($database);
$school = $orm->selectColumnsWhere('Users', ['school_name', 'ref_id'], 'ref_id = ?', [$school_id]);
if (!$school){
    header("HTTP/1.1 404 NOT FOUND ");
    echo "School not found";
    exit;
}

$request_method = $_SERVER['REQUEST_METHOD'];
if ($request_method == 'GET'){
    $database = new Database();
    $orm = new DatabaseHelper($database);
    if (isset($_GET['teacher_id'])){
        $teacher_id = $_GET['teacher_id'];
        $whereClause = 'school_id = ? AND id = ?';
        $params = [
            $school_id,
            $teacher_id
        ];
        $teacher = $orm->selectWhere('Teachers', $whereClause, $params);
        if (!$teacher){
            header("HTTP/1.1 404 Not Found");
            echo json_encode([
                "error" => true,
                "message" => "No teacher matches the query"
            ]);
            exit;
        }
        $response = array_slice($teacher, 0, 1);
        echo json_encode($response[0]);
        exit;
    }
    
    $teachers = $orm->selectWhere('Teachers', 'school_id = ?', [$school_id]);
    echo json_encode($teachers);
    exit;
}

if ($request_method === 'POST'){
    $rawPostData = file_get_contents("php://input");
    $postdata = json_decode($rawPostData, true);
    $errors = [];
    if (!isset($postdata['first_name'])){
        $errors['first_name'] = 'Teacher first name is a required field';
    }
    if (!isset($postdata['last_name'])){
        $errors['last_name'] = 'Teacher last name is a required field';
    }
    if (!isset($postdata['email'])){
        $errors['email'] = 'Email is a required field';
    }
    
    if (!isset($postdata['phone'])){
        $errors['phone'] = 'Phone number is a required field';
    }
    if (!isset($postdata['gender'])){
        $errors['gender'] = 'Gender is a required field';
    }
    if (!isset($postdata['date_of_birth'])){
        $errors['date_of_birth'] = 'Date of birth is a required field';
    }
    if ($errors){
        header("HTTP/1.1 400 BAD REQUEST");
        echo json_encode($errors);
        exit;
    }
    $date = new DateTime($postdata['date_of_birth']);

    $formattedDate = $date->format('Y/m/d');
    $database = new Database();
    $orm = new DatabaseHelper($database);
    $whereClause = 'school_id = ? AND email = ?';
        $params = [
            $school_id,
            $postdata['email']
        ];
    $teacher = $orm->selectWhere('Teachers', $whereClause, $params);
    if ($teacher){
        header("HTTP/1.1 400 BAD REQUEST");
        echo "Teacher already exists";
        exit ;
    }
    $data = [
        "id" => bin2hex(random_bytes(16)),
        'first_name' => $postdata['first_name'],
        'last_name' => $postdata['last_name'],
        'gender' => $postdata['gender'],
        'email' => $postdata['email'],
        'phone' => $postdata['phone'],
        'date_of_birth' => $formattedDate,
        'school_id' => $school_id,
        "class" => $postdata['class'],
        "religion" => $postdata['religion'],
        "blood_group" => $postdata['blood_group'],

    ];
    $database = new Database();
    $orm = new DatabaseHelper($database);
    $orm->insert("Teachers", $data);

    echo json_encode($data);
    exit;
}

if ($request_method == 'PATCH'){
    $rawPatchData = file_get_contents("php://input");
    $patchdata = json_decode($rawPatchData, true);
    if (isset($_GET['teacher_id'])){
        $teacher_id = $_GET['teacher_id'];
        $whereClause = 'school_id = ? AND id = ?';
        $params = [
            $school_id,
            $teacher_id
        ];
        $teacher = $orm->selectWhere('Teachers', $whereClause, $params);
        if (!$teacher){
            header("HTTP/1.1 404 Not Found");
            echo json_encode([
                "error" => true,
                "message" => "No teacher matches the query"
            ]);
            exit;
        }
        
        $obj = $teacher[0];
        foreach ($obj as $key => &$value) {
            if (isset($patchdata[$key])) {
                $value = $patchdata[$key];
            }
        }
        $date = new DateTime($obj['date_of_birth']);
        $formattedDate = $date->format('Y/m/d');
        $obj['date_of_birth'] = $formattedDate;

        unset($obj['id']);
        unset($obj['school_id']);
        $orm->update('Teachers', $obj, $whereClause, $params);
        echo json_encode($obj);
        exit;
    } else {
        echo "Set teacher_id as a GET param";
        exit;
    }
}

if ($request_method == 'DELETE'){
    if (isset($_GET['teacher_id'])){
        $teacher_id = $_GET['teacher_id'];
        $whereClause = 'school_id = ? AND id = ?';
        $params = [
            $school_id,
            $teacher_id
        ];
        $teacher = $orm->selectWhere('Teachers', $whereClause, $params);
        if (!$teacher){
            header("HTTP/1.1 404 Not Found");
            echo json_encode([
                "error" => true,
                "message" => "No teacher matches the query"
            ]);
            exit;
        }
        
        $orm->delete('Teachers', "id = ?", [$teacher_id]);
        echo json_encode($teacher);
        exit;
    } else {
        echo "Set teacher_id as a GET param";
        exit;
    }
}
?>
