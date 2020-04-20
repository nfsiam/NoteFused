<?php
    session_start();
    require_once 'db/dbcon.php';

    $loggedUser = "";
    $filename = "";
    
    if(isset($_SESSION['user'])) 
    {
        $user = $_SESSION['user'];
        if(isset($user['username']))
        {
            $loggedUser = $user['username'];
        }
    }
    if(isset($_GET['id']))
    {
        if(!empty($_GET['id']))
        {
            
            $id = $_GET['id'];

            $query = "SELECT * FROM files WHERE fileID='$id'";
            
            $result=get($query);
            //print_r($result);
            

            if(mysqli_num_rows($result) > 0)
            {
                $file=mysqli_fetch_assoc($result);
                if($file['filePrivacy']==1)
                {
                    if($file['fileOwner']!=$loggedUser)
                    {
                        header('Location:../login.php');
                        return;
                    }
                }
                $filename = $file['fName'];

            }
            $file = 'upload/'.$id;

            if (file_exists($file)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="'.$filename.'"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file));
                readfile($file);
                exit;
            }
        }
    }
?>