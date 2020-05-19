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
    if(isset($_POST['delete']) && isset($_POST['username']))
    {
        $data = array();

        $surl = sanitizer($_POST['delete']);
        $username = sanitizer($_POST['username']);

        if(!empty($surl) && !empty($username))
        {
            try
            {
                $query = "DELETE from urlmap where surl='$surl' and urlOwner='$username'";
                execute($query); //removing record from urlmap

                //check if any other record exists for another owner
                $query = "SELECT * FROM urlmap WHERE surl='$surl'";
                $result=get($query);

                if(mysqli_num_rows($result) > 0)
                {
                    //we do nothing lol
                }
                else
                {
                    $query = "DELETE from urls where surl='$surl'";
                    execute($query); //removing record from urls
                }

                $data['success'] = 'URL deleted';
            }
            catch(Error $e)
            {

            }
        }
        echo json_encode($data);
    }

?>