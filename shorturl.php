<?php
    session_start();
    require "db/dbcon.php";
    $longUrl = "";
    $err_longUrl = "";
    $surl = "";
    $err_url = "";
    $data = array();

    if(isset($_GET['id']))
    {
        //header("location: http://example.com",  true,  301 );  exit;
       // return;
        $ul = "";
        if(empty($_GET['id']))
        {
            header("Location:$noteID");
        }
        else
        {
            $ul = htmlspecialchars($_GET['id']);
            $query = "SELECT longUrl FROM urls WHERE surl='$ul'";
            $result=get($query);
            if(mysqli_num_rows($result) > 0)
            {
                $ulres = mysqli_fetch_assoc($result);
                $lurl = $ulres['longUrl'];
                $parse = parse_url($lurl);
                if(!isset($parse['scheme']))
                {
                    $lurl = "http://".$lurl;
                }
                // header("Location:$lurl");
                // echo $lurl;
                // return;
                header("location: $lurl",  true,  301 );  exit;
            }

        }
    }

    function insertUrl($url,$longUrl)
    {
        $query = "INSERT INTO urls (surl,longUrl) VALUES ('$url', '$longUrl')";
        execute($query);
    }
    function generate()
    {
        $str = substr(md5(microtime()), 0, 5);
        return $str;  
    }
    function uniq($url)
    {
        //here we will check if a record
        //already exists in database or not
        $query = "SELECT surl FROM urls WHERE surl='$url'";
        $result=get($query);
        if(mysqli_num_rows($result) > 0)
        {
            return false;
        }
        else
        {
            return true;
        }
        
    }
    function generateURL($longUrl)
    {
        $url ="";
        while(true)
        {
            $url = generate();
            if(uniq($url))
            {
                insertUrl($url,$longUrl);
                break;
            }
        }
        //we now return the url if it is uniq...
        return $url;
    }



    if(isset($_POST['submit']))
    {
        
        $hasNoError = true;

        if(empty($_POST['longUrl']))
        {
            $err_longUrl = "Enter your URL here first";
            $hasNoError = false;
        }
        else
        {
            $longUrl = htmlspecialchars($_POST['longUrl']);
        }
        // $hsn = ""+$hasNoError;
        // $query = "INSERT INTO urls (surl,longUrl) VALUES ('siam5', '$hsn')";
        // execute($query);

        if($hasNoError)
        {
            //does the url already exists? then return url
            
            
            $query = "SELECT * FROM urls WHERE longUrl='$longUrl'";
			$result=get($query);
			if(mysqli_num_rows($result) > 0)
			{
                $res=mysqli_fetch_assoc($result);
                $surl = $res['surl'];         
			}
			else
			{
                $surl = generateURL($longUrl);
                // $myfile = fopen("logs.txt", "a") or die("Unable to open file!");
                // $txt = $surl;
                // fwrite($myfile, "\n". $txt);
                // fclose($myfile);
            }

            
            $surl= "192.168.137.1/webtech/notefused/go/".$surl;
            $data['surl'] = $surl;
            echo json_encode($data);

        }
    }

?>



