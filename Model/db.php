<?php
class Database{
    private $dsn = "mysql:host=localhost;dbname=chatbox";
    private $user = "root";
    private $pass = "";
    public $conn;

    public function __construct(){
        try{
            $this->conn = new PDO($this->dsn, $this->user, $this->pass);
            echo "Welcome. Your connected to DB";
        }
        catch(PDOException $e){
            echo $e->getmessage();
        }
    }
}

$obj = new Database(); 

?>