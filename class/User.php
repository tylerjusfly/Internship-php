<?php declare(strict_types=1);

class User
{
    // DB Properties
    private $conn;
    private $tableName = "users";

    //Class Properties
    public $id;
    public string $fullname;
    public string $gender;
    public string $username;
    public $password;
    public $created_at;

    //Constructor
    public function __construct($db)
    { //set connection of this class to db
         $this->conn = $db;
    }

    //Create Users
    public function signUp()
    {
        // SQL QUERY and using named parameters
        $sqlQuery = "INSERT INTO " . $this->tableName . "
        SET 
            fullname = :fullname,
            gender = :gender,
            username = :username,
            password = :password ";

        //Prepare Statement
        $stmt = $this->conn->prepare($sqlQuery);

        //Filter or cleanup data  //and reAssigning properties to cleanedup properties
        $this->fullname = htmlspecialchars(strip_tags($this->fullname));
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->gender = htmlspecialchars(strip_tags($this->gender));
        $this->password = htmlspecialchars(strip_tags($this->password));

        // Bind data with name parameters now (not number parameters)
        $stmt->bindParam(':fullname', $this->fullname);
        $stmt->bindParam(':gender', $this->gender);
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);

        //Execute query
        if($stmt->execute()){
            return true;
        }
        else{
            printf("Error : %s . /n", $stmt->error);
            return false;
        }

    }
}