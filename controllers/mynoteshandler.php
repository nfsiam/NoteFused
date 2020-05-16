<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    require_once dirname(__FILE__).'/../models/db/dbcon.php';
    $txt = "";
    $noteID = "";

    $loggedUser = "";

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
            
            $noteID = $_GET['id'];

            $query = "SELECT * FROM notes WHERE noteID='$noteID'";
            
            $result=get($query);
            //stat update
            $datestamp = time();
            $query = "INSERT INTO stat (datestamp,username,notedownload) VALUES('$datestamp','$loggedUser', '1');";
            execute($query);        

            if(mysqli_num_rows($result) > 0)
            {
                $note=mysqli_fetch_assoc($result);
                $noteOwner = $note['noteOwner'];
                $noteText = $note['text'];
                $txt = $noteText."\n\n"."#notefused";
            }
        }
    }

    
    header('Content-type: text/plain');
    header("Content-Disposition: attachment; filename=$noteID.txt");

    echo $txt;
?>