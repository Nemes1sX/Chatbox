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
    public function insert($fname, $lname, $birthdate, $email, $msg){
        $sql = "INSERT INTO chat (firstname, lastname, birthdate, email, msg) VALUES
        (:fname,:lname,:email,:phone)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['fname'=>$fname, 'lname'=>$lname, 'birthdate'=>$birthdate, 'email'=>$email,
        'msg'=>$msg]);

        return true;
    }
    public function read(){
        $data = array();
        $sql = "SELECT * FROM chat";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $row){
            $data[] = $row;
        }
        return $data;
    }
    public function totalRows(){
        $sql = "SELECT * FROM chat";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $t_rows = $stmt->rowCount();

        return $t_rows;
    }

}

$obj = new Database();
echo $obj->totalRows(); 
?>