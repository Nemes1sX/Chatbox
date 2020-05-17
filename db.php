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
    public function insert($fname, $lname, $postdate, $birthdate, $email, $msg){
        
        $sql = "INSERT INTO chat (firstname, lastname, post, birthdate, email, msg) VALUES
        (:fname,:lname,:postdate,:birthdate,:email,:msg)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['fname'=>$fname, 'lname'=>$lname, 'post'=>$postdate, 'birthdate'=>$birthdate, 'email'=>$email,
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
    public function validation($fname, $lname, $email, $msg, $birthdate){
        $birthdayp = "/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/"; //Regex pattern for birthday date format. User must provide yyyy-mm-dd date format
        $namep = "/^[a-zA-Z\s]*$/"; //Regex pattern for fullname format. User must provide 'firstname lastname' format
        if(!empty($msg) && !empty($fname) && preg_match($namep, $fname) && !empty($fname) && preg_match($namep, $fname) && 
         preg_match($email, FILTER_VALIDATE_EMAIL) && $email =='-'  &&  !empty($birthday) && preg_match($birthdayp, $birthday) && validateDate($birthday, 'Y-m-d')) //Checking if validation is correct
            return true;
            else return false;
     }
    

}

?>