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
    <link rel="stylesheet" href="styles/side2.css">
    <link rel="stylesheet" href="styles/base.css">
    <link rel="stylesheet" href="styles/file.css">
    <link rel="stylesheet" href="styles/optiontoggler.css">
    <link rel="stylesheet" href="styles/login.css">
    <link rel="stylesheet" href="styles/form.css">
    <link rel="stylesheet" href="styles/navbar.css">
    <link rel="stylesheet" href="styles/userdashcard.css">

    <script src="js/jquery341.js"></script>
    <script src="js/sidebarfunctionality.js" defer></script>
    <script src="js/fileuploadfunctionality.js" defer></script>
    <script src="js/optiontogglerfunctionality.js" defer></script>
    <script src="js/loginvalidationfunctionality.js" defer></script>
    <script src="js/navbarfunctionality.js" defer></script>
    <script src="js/userdashcardfunctionality.js" defer></script>

    <style>
        .inp-but{
            display:none;
        }
    </style>

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
    <script>
        
        let loggedUser ="<?php echo empty($loggedUser)?'':$loggedUser?>";
        let noteid = '<?php echo $noteID; ?>';

        // console.log("aaaa: "+loggedUser);
        
        //sidebar
        
        //option toggler
        
        //login validation
        

    </script>
</body>

</html>