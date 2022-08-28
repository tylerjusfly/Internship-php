<?php
    class Post 
    {
        //DB properties
        private $conn;
        private $tableName = "posts";

        // Initialize Class Properties of Posts
        public $id;
        public $category_id;
        public $category_name;
        public $title;
        public $body;
        public $author;
        public $created_at;

        //Constructor -> this runs automatically when you instanciate a class
        public function __construct($db)
        {
            //set connection of this class to db
            $this->conn = $db;
        }

        //Get Posts Method
        public function readAll() 
        {
            // Create a Query
            $sqlQuery = 'SELECT c.name as category_name, p.id, p.category_id, p.title, p.body, p.author, p.created_at
            FROM ' . $this->tableName . ' p
            LEFT JOIN
              categories c ON p.category_id = c.id
            ORDER BY
              p.created_at DESC'; 

            //Prepare SQL statement with the PDO "prepare()"
            $stmt = $this->conn->prepare($sqlQuery);

            //execute Statement
            $stmt->execute();

            //return statement
            return $stmt;
        }

        public function readOne()
        {
             // Create a Query
             $sqlQuery = 'SELECT c.name as category_name, p.id, p.category_id, p.title, p.body, p.author, p.created_at
             FROM ' . $this->tableName . ' p
             LEFT JOIN
               categories c ON p.category_id = c.id
             WHERE
               p.id = ?
             LIMIT 0,1';


            //Prepare statement
            $stmt = $this->conn->prepare($sqlQuery);

            //Bind Id to placeHolder
            $stmt->bindParam(1, $this->id);
            $stmt->execute(); 

            $row = $stmt->fetch(PDO::FETCH_ASSOC); //fetch data as associative array
            
            //set Class Properties
            $this->title = $row['title'];
            $this->body = $row['body'];
            $this->author = $row['author'];
            $this->category_id = $row['category_id'];
            $this->category_name = $row['category_name'];
        }


    }
