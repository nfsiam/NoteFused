<?php
    require "db/dbcon.php";
    // $noteText =  $_POST['noteText'];
    // $noteOwner =  $_POST['noteOwner'];
    // $notePrivacy = $_POST['notePrivacy'];
    // $expiration =  $_POST['expiration'];
    // $lastEdited = $_POST['lastEdited'];
    // $lastVisited =  $_POST['lastVisited'];
    // $xpire =  $_POST['xpire'];
    if(isset($_POST['submit']))
    {
        $noteText =  $_POST['noteText'];
        $noteOwner =  $_POST['noteOwner'];
        $notePrivacy = $_POST['notePrivacy'];
        $expiration =  $_POST['expiration'];
        $lastEdited = $_POST['lastEdited'];
        $lastVisited =  $_POST['lastVisited'];
        $xpire =  $_POST['xpire'];
        $notePrivacy = $_POST['notePrivacy'];
        $noteID = $_POST['noteID'];

        $query = "UPDATE notes SET notePrivacy='$notePrivacy', noteOwner='$noteOwner', lastEdited='$lastEdited', xpire='$xpire', lastVisited = '$lastVisited', expiration ='$expiration', text='$noteText' WHERE noteID='$noteID'";
        // $query = "UPDATE notes SET notePrivacy='$notePrivacy' WHERE noteID='$noteID'";
        execute($query);
    }
?>