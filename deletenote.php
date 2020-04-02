<?php
    require "db/dbcon.php";
    if(isset($_POST['delete']))
    {
    
        $noteID = $_POST['noteID'];

        //$query = "UPDATE notes SET notePrivacy='$notePrivacy', noteOwner='$noteOwner', lastEdited='$lastEdited', xpire='$xpire', lastVisited = '$lastVisited', expiration ='$expiration', text='$noteText' WHERE noteID='$noteID'";
        // $query = "UPDATE notes SET notePrivacy='$notePrivacy' WHERE noteID='$noteID'";
        $query = "DELETE from notes where noteID='$noteID'";
        execute($query);
    }
?>