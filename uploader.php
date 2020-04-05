<?php
    session_start();
    require_once "db/dbcon.php";
    require_once "uniqstringgenerator.php";
    require_once "filenamesanitizer.php";
    $loggedUser = "";
    $resarr = array();

    if(isset($_SESSION['user'])) 
    {
        $user = $_SESSION['user'];
        if(isset($user['username']))
        {
            $loggedUser = $user['username'];
        }
    }   

    function dbOperation($filename,$fileID)
    {
        global $loggedUser;
        $uploadDate = date("Y-m-d H:i:s");
        $xpire = 3;
        $expiration = Date('Y-m-d H:i:s', strtotime("+$xpire days"));
        $privacy = 0;
        // echo $loggedUser;


        if(empty($loggedUser))
        {
            $loggedUser = "test-user";
        }
        else
        {
            //users preferred template
        }

        $query = "INSERT INTO files (fileID,fileOwner, filePrivacy,fName,uploadDate,expiration,xpire)
        VALUES ('$fileID','$loggedUser', '$privacy', '$filename','$uploadDate','$expiration','$xpire')";
        execute($query);

    }


    

    $count = count($_FILES['file']['name']);
    // $data = array();
    $filesize = 0;
    $fileNames = array();
    $noProb = true; 

    for($i=0;$i<$count;$i++)
    {
        $name = filter_filename($_FILES['file']['name'][$i]);
        $fileNames[] = $name;
        $filesize += $_FILES['file']['size'][$i];
        if(ceil($filesize/1024) > 1024)
        {
            //echo ceil($filesize/1024);
            $noProb =false;
            break;
        }
    }

    $output = "";

    if($noProb)
    {
        for($i=0;$i<$count;$i++)
        {
            
            $filename = $fileNames[$i];
            try
            {
                $uniqfilename =  generateUniq('files','fileID');
                dbOperation($filename,$uniqfilename);
                if(move_uploaded_file($_FILES['file']['tmp_name'][$i],'upload/'.$uniqfilename))
                {
                    $outputurl = 'http://192.168.137.1/webtech/notefused/file/'.$uniqfilename;
                    $a = '<a href="'.$outputurl.'">'.$outputurl.'</a>';

                    $output .= '<div class="res-child">
                                    <div class="res-child-name">'.$filename.'</div>
                                    <div class="res-child-link">'.$a.'
                                    </div>
                                </div>';
                }
                else
                {
                    dbOperationDelete($uniqfilename);
                }
            }
            catch(Exception $e)
            {
                echo "Something Went wrong";
            }
        }
        echo $output;
    }
?>