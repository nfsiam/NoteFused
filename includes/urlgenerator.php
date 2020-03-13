<?php
    require "./db/dbcon.php";

    function generate()
    {
        $str = substr(md5(microtime()), 0, 5);
        return $str;  
    }
    function uniq($url)
    {
        //here we will check if a record
        //already exists in database or not
        $query = "SELECT * FROM notes WHERE noteID='$url'";
        $result=get($query);
        if(mysqli_num_rows($result) > 0)
        {
            return false;
        }
        else
        {
            return true;
        }
        
    }
    function generateURL()
    {
        while(true)
        {
            $url = generate();
            if(uniq($url))
            {
                break;
            }
        }
        //we now return the url if it is uniq...
        return $url;
    }
?>