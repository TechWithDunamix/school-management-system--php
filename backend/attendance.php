<?php

header('Content-Type: application/json');
require_once "inc/db.php";
require_once "inc/DatabaseHelper.php";
include "inc/auth.php";
$school_id = $_GET['school_id'];
$database = new Database();
$orm = new DatabaseHelper($database);

// Validate School
$school = $orm->selectColumnsWhere('Users', ['school_name', 'ref_id'], 'ref_id = ?', [$school_id]);
if (!$school) {
    header("HTTP/1.1 404 NOT FOUND");
    echo json_encode([
        "status" => "error",
        "message" => "School not found"
    ]);
    exit;
}

$request_method = $_SERVER['REQUEST_METHOD'];

switch ($request_method) {
    case 'GET':
        handleGetRequests($orm, $school_id);
        break;

    case 'POST':
        handlePostRequest($orm, $school_id);
        break;

    case 'PATCH':
        handlePatchRequest($orm, $school_id);
        break;

    case 'DELETE':
        handleDeleteRequest($orm, $school_id);
        break;

    default:
        header("HTTP/1.1 405 METHOD NOT ALLOWED");
        echo json_encode([
            "status" => "error",
            "message" => "Method not allowed"
        ]);
        exit;
}

function handleGetRequests($orm, $school_id) {
    if (isset($_GET['student_id'])) {
        $student_id = $_GET['student_id'];
        $whereClause = 'school_id = ? AND student_id = ?';
        $params = [$school_id, $student_id];
        if (isset($_GET['date'])) {
            $date = $_GET['date'];
            $whereClause .= ' AND date = ?';
            $params[] = $date;
        }
        $attendance = $orm->selectWhere('attendance', $whereClause, $params);
        if (!$attendance) {
            header("HTTP/1.1 404 Not Found");
            echo json_encode([
                "status" => "error",
                "message" => "No attendance records found for the student"
            ]);
            exit;
        }
        echo json_encode($attendance);
        exit;
    }

    if (isset($_GET['class_id'])) {
        $class_id = $_GET['class_id'];
        $whereClause = 'school_id = ? AND class_id = ?';
        $params = [$school_id, $class_id];
        if (isset($_GET['date'])) {
            $date = $_GET['date'];
            $whereClause .= ' AND date = ?';
            $params[] = $date;
        }
        $attendance = $orm->selectWhere('attendance', $whereClause, $params);
        if (!$attendance) {
            header("HTTP/1.1 404 Not Found");
            echo json_encode([
                "status" => "error",
                "message" => "No attendance records found for the class"
            ]);
            exit;
        }
        echo json_encode($attendance);
        exit;
    }

    if (isset($_GET['date'])) {
        $date = $_GET['date'];
        $whereClause = 'school_id = ? AND date = ?';
        $params = [$school_id, $date];
        $attendance = $orm->selectWhere('attendance', $whereClause, $params);
        if (!$attendance) {
            header("HTTP/1.1 404 Not Found");
            echo json_encode([
                "status" => "error",
                "message" => "No attendance records found for the date"
            ]);
            exit;
        }
        echo json_encode($attendance);
        exit;
    }

    $attendance = $orm->selectWhere('attendance', 'school_id = ?', [$school_id]);
    echo json_encode($attendance);
    exit;
}

function handlePostRequest($orm, $school_id) {
    $rawPostData = file_get_contents("php://input");
    $postdata = json_decode($rawPostData, true);
    $errors = [];

    if (!isset($postdata['class_id'])) {
        $errors['class_id'] = 'Class ID is a required field';
    }
    if (!isset($postdata['student_id'])) {
        $errors['student_id'] = 'Student ID is a required field';
    }
    if (!isset($postdata['date'])) {
        $errors['date'] = 'Date is a required field';
    }
    if (!isset($postdata['session'])) {
        $errors['session'] = 'Session is a required field';
    }
    if (!isset($postdata['state'])) {
        $errors['state'] = 'Attendance state is a required field';
    }
    if ($errors) {
        header("HTTP/1.1 400 BAD REQUEST");
        echo json_encode([
            "status" => "error",
            "message" => "Validation Failed",
            "errors" => $errors
        ]);
        exit;
    }

    $data = [
        "class_id" => $postdata['class_id'],
        "student_id" => $postdata['student_id'],
        "school_id" => $school_id,
        "date" => $postdata['date'],
        "session" => $postdata['session'],
        "state" => $postdata['state']
    ];

    $orm->insert('attendance', $data);
    echo json_encode([
        "status" => "success",
        "message" => "Attendance record created successfully",
        "data" => $data
    ]);
    exit;
}

function handlePatchRequest($orm, $school_id) {
    $rawPatchData = file_get_contents("php://input");
    $patchdata = json_decode($rawPatchData, true);

    if (isset($_GET['student_id']) && isset($_GET['date']) && isset($_GET['session'])) {
        $student_id = $_GET['student_id'];
        $date = $_GET['date'];
        $session = $_GET['session'];
        $whereClause = 'school_id = ? AND student_id = ? AND date = ? AND session = ?';
        $params = [$school_id, $student_id, $date, $session];
        $attendance = $orm->selectWhere('attendance', $whereClause, $params);

        if (!$attendance) {
            header("HTTP/1.1 404 Not Found");
            echo json_encode([
                "status" => "error",
                "message" => "No attendance record found for the specified parameters"
            ]);
            exit;
        }

        $obj = $attendance[0];
        foreach ($obj as $key => &$value) {
            if (isset($patchdata[$key])) {
                $value = $patchdata[$key];
            }
        }

        $orm->update('attendance', $obj, $whereClause, $params);
        echo json_encode([
            "status" => "success",
            "message" => "Attendance record updated successfully",
            "data" => $obj
        ]);
        exit;
    } else {
        header("HTTP/1.1 400 BAD REQUEST");
        echo json_encode([
            "status" => "error",
            "message" => "Set student_id, date, and session as GET parameters"
        ]);
        exit;
    }
}

function handleDeleteRequest($orm, $school_id) {
    if (isset($_GET['student_id']) && isset($_GET['date']) && isset($_GET['session'])) {
        $student_id = $_GET['student_id'];
        $date = $_GET['date'];
        $session = $_GET['session'];
        $whereClause = 'school_id = ? AND student_id = ? AND date = ? AND session = ?';
        $params = [$school_id, $student_id, $date, $session];
        $attendance = $orm->selectWhere('attendance', $whereClause, $params);

        if (!$attendance) {
            header("HTTP/1.1 404 Not Found");
            echo json_encode([
                "status" => "error",
                "message" => "No attendance record found for the specified parameters"
            ]);
            exit;
        }

        $obj = $attendance[0];
        $orm->delete('attendance', "student_id = ? AND date = ? AND session = ?", [$student_id, $date, $session]);
        echo json_encode([
            "status" => "success",
            "message" => "Attendance record deleted successfully",
            "data" => $obj
        ]);
        exit;
    } else {
        header("HTTP/1.1 400 BAD REQUEST");
        echo json_encode([
            "status" => "error",
            "message" => "Set student_id, date, and session as GET parameters"
        ]);
        exit;
    }
}
?>
