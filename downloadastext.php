<?php
    require "db/dbcon.php";
    $txt = "";
    $noteID = "";
    if(isset($_GET['id']))
    {
        if(!empty($_GET['id']))
        {
            
            $noteID = $_GET['id'];

            $query = "SELECT * FROM notes WHERE noteID='$noteID'";
            
            $result=get($query);
            //print_r($result);
            

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
    //header('Content-Disposition: attachment; filename="default-filename.txt"');
    //header("Content-Disposition: attachment; filename='default-filename.txt'");
    header("Content-Disposition: attachment; filename=$noteID.txt");

    echo $txt;
?>