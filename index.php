<?php
include('db.php');
ini_set('display_errors', 1);
//`
$fullname = '';
$msg = '';
$birthday = '';

$database = new Database();

if(isset($_POST['submit'])) { 
    $post = date('Y-m-d H:i'); //Posted message current timestamp;
    $msg = $database->sanitize($_POST['msg']); //mysql escape string to string datatype fields
    $email = $database->sanitize($_POST['email']); 
    $fullname = $database->sanitize($_POST['fullname']); 
    $birthday = date_create($_POST['birthdate']); //Create date datatype for birthday
    $birthday = date_format($birthday, 'Y-m-d'); 
    if(!$database->validate($fullname, $birthday, $msg)) //Validating if fullname, birthday and message properly filled
        $database->create($fullname, $birthday, $email, $msg, $post); //In successfull validation case, a message will be created
        else echo 'Klaida neužpildytas vienas iš privalomų laukelių arba blogai ivesti duomenis';  
}

  
?>
<!--xml version="1.0" encoding="UTF-8"?>-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Žinutės</title>
        <link rel="stylesheet" media="screen" type="text/css" href="css/screen.css" />

        <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <!--  Flatpickr  -->
        <script src="js/jquery.min.js"></script>
        <script type="text/javascript">
    $(document).ready(function () {

       
        $("#birthdate").flatpickr({ //jQuery calendar libary for proper date formating
            enableTime: false,
            dateFormat: "Y-m-d",
            maxDate: "today"
        });

        
        /*$('#submit-btn').on('click', function (e) { //Client side validation and ajax api function
            
            var full_name = $('#fullname').val();
            var email = $('#email').val();
            var birthdate = $('#birthdate').val();
            var msg = $('#message').val();
            var regEx = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/ //regex pattern for email validation
            var regExn = /^[a-zA-Z\s]*$/; //Regex pattern for fullname validationn
            var validEmail = regEx.test(email); //Checking regex pattern  for email
            var validFullname = regExn.test(full_name); //Checking regex pattern  for fullname
            if(!validFullname || full_name == ''){ //Fullname client-side validationn
                $('#fullname').after('<span class="error" style="color: red">Full name contains only letters or enter full name</span>'); //If validation fails, user will get a error text and input border appears in red
                $(".err label").css({"color": "#dd0000"});
                $(".err input").css({"border": "1px solid #dd0000" });        
                return false;
            }
            if(!birthdate){ //Birthdate validatiion
                $('#birthdate').after('<span class="error" style="color: red">Please enter the birthdate</span>');
                $(".err label").css({"color": "#dd0000"});
                $(".err input").css({"border": "1px solid #dd0000" });
                return false;
            }
             if (!validEmail) { //Email validation
                $('#email').after('<span class="error" style="color: red">Enter a valid email</span>');
                $(".err label").css({"color": "#dd0000"});
                $(".err input").css({"border": "1px solid #dd0000" });
                return false;
            }
            if(msg == ''){ //Message validation
                $('#message').after('<span class="error" style="color: red">Please enter the message</span>');
                $(".err label").css({"color": "#dd0000"});
                $(".err input, .err textarea").css({"border": "1px solid #dd0000" });
                return false;
            }
            $('.load').show(); //A loading bar will appear, if vaildation runs succesfull
            $(':input').prop('disabled', true); //Makes input fields inactive before AJAX request      
            $.ajax({
                type: "POST",
                url: "index.php",
                data: 'json',
                cache: false,   
                 success: function(result){
                    alert(result);
                    $('#chat').trigger('reset'); //Reset input form fields after affter succesfull AJAX request      
                    $(':input').prop('disabled', false); //Makes input fields active affter succesfull AJAX request        
                },
                 error: function(result){
                    alert(result);
                    console.log('Error:', data);
                }
            }); 
                 

        });*/
        show()
        function show(){
            $.ajax({
                url: "controller/chatcontroller.php";
                type: "POST",
                data:  {action: "view"},
                sucess: function(response){
                    console.log(response);
                }
            });
        }
     
    });
</script>
    </head>
    <body>
  
        <div id="wrapper">
            <h1>Jūsų žinutės</h1>
            <h3>Įjungti/išjungti JavaScript</h3>
            <button type="submit" id="enable-jquery">Enable JavaScript</button> 
            <button type="submit" id="disable-jquery">Disable JavaScript</button>
            <form id="chat" method="post">
                <p class="fullname">
                    <label for="fullname">Vardas, pavardė *</label><br/>
                    <input id="fullname" type="text" name="fullname" value="" required/>
                </p>
                <p class="birthdate">
                    <label for="birthdate">Gimimo data *</label><br/>
                    <input id="birthdate" type="text" name="birthdate" value="" required data-date-format="Y-m-d"/>
                </p>
                <p class="email">
                    <label for="email">El.pašto adresas</label><br/>
                    <input id="email" type="text" name="email" value="" />
                </p>
                <p class="msg">
                    <label for="message">Jūsų žinutė *</label><br/>
                    <textarea id="message" name="msg" required></textarea>
                </p>
                <p>
                    <span>* - privalomi laukai</span>
                    <input type="submit" value="skelbti" id="submit-btn"/>
                    <img class="load" src="img/ajax-loader.gif" alt="" hidden/>
                </p>
            </form>
            <ul>
                <li>
                    <strong>Šiuo metu žinučių nėra. Būk pirmas!</strong>
                </li>
                <li>
                <?php                

                    $results = $database->read(); //Get messages from database 
              
                    foreach($results as $row) { //Iteration for parsing messages
                     ?>
                   <span><?php echo date_format(new DateTime($row['post']), 'Y m d H:i'); ?></span> <!-- Formatting date according to the example-->
                   <a href="<?php if($row['email'] != '-')  echo "mailto:".$row['email'];  else  echo '#'; ?>"><?php echo $row['fullname']; ?></a>, <?php  $diff=date_diff(date_create($row['birth']),date_create($row['post'])); echo $diff->format("%y") ?> m. <br/>
                   <?php echo $row['msg']; } ?>  <!-- Data parsing -->
                 </li>    
            </ul>
            <?php   $pagLink = "<div class='pagination'>";  ?>
               <ul>         
                <p id="pages">
                <?php if (isset($_GET['pageno'])) { //Conditional statement who determines a page where is a user
                     $pageno = $_GET['pageno']; 
                     } else {
                     $pageno = 1; //For the first time a messages' page would be a first page.
                     }
                ?>     
                    <li class="inline"><a href="?pageno=1">Pirmas</a></li>
                    <li class="<?php  if($pageno <= 1) echo 'disabled';  ?> inline">
                        <a href="<?php if($pageno <= 1) echo '#';  else  echo "?pageno=".($pageno - 1);  ?>">Atgal</a>
                    </li>

                    <?php $total_pages = $database->paging();
                    for ($i=1; $i<=$total_pages; $i++) {  
                        $pagLink .= "<li class='inline'><a href='?pageno=".$i."'>".$i."</a></li>"; //Parsing the pages depending from total messages.
                    };   ?>
                    <li class="<?php if($pageno >= $total_pages) echo 'disabled';  ?> inline">
                        <a href="<?php if($pageno >= $total_pages) echo '#';  else  echo "?pageno=".($pageno + 1);  ?>">Toliau</a>
                    </li>
                    <li class="inline"><a href="?pageno=<?php echo $total_pages; ?>">Paskutinis</a></li> 
            <?php  echo $pagLink . "</div>";   ?>
            </p>
        </div>
    </body>
</html>
