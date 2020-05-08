<?php
    session_start();
    require_once "db/dbcon.php";
    require_once "uniqstringgeneratormodule.php";
    require_once "filenamesanitizermodule.php";
    require_once "planmodule.php";
    require_once "userstatmodule.php";
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

    function dbOperation($filename,$fileID,$fileSize)
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

        $query = "INSERT INTO files (fileID,fileOwner, filePrivacy,fName,uploadDate,expiration,xpire,filesize)
        VALUES ('$fileID','$loggedUser', '$privacy', '$filename','$uploadDate','$expiration','$xpire','$fileSize')";
        execute($query);

    }


    

    $count = count($_FILES['file']['name']);
    // $data = array();
    // $filesize = 0;
    $fileNames = array();
    $fileSizeArray = array();
    $noProb = true; 
    $fsinKB = 0;
    $errMsg = '';

    for($i=0;$i<$count;$i++)
    {
        $name = filter_filename($_FILES['file']['name'][$i]);
        $fileNames[] = $name;
        
        $fs = $_FILES['file']['size'][$i];
        
        $fileSizeArray[] = ceil($fs/1024);
        
        
        // $filesize += $_FILES['file']['size'][$i];
        // echo "alert('$filesize')";

        $fsinKB += ceil($fs/1024);

        $usedSpace = getFileSize();
        $filelimit = getLimit('file');

        $remainingSapce = 0;
        if(is_int($filelimit) && is_int($usedSpace))
        {
            if($filelimit > $usedSpace)
            {
                $remainingSapce = $filelimit - $usedSpace;
            }
        }
        if($fsinKB > $remainingSapce)
        {
            $noProb = false;
            $errMsg = 'You don\'t have enough space. Upgrade your plan or delete old files'; 
            break;

        }

        if($fsinKB > 102410)
        {
            //echo ceil($filesize/1024);
            $noProb =false;
            $errMsg = 'You can not upload more than 10MB at a time'; 
            break;
        }
    }

    $output = "";

    if($noProb)
    {
        for($i=0;$i<$count;$i++)
        {
            
            $filename = $fileNames[$i];
            $fileSize = $fileSizeArray[$i];
            try
            {
                $uniqfilename =  generateUniq('files','fileID');
                dbOperation($filename,$uniqfilename,$fileSize);
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
                echo "<script>alert('Something Went wrong');</script>";
            }
        }
        echo $output;
    }
    elseif($noProb == false)
    {
        // echo "<script type='application/javascript'>  alert('$errMsg'); </script>";
        ?>
        <script>
            alert("<?php echo $errMsg; ?>");
        </script>
        <?php
    }
?>