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

    // call readAll method from post
    $allPosts = $post->readAll();
    //get row count
    $rowCount = $allPosts->rowCount();

    //Check if data exists with row count
    if($rowCount > 0) {
        $post_arr = array();
        $post_arr['data'] = array(); //creating data key and setting it to an array

        //loop through data from readAll method and fetch as associative array
        while($row = $allPosts->fetch(PDO::FETCH_ASSOC)){
            extract($row); //extracts data 
            $post_item = array(
                'id' => $id,
                'title' => $title,
                'body' => html_entity_decode($body),
                'author' => $author,
                'category_id' => $category_id,
                'category_name' => $category_name,
            );
            array_push($post_arr['data'], $post_item);
        }
        //Convert to Json and Output
        echo json_encode($post_arr);
    }
    else {
        //no post , create an array with key message and value
        echo json_encode(
            array("message" => "No post Found")
        );
    }

