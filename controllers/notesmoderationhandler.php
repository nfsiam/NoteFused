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
        $noteid = sanitizer($_POST['delete']);
        if(!empty($noteid))
        {
            try
            {
                $query = "DELETE from notes where noteID='$noteid'";
                execute($query);
                $data['success'] = 'Note deleted';
            }
            catch(Error $e)
            {

            }
        }
        echo json_encode($data);
    }

?>