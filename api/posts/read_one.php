<?php
    //Headers for Api
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");

    //Import files
    include_once '../../config/Database.php';
    include_once '../../class/Post.php';

    //Instantiate Database and connect
    $database = new Database();
    $db = $database->getConnection();

    //Instantiate Post Object
    $post = new Post($db);

    //Get Id
    $post->id = isset($_GET['id']) ? $_GET['id'] : die();

    //call The readOne method to set the class Properties
    $result = $post->readOne();

    if($post->title != null)
    {
        //create array
        $post_array = array(
            'id' => $post->id,
            'title' => $post->title,
            'body' => $post->body,
            'author' => $post->author,
            'category_id' => $post->category_id,
            'category_name' => $post->category_name
          );
    
        //Make into Json
        print_r(json_encode($post_array));

    }
    else
    {
        echo json_encode(
            array("message" => "No Post Was Found")
        );
        //echo $_SERVER['PHP_SELF'];
    }

    //  <isset> Checks whether a variable is empty. Also check whether the variable is set/declared: