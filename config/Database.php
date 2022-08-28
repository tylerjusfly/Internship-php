<?php
    class Database
    {
        //DB params
        private $host = "localhost:3307";
        private  $db_name = "apidb";
        private $username = "root"; 
        private $password = "123456";
        private $conn;

        // DB Connect method 
        public function getConnection() {
            $this->conn = null;

            try {
                $this->conn = new PDO("mysql:host=" .  $this->host . ";dbname=" . $this->db_name , $this->username, $this->password);

                //set error mode to get exception when we make queries and something goes wrong
                $this->conn ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch (PDOException $err) {
                echo "Connection error : " . $err->getMessage();
            }

            return $this->conn;
        }

    } 
