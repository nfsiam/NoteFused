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

    if(isset($_POST['delete']))
    {
        if(!empty($_POST['delete']))
        {
            $delete = htmlspecialchars($_POST['delete']);
            if($delete == 'note')
            {
                try
                {
                    $noteID = htmlspecialchars($_POST['noteID']);
                    $query = "DELETE from notes where noteID='$noteID'";
                    execute($query);
                    $jsn['success'] = 'true';
                }
                catch(Exception $e)
                {
                    $jsn['success'] = 'false';
                }
            }
            elseif($delete == 'file')
            {
                try
                {
                    $fileID = htmlspecialchars($_POST['fileID']);
                    $query = "DELETE from files where fileID='$fileID'";
                    unlink("upload/$fileID"); //deleting file from server
                    execute($query); //removing record from database
                    $jsn['success'] = 'true';
                }
                catch(Exception $e)
                {
                    $jsn['success'] = 'false';
                }
            }
            elseif($delete == 'url')
            {
                try
                {
                    $surl = htmlspecialchars($_POST['surl']);
                    //it will delete record for logged user
                    $query = "DELETE from urlmap where surl='$surl' and urlOwner='$loggedUser'";
                    execute($query); //removing record from urlmap

                    //check if any other record exists for another owner
                    $query = "SELECT * FROM urlmap WHERE surl='$surl'";
                    $result=get($query);

                    if(mysqli_num_rows($result) > 0)
                    {
                       //we do nothing lol
                    }
                    else
                    {
                        $query = "DELETE from urls where surl='$surl'";
                        execute($query); //removing record from urls
                    }
                    $jsn['success'] = 'true';
                }
                catch(Exception $e)
                {
                    $jsn['success'] = 'false';
                }
            }
        }

        echo json_encode($jsn);
    }
?>