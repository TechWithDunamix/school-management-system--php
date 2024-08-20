<?php

header('Content-Type: application/json');
require_once "inc/db.php";
require_once "inc/DatabaseHelper.php";

$school_id = $_GET['school_id'];
$database = new Database();
$orm = new DatabaseHelper($database);

// Validate School
$school = $orm->selectColumnsWhere('Users', ['school_name', 'ref_id'], 'ref_id = ?', [$school_id]);
if (!$school) {
	header("HTTP/1.1 404 NOT FOUND");
	echo json_encode([
		"status" => "error",
		"message" => "School not found",
	]);
	exit;
}
;

$request_method = $_SERVER['REQUEST_METHOD'];

if ($request_method == 'GET') {
	// Fetch specific class or all classes
	if (isset($_GET['class_id'])) {
		$class_id = $_GET['class_id'];
		$whereClause = 'school_id = ? AND id = ?';
		$params = [$school_id, $class_id];
		$class = $orm->selectWhere('Classes', $whereClause, $params);
		if (!$class) {
			header("HTTP/1.1 404 Not Found");
			echo json_encode([
				"status" => "error",
				"message" => "No class matches the query",
			]);
			exit;
		}
		$response = array_slice($class, 0, 1)[0];
		echo json_encode([
			"status" => "success",
			"message" => "Class retrieved successfully",
			"data" => $response,
		]);
		exit;
	}

	// Fetch all classes for the school
	$classes = $orm->selectWhere('Classes', 'school_id = ?', [$school_id]);
	echo json_encode([
		"status" => "success",
		"message" => "All classes retrieved successfully",
		"data" => $classes,
	]);
	exit;
}

if ($request_method === 'POST') {
	// Create a new class
	$rawPostData = file_get_contents("php://input");
	$postdata = json_decode($rawPostData, true);
	$errors = [];

	if (!isset($postdata['class_name'])) {
		$errors['class_name'] = 'Class name is a required field';
	}
	if (!isset($postdata['teacher'])) {
		$errors['teacher'] = 'Teacher name is a required field';
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
	;

	$_class = $orm->selectWhere("Classes", "school_id = ? AND class_name = ?", [$school_id, $postdata["class_name"]]);
	if ($_class) {
		header("HTTP/1.1 400 BAD REQUEST");

		echo json_encode([
			"status" => "error",
			"message" => "Class name already exists",
		]);
		exit;
	}
	$data = [
		"id" => bin2hex(random_bytes(16)),
		'class_name' => $postdata['class_name'],
		"school_id" => $school_id,
		"date_created" => (new DateTime())->format('Y-m-d H:i:s'),
		"teacher" => $postdata['teacher'],
	];

	$qs = $orm->insert("Classes", $data);
	echo json_encode([
		"status" => "success",
		"message" => "Class created successfully",
		"data" => $data,
	]);
	exit;
}

if ($request_method == 'PATCH') {
	// Update a class
	$rawPatchData = file_get_contents("php://input");
	$patchdata = json_decode($rawPatchData, true);
	$errors = [];

	if (isset($_GET['class_id'])) {
		$class_id = $_GET['class_id'];
		$whereClause = 'school_id = ? AND id = ?';
		$params = [$school_id, $class_id];
		$class = $orm->selectWhere('Classes', $whereClause, $params);
		if (!$class) {
			header("HTTP/1.1 404 Not Found");
			echo json_encode([
				"status" => "error",
				"message" => "No class matches the query",
			]);
			exit;
		}

		$obj = $class[0];
		foreach ($obj as $key => &$value) {
			if (isset($patchdata[$key])) {
				$value = $patchdata[$key];
			}
		}

		unset($obj['id']);
		unset($obj['school_id']);
		$orm->update('Classes', $obj, $whereClause, $params = $params);
		echo json_encode([
			"status" => "success",
			"message" => "Class updated successfully",
			"data" => $obj,
		]);
		exit;
	} else {
		echo json_encode([
			"status" => "error",
			"message" => "Set class_id as a get param",
		]);
		exit;
	}
}

if ($request_method == 'DELETE') {
	// Delete a class
	if (isset($_GET['class_id'])) {
		$class_id = $_GET['class_id'];
		$whereClause = 'school_id = ? AND id = ?';
		$params = [$school_id, $class_id];
		$class = $orm->selectWhere('Classes', $whereClause, $params);
		if (!$class) {
			header("HTTP/1.1 404 Not Found");
			echo json_encode([
				"status" => "error",
				"message" => "No class matches the query",
			]);
			exit;
		}

		$obj = $class[0];
		$orm->delete('Classes', "id = ?", [$obj['id']]);
		echo json_encode([
			"status" => "success",
			"message" => "Class deleted successfully",
			"data" => $obj,
		]);
		exit;
	} else {
		echo json_encode([
			"status" => "error",
			"message" => "Set class_id as a get param",
		]);
		exit;
	}
}

?>
