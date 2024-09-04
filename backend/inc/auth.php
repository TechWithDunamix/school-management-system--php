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

		if (isset($user[0])) {
			$obj = $user[0];

			// Check if ref_id exists in the object
			if (is_object($obj) && property_exists($obj, 'ref_id')) {
				define("USER", $obj);
				// define("school_id", $obj->ref_id);

				// Proceed with your logic here, as ref_id is defined
				// ...
			} else {
				// Handle the case where ref_id doesn't exist
				// header('HTTP/1.1 500 Internal Server Error');
				// echo json_encode([
				// 	'status' => 'error',
				// 	'message' => 'Internal Server Error: ref_id not found in user data',
				// ]);
				// exit();
				define("USER", $obj);
				// define("school_id", $obj->ref_id);
			}
		} else {
			// Handle the case where user is not found
			header('HTTP/1.1 404 Not Found');
			echo json_encode([
				'status' => 'error',
				'message' => 'User not found',
			]);
			exit();
		}
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
