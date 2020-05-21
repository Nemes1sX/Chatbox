<?php
class Database{
    //Connection settings to database. Using PDO because it supports 12 different DBMS
    private $dsn = "mysql:host=localhost;dbname=chatbox";
    private $user = "root";
    private $pass = "";
    protected $conn;

    public function __construct(){ //Connection to adatabase
        try{
            $this->conn = new PDO($this->dsn, $this->user, $this->pass);
            echo "Welcome. Your connected to DB";
            echo "<br>";
        }
        catch(PDOException $e){
            echo $e->getmessage();
        }
    }
    public function insert($fname, $lname, $postdate, $birthdate, $email, $msg){ 
        
        $sql = "INSERT INTO chat (firstname, lastname, post, birthdate, email, msg) VALUES
        (:fname,:lname,:postdate,:birthdate,:email,:msg)";
        $stmt = $this->conn->prepare($sql); //Using prepared statment on queries as prevention from SQL injections
        $stmt->execute(['fname'=>$fname, 'lname'=>$lname, 'post'=>$postdate, 'birthdate'=>$birthdate, 'email'=>$email,
        'msg'=>$msg]);

        return true;
    }
    public function read($this_page_first_result){ 
        $data = array();
        $sql = "SELECT * FROM chat ORDER BY post LIMIT'.$this_page_first_result.',5"; //Fetch data with ordering data by post and limit 5 records per page
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $row){
            $data[] = $row;
        }
        return $data;
    }
    public function totalRows(){ //Counts table rows
        $sql = "SELECT * FROM chat";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $t_rows = $stmt->rowCount();

        return $t_rows;
    }
    public function validation($fname, $lname, $email, $msg, $birthdate){ //Back-end validations
        $birthdayp = "/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/"; //Regex pattern for birthday date format. User must provide yyyy-mm-dd date format
        $namep = "/^[a-zA-Z\s]*$/"; //Regex pattern for fullname format. User must provide 'firstname lastname' format
        if(!empty($msg) && !empty($fname) && preg_match($namep, $fname) && !empty($fname) && preg_match($namep, $fname) && 
         preg_match($email, FILTER_VALIDATE_EMAIL) && $email =='-'  &&  !empty($birthday) && preg_match($birthdayp, $birthday) && validateDate($birthday, 'Y-m-d')) //Checking if validation is correct
            return true;
            else return false;
     }
    

}

?>