<?php
    session_start();
    require "includes/initiatenotepad.php";
    require "includes/indexloginvalidation.php";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NoteFused</title>
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.7/css/all.css"> -->
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/side2.css">
    <link rel="stylesheet" href="styles/login.css">
    <link rel="stylesheet" href="styles/form.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


</head>

<body>
    <div class="container">
        <div class="sidebar">
            <ul class="top">
                <li>
                    <button class="parentButton" onclick="showChild(this)" id="p1">Profile</button>
                    <ul class="drp" id="drp1">
                        <?php
                            
                            if(isset($_SESSION['user']))
                            {
                                echo "<li><a href='mynotes.html'><button class='childButton'>My Notes</button></a></li>";
                                echo "<li><a href='destroysession.php'><button class='childButton'>Logout</button></a></li>";
                                //<a href="contact.php"><button class="last-parent" onclick="showChild(this)"id="p3">Contact</button></a>
                            }
                            else
                            {
                                echo "<li><button class='childButton' onclick='openForm()'>Login</button></li>";
                                echo "<li><button class='childButton' onclick='goToReg()'>Register</button></li>";
                            }
                        ?>
                    </ul>
                </li>
                <li>
                    <button class="parentButton" onclick="showChild(this)" id="p2">Settings</button>
                    <div class="drp" id="drp2">
                        <input type="button" value="Log In" class="childButton">
                    </div>
                </li>
                <li>
                    <a href="contact.php"><button class="last-parent" onclick="showChild(this)"
                            id="p3">Contact</button></a>
                    <!-- <div class="drp" id="drp3">
                        <input type="button" value="Log In" class="childButton">

                    </div> -->

                </li>
            </ul>
        </div>
        <div class="editor">
            <div class="bar" id="bar">
                <div class="head-bar">
                    <div class="title">
                        <a href="./">NoteFused</a>
                    </div>
                    <div class="btns">
                        <button id="expand">
                            <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                            <g>
                                <title>background</title>
                                <rect fill="none" id="canvas_background" height="402" width="582" y="-1" x="-1"/>
                            </g>
                            <g>
                                <title>Layer 1</title>
                                <path id="svg_1" d="m256,298.3l0,0l0,0l174.2,-167.2c4.3,-4.2 11.4,-4.1 15.8,0.2l30.6,29.9c4.4,4.3 4.5,11.3 0.2,15.5l-212.7,204.2c-2.2,2.2 -5.2,3.2 -8.1,3c-3,0.1 -5.9,-0.9 -8.1,-3l-212.7,-204.2c-4.3,-4.2 -4.2,-11.2 0.2,-15.5l30.6,-29.9c4.4,-4.3 11.5,-4.4 15.8,-0.2l174.2,167.2z"/>
                            </g>
                        </svg>
                    </button>
                                                                                    
                        <button onclick="openForm()" id="ham">&#9776</button>
                    </div>
                </div>
                <form action="" id="noteForm">
                <div class="edit-settings" id="editSettings">
                    <div class="privacy-radio-holder sub-settings">
                        <div class="sep-div"><input type="radio" name="privacy" id="privpub" value="public" <?php echo $privacypub; ?> ><span>Public Note</span></div>
                        <div class="sep-div"><input type="radio" name="privacy" id="privpri" value="private" <?php echo $privacypriv; ?> ><span>Private Note</span></div>
                    </div>
                    <div class="sub-settings">
                        <div class="sep-div">
                            <span>Expiration</span>
                            <select name="" id="expire">
                                <option value="3650" <?php echo $exp[0] ;?> >None</option>
                                <option value="3" <?php echo $exp[1] ;?> >3 days</option>
                                <option value="7" <?php echo $exp[2] ;?> >7 days</option>
                                <option value="30" <?php echo $exp[3] ;?> >30 days</option>
                            </select>
                        </div>
                    </div>
                    <div class="sub-settings">
                        <div class="sep-div">
                            <span>Author</span>
                            <input type="text" name="" id="author" value="<?php echo $noteOwner; ?>" readonly>
                        </div>
                    </div>
                    
                </div>
            </div>
            
            <div class="notepad">
                <textarea name="" id="pad" spellcheck="false" placeholder="Start typing notes here..."><?php echo $noteText; ?></textarea>
            </div>

        </form>
        </div>
    </div>
    <div id="disableDiv">


    </div>
    <div class="loginform" id="loginForm">
        <button id="close" onclick="closeForm()">x</button>
        <form action="" id="" method="post">
            <h1 class="form-heading">Login</h1>
            <div class="warn"><?php echo $err_profile; ?></div>
            <div class="input-sec">
                <input type="text" name="uname" id="unamebox" value="<?php echo $uname; ?>">
                <span data-placeholder="username" ></span>
            </div>
            <div class="warn"><?php echo $err_uname; ?></div>
            <div class="input-sec">
                <input type="password" name="pass" id="passbox" value="<?php echo $pass;?>">
                <span data-placeholder="password"></span>
            </div>
            <div class="warn"><?php echo $err_pass; ?></div>
            <div class="button-holder">
                <input type="submit" value="Login" class="subBtn" name="login" >
            </div>
            <div class="bottomText">
                Don't have an account? <a href="reg.php">Register Now</a>
            </div>

        </form>
    </div>
    <script>
        function setupTextAreaHeight()
        {
            let h = $('#bar').height();
            document.documentElement.style.setProperty('--edsetH', `${h}px`);
        }
        $(window).ready(function(){
            setupTextAreaHeight();
            
        });
        $(window).resize(function(){
            setupTextAreaHeight();
        });
        

        function hideChild() {
            document.getElementById("drp1").display = "none";

        }
        function openForm() {
            document.getElementById("disableDiv").style.display = "block";
            document.getElementById("loginForm").style.display = "block";
        }

        function closeForm() {
            document.getElementById("unamebox").value = "";
            document.getElementById("passbox").value = "";
            $(".input-sec input").removeClass('focus');
            document.getElementById("disableDiv").style.display = "none";
            document.getElementById("loginForm").style.display = "none";
        }

        function goToReg() {
            window.location.href = "reg.php";
        }
        function showChild(ele) {
            var id = ele.id;
            if (id == "p1") {
                document.getElementById("drp1").style.display = "block";
                document.getElementById("drp1").focus();
                document.getElementById("drp2").style.display = "none";
                // document.getElementById("drp3").style.display = "none";
            }
            if (id == "p2") {
                document.getElementById("drp2").style.display = "block";
                document.getElementById("drp2").focus();
                document.getElementById("drp1").style.display = "none";
                // document.getElementById("drp3").style.display = "none";
            }
            // if (id == "p3") {
            //     document.getElementById("drp3").style.display = "block";
            //     document.getElementById("drp3").focus();
            //     document.getElementById("drp1").style.display = "none";
            //     document.getElementById("drp2").style.display = "none";
            // }

        }


        $(".input-sec input").on("focus", function () {
            $(this).addClass("focus");
        });
        $(".input-sec input").on("blur", function () {
            if ($(this).val() == "") {
                $(this).removeClass('focus');
            }
        });

        let expand = document.getElementById('expand');
        let editSettings = document.getElementById('editSettings');
        
        expand.addEventListener('click',()=>{
            //console.log('outer');
            if($('#editSettings').css('display') == "none")
            {
                editSettings.style.display = "block";
                setupTextAreaHeight();
                return;
            }
            if($('#editSettings').css('display') == "block")
            {
                editSettings.style.display = "none";
                setupTextAreaHeight();
                return;
            }            
        });

        function onNoteChange()
        {
            //console.log("1");
            let priv = $('input[name=privacy]:checked', '#noteForm').val() == "public" ? 0 : 1;
            let author = $('#author', '#noteForm').val();
            let expire = $('#expire', '#noteForm').val();
            let padtext  = $('#pad').val();

            let noteID = "<?php echo $noteID; ?>";
            let expiration = "<?php echo $expiration.''; ?>";
            let lastEdited = "<?php 
                                $date = date("Y-m-d H:i:s");
                                echo $date.'';
                                ?>";
            let lastVisited = "<?php echo $lastVisited.''; ?>";
            //console.log(padtext);


            $.ajax({

                url:'updatenote.php',
                method:'POST',
                data:{
                    submit:"submit",
                    noteText:  padtext,
                    noteOwner:  author,
                    notePrivacy: priv,
                    expiration:  expiration,
                    lastEdited: lastEdited,
                    lastVisited:  lastVisited,
                    xpire:  expire,
                    noteID: noteID
                },
                success:function(response){
                    //alert(response);
                    //console.log("3");

                }
            });
        }


        $('#noteForm input').on('change', function() {
            onNoteChange();
        //alert($('input[name=privacy]:checked', '#noteForm').val()); 
        });

        $('#expire').on('change',function(){
            onNoteChange();
        });
        $('#pad').keyup(function(){
            onNoteChange();
        });
        




    </script>
    <?php
            if($uname != "")
            {
                echo "<script>
                $('#unamebox').addClass('focus');
                </script>";
            }
            if($pass != "")
            {
                echo "<script>
                $('#passbox').addClass('focus');
                </script>";
            }
            if(isset($_POST['login']))
            {
                echo "<script>document.getElementById('disableDiv').style.display = 'block';
                document.getElementById('loginForm').style.display = 'block';</script>";
            }
        ?>
</body>

</html>