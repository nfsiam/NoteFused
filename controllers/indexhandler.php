<?php
    require_once dirname(__FILE__).'/../models/db/dbcon.php';
    require_once dirname(__FILE__).'/uniqstringgeneratormodule.php';    $loggedUser = "";
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
        global $noteText, $noteOwner, $notePrivacy, $expiration, $lastVisited, $lastVisited, $privacypub, $privacypriv, $exp;
        
        $xpire = $note['xpire'];

        // $lastVisited = date("Y-m-d H:i:s");
        $lastVisited = time();

        // $expiration = Date('Y-m-d H:i:s', strtotime("+$xpire days"));

        $expiration = strtotime("+$xpire days", time());


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
            // $noteID = generateURL();
            $noteID = generateUniq('notes','noteID',6);
            // $location = dirname(__FILE__)."/../$noteID";
            // header("Location:$location");
            header("Location:./$noteID");
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
                        $location = dirname(__FILE__)."/../login.php";
                        header("Location:login.php");
                        // header("Location:$location");
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
                            // header("Location:./");
                            // $location = dirname(__FILE__)."/../login.php";
                            header("Location:login.php");
                            // header("Location:$location");
                        }
                    }
                }
            }
            else
            {
                //create new note against the id
                // $lastEdited = date("Y-m-d H:i:s");

                $lastEdited = time();

                // $lastVisited = date("Y-m-d H:i:s");

                $lastVisited = time();

                // $expiration = Date('Y-m-d H:i:s', strtotime("+$xpire days"));

                $expiration = strtotime("+$xpire days", time());

                $privacy = 0;

                if(empty($loggedUser))
                {
                    //our default note template
                }
                else
                {
                    //users preferred template
                    $xpire = 3650;
                    // $expiration = Date('Y-m-d H:i:s', strtotime("+$xpire days"));

                    $expiration = strtotime("+$xpire days", time());

                    $noteOwner = $loggedUser;

                }
                $query = "INSERT INTO notes (noteID, notePrivacy,noteOwner,lastEdited,lastVisited,xpire,expiration,text)
                VALUES ('$noteID', '$privacy', '$noteOwner','$lastEdited','$lastVisited','$xpire','$expiration','$noteText')";
                execute($query);

                //stat update
                $datestamp = time();
                $query = "INSERT INTO stat (datestamp,username,notecreate) VALUES('$datestamp','$loggedUser', '1');";
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