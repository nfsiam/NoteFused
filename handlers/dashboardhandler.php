<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    require_once dirname(__FILE__).'/../db/dashboarddb.php';

    if(isset($_SESSION['admin'])) 
    {
        $admin = $_SESSION['admin'];
        if(isset($admin['username']))
        {
            $loggedAdmin = $admin['username'];
        }
    }

    if(isset($_POST['getCounts']))
    {
        $data = array();
        
        $totalfilesize = getFileSize();
        $data['totalfilesize'] = is_double($totalfilesize) ? $totalfilesize : 0;

        $notecount = getCounts('note');
        $data['notecount'] = is_int($notecount) ? $notecount : 0;

        $pnotecount = getCounts('pnote');
        $data['pnotecount'] = is_int($pnotecount) ? $pnotecount : 0;

        $gnotecount = getCounts('gnote');
        $data['gnotecount'] = is_int($gnotecount) ? $gnotecount : 0;

        $filecount = getCounts('file');
        $data['filecount'] = is_int($filecount) ? $filecount : 0;

        $pfilecount = getCounts('pfile');
        $data['pfilecount'] = is_int($pfilecount) ? $pfilecount : 0;

        $urlcount = getCounts('url');
        $data['urlcount'] = is_int($urlcount) ? $urlcount : 0;



        echo json_encode($data);
    }

    ?>