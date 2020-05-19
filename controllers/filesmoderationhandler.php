<?php
    require_once dirname(__FILE__).'/../models/db/dbcon.php';
    function sanitizer($string)
    {
        $con = getCon();
        if(!empty($string))
        {
            return  mysqli_real_escape_string($con, trim(htmlspecialchars($string)));
        }
        else
        {
            return "";
        }

    }
    if(isset($_POST['delete']))
    {
        $data = array();
        $fileid = sanitizer($_POST['delete']);
        if(!empty($fileid))
        {
            try
            {
                $query = "DELETE from files where fileID='$fileid';";
                execute($query);
                //fwork
                // if(file_exists("upload/$fileID"))
                if(file_exists(dirname(__FILE__).'/../models/upload/'.$fileid))
                {
                    unlink(dirname(__FILE__).'/../models/upload/'.$fileid); //deleting file from server
                }

                $data['success'] = 'File deleted';
            }
            catch(Error $e)
            {

            }
        }
        echo json_encode($data);
    }

?>