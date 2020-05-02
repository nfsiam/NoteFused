<?php
    session_start();
    require "settingshandler.php";
    $name = $uname = $email = "";
    $btn1text = $btn2text =$btn3text = "Select";
    function setInfo()
    {
        $info = getInfo();
        
        if($info != false)
        {
            global $name, $uname, $email, $btn1text, $btn2text, $btn3text;
            $name = $info['name'];
            $uname = $info['username'];
            $email = $info['email'];
            if($info['plan'] == 0 ) $btn1text = 'Selected';
            elseif($info['plan'] == 1 ) $btn1text = 'Selected';
            elseif($info['plan'] == 2 ) $btn1text = 'Selected';
        }

    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NoteFused</title>
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.7/css/all.css"> -->
    <link rel="stylesheet" href="styles/base.css">
    <link rel="stylesheet" href="styles/form.css">
    <link rel="stylesheet" href="styles/profilesettings.css">
    <link rel="stylesheet" href="styles/optiontoggler.css">
    <!-- <link rel="stylesheet" href="styles/login.css"> -->
    <link rel="stylesheet" href="styles/navbar.css">
    <link rel="stylesheet" href="styles/userdashcard.css">


    <script src="js/jquery341.js"></script>
    <script src="js/sidebarfunctionality.js" defer></script>
    <script src="js/shortnerfunctionality.js" defer></script>
    <script src="js/optiontogglerfunctionality.js" defer></script>
    <!-- <script src="js/loginvalidationfunctionality.js" defer></script> -->
    <script src="js/navbarfunctionality.js" defer></script>
    <script src="js/userdashcardfunctionality.js" defer></script>
    <script src="js/settingsfunctionality.js" defer></script>


</head>
<body>
    <div class="holder">
        <?php require "navbar.php"; ?>
        <div class="container">
            
            <div class="sidebar">
                <?php require "userdashcard.php";
                setInfo(); //to override the name of userdashcard
                ?>
            </div>
            <div class="fuse">
                <div class="mini-container">
                    <section id="personalInfo">
                        <div class="section-title">
                            <span>Personal Info</span>
                        </div>
                        <div class="section-content">
                            <div class="input-sec">
                                <input type="text" name="name" id="namebox" value="<?php echo $name;?>">
                                <span data-placeholder="name"></span>
                            </div>
                            <div class="warn"><?php //echo $err_name; ?></div>
                            <div class="input-sec">
                                <input type="text" name="uname" id="unamebox" value="<?php echo $uname ;?>">
                                <span data-placeholder="username"></span>
                            </div>
                            <div class="warn"><?php //echo $err_uname; ?></div>
                            <div class="input-sec">
                                <input type="text" name="email" id="emailbox" value="<?php echo $email ;?>">
                                <span data-placeholder="email"></span>
                            </div>
                            <div class="warn"><?php //echo $err_email; ?></div>
                            <div class="input-sec">
                                <input type="password" name="oldpass" id="oldpassbox" value="<?php //echo $pass ;?>">
                                <span data-placeholder="old password"></span>
                            </div>
                            <div class="warn"><?php //echo $err_pass; ?></div>
                            <div><input type="checkbox" name="" id="passchange"><label for="passchange">Change Password</label></div>
                            <div class="input-sec">
                                <input type="password" name="pass" id="newpassbox" value="<?php //echo $pass ;?>">
                                <span data-placeholder="new password"></span>
                            </div>
                            <div class="warn"><?php //echo $err_pass; ?></div>
                            <div class="input-sec">
                                <input type="password" name="cpass" id="cnewpassbox" value="<?php //echo $cpass ?>">
                                <span data-placeholder="confirm new password"></span>
                            </div>
                            <div class="warn"><?php //echo $err_cpass; ?></div>
                            <div class="button-holder">
                                <input type="reset" value="Clear Changes" class="resBtn" id="resetButton" onclick="resetForm()">
                                <div class="gap"></div>
                                <input type="submit" value="Update" class="subBtn" name="register">
                            </div>
                        </div>
                    </section>
                    <div class="secdiv"></div>
                    <section id="plans">
                        <div class="section-title">
                            <span class="title">Upgrade Plan</span>
                        </div>
                        <div class="section-content">
                            <div class="compare-table">
                                <div class="basic-plan card">
                                    <div>Basic</div>
                                    <div>$0.00/Month</div>
                                    <div>Unlimited Public Note</div>
                                    <div>50 Private Note Limit</div>
                                    <div>
                                        10 Files Limit
                                        <br>
                                        Maximum 10MB
                                    </div>
                                    <div>50 Short URL Limit</div>
                                    <div>-</div>
                                    <div>-</div>
                                    <div><button><?php echo $btn1text; ?></button></div>
                                </div>
                                <div class="pro-plan card">
                                    <div>Pro</div>
                                    <div>$3.00/Month</div>
                                    <div>Unlimited Public Note</div>
                                    <div>200 Private Note Limit</div>
                                    <div>
                                        20 Files Limit
                                        <br>
                                        Maximum 50MB
                                    </div>
                                    <div>200 Short URL Limit</div>
                                    <div>Pinned Profile</div>
                                    <div>-</div>
                                    <div><button><?php echo $btn2text; ?></button></div>
                                </div>
                                <div class="ultra-plan card">
                                    <div>Ultra</div>
                                    <div>$40.00/Month</div>
                                    <div>Unlimited Public Note</div>
                                    <div>Unlimited Private Note</div>
                                    <div>
                                        200 Files Limit
                                        <br>
                                        Maximum 1GB
                                    </div>
                                    <div>Unlimited Short URL</div>
                                    <div>Pinned Profile</div>
                                    <div>Profile Verifiation</div>
                                    <div><button><?php echo $btn3text; ?></button></div>
                                </div>
                            </div>
                            <div class="request-status">
                                You have not requested any plan change
                            </div>
                        </div>
                    </section>
                    
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
    </div>
    <script>
    </script>
</body>

</html>