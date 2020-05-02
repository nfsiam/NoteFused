<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    require_once "db/dbcon.php";
    $loggedUser = "";

    if(isset($_SESSION['user'])) 
    {
        $user = $_SESSION['user'];
        if(isset($user['username']))
        {
            $loggedUser = $user['username'];
        }
    }

    function getInfo()
    {
        global $loggedUser;
        $personalInfoArray = array();
        $query = "SELECT * from profiles where username='$loggedUser';";
        try
        {
            $result = get($query);
            if($result == false) return false;
            if(mysqli_num_rows($result) > 0)
            {
                return mysqli_fetch_assoc($result);
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


    //update personal info


    function updatePersonalInfo($via,$passchange = false)
    {
        global $loggedUser;
        $query = "UPDATE profiles set name='$via[0]' , email='$via[1]' where username='$loggedUser'";
        if($passchange)
        {
            $query = "UPDATE profiles set name='$via[0]' , email='$via[1]', pass='$via[4]' where username='$loggedUser'";
        }
        try
        {            
            execute($query);
            return true;
        }
        catch(Error $e)
        {
            return false;
        }
    }


    function matchPass($opass)
    {
        global $loggedUser;

        $query = "SELECT pass from profiles where username='$loggedUser';";
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

    function validate($irray, &$data, $passchange = false)
    {
        $con = getCon();
        $infoArray = array();
        for ($i=0; $i < count($irray); $i++)
        { 
            # code...
            $infoArray[$i] = mysqli_real_escape_string($con, trim(htmlspecialchars($irray[$i])));
        }
        $error = array();
        //$valid = true;
        $name = preg_replace('/\s\s+/', ' ', $infoArray[0]);
        if(empty($name))
        {
            $error[0] = "please enter your name above";
        }
        elseif(!ctype_alpha(str_replace(' ', '', $name)))
        {
            $error[0] = "please enter letters and Space only (e.g. Abcd Efgh)";
            // echo "in";
        }
        else
        {

        }
        
        $email = $infoArray[1];
        if(empty($email))
        {
            $error[1] = "please enter your email above";
        }
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $error[1] = "please enter valid email only";
        }
        else
        {

        }

        $opass = $infoArray[2];

        if(empty($opass))
        {
            $error[2] = "please enter your password above";
        }
        else if(!matchPass($opass))
        {
            $error[2] = "please enter correct password";
        }
        else
        {

        }
        if($passchange === true)
        {
            $npass = $infoArray[4];
            if(empty($npass))
            {
                $error[3] = "please enter your new password above";
            }
            else if(strlen($npass) < 4)
            {
                $error[3] = "please make sure your password is minimum 4 digit";
            }
            else
            {
    
            }
            $cnpass = $infoArray[5];
            if(empty($cnpass))
            {
                $error[4] = "please re-enter your new password above";
            }
            else if($npass !== $cnpass)
            {
                $error[4] = "passwords didn't match";
            }
            else
            {
    
            }

        }
        //print_r($error);
        $data['errors'] = $error;
        if(count($error)>0)
        {
            return false;
        }
        else
        {
            return $infoArray;
        }
    }


    if(isset($_POST['infoArray']))
    {
        $data = array();

        $infoArray = $_POST['infoArray'];
        if(is_array($infoArray))
        {
            // echo count($infoArray);
            if(count($infoArray)==4)
            {
                //sanitize, validate, update
                //$data['errName'] = "name can not be empty";
                $validatedInfoArray = validate($infoArray,$data);
                if(is_array($validatedInfoArray))
                {
                    if(updatePersonalInfo($validatedInfoArray))
                    {
                        $data['success'] = 'true';
                    }
                    else
                    {
                        $data['success'] = 'false';
                        $data['message'] = 'Something went wrong here';
                    }
                }
                else
                {
                    //eror in the input fields
                }

            }
            elseif(count($infoArray)==6)
            {
                $validatedInfoArray = validate($infoArray,$data,true);
                if(is_array($validatedInfoArray))
                {
                    if(updatePersonalInfo($validatedInfoArray,true))
                    {
                        $data['success'] = 'true';
                    }
                    else
                    {
                        $data['success'] = 'false';
                        $data['message'] = 'Something went wrong here';
                    }
                }
                else
                {
                    //eror in the input fields
                }
            }
            else
            {
                $data['success'] = 'false';
                $data['message'] = 'Something went wrong here';
            }

        }
        else
        {
            //not array
            $data['success'] = 'false';
            $data['message'] = 'Something went wrong';
        }

        echo json_encode($data);

    }

?>