<?php
    session_start();

    require_once dirname(__FILE__).'/../db/dbcon.php';
    require_once dirname(__FILE__).'/../modules/uniqstringgeneratormodule.php';
    require_once dirname(__FILE__).'/../modules/planmodule.php';
    require_once dirname(__FILE__).'/../modules/userstatmodule.php';

    $loggedUser = "";
    $surl = "";
    $data = array();
    // $resarr = array();

    if(isset($_SESSION['user'])) 
    {
        $user = $_SESSION['user'];
        if(isset($user['username']))
        {
            $loggedUser = $user['username'];
        }
    }

    function insertUrl($url,$longUrl)
    {
        $query = "INSERT INTO urls (surl,longUrl) VALUES ('$url', '$longUrl')";
        execute($query);
    }
    function updateOwner($loggedUser,$surl)
    {
        $query = "SELECT * FROM urlmap WHERE surl='$surl' and urlOwner='$loggedUser'";
        $result=get($query);
        if(mysqli_num_rows($result) > 0)
        {

        }
        else
        {
            $query = "INSERT INTO urlmap (urlOwner,surl) VALUES ('$loggedUser', '$surl')";
            execute($query);
        }
    }
    
    if(isset($_POST['longUrl']))
    {
        $data = array();

        $limit = getLimit('url');
        $urlcount = getCounts('url');

        if($urlcount < $limit)
        {
            if(!empty($_POST['longUrl']))
            {
    
                $longUrl = htmlspecialchars($_POST['longUrl']);
                $longUrl = strpos($longUrl, 'http') !== 0 ? "http://$longUrl" : $longUrl;
                //echo $longUrl;
                if(filter_var($longUrl, FILTER_VALIDATE_URL))
                {
    
                    //check if already exists then return past short url
                    $query = "SELECT * FROM urls WHERE longUrl='$longUrl'";
                    $result=get($query);
                    if(mysqli_num_rows($result) > 0)
                    {
                        $res=mysqli_fetch_assoc($result);
                        $surl = $res['surl'];
    
                        //insert the new owner
                        updateOwner($loggedUser,$surl);
                        /* $query = "INSERT INTO urlmap (urlOwner,surl) VALUES ('$loggedUser', '$surl')";
                        execute($query); */
                    }
                    else
                    {
                        $surl = generateUniq('urls','surl');
                        insertUrl($surl,$longUrl);
                        updateOwner($loggedUser,$surl);
                        //insert the new owner
                        /* $query = "INSERT INTO urlmap (urlOwner,surl) VALUES ('$loggedUser', '$surl')";
                        execute($query); */
    
                    }
                    $surl= "http://192.168.137.1/webtech/notefused/go/".$surl;
                    $data['surl'] = $surl;
                }
                else
                {
                    //throw error ivalid url
                }
            }
            else
            {
                //throw empty url
            }

        }
        else
        {
            //error limit exceeded
            $data['limitError'] = "Limit Exceeded";
        }

        echo json_encode($data);
    }
    
?>