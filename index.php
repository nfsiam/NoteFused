<?php
    require "includes/initiatenotepad.php";
    require "includes/indexloginvalidation.php";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NoteFused</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.7/css/all.css">
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
                        <li><button class="childButton" onclick="openForm()">Login</button></li>
                        <li><button class="childButton" onclick="goToReg()">Register</button></li>
                        <li><a href="mynotes.html"><button class="childButton">My Notes</button></a></li>
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
            <div class="bar">
                <div class="title">
                    <a href="./">NoteFused</a>
                </div>
                <div class="btns">
                    <button onclick="openForm()" id="ham">&#9776</button>
                </div>
            </div>
            <div class="notepad">
                <textarea name="" id="pad" spellcheck="false" placeholder="Start typing notes here..."><?php echo $noteText; ?></textarea>
            </div>

        </div>
    </div>
    <div id="disableDiv">


    </div>
    <div class="loginform" id="loginForm">
        <button id="close" onclick="closeForm()">x</button>
        <form action="" id="" method="post">
            <h1 class="form-heading">Login</h1>
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
                document.getElementById("drp3").style.display = "none";
            }
            if (id == "p2") {
                document.getElementById("drp2").style.display = "block";
                document.getElementById("drp2").focus();
                document.getElementById("drp1").style.display = "none";
                document.getElementById("drp3").style.display = "none";
            }
            if (id == "p3") {
                document.getElementById("drp3").style.display = "block";
                document.getElementById("drp3").focus();
                document.getElementById("drp1").style.display = "none";
                document.getElementById("drp2").style.display = "none";
            }

        }


        $(".input-sec input").on("focus", function () {
            $(this).addClass("focus");
        });
        $(".input-sec input").on("blur", function () {
            if ($(this).val() == "") {
                $(this).removeClass('focus');
            }
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