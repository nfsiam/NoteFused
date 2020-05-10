<?php
    session_start();
    require_once dirname(__FILE__).'/../db/dbcon.php';


    $loggedUser = "";
    if(isset($_SESSION['user'])) 
    {
        $user = $_SESSION['user'];
        if(isset($user['username']))
        {
            $loggedUser = $user['username'];
        }
    }
    
    $jsn = array();
    $jsn['success'] = 'false';

    if(isset($_POST['update']))
    {
        if(!empty($_POST['update']))
        {
            $update = htmlspecialchars($_POST['update']);
            if($update == 'filePrivacy')
            {
                try
                {
                    $fileID = htmlspecialchars($_POST['fileID']);
                    $filePrivacy = htmlspecialchars($_POST['filePrivacy']);
                    $query = "UPDATE files set filePrivacy='$filePrivacy' where fileID='$fileID' and fileOwner='$loggedUser'";
                    execute($query);
                    $jsn['success'] = 'true';
                }
                catch(Error $e)
                {
                    $jsn['success'] = 'false';
                }
            }
            if($update == 'note')
            {
                try
                {
                    //VALIDATION REQUIRED**********************
                    $noteOwner = empty($loggedUser)? "guest" : $loggedUser;
                    $noteText =  $_POST['noteText'];
                    $notePrivacy = $_POST['notePrivacy'];
                    $xpire =  $_POST['xpire'];
                    $lastVisited = time();
                    $lastEdited = time();
                    $expiration = strtotime("+$xpire days", time());
                    $noteID = $_POST['noteID'];
                    $query = "UPDATE notes SET notePrivacy='$notePrivacy', noteOwner='$noteOwner', lastEdited='$lastEdited', xpire='$xpire', lastVisited = '$lastVisited', expiration ='$expiration', text='$noteText' WHERE noteID='$noteID'";
                    execute($query);
                    $jsn['success'] = 'true';
                }
                catch(Error $e)
                {
                    $jsn['success'] = 'false';
                }
            }
        }

        echo json_encode($jsn);
    }
?>