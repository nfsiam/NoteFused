<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    require_once dirname(__FILE__).'/../models/db/dashboarddb.php';

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
    if(isset($_POST['getStat']))
    {

        $data = array();
        $data[] = array('Date', 'Note Activity','File Activity','URL Activity');

        $query = "SELECT DISTINCT FROM_UNIXTIME(datestamp,'%d/%M/%Y') AS day, 
        SUM(notecreate)+SUM(notedelete)+SUM(notedownload) as note,
        SUM(fileupload)+SUM(filedelete)+SUM(filedownload) as file,
        SUM(urlshort)+SUM(urldelete) as url
        FROM stat WHERE FROM_UNIXTIME(datestamp) >= CURDATE() - INTERVAL 30 Day  GROUP by day order by day;";
        $result = get($query);

        if($result === false)
        {
            $data[] = array("",0,0,1);
            echo json_encode($data);
            exit();
        }
        elseif(mysqli_num_rows($result)<1)
        {
            $data[] = array("",0,0,0);
            echo json_encode($data);
            exit();
        }
        while($res = mysqli_fetch_assoc($result))
        {
            $day = $res['day'];
            $note = (int)$res['note'];
            $file = (int)$res['file'];
            $url = (int)$res['url'];
            $data[] = array($day,$note,$file,$url);
        }

        echo json_encode($data);
    }
    
    if(isset($_POST['getRec']))
    {

        $data = array();
        $data[] = array('Date', 'Visit');

        $query = "SELECT DISTINCT FROM_UNIXTIME(lastVisited,'%d/%M/%Y') AS day, count(*) as notevisit  FROM notes WHERE FROM_UNIXTIME(lastVisited) >= CURDATE() - INTERVAL 30 Day  GROUP by day order by lastVisited";
        $result = get($query);

        if($result === false)
        {
            $data[] = array("",0);
            echo json_encode($data);
            exit();
        }
        elseif(mysqli_num_rows($result)<1)
        {
            $data[] = array("",0);
            echo json_encode($data);
            exit();
        }
        while($res = mysqli_fetch_assoc($result))
        {
            $day = $res['day'];
            $hit = (int)$res['notevisit'];
            $data[] = array($day,$hit);
        }

        echo json_encode($data);
    }
    if(isset($_POST['getRec2']))
    {

        $data = array();
        $data[] = array('Date', 'Upload');

        $query = "SELECT DISTINCT FROM_UNIXTIME(uploadDate,'%d/%M/%Y') AS day, count(*) as notevisit  FROM files WHERE FROM_UNIXTIME(uploadDate) >= CURDATE() - INTERVAL 30 Day  GROUP by day order by uploadDate";
        $result = get($query);

        if($result === false)
        {
            $data[] = array("",0);
            echo json_encode($data);
            exit();
        }
        elseif(mysqli_num_rows($result)<1)
        {
            $data[] = array("",0);
            echo json_encode($data);
            exit();
        }
        while($res = mysqli_fetch_assoc($result))
        {
            $day = $res['day'];
            $hit = (int)$res['notevisit'];
            $data[] = array($day,$hit);
        }

        echo json_encode($data);
    }
    if(isset($_POST['getRec3']))
    {

        $data = array();
        $data[] = array('Date', 'URL Shortened');

        $query = "SELECT DISTINCT FROM_UNIXTIME(createDate,'%d/%M/%Y') AS day, count(*) as urlcreate  FROM urlMap WHERE FROM_UNIXTIME(createDate) >= CURDATE() - INTERVAL 30 Day  GROUP by day order by createDate";
        $result = get($query);
        if($result === false)
        {
            $data[] = array("",0);
            echo json_encode($data);
            exit();
        }
        elseif(mysqli_num_rows($result)<1)
        {
            $data[] = array("",0);
            echo json_encode($data);
            exit();
        }
        while($res = mysqli_fetch_assoc($result))
        {
            $day = $res['day'];
            $hit = (int)$res['urlcreate'];
            $data[] = array($day,$hit);
        }

        echo json_encode($data);
    }

?>