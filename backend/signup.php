<?php 
header('Content-Type: application/json');
require_once "inc/db.php";
require_once "inc/DatabaseHelper.php";

$request_method = $_SERVER['REQUEST_METHOD'];
if ($request_method === 'POST'){
    $rawPostData = file_get_contents("php://input");
    $postdata = json_decode($rawPostData,true);
    
    $errors = [];
    if (!isset($postdata['email']) && !filter_var($postdata['email'],FILTER_VALIDATE_EMAIL)){
        $errors['email'] = "Email is invalid or not provided";
        
    };

    if (! isset($postdata['password'])){
        $errors['password'] = "Password is not provided !";
        
    };

    if (! isset($postdata['username'])){
        $errors['username'] = "Username is a required field";
        
    };
    if (! isset($postdata['school_name'])){
        $errors['school_name'] = "School name is a required field !";
        
    };
    // $userExixts = checkUserExists($_POST['email']);
    // if ($userExixts){
    //     $errors['email'] = 'email already exists';
    // };
    

    if ($errors){
        header("HTTP/1.1 400 NOT FOUND");

        echo json_encode($errors);
        exit ;
    }else{
        $db = new Database();
        $orm = new DatabaseHelper($db);
        $email = $postdata['email'];
        $school_name = $postdata['school_name'];
        $user = $orm -> selectWhere('Users', 'email = ?', [$email,]);
        $school = $orm -> selectWhere('Users', 'school_name = ?', [$school_name,]);

        if ($user){
            header("HTTP/1.1 400 Bad Request");
            echo json_encode([
                "email" => "User with this email already exists"
            ]);
            exit;
        };
        if ($school){
            header("HTTP/1.1 400  BAD REQUEST");
            echo json_encode([
                "school_name" => "Shool with this name already exists"
            ]);
            exit;
        };
        if (isset($postdata['ref_by'])){
            $ref_by = $postdata['ref_by'];
        };
        $hashedPassword = password_hash($postdata['password'], PASSWORD_DEFAULT);
        $ref_id = bin2hex(random_bytes(8));
        $data = [
            "id" => bin2hex(random_bytes(16)),
            "email" => $postdata['email'],
            "hashedpassword" => $hashedPassword,
            "username" => $postdata['username'],
            "school_name" => $postdata['school_name'],
            "ref_by" => isset($ref_by) && $ref_by,
            "ref_id" => $ref_id

        ];
        $qs = $orm->insert("Users",$data);
        
        $_SESSION['email'] = $postdata['email'];
        $_SESSION['school_name'] = $postdata['school_name'];
        $_SESSION['school_id'] = $ref_id;


        echo json_encode(["success" => true,"message" => "User created"]);
    };
    

    
};

?>
