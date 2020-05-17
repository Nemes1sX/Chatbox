<?php
require_once 'db.php';

$db = new Database();
ini_set('display_errors', 1);

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
  if(isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['birthdate'])
  && isset($_POST['msg'])){
        $postdate = date("Y-m-d H:i"); 
        $firstname = $_POST['fname'];  
        $lname = $_POST['lname'];      
        $birthdate = $_POST['birthdate'];
        if(isset($_POST['email']))
            $email = $_POST['email'];
            else $email = '-';     
    if($db->validation($fname, $lname, $email, $msg, $birthdate)) 
        $db->insert($fname, $lname, $postdate, $birthdate, $email, $msg);
        else echo 'Klaida neužpildytas vienas iš privalomų laukelių arba blogai ivesti duomenis';    
 }

 }

?>
