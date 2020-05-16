<?php
require_once 'db.php';

$db = new Database();
function validation($fname, $lname, $msg, $birthdate){
    $birthdayp = "/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/"; //Regex pattern for birthday date format. User must provide yyyy-mm-dd date format
    $namep = "/^[a-zA-Z\s]*$/"; //Regex pattern for fullname format. User must provide 'firstname lastname' format
    if(!empty($msg) && !empty($fname) && preg_match($namep, $fname) && !empty($fname) && preg_match($namep, $fname) && !empty($birthday) 
    && preg_match($birthdayp, $birthday) && validateDate($birthday, 'Y-m-d')) //Checking if validation is correct
        return true;
        else return false;
 }

if(isset($_GET['action']) && $_GET['action'] == "view"){
    $output = '';
    $data = $db->read();
    if($db->totalRowCount()>0){
        foreach($data as $row){
            $output.='<li>';
            $output .='<span>'.date_format(new DateTime($row['post']), 'Y m d H:i').'</span>';
            if($row['email'] != '-') 
               $output.='<a href="mailto:"'.$row['email'].'>'.$row['fname'].' '.$row['lname'].'</a>';
               else $output.= $row['fname'].' '.$row['lname'];
            $diff=date_diff(date_create($row['birth']),date_create($row['post']));  
            $output.= $diff->format("%y").'m.';
            $output.= $row['msg'];
            $output.='</li>';
        }   
        echo $output;
    }
    else echo '<h1>No messages posted</h1>';
}
 if(isset($_POST['action']) && $_POST['action'] == 'insert'){
    if(validation($fname, $lname, $msg, $birthdate)) {
    $postdate = date("Y-m-d H:i"); 
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $birthdate = $_POST['birthdate'];
    if(isset($_POST['email']) &&  filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        $email = $_POST['email'];
        else $email = '-';
    $db->insert($fname, $lname, $postdate, $birthdate, $email, $msg);        
 }
 else echo 'Klaida neužpildytas vienas iš privalomų laukelių arba blogai ivesti duomenis';  
}


?>
