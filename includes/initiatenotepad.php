<?php
    require "urlgenerator.php";
    $loggedUser = "";
    $noteID = "";
    $noteText = "";
    $noteOwner = "guest";
    $notePrivacy = 0;
    $expiration = "";
    $lastEdited = "";
    $lastVisited = "";

    $privacypub = "";
    $privacypriv = "";
    $exp = array("","","","");
    $xpire = 3;
    //date_default_timezone_set('UTC');
    if(isset($_SESSION['user'])) 
    {
        $user = $_SESSION['user'];
        if(isset($user['username']))
        {
            $loggedUser = $user['username'];
        }
    }
    
    function prepareNote($note,$noteID,$owner)
    {
        global $noteText, $noteOwner, $notePrivacy, $expiration, $lastVisited, $lastVisited, $privacypub, $privacypriv, $exp, $xpire;
        
        $xpire = $note['xpire'];

        $lastVisited = date("Y-m-d H:i:s");

        $expiration = Date('Y-m-d H:i:s', strtotime("+$xpire days"));

        $query2 = "UPDATE notes SET lastVisited = '$lastVisited', expiration ='$expiration' WHERE noteID='$noteID'";
        execute($query2);

        if($notePrivacy == 0)
        {
            $privacypub = "checked";
        }
        else
        {
            $privacypriv = "checked";
        }
        
        $noteOwner = $owner;

        $noteText = $note['text'];
        if($xpire == 3)
        {
            $exp[1] = "selected";
        }
        if($xpire == 7)
        {
            $exp[2] = "selected";
        }
        if($xpire == 30)
        {
            $exp[3] = "selected";
        }
        if($xpire > 30)
        {
            $exp[0] = "selected";
        }
    }



    if(isset($_GET['id']))
    {
        if(empty($_GET['id']))
        {
            //we wll generate auto url for id
            $noteID = generateURL();
            header("Location:$noteID");
        }
        else
        {
            
            $noteID = htmlspecialchars($_GET['id']);

            $query = "SELECT * FROM notes WHERE noteID='$noteID'";
            
            $result=get($query);
            

            if(mysqli_num_rows($result) > 0)
            {
                $note=mysqli_fetch_assoc($result);
                $notePrivacy = $note['notePrivacy'];
                $owner = $note['noteOwner'];

                if($notePrivacy==0)
                {
                    prepareNote($note,$noteID,$owner);
                }
                else if($notePrivacy==1)
                {
                    if(empty($loggedUser))
                    {
                        //ask to login
                        header("Location:login.php");
                    }
                    else
                    {
                        if($owner == $loggedUser)
                        {
                            prepareNote($note,$noteID,$owner);
                        }
                        else
                        {
                            session_destroy();
                            header("Location:./");
                        }
                    }
                }
            }
            else
            {
                //create new note against the id
                $lastEdited = date("Y-m-d H:i:s");
                $lastVisited = date("Y-m-d H:i:s");
                $expiration = Date('Y-m-d H:i:s', strtotime("+$xpire days"));
                $privacy = 0;

                if(empty($loggedUser))
                {
                    //our default note template
                }
                else
                {
                    //users preferred template
                    $xpire = 3650;
                    $expiration = Date('Y-m-d H:i:s', strtotime("+$xpire days"));
                    $noteOwner = $loggedUser;

                }
                $query = "INSERT INTO notes (noteID, notePrivacy,noteOwner,lastEdited,lastVisited,xpire,expiration,text)
                VALUES ('$noteID', '$privacy', '$noteOwner','$lastEdited','$lastVisited','$xpire','$expiration','$noteText')";
                execute($query);

                $query = "SELECT * FROM notes WHERE noteID='$noteID'";
                $result=get($query);
                if(mysqli_num_rows($result) > 0)
                {
                    $note=mysqli_fetch_assoc($result);
                    prepareNote($note,$noteID,$noteOwner);
                }
            }
             
        }
    }


?>