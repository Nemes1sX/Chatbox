
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
        <script src="js/jquery-3.5.1.min.js"></script>
        <script type="text/javascript">
    $(document).ready(function () {

       
       /* $(".birthdate").flatpickr( {//jQuery calendar libary for proper date formating
            enableTime: false,
            dateFormat: "Y-m-d",
            maxDate: "today"
        });*/

        show();        
        $('#submit-btn').on('click', function (e) { //Client side validation and ajax api function
            
            var fname = $('#fname').val();
            var lname = $('#lname').val();
            var email = $('#email').val();
            var birthdate = $('#birthdate').val();
            var msg = $('#message').val();
            var post = $('#post').val();
            var today = new Date();
            var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
            var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
            var post  = date+' '+time;
            var regEx = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/ //regex pattern for email validation
            var regExn = /^[a-zA-Z\s]*$/; //Regex pattern for fullname validationn
            var validEmail = regEx.test(email); //Checking regex pattern  for email
            var validfname = regExn.test(fname); //Checking regex pattern  for firstname
            var validlname = regExn.test(lname); //Checking regex pattern  for lastname
            if(!validfname || fname == ''){ //Fullname client-side validationn
                $('#fname').after('<span class="error" style="color: red">Full name contains only letters or enter full name</span>'); //If validation fails, user will get a error text and input border appears in red
                $(".err label").css({"color": "#dd0000"});
                $(".err input").css({"border": "1px solid #dd0000" });        
                return false;
            }
            if(!validlname || lname == ''){ //Fullname client-side validationn
                $('#lname').after('<span class="error" style="color: red">Full name contains only letters or enter full name</span>'); //If validation fails, user will get a error text and input border appears in red
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
            console.log(fname);
            console.log(lname);
            console.log(email);
            console.log(birthdate);
            console.log(msg);
            $('.load').show(); //A loading bar will appear, if vaildation runs succesfull
            $(':input').prop('disabled', true); //Makes input fields inactive before AJAX request      
            $.ajax({
                type: "POST",
                url: "chatcontroller.php",
                data: $('#chat').serialize()+"&action=insert",
                 success: function(result){
                    alert(result);
                    $('#chat').trigger('reset'); //Reset input form fields after affter succesfull AJAX request      
                    $(':input').prop('disabled', false); //Makes input fields active affter succesfull AJAX request        
                    $('.load').hide();
                },
                 error: function(result){
                    alert(result);
                    console.log('Error:', data);
                    $('.load').hide();
                }
            }); 
                 
             show();   
        });
     
        function show(){
           $.ajax({
                url: "chatcontroller.php",
                type: "POST",
                data:  {action: "view"},
                success: function(response){
                    $('#msg').html(response);
                },
                error: function(response){
                    alert(response);
                    console.log('Error:', response);
                }
            });
           
        }
     
    });
</script>
    </head>
    <body>
  
        <div id="wrapper">
            <h1>Jūsų žinutės</h1>
            <form id="chat" method="post" action="">
           <!--<input type="hidden" id="post" name="post">-->
                <p class="firstname">
                    <label for="firstname">Vardas *</label><br/>
                    <input id="fname" type="text" name="fname" value="" required/>
                </p>
                <p class="lastname">
                    <label for="lastname">Pavardė *</label><br/>
                    <input id="lname" type="text" name="lname" value="" required/>
                </p>
                <p class="birthdate">
                    <label for="birthdate">Gimimo data *</label><br/>
                    <input id="birthdate" class="birthdate" type="text" name="birthdate" value="" required data-date-format="Y-m-d"/>
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
                    <input type="submit" name="insert" value="Skelbti" id="submit-btn"/>
                    <img class="load" src="img/ajax-loader.gif" alt="" hidden/>
                </p>
            </form>
                <div id="msg">
           
               <!-- <ul id="msg">
                <li>
                    <strong>Šiuo metu žinučių nėra. Būk pirmas!</strong>
                </li>            
                <li>
                    <span>2010 01 01 08:59</span> <a href="mailto:example@example.com">Vardas Pavardė</a>, 13 m.<br/>
                    Įkėlėme šeimos dienos akciją. Dėl papildomos medžiagos užtrukome šiek tiek ilgiau nei įprasta.
                </li>
                <li>
                    <span>2010 01 01 08:59</span> Vardas Pavardė, 75 m. <br/>
                    Įkėlėme šeimos dienos akciją. Dėl papildomos medžiagos užtrukome šiek tiek ilgiau nei įprasta.
                </li>
                <li>
                    <span>2010 01 01 08:59</span> Vardas Pavardė, 10 m. <br/>
                    Įkėlėme šeimos dienos akciją. Dėl papildomos medžiagos užtrukome šiek tiek ilgiau nei įprasta.
                </li>
                <li>
                    <span>2010 01 01 08:59</span> <a href="mailto:example@example.com">Vardas Pavardė</a>, 25 m. <br/>
                    Įkėlėme šeimos dienos akciją. Dėl papildomos medžiagos užtrukome šiek tiek ilgiau nei įprasta.
                </li>
                <li>
                    <span>2010 01 01 08:59</span> Vardas Pavardė, 26 m. <br/>
                    Įkėlėme šeimos dienos akciją. Dėl papildomos medžiagos užtrukome šiek tiek ilgiau nei įprasta.
                </li>
                </ul>-->
            </div>
            <p id="pages">
                <a href="#" title="atgal">atgal</a>
                <a href="#" title="1">1</a>
                2
                <a href="#" title="3">3</a>
                <a href="#" title="4">4</a>
                <a href="#" title="toliau">toliau</a>
            </p>
        </div>
        </body>
    </body>
</html>
