<?php
    session_start();
    require "handlers/indexhandler.php";
    // require "includes/initiatenotepad.php";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NoteFused</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.7/css/all.css">
    <link rel="stylesheet" href="styles/optiontoggler.css">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/side2.css">
    <link rel="stylesheet" href="styles/login.css">
    <link rel="stylesheet" href="styles/form.css">

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
    <script src="js/jquery341.js"></script>
    <script src="js/sidebarfunctionality.js" defer></script>
    <script src="js/editorfunctionality.js" defer></script>
    <script src="js/optiontogglerfunctionality.js" defer></script>
    <script src="js/loginvalidationfunctionality.js" defer></script>


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
                            <li><a href='modules/destroysessionmodule.php'><button class='childButton'>Logout</button></a></li>
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
            
            <div class="fuse">
                <textarea name="" id="pad" spellcheck="false" placeholder="Start typing notes here..."><?php echo $noteText; ?></textarea>
            </div>
            </form>
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
        let noteid = '<?php echo $noteID; ?>';
    </script>
</body>

</html>