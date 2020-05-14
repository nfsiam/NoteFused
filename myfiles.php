<?php
    session_start();

    require_once "db/dbcon.php";

    date_default_timezone_set("Asia/Dhaka");


    $loggedUser = "";

    $resarr = array();

    function shortDate($longDate)
    {
        // $date=date_create("$longDate");

        
        // return date_format($date,"d/M/y");
        return date('d/m/Y',$longDate);
    }

    if(isset($_SESSION['user'])) 
    {
        $user = $_SESSION['user'];
        if(isset($user['username']))
        {
            $loggedUser = $user['username'];
        }

        $query = "SELECT * FROM files WHERE fileOwner='$loggedUser'";
        $result=get($query);
        //print_r($result);
        
        

		while($row = mysqli_fetch_assoc($result))
		{
            $resarr[] = $row;
            //$notecounts++;
        }

        // foreach($resarr as $res)
        // {
        //     echo $res['text'];
        //     echo "<br>";
        // }
        //print_r($resarr);
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NoteFused</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/all.css">
    <link rel="stylesheet" href="styles/throwlert.css">
    <!-- <link rel="stylesheet" href="styles/short.css"> -->
    <link rel="stylesheet" href="styles/side2.css">
    <!-- <link rel="stylesheet" href="styles/short.css"> -->
    <link rel="stylesheet" href="styles/base.css">
    <link rel="stylesheet" href="styles/myfiles.css">
    <link rel="stylesheet" href="styles/optiontoggler.css">
    <link rel="stylesheet" href="styles/login.css">
    <link rel="stylesheet" href="styles/form.css">
    <link rel="stylesheet" href="styles/navbar.css">
    <link rel="stylesheet" href="styles/userdashcard.css">

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
    <script src="js/jquery341.js"></script>
    <script src="js/throwlert.js" defer></script>
    <script src="js/sidebarfunctionality.js" defer></script>
    <script src="js/myfilesfunctionality.js" defer></script>
    <script src="js/optiontogglerfunctionality.js" defer></script>
    <!-- <script src="js/loginvalidationfunctionality.js" defer></script> -->
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
                <!-- <div class="actions">
                    <input type="text" name="" id="" placeholder="search">
                    <select id='sortSel'>
                        <option value="bydate">sort by date</option>
                        <option value="byname">sort by name</option>
                    </select>
                </div> -->
                <div class="mini-container">
                    <div class="row-head">
                        <!-- <div class="row-plate"> -->
                            <div class="row1">
                                <div class="col1">
                                    File Name
                                </div>
                            </div>
                            <div class="row2">
                                <div class="col2">
                                    Upload Date
                                </div>
                                <div class="col3">
                                    Privacy
                                </div>
                            </div>
                            <div class="row3">
                                <div class="col4">
                                    Download Link
                                </div>
                            </div>
                            <div class="row4">
                                <div class="col5">
                                    Copy Link
                                </div>
                                <div class="col6">
                                    Download
                                </div>
                                <div class="col7">
                                    Delete
                                </div>
                            </div>
                        <!-- </div> -->
                    </div>
                    
<?php
    foreach($resarr as $key=>$res)
    {
        $fileName = $res['fName'];
        $uploadDate = shortDate($res['uploadDate']);
        $privacy = $res['filePrivacy']==0? 'public':'private';
        $checkstate1 = $checkstate2 = "";
        if($privacy=='public') $checkstate1 = 'checked';
        if($privacy=='private') $checkstate2 = 'checked';
        $privTitle = $privacy=="public"?'Anybody with the link can download the file'
                                        :'Only you can download the file while logged in';
        $fileID = $res['fileID'];
        $dlink = 'http://192.168.137.1/webtech/notefused/file/'.$res['fileID'];

    
            
            echo    "<div class='row-plate' id='$fileID'>
                        <div class='row1'>
                            <div class='col1'>
                                $fileName
                            </div>
                        </div>
                        <div class='row2'>
                            <div class='col2'>
                                $uploadDate
                            </div>
                            <div class='col3' title='$privTitle'>
                                <div class='col3-inner'>
                                    <input type='radio' name='privacy$key' id='' value='0' $checkstate1> Public
                                    <br>
                                    <input type='radio' name='privacy$key' id='' value='1' $checkstate2> Private
                                </div>
                            </div>
                        </div>
                        <div class='row3'>
                            <div class='col4'>
                                <a class='abc' href='$dlink'>$dlink</a>
                            </div>
                        </div>
                        <div class='row4'>
                            <div class='col5'>
                                <a href=''><i class='fas fa-copy'></i></a>
                            </div>
                            <div class='col6'>
                                <a href='$dlink'><i class='fas fa-download'></i></a>
                            </div>
                            <div class='col7'>
                                <a href='' id='$fileID'><i class='fa fa-trash' aria-hidden='true'></i></a>
                            </div>
                        </div>
                    </div>";
    }

?>                    
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
</body>

</html>