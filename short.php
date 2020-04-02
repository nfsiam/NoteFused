<?php
    session_start();
    require "includes/initiatenotepad.php";
    //require "includes/indexloginvalidation.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NoteFused</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.7/css/all.css">
    <!-- <link rel="stylesheet" href="styles/short.css"> -->
    <link rel="stylesheet" href="styles/side2.css">
    <link rel="stylesheet" href="styles/topbar.css">
    <link rel="stylesheet" href="styles/login.css">
    <link rel="stylesheet" href="styles/form.css">

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
    <script src="js/jquery341.js"></script>


</head>
<body>
    
    <div class="container">
        
        <div class="sidebar">
            <ul class="top">
                <li>
                    <button class="parentButton" id="p1">Profile</button>
                    <ul class="drp" id="drp1">
                        <?php
                            
                            $loggedDiv = "none";
                            $noLoggedDiv = "block";
                            if(isset($_SESSION['user']))
                            {
                                $loggedDiv = "block";
                                $noLoggedDiv = "none";
                            }
                        ?>
                        <div id="loggedDiv" style = "display:<?php echo $loggedDiv;?>">                                    
                            <li><a href='mnotes.php'><button class='childButton'>My Notes</button></a></li>
                            <li><a href='destroysession.php'><button class='childButton'>Logout</button></a></li>
                        </div>
    
                        <div id="noLoggedDiv" style = "display:<?php echo $noLoggedDiv;?>">
                            <li><button class='childButton' id="loginButton">Login</button></li>
                            <li><a href='reg.php'><button class='childButton'>Register</button></a></li>
                        </div>
                    </ul>
                </li>
                <li>
                    <button class="parentButton" id="p2">Settings</button>
                    <div class="drp" id="drp2">
                        <input type="button" value="Log In" class="childButton">
                    </div>
                </li>
                <li>
                    <a href="contact.php"><button class="last-parent" onclick="showChild(this)"
                            id="p3">Contact</button></a>
                </li>
            </ul>
        </div>
        <div class="fuse">
            <div class="mini-container">
                <div class="example-span">
                    <span id="exampleSpan">Enter your URL below</span>
                </div>
                <div class="url-box">
                    <input type="text" name="" id="urlBox" placeholder="http://www.example.com" spellcheck="false">
                </div>
                <div class="shorten-button-box">
                    <button id="shortenButton">Shorten</button>
                </div>
                <div class="shorten-result">
                    <div class="your-result-span">
                        <span id="yourResultSpan">Your URL:</span>
                    </div>
                    <div class="result-url-box">
                        <input type="text" name="" id="resultUrlBox" spellcheck="false">
                    </div>
                    <div class="result-url-share">
                        <button id="copyToClip">Copy</button>
                        <button id="copyToClip">Copy</button>
                        <button id="copyToClip">Copy</button>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="alter-options">
            <div class="option-toggler" id="optionToggler">
                <div class="create-link">
                    <button id="createNewLink" title="Shorten a URL"><i class="fas fa-link"></i></button>
                </div>
                <div class="create-file">
                    <button id="createNewFile" title="Upload a File"><i class="fas fa-file-archive"></i></button>
                </div>
                <div class="create-note">
                    <button id="createNewNote" title="Create another Note"><i class="fas fa-file-alt"></i></button>
                </div>
            </div>
            <div class="expand-option">
                <button id="expandOptions"><i class="fas fa-plus"></i></button>
            </div>

        </div>
    </div>
        
        
    </div>
    <div id="disableDiv"></div>

    <div class="loginform" id="loginForm">
        <button id="close" onclick="closeForm()">x</button>
        <form action="" id="login_form" method="post">
            <h1 class="form-heading">Login</h1>
            <div class="warn" id="errProfile"><?php //echo $err_profile; ?></div>
            <div class="input-sec">
                <input type="text" name="uname" id="unamebox" value="<?php //echo $uname; ?>">
                <span data-placeholder="username" ></span>
            </div>
            <div class="warn" id="errUname"><?php //echo $err_uname; ?></div>
            <div class="input-sec">
                <input type="password" name="pass" id="passbox" value="<?php //echo $pass;?>">
                <span data-placeholder="password"></span>
            </div>
            <div class="warn" id="errPass"><?php //echo $err_pass; ?></div>
            <div class="button-holder">
                <input type="submit" value="Login" class="subBtn" name="login" >
            </div>
            <div class="bottomText">
                Don't have an account? <a href="reg.php">Register Now</a>
            </div>

        </form>
    </div>
    <script>
        
        let loggedUser ="<?php echo empty($loggedUser)?'':$loggedUser?>";
        // console.log("aaaa: "+loggedUser);
        
        //sidebar
        function openForm() {
            document.getElementById("disableDiv").style.display = "block";
            document.getElementById("loginForm").style.display = "block";
        }

        function closeForm() {
            document.getElementById("unamebox").value = "";
            document.getElementById("passbox").value = "";
            document.getElementById("errProfile").innerHTML = "";
            document.getElementById("errUname").innerHTML = "";
            document.getElementById("errPass").innerHTML = "";
            $(".input-sec input").removeClass('focus');
            document.getElementById("disableDiv").style.display = "none";
            document.getElementById("loginForm").style.display = "none";
        }

        function showChildButtons(element){
            if(element.id == "p1"){
                $('#drp2').slideUp(200);  
                $('#drp1').slideDown();
            }
            else if(element.id == "p2"){ 
                $('#drp1').slideUp(200);  
                $('#drp2').slideDown(); 
            }
        }

        $('#p1').click(function(){
            showChildButtons(this);
        });
        $('#p2').click(function(){
            showChildButtons(this);
        });

        $('#close').click(function(){
            closeForm();
        });
        $('#loginButton').click(function(){
            openForm();
        });



        //option toggler
        $('#expandOptions').on('click',function(e){
            e.preventDefault();

            if(!$('#optionToggler').is(':visible'))
            {
                $('#optionToggler').slideDown();
            }
            else{
                $('#optionToggler').slideUp();
            }
            
        });
        $('#expandOptions').on('focusout',function(e){
            e.preventDefault();

            if($('#optionToggler').is(':visible'))
            {
                $('#optionToggler').slideUp();
            }
            
        });


        //login validation

        $(".input-sec input").on("focus", function () {
            $(this).addClass("focus");
        });
        $(".input-sec input").on("blur", function () {
            if ($(this).val() == "") {
                $(this).removeClass('focus');
            }
        });


        $('#login_form').submit(function(e){
            e.preventDefault();
            let uname = $('#unamebox').val();
            let pass = $('#passbox').val();
            let everythingOk = true;
            if(uname.trim() == ''){
                $('#errUname').html("username can not be empty");
                everythingOk = false;
            }else{
                $('#errUname').html("");
                everythingOk = true;
            }
            if(pass.trim() == ''){
                $('#errPass').html("password can not be empty");
                everythingOk = false;
            }else{
                $('#errPass').html("");
                everythingOk = true;
            }
            
            if(everythingOk){
                // $('#errProfile').load('floatingloginvalidation.php',{
                //     login:"submit",
                //     uname:  uname,
                //     pass:  pass
                // });

                $.ajax({
                    url:'floatingloginvalidation.php',
                    method:'POST',
                    dataType:'JSON',
                    data:{
                        login:"submit",
                        uname:  uname,
                        pass:  pass
                    },success:function(data){
                        //alert(response);
                        
                        $('#errProfile').html(data.errProfile);
                        $('#errUname').html(data.errUname);
                        $('#errPass').html(data.errPass);
                        console.log(data.loggdUser);
                        if(data.loggedUser != undefined)
                        {
                            loggedUser = data.loggedUser;
                            
                            $('#loggedDiv').css('display','block');
                            $('#noLoggedDiv').css('display','none');
                            closeForm();
                        }
                    }
                });
            }
        });
        console.log(loggedUser);

        if($('#unamebox').val() != ""){
            $(this).addClass('focus');
        }
        if($('#passbox').val() != ""){
            $(this).addClass('focus');
        }

        $('#urlBox,#resultUrlBox','.mini-container').focus(function(){
            $('.alter-options').fadeOut();
        });
        $('#urlBox,#resultUrlBox','.mini-container').focusout(function(){
            $('.alter-options').fadeIn();
        });


    </script>
</body>

</html>