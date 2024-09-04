<?php

header('Content-Type: application/json');
require_once "inc/db.php";
require_once "inc/DatabaseHelper.php";
include "inc/auth.php";
$school_id = USER['ref_id'];
$database = new Database();
$orm = new DatabaseHelper($database);
$school = $orm->selectColumnsWhere('Users', ['school_name', 'ref_id'], 'ref_id = ?', [$school_id]);
if (!$school) {
	header("HTTP/1.1 404 NOT FOUND ");

	echo json_encode([
		"status" => "error",
		"message" => "School not found",
	]);
	exit;
}
;

$request_method = $_SERVER['REQUEST_METHOD'];
if ($request_method == 'GET') {
	$database = new Database();
	$orm = new DatabaseHelper($database);
	if (isset($_GET['student_id'])) {
		$student_id = $_GET['student_id'];
		$whereClause = 'school_id = ? AND id = ?';
		$params = [
			$school_id,
			$student_id,
		];
		$student = $orm->selectWhere('Students', $whereClause, $params);
		if (!$student) {
			header("HTTP/1.1 404 bad Not found");

			echo json_encode([
				"status" => "error",
				"message" => "No student match the query",
			]);
			exit;
		}
		;
		$response = array_slice($student, 0, 1)[0];
		echo json_encode([
			"status" => "success",
			"message" => "Student retrieved successfully",
			"data" => $response,
		]);
		exit;

	}
	;

	$students = $orm->selectWhere('Students', 'school_id = ?', [$school_id]);
	echo json_encode([
		"status" => "success",
		"message" => "All students retrieved successfully",
		"data" => $students,
	]);
	exit;

}
;
if ($request_method === 'POST') {
	$rawPostData = file_get_contents("php://input");
	$postdata = json_decode($rawPostData, true);
	$errors = [];
	if (!isset($postdata['first_name'])) {
		$errors['first_name'] = 'Student first name is a required field';
	}
	;
	if (!isset($postdata['last_name'])) {
		$errors['last_name'] = 'Student last name is a required field';
	}
	;

	if (!isset($postdata['parent_phone'])) {
		$errors['parent_phone'] = 'Student parent phone is a required field';
	}
	;
	if (!isset($postdata['parent_full_name'])) {
		$errors['parent_full_name'] = 'Student  Parent full name is a required field';
	}
	;
	if (!isset($postdata['age'])) {
		$errors['age'] = 'Student age is a required field';
	}
	;
	if (!isset($postdata['class'])) {
		$errors['class'] = 'Student  class is a required field';
	}
	;
	if (!isset($postdata['date_of_birth'])) {
		$errors['date_of_birth'] = 'Student  Date of birth is a required field';
	}
	;
	if (!isset($postdata['gender'])) {
		$errors['gender'] = 'Gender is a required field';
	}
	;
	if ($errors) {
		header("HTTP/1.1 400  BAD REQUEST");

		echo json_encode([
			"status" => "error",
			"message" => "Validation Failed",
			"errors" => $errors,
		]);
		exit;
	}
	;
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
		"school_id" => $school_id,
		"logincode" => bin2hex(random_bytes(6)),

	];
	$database = new Database();
	$orm = new DatabaseHelper($database);
	$qs = $orm->insert("Students", $data);

	echo json_encode([
		"status" => "success",
		"message" => "Student created successfully",
		"data" => $data,
	]);

}
;

if ($request_method == 'PATCH') {
	$rawPatchData = file_get_contents("php://input");
	$patchdata = json_decode($rawPatchData, true);
	$errors = [];
	if (isset($_GET['student_id'])) {
		$student_id = $_GET['student_id'];
		$whereClause = 'school_id = ? AND id = ?';
		$params = [
			$school_id,
			$student_id,
		];
		$student = $orm->selectWhere('Students', $whereClause, $params);
		if (!$student) {
			header("HTTP/1.1 404 bad Not found");

			echo json_encode([
				"status" => "error",
				"message" => "No student match the query",
			]);
			exit;
		}
		;

		$obj = $student[0];

		$swapped = [];
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
		$orm->update('Students', $obj, $whereClause, $params = $params);
		echo json_encode([
			"status" => "success",
			"message" => "Student updated successfully",
			"data" => $obj,
		]);
		exit;

	} else {
		echo json_encode([
			"status" => "error",
			"message" => "Set student_id as a get param",
		]);
		exit;
	}
}
if ($request_method == "DELETE") {
	$rawPatchData = file_get_contents("php://input");
	$patchdata = json_decode($rawPatchData, true);
	$errors = [];
	if (isset($_GET['student_id'])) {
		$student_id = $_GET['student_id'];
		$whereClause = 'school_id = ? AND id = ?';
		$params = [
			$school_id,
			$student_id,
		];
		$student = $orm->selectWhere('Students', $whereClause, $params);
		if (!$student) {
			header("HTTP/1.1 404  Not found");

			echo json_encode([
				"status" => "error",
				"message" => "No student match the query",
			]);
			exit;
		}
		;

		$obj = $student[0];
		$orm->delete('Students', "id = ?", [$obj['id']]);

		echo json_encode([
			"status" => "success",
			"message" => "Student deleted successfully",
			"data" => $obj,
		]);

		exit;

	} else {
		echo json_encode([
			"status" => "error",
			"message" => "Set student_id as a get param",
		]);
		exit;
	}
}
?>