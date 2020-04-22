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

    function getCounts($thing)
    {
        global $loggedUser;
        // echo $loggedUser;
        $extended = "";
        switch ($thing) {
            case 'note':
                # code...
                $thingID = 'noteID';
                $thingTable  = 'notes';
                $thingOwner = 'noteOwner';
            break;
            case 'pnote':
                # code...
                $thingID = 'noteID';
                $thingTable  = 'notes';
                $thingOwner = 'noteOwner';
                $extended = "and notePrivacy='1'";
            break;
            case 'file':
                # code...
                $thingID = 'fileID';
                $thingTable  = 'files';
                $thingOwner = 'fileOwner';
            break;
            case 'pfile':
                # code...
                $thingID = 'fileID';
                $thingTable  = 'files';
                $thingOwner = 'fileOwner';
                $extended = "and filePrivacy='1'";
            break;
            case 'url':
                # code...
                $thingID = 'surl';
                $thingTable  = 'urlMap';
                $thingOwner = 'urlOwner';
            break;
            
            default:
                # code...
                break;
            }
        $query = "SELECT $thingID from $thingTable where $thingOwner='$loggedUser' $extended;";
        try
        {
            return mysqli_num_rows(get($query));
        }
        catch(Error $e)
        {
            return -1;
        }
    }

    if(isset($_POST['ustats']))
    {
        $data = array();
        $pnotecount = $pfilecount = $urlcount = $notecount = $filecount = -1;

        $notecount = getCounts('note');
        $pnotecount = getCounts('pnote');
        $filecount = getCounts('file');
        $pfilecount = getCounts('pfile');
        $urlcount = getCounts('url');

        $data['notecount'] = $notecount;
        $data['pnotecount'] = $pnotecount;
        $data['filecount'] = $filecount;
        $data['pfilecount'] = $pfilecount;
        $data['urlcount'] = $urlcount;

        echo json_encode($data);

    }

?>