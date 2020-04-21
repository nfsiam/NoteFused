<?php
    session_start();
    //require "includes/initiatenotepad.php";
    //require "includes/indexloginvalidation.php";
    require_once "db/dbcon.php";

    $resarr = array();

    function shortDate($longDate)
    {
        $date=date_create("$longDate");

        
        return date_format($date,"d/M/y");
    }

    if(isset($_SESSION['user'])) 
    {
        $user = $_SESSION['user'];
        if(isset($user['username']))
        {
            $loggedUser = $user['username'];
        }

        $query = "SELECT * from urlmap WHERE urlOwner='$loggedUser'";
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.7/css/all.css">
    <link rel="stylesheet" href="styles/side2.css">
    <link rel="stylesheet" href="styles/base.css">
    <link rel="stylesheet" href="styles/myurl2.css">
    <link rel="stylesheet" href="styles/optiontoggler.css">
    <link rel="stylesheet" href="styles/login.css">
    <link rel="stylesheet" href="styles/form.css">
    <link rel="stylesheet" href="styles/navbar.css">
    <link rel="stylesheet" href="styles/userdashcard.css">


    <script src="js/jquery341.js"></script>
    <script src="js/sidebarfunctionality.js" defer></script>
    <script src="js/myurlsfunctionality.js" defer></script>
    <script src="js/optiontogglerfunctionality.js" defer></script>
    <script src="js/loginvalidationfunctionality.js" defer></script>
    <script src="js/navbarfunctionality.js" defer></script>
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
                    <div class="row-head">
                    <div class='row1'>
                            <div class='col1'>
                                SL
                            </div>
                        </div>
                        <div class='row2'>
                            <div class='col2'>
                                Full URL
                            </div>
                        </div>
                        <div class='row3'>
                            <div class='col3'>
                                Short URL
                            </div>
                        </div>
                        <div class='row4'>
                            <div class='col4'>
                                Copy Link
                            </div>
                            <div class='col5'>
                                Delete
                            </div>
                        </div>
                    </div>
                    
<?php
    $urls = array();
    $c = 1;
    foreach($resarr as $res)
    {
        $surl =  $res['surl'];

        $query = "SELECT * from urls WHERE surl='$surl'";
        $result=get($query);
		while($row = mysqli_fetch_assoc($result))
		{
            $fullUrl = $row['longUrl'];
            $srl = $shortUrl = $row['surl'];
            $shortUrl = 'http://192.168.137.1/webtech/notefused/go/'.$shortUrl;
            echo    "<div class='row-plate'>
                        <div class='row1'>
                            <div class='col1'>
                                $c
                            </div>
                        </div>
                        <div class='row2'>
                            <div class='col2'>
                                <a href='$fullUrl'>$fullUrl</a>
                            </div>
                        </div>
                        <div class='row3'>
                            <div class='col3'>
                                <a href='$shortUrl'>$shortUrl</a>
                            </div>
                        </div>
                        <div class='row4'>
                            <div class='col4'>
                                <a href=''><i class='fas fa-copy'></i></a>
                            </div>
                            <div class='col5'>
                                <a href='' id='$srl'><i class='fa fa-trash' aria-hidden='true'></i></a>
                            </div>
                        </div>
                    </div>";
                    $c++;
        }

    }
    /* foreach($resarr as $res)
    {
        $fileName = $res['fName'];
        $uploadDate = shortDate($res['uploadDate']);
        $expiration = shortDate($res['expiration']);
        $privacy = $res['filePrivacy']==0? 'public':'private';
        $privTitle = $privacy=="public"?'Anybody with the link can download the file'
                                        :'Only you can download the file while logged in';
        $fileID = $res['fileID'];
        $dlink = 'http://192.168.137.1/webtech/notefused/file/'.$res['fileID'];

    
            
            echo    "<div class='row-plate'>
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
                                $privacy
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
    } */

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
        
        let loggedUser ="<?php echo empty($loggedUser)?'':$loggedUser?>";
        let noteid = '<?php echo $noteID; ?>';

        // console.log("aaaa: "+loggedUser);
        
        //sidebar
        
        //option toggler
        
        //login validation
        

    </script>
</body>

</html>