<?php
    session_start();
    require "db/dbcon.php";
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
    // echo $loggedUser;

    function fileNameExtender($oldName,$extension)
    {
        $pos = strrpos($oldName,'.');
        if($pos===false)
        {
            $newName = $filename.'_'.$fileID;
            return $newName;
        }
        else
        {
            $newName = substr_replace($oldName, '_'.$extension, $pos, 0);
            return $newName;
        }
    }
    
    // else
    // {
    //     header("Location:login.php");
    // }    

    function dbOperation($filename)
    {
        global $loggedUser;
        $uniqfilename = "";
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
            // $xpire = 3650;
            // $expiration = Date('Y-m-d H:i:s', strtotime("+$xpire days"));
        }

        $query = "INSERT INTO files (fileOwner, filePrivacy,fName,uploadDate,expiration,xpire)
        VALUES ('$loggedUser', '$privacy', '$filename','$uploadDate','$expiration','$xpire')";
        execute($query);

        $query = "SELECT fileID FROM files WHERE fName='$filename' and uploadDate='$uploadDate'";
        $result=get($query);
        if(mysqli_num_rows($result) > 0)
        {
            $res=mysqli_fetch_assoc($result);
            $fileID =  $res['fileID'];
            
            $uniqfilename = fileNameExtender($filename,$fileID);
            $query = "UPDATE files SET fName='$uniqfilename' where fileID = '$fileID'";
            execute($query);
            return $uniqfilename;
        }
        else
        {
            return "failed";
        }

    }


    function beautify_filename($filename) {
        // reduce consecutive characters
        $filename = preg_replace(array(
            // "file   name.zip" becomes "file-name.zip"
            '/ +/',
            // "file___name.zip" becomes "file-name.zip"
            '/_+/',
            // "file%%%name.zip" becomes "file-name.zip"
            '/%+/',
            // "file---name.zip" becomes "file-name.zip"
            '/-+/'
        ), '-', $filename);
        $filename = preg_replace(array(
            // "file--.--.-.--name.zip" becomes "file.name.zip"
            '/-*\.-*/',
            // "file...name..zip" becomes "file.name.zip"
            '/\.{2,}/'
        ), '.', $filename);
        // lowercase for windows/unix interoperability http://support.microsoft.com/kb/100625
        $filename = mb_strtolower($filename, mb_detect_encoding($filename));
        // ".file-name.-" becomes "file-name"
        $filename = trim($filename, '.-');
        return $filename;
    }

    function filter_filename($filename, $beautify=true) {
        // sanitize filename
        $filename = preg_replace(
            '~
            [<>:"/\\|?*]|            # file system reserved https://en.wikipedia.org/wiki/Filename#Reserved_characters_and_words
            [\x00-\x1F]|             # control characters http://msdn.microsoft.com/en-us/library/windows/desktop/aa365247%28v=vs.85%29.aspx
            [\x7F\xA0\xAD]|          # non-printing characters DEL, NO-BREAK SPACE, SOFT HYPHEN
            [#\[\]@!$&\'()+,;=]|     # URI reserved https://tools.ietf.org/html/rfc3986#section-2.2
            [{}^\~`]                 # URL unsafe characters https://www.ietf.org/rfc/rfc1738.txt
            ~x',
            '-', $filename);
        // avoids ".", ".." or ".hiddenFiles"
        $filename = ltrim($filename, '.-');
        // optional beautification
        if ($beautify) $filename = beautify_filename($filename);
        // maximize filename length to 255 bytes http://serverfault.com/a/9548/44086
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $filename = mb_strcut(pathinfo($filename, PATHINFO_FILENAME), 0, 255 - ($ext ? strlen($ext) + 1 : 0), mb_detect_encoding($filename)) . ($ext ? '.' . $ext : '');
        return $filename;
    }

    $count = count($_FILES['file']['name']);
    $data = array();
    $filesize = 0;
    $filename = array();
    $noProb = true; 

    for($i=0;$i<$count;$i++)
    {
        $name = filter_filename($_FILES['file']['name'][$i]);
        $filename[] = $name;
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
            $uniqfilename =  dbOperation($filename[$i]);
            if($uniqfilename!="failed")
            {
                $filepath = 'http://192.168.137.1/webtech/notefused/upload/'.$uniqfilename;
                if(move_uploaded_file($_FILES['file']['tmp_name'][$i],'upload/'.$uniqfilename))
                {
                    // $output .= '<a download="'.$filename[$].'" href="'.$filepath.'">'.$filepath.'</a><br>';
                    // $output .= $uniqfilename."<br>".$filepath."<br><br>";
                    // echo '<a download="';
                    // echo $filepath;
                    // echo '" href="';
                    // echo $filepath;
                    // echo '">';
                    // echo $filepath;
                    // echo '</a><br>';
                    $outputurl = '<a download="'.$uniqfilename.'" href="'.$filepath.'">'.$filepath.'</a>';
                    // $output .= "<div>
                    //                 <div>$uniqfilename</div>
                    //                 <div>$outputurl</div>
                    //             </div>";
                    $output .= '<div class="res-child">
                                    <div class="res-child-name">'.$uniqfilename.'</div>
                                    <div class="res-child-link">'.$outputurl.'</div>
                                </div>';
                }
            }
            else{
                $output .= "failed";
            }
        }
    }
    // $uniqfilename = "a8834-1_58.txt";
    // $filepath = "upload/a8834-1_58.txt";


    // echo '<a download="'.$uniqfilename.'" href="'.$filepath.'">click</a>';
    echo $output;
    // echo $loggedUser;


?>