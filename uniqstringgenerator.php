<?php
    require "db/dbcon.php";
    function generate()
    {
        $str = substr(md5(microtime()), 0, 14);
        return $str;
    }
    function uniq($shortString,$table,$idToCheck)
    {
        //here we will check if a record
        //already exists in database or not

        $query = "SELECT '$idToCheck' FROM '$table' WHERE '$idToCheck'='$shortString'";
        $result=get($query);
        return mysqli_num_rows($result) > 0 ? false: true;

        // if(mysqli_num_rows($result) > 0)
        // {
        //     return false;
        // }
        // else
        // {
        //     return true;
        // }
        
    }
    function generateUniq($table,$idToCheck)
    {
        $shortString ="";
        while(true)
        {
            $shortString = generate();
            if(uniq($shortString,$table,$idToCheck))
            {
                break;
            }
        }
        return $shortString;
    }


?>