<?php
    require_once 'db/dbcon.php';
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
        }

        echo json_encode($jsn);
    }
?>