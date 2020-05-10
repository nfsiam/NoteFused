<?php
    session_start();
    // require "includes/initiatenotepad.php";
    //require "includes/indexloginvalidation.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NoteFused</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.7/css/all.css">
    <link rel="stylesheet" href="styles/side2.css">
    <link rel="stylesheet" href="styles/base.css">
    <link rel="stylesheet" href="styles/short.css">
    <link rel="stylesheet" href="styles/optiontoggler.css">
    <link rel="stylesheet" href="styles/login.css">
    <link rel="stylesheet" href="styles/form.css">
    <link rel="stylesheet" href="styles/navbar.css">
    <link rel="stylesheet" href="styles/userdashcard.css">


    <script src="js/jquery341.js"></script>
    <script src="js/sidebarfunctionality.js" defer></script>
    <script src="js/shortnerfunctionality.js" defer></script>
    <script src="js/optiontogglerfunctionality.js" defer></script>
    <!-- <script src="js/loginvalidationfunctionality.js" defer></script> -->
    <script src="js/navbarfunctionality.js" defer></script>
    <script src="js/userdashcardfunctionality.js" defer></script>


</head>
<body>
    <div class="holder">
        <!-- <div class="navbar">
            <div class="headings">
                <a href="./">NoteFused</a>
            </div>
        </div> -->
        <?php require "navbar.php"; ?>

        <div class="container">
            
            <div class="sidebar">
                <?php require "userdashcard.php"; ?>
            </div>
            <div class="fuse">
                <div class="mini-container">
                    <div class="row2">
                        <div class="example-span">
                            <span id="exampleSpan">Enter your URL below</span>
                        </div>
                        <div class="row1">
                            <div class="url-box">
                                <input type="text" class="urlBox" name="" id="urlBox" placeholder="http://www.example.com" spellcheck="false">
                            </div>
                            <div class="button-box">
                                <button id="shortenButton">Shorten</button>
                            </div>
                        </div>
                    </div>
                    <div class="row2 result-row">
                        <div class="example-span">
                            <span id="exampleSpan">Here is your short URL</span>
                        </div>
                        <div class="row1">
                            <div class="url-box result-url-box">
                                <input type="text" class="urlBox" name="" id="resultUrlBox"spellcheck="false">
                            </div>
                            <div class="button-box copy-button-box">
                                <button id="copyButton"><i class="fas fa-copy"></i></button>
                            </div>
                        </div>
                        <div class="alert">
                                <span>link copied to your clipboard</span>
                        </div>
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
    </div>
    <script>
    </script>
</body>

</html>