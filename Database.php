<?php

require_once 'config.php';

class Database
{
    private $username;
    private $password;
    private $host;
    private $database;


    public function __construct()
    {
        $this->username = USERNAME;
        $this->password = PASSWORD;
        $this->host = HOSTNAME;
        $this->database = DATABASE;
    }

    public function setConnection(){
        try{
            $con = new PDO(
                "pgsql:host=$this->host;port=5432;dbname=$this->database",
                $username=$this->username,
                $password=$this->password,
                ["sslmode" => "prefer"]
            );

            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $con;

        }
        catch(Exception $e){
            die('connection failed: '.$e->getMessage());
        }
    }


}