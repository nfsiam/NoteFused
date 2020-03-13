<?php
    $uname = "";
    $err_uname = "";
    $pass = "";
    $err_pass = "";
    if(isset($_POST['login']))
    {
        if(empty($_POST['uname']))
        {
            $err_uname = "Username can not be empty";
        }
        else
        {
            $uname = htmlspecialchars($_POST['uname']);
        }

        if(empty($_POST['pass']))
        {
            $err_pass = "Password can not be empty";
        }
        else
        {
            $pass = htmlspecialchars($_POST['pass']);
        }

    }
?>