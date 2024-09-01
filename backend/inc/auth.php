<?php
require_once 'JWT.php';
require_once "config.php";


$jwt = new JWT(SECRET_KEY);


$headers = apache_request_headers();
$authHeader = $headers['Authorization'];



if (strpos($authHeader, 'Bearer ') === 0) {
    $token = str_replace('Bearer ', '', $authHeader);

    $validatedPayload = $jwt->validateToken($token);

    if ($validatedPayload) {
        $userId = $validatedPayload['userId'];
        $username = $validatedPayload['username'];
    } else {
        header('HTTP/1.1 401 Unauthorized');
        echo json_encode(['error' => 'Unauthorized: Invalid or expired token']);
        exit();
    }
} else {
    header('HTTP/1.1 401 Unauthorized');
    echo json_encode(['error' => 'Unauthorized: No token provided']);
    exit();
}
?>
