<?php

require "db/dbcon.php";
function matchPass($opass)
{
    $query = "SELECT pass from profiles where username='siam';";
    try
    {
        $result = get($query);
        if($result == false) return false;
        if(mysqli_num_rows($result) > 0)
        {
            $res =  mysqli_fetch_row($result);
            if($opass != $res[0])
            {
              return false;
            }
            else
            {
              return true;
            }
        }
        else
        {
            return false;
        }

    }
    catch(Error $e)
    {
        return false;
    }
}

echo matchPass("1234")? "milse" : "mile nai";
