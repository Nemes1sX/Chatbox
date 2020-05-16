<?php
include("chatbox\model\db.php");
//require_once "db.php";


$db = new Database();

if(isset($_POST['action']) && $_POST['action'] == "view"){
    $output = "";
    $data = $db->read();
    print_r($data);
}
?>
