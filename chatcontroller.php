<?php

//Chatbox controller
require_once 'db.php';



$db = new Database();


//Data fetch
if(isset($_POST['action']) && $_POST['action'] == "view"){ 
    if (!isset($_GET['page'])) { //Preparing paging
        $page = 1;
      } else {
        $page = $_GET['page'];
      }
      $this_page_first_result = ($page-1)*5;
      $output = '';
   
    $data = $db->read($this_page_first_result); //Fetching data with page first result, preparing query for paging
    if($db->totalRows()>0){
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
        $number_of_pages = ceil($db->totalRows()/5); 
      
        for ($page=1;$page<=$number_of_pages;$page++) {
            echo '<a href="index.php?page=' . $page . '">' . $page . '</a> ';
          }
        }
        else echo '<h1>No messages posted</h1>';
    }
    

    //Post form data to database
 if(isset($_POST['insert']) && $_POST['action'] == 'insert'){  //Checking post submission
        $postdate = date("Y-m-d H:i"); 
        $fname = $_POST['fname'];  
        $lname = $_POST['lname'];      
        $birthdate = $_POST['birthdate'];
        $msg = $_POST['msg'];
        if(isset($_POST['email']))
            $email = $_POST['email'];
            else $email = '-';    
    if($db->validation($fname, $lname, $email, $msg, $birthdate)) //Validate form data from back-end
        if($db->insert($fname, $lname, $postdate, $birthdate, $email, $msg)) //In validation pass, data will be inserted to database
            echo 'Success';
            else echo 'Error';
        else echo 'Klaida neužpildytas vienas iš privalomų laukelių arba blogai ivesti duomenis';    
  }
      
 


?>
