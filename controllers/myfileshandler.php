<?php
    session_start();
    // require_once dirname(__FILE__).'/../db/dbcon.php';
    require_once dirname(__FILE__).'/../models/db/dbcon.php';


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

            //stat update
            $datestamp = time();
            $query = "INSERT INTO stat (datestamp,username,filedownload) VALUES('$datestamp','$loggedUser', '1');";
            execute($query);
            //print_r($result);
            

            if(mysqli_num_rows($result) > 0)
            {
                $file=mysqli_fetch_assoc($result);
                if($file['filePrivacy']==1)
                {
                    // echo "yes";
                    // echo $loggedUser;
                    // echo $file['fileOwner'];
                    if($file['fileOwner']!=$loggedUser)
                    {
                        header('Location:../controllers/destroysessionmodule.php');
                        return;
                    }
                }
                $filename = $file['fName'];

            }
            $file = '../models/upload/'.$id;

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