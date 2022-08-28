<?php
    //Headers for Api
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Allow-Control-Headers: Access-Allow-Control-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With");

    //Import files
    include_once '../../config/Database.php';
    include_once '../../class/User.php';

    //Instantiate Database and connect
    $database = new Database();
    $db = $database->getConnection();

    // Instantiate User Class
    $user = new User($db);

    //Get Raw Posted Data
    $data = json_decode(file_get_contents("php://input"));

    if(
        ctype_alpha($data->fullname) && ctype_alpha($data->gender) && ctype_alpha($data->username)
        && isset($data->fullname) && isset($data->gender) && isset($data->username) && isset($data->password)
    )
    {
        $user->fullname = $data->fullname;
        $user->gender = $data->gender;
        $user->username = $data->username;
        //hashing userPassword
        $hashedPass = password_hash($data->password, PASSWORD_DEFAULT);
        $user->password = $hashedPass;

    }
    else{
        echo json_encode("Input data not valid");
    }

    

    // Create the data
    if($user->signUp())
    {
        //send a json value of key and value
        echo json_encode(
            array("message" => "User Created")
        );
    }
    else
    {
        echo json_encode(
            array("message" => "User Not Created")
        );
    }