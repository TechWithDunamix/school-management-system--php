<?php 
include "db.php";
include "DatabaseHelper.php";

$db = new Database();
$orm = new DatabaseHelper($db);

function checkUserExists($email){
    global $orm;
    global $db;
    $user = $orm -> selectWhere('Users', 'email = ?', [$email,]);
    if (!$user){
        echo "user not exists";
        return true;
    };
    $db -> disconnect();
    return false;
};

// checkUserExists('dunamis@gmail.com');
?>