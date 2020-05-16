<?php
    session_start();
    // require "includes/initiatenotepad.php";
    //require "includes/indexloginvalidation.php";

    //preventing access from view route
    if (strpos($_SERVER['REQUEST_URI'], '/views/') !== false) {
        exit();
    }
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NoteFused</title>

    <link rel="stylesheet" href="views/styles/all.css">
    <link rel="stylesheet" href="views/styles/side2.css">
    <link rel="stylesheet" href="views/styles/base.css">
    <link rel="stylesheet" href="views/styles/file.css">
    <link rel="stylesheet" href="views/styles/optiontoggler.css">
    <link rel="stylesheet" href="views/styles/login.css">
    <link rel="stylesheet" href="views/styles/form.css">
    <link rel="stylesheet" href="views/styles/navbar.css">
    <link rel="stylesheet" href="views/styles/userdashcard.css">
    <link rel="stylesheet" href="views/styles/throwlert.css" />
    <link rel="stylesheet" href="views/styles/sidebar.css" />


    <script src="views/js/jquery341.js"></script>
    <script src="views/js/throwlert.js" defer></script>
    <script src="views/js/fileuploadfunctionality.js" defer></script>
    <script src="views/js/optiontogglerfunctionality.js" defer></script>
    <script src="views/js/navbarfunctionality.js" defer></script>
    <script src="views/js/userdashcardfunctionality.js" defer></script>
    <script src="views/js/sidebar.js" defer></script>


    <style>
        .inp-but{
            display:none;
        }
    </style>

</head>
<body>
    <?php require "sidebar.php"; ?>
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
                    <div>
                        <div class="row1">
                            Upload files
                        </div>
                        <div class="row2">
                            <label for="choose" class="choose-label">Select Files</label>
                            <input type="file" name="file[]" id="choose"  multiple>
                        </div>
                        <div class="row3">
                            or Drag and Drop yout files here
                        </div>
                        <div class="row4">
                        </div>
                        <div class="row5">
                            <button id="uploadButton">Upload</button>
                        </div>
                    </div>
                    <div class="row6">
                        <progress id='prog'></progress>
                    </div>
                    
                    <div class="res">
                        <!-- <div class="res-child">
                            <div class="res-child-name">some</div>
                            <div class="res-child-link"><a href="">some</a></div>
                        </div>
                        <div class="res-child">
                            <div class="res-child-name">some</div>
                            <div class="res-child-link"><a href="">some</a></div>
                        </div>
                        <div class="res-child">
                            <div class="res-child-name">some</div>
                            <div class="res-child-link"><a href="">some</a></div>
                        </div> -->
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
    <div class="throwlert">
            <div class="alert-box">
                <div class="alert-close-button">
                    <button><i class="fas fa-times"></i></button>
                </div>
                <div class="alert-type type-success">
                    <i class="far fa-check-circle"></i>
                </div>
                <div class="alert-type type-error">
                    <i class="far fa-times-circle"></i>
                </div>
                <div class="alert-dialog"></div>
            </div>
        </div>
    <script>
    </script>
</body>

</html>