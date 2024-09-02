<?php
require_once 'JWT.php';
require_once "config.php";
require_once "db.php";
require_once "DatabaseHelper.php";

$jwt = new JWT(SECRET_KEY);

$headers = apache_request_headers();

// == Had to do this cuz it breaks the frontend when the header is not available (SyntaxError)
$authHeader = array_key_exists('Authorization', $headers) ? $headers['Authorization'] : null;

if (strpos($authHeader, 'Bearer ') === 0) {
	$token = str_replace('Bearer ', '', $authHeader);

	$validatedPayload = $jwt->validateToken($token);

	if ($validatedPayload) {
		$userEmail = $validatedPayload['email'];
		$userPassword = $validatedPayload['password'];
		$db = new Database();
		$orm = new DatabaseHelper($db);

		$user = $orm->selectWhere('Users', 'email = ?', [$userEmail]);
		$obj = $user[0];

		define("USER",$user[0]);
		define("school_id",$obj->ref_id);

		
		
	} else {
		header('HTTP/1.1 401 Unauthorized');
		echo json_encode([
			'status' => 'error',
			'message' => 'Unauthorized: Invalid or expired token',
		]);
		exit();
	}
} else {
	header('HTTP/1.1 401 Unauthorized');
	echo json_encode([
		'status' => 'error',
		'message' => 'Unauthorized: No token provided',
	]);
	exit();
}
?>
