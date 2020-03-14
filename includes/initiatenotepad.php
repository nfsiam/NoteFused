<?php
    require "urlgenerator.php";
    $noteText = "";
    $noteOwner = "guest";

    if(isset($_SESSION['user'])) 
    {
        $user = $_SESSION['user'];
        if(isset($user['username']))
        {
            $noteOwner = $user['username'];
        }
    }

    if(isset($_GET['id']))
    {
        if(empty($_GET['id']))
        {
            //we wll generate auto url for id
            $noteID = generateURL();
            //by default owner is guest but if user
            //is logged in he will be the owner.
            

            //here we create an entry in the database
            //against the new noteID before sending 
            //him towards our else block

            $query = "INSERT INTO notes (noteID, notePrivacy, noteOwner, text)
            VALUES ('$noteID', '0', '$noteOwner','')";
            execute($query);
            header("Location:$noteID");


            //and we will create a new note against the id

        }
        else
        {
            $noteID = htmlspecialchars($_GET['id']);
            //if not empty we will get data asspciated
            //with the id but first we will check if
            //the data is private or not, if private
            //we will show a message and ask the vistor
            //to sign in. If he signs in we will show
            //him the data.
            //if the data is not private we will show the
            //data

            //$note = get($noteID);
            $query = "SELECT * FROM notes WHERE noteID='$noteID'";
            $result=get($query);

            if(mysqli_num_rows($result) > 0)
            {
                $note=mysqli_fetch_assoc($result);
                $text = $note['text'];//the text;
                $notePrivacy = $note['notePrivacy'];
                $noteOwner = $note['noteOwner'];

                if(true/*hasAccess()*/)
                {
                    $noteText = $text;
                }
                else
                {
                    //ask user to login to view 
                    //the private code or offer
                    //the user to open a new note!
                }
            }
            else
            {
                //create new note against the id
                $query = "INSERT INTO notes (noteID, notePrivacy, noteOwner, text)
                VALUES ('$noteID', '0', '$noteOwner','')";
                execute($query);
            }
             
        }
    }
?>