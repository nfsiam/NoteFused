<?php
    require_once "db/dbcon.php";

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