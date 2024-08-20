<?php
header('Content-Type: application/json');
require_once "inc/db.php";
require_once "inc/DatabaseHelper.php";

$request_method = $_SERVER['REQUEST_METHOD'];
if ($request_method === 'POST') {
	$rawPostData = file_get_contents("php://input");
	$postdata = json_decode($rawPostData, true);

	$errors = [];
	if (!isset($postdata['email']) || !filter_var($postdata['email'], FILTER_VALIDATE_EMAIL)) {
		$errors['email'] = "Email is invalid or not provided";
	}

	if (!isset($postdata['password'])) {
		$errors['password'] = "Password is not provided";
	}

	if ($errors) {
		header("HTTP/1.1 400 Bad Request");
		echo json_encode([
			"status" => "error",
			"message" => "Validation Failed",
			"errors" => $errors,
		]);
		exit;
	} else {
		$db = new Database();
		$orm = new DatabaseHelper($db);
		$email = $postdata['email'];
		$password = $postdata['password'];

		$user = $orm->selectWhere('Users', 'email = ?', [$email]);

		if (!$user) {
			header("HTTP/1.1 401 Unauthorized");
			echo json_encode([
				"status" => "error",
				"message" => "Invalid email or password",
			]);
			exit;
		}

		if (!password_verify($password, $user[0]['hashedpassword'])) {
			header("HTTP/1.1 401 Unauthorized");
			echo json_encode([
				"status" => "error",
				"message" => "Invalid email or password",
			]);
			exit;
		}

		$_SESSION['email'] = $email;
		$_SESSION['school_name'] = $user[0]['school_name'];
		$_SESSION['school_id'] = $user[0]['ref_id'];

		echo json_encode([
			"status" => "success",
			"message" => "Login successful",
			"data" => [
				"email" => $email,
				"school_name" => $user[0]['school_name'],
				"school_id" => $user[0]['ref_id'],
			],
		]);
		exit;
	}
}
?>