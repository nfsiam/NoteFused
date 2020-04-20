<?php
    session_start();
    require_once 'db/dbcon.php';

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
        }

        echo json_encode($jsn);
    }
?>