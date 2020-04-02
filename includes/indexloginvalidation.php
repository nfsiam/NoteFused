<?php
    $uname = "";
    $err_uname = "";
    $pass = "";
    $err_pass = "";
    $err_profile = "";
    if(isset($_POST['login']))
    {
        $hasNoError = true;
        if(empty($_POST['uname']))
        {
            $err_uname = "Username can not be empty";
            $hasNoError = false;
        }
        else
        {
            $uname = htmlspecialchars($_POST['uname']);
        }

        if(empty($_POST['pass']))
        {
            $err_pass = "Password can not be empty";
            $hasNoError = false;
        }
        else
        {
            $pass = htmlspecialchars($_POST['pass']);
        }
        if($hasNoError)
        {
            $query = "SELECT * FROM profiles WHERE username='$uname' AND pass='$pass'";
			$result=get($query);
			if(mysqli_num_rows($result) > 0)
			{
                $user=mysqli_fetch_assoc($result);
                $_SESSION['user'] = $user;
                $loggedUser = $user['username'];
                unset($_POST['login']);
                
			}
			else
			{
				$err_profile = "No user found associated with the username and password";
			}
        }


    }
?>