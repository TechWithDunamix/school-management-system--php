<?php

header('Content-Type: application/json');
require_once "inc/db.php";
require_once "inc/DatabaseHelper.php";
include "inc/auth.php";
$school_id = $_GET['school_id'];
$database = new Database();
$orm = new DatabaseHelper($database);

// Check if school exists
$school = $orm->selectColumnsWhere('Users', ['school_name', 'ref_id'], 'ref_id = ?', [$school_id]);
if (!$school) {
    header("HTTP/1.1 404 NOT FOUND ");
    echo json_encode([
        "status" => "error",
        "message" => "School not found",
    ]);
    exit;
}

$request_method = $_SERVER['REQUEST_METHOD'];

if ($request_method == 'GET') {
    // Get all subjects
    if (!isset($_GET['subject_id'])) {
        $subjects = $orm->selectWhere('subjects', 'school_id = ?', [$school_id]);
        echo json_encode([
            "status" => "success",
            "message" => "All subjects retrieved successfully",
            "data" => $subjects,
        ]);
        exit;
    }

    // Get a specific subject
    if (isset($_GET['subject_id'])) {
        $subject_id = $_GET['subject_id'];
        $whereClause = 'school_id = ? AND subject_id = ?';
        $params = [$school_id, $subject_id];
        $subject = $orm->selectWhere('subjects', $whereClause, $params);
        if (!$subject) {
            header("HTTP/1.1 404 Not Found");
            echo json_encode([
                "status" => "error",
                "message" => "No subject found",
            ]);
            exit;
        }
        echo json_encode([
            "status" => "success",
            "message" => "Subject retrieved successfully",
            "data" => $subject[0],
        ]);
        exit;
    }
}

if ($request_method === 'POST') {
    $rawPostData = file_get_contents("php://input");
    $postdata = json_decode($rawPostData, true);
    $errors = [];

    // Validate required fields
    if (!isset($postdata['subject_name'])) {
        $errors['subject_name'] = 'Subject name is a required field';
    }
    if (!isset($postdata['class_id'])) {
        $errors['class_id'] = 'Class ID is a required field';
    }
    if ($errors) {
        header("HTTP/1.1 400 BAD REQUEST");
        echo json_encode([
            "status" => "error",
            "message" => "Validation Failed",
            "errors" => $errors,
        ]);
        exit;
    }

    $data = [
        'subject_name' => $postdata['subject_name'],
        'class_id' => $postdata['class_id'],
        'school_id' => $school_id,
    ];
    
    $orm->insert('subjects', $data);
    echo json_encode([
        "status" => "success",
        "message" => "Subject created successfully",
        "data" => $data,
    ]);
    exit;
}

if ($request_method == 'PATCH') {
    $rawPatchData = file_get_contents("php://input");
    $patchdata = json_decode($rawPatchData, true);
    $errors = [];
    
    if (isset($_GET['subject_id'])) {
        $subject_id = $_GET['subject_id'];
        $whereClause = 'school_id = ? AND subject_id = ?';
        $params = [$school_id, $subject_id];
        $subject = $orm->selectWhere('subjects', $whereClause, $params);
        if (!$subject) {
            header("HTTP/1.1 404 Not Found");
            echo json_encode([
                "status" => "error",
                "message" => "No subject found",
            ]);
            exit;
        }

        $obj = $subject[0];
        foreach ($obj as $key => &$value) {
            if (isset($patchdata[$key])) {
                $value = $patchdata[$key];
            }
        }
        
        unset($obj['school_id']);
        $orm->update('subjects', $obj, $whereClause, $params);
        echo json_encode([
            "status" => "success",
            "message" => "Subject updated successfully",
            "data" => $obj,
        ]);
        exit;

    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Set subject_id as a GET parameter",
        ]);
        exit;
    }
}

if ($request_method == 'DELETE') {
    if (isset($_GET['subject_id'])) {
        $subject_id = $_GET['subject_id'];
        $whereClause = 'school_id = ? AND subject_id = ?';
        $params = [$school_id, $subject_id];
        $subject = $orm->selectWhere('subjects', $whereClause, $params);
        if (!$subject) {
            header("HTTP/1.1 404 Not Found");
            echo json_encode([
                "status" => "error",
                "message" => "No subject found",
            ]);
            exit;
        }

        $obj = $subject[0];
        $orm->delete('subjects', "subject_id = ?", [$obj['subject_id']]);
        echo json_encode([
            "status" => "success",
            "message" => "Subject deleted successfully",
            "data" => $obj,
        ]);
        exit;

    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Set subject_id as a GET parameter",
        ]);
        exit;
    }
}
?>
