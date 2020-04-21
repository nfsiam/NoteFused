<?php
    session_start();
    require "db/dbcon.php";
    $loggedUser = "";
    $resarr = array();
    $notecounts = 0;

    if(isset($_SESSION['user'])) 
    {
        $user = $_SESSION['user'];
        if(isset($user['username']))
        {
            $loggedUser = $user['username'];
        }
    }
    else
    {
        header("Location:login.php");
    }

    


    //echo mb_strlen('আচ্ছা বাংলায় কিছু লিখলাম','UTF-8');
    //$str = 'আচ্ছা বাংলায় কিছু লিখলাম';
    //echo mb_strlen($str, 'utf8');

    function shortDate($longDate)
    {
        $date=date_create("$longDate");

        
        return date_format($date,"d/M/y");
    }
    function sliceText($text)
    {
        $newText = "";
        if(mb_strlen($text,'utf8') >= 15)
        {
             $newText .= mb_substr($text,0,15);
             $newText .= "...";
        }
        else if(mb_strlen($text,'utf8') == 0)
        {
            $newText = "---";
        }
        else
        {
            $newText = $text;
        }

        return $newText;
        
    }
    function sliceID($text)
    {
        
        $newText = "";
        $newText = wordwrap($text, 6, "\n", true);
        echo "<script>console.log('$text');</script>";
        return $text;

    }
    
    if(isset($_SESSION['user'])) 
    {
        $user = $_SESSION['user'];
        if(isset($user['username']))
        {
            $loggedUser = $user['username'];
        }

        $query = "SELECT * FROM notes WHERE noteOwner='$loggedUser'";
        $result=get($query);
        //print_r($result);
        
        

		while($row = mysqli_fetch_assoc($result))
		{
            $resarr[] = $row;
            $notecounts++;
        }

        // foreach($resarr as $res)
        // {
        //     echo $res['text'];
        //     echo "<br>";
        // }
        //print_r($resarr);
    }


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>NoteFused</title>
        <link
            rel="stylesheet"
            href="https://use.fontawesome.com/releases/v5.0.7/css/all.css"
        />
        <!-- <link rel="stylesheet" href="styles/main.css"> -->
        <link rel="stylesheet" href="styles/side2.css" />
        <link rel="stylesheet" href="styles/login.css" />
        <link rel="stylesheet" href="styles/form.css" />
        <link rel="stylesheet" href="styles/mynotes.css" />
        <link rel="stylesheet" href="styles/navbar.css">
        <link rel="stylesheet" href="styles/userdashcard.css">



        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
        <script src="js/jquery341.js"></script>
        <script src="js/navbarfunctionality.js" defer></script>


    </head>

    <body>
        <div class="holder">
            <!-- <div class="navbar">
                <div class="headings">
                    <a href="./">NoteFused</a>
                </div>
            </div> -->
            <?php require "navbar.php"; ?>

            <div class="container">
            <div class="sidebar">
                <?php require "userdashcard.php"; ?>
            </div>
                <div class="note-lists">
                    
                    <table>
                        <thead>
                        <tr class='head'>
                            <div class='trdiv'>
                            <th id='noteid'>
                                <div class='sub-unit'>
                                    Note ID
                                </div>
                            </th>
                            <th id='lastEdit'>
                                <div class='sub-unit'>
                                    Last Edited
                                </div>
                            </th>
                            <th id='lastVisit'>
                                <div class='sub-unit'>
                                    Last Visited
                                </div>
                            </th>
                            <th id='expire'>
                                <div class='sub-unit'>
                                    Expiration
                                </div>
                            </th>
                            <th id='privacy'>
                                <div class='sub-unit'>
                                    privacy
                                </div>
                            </th>
                            <th id='textcontent'>
                                <div class='sub-unit'>
                                    Content
                                </div>
                            </th>
                            <th id='share'>
                                <div class='sub-unit'>
                                    Edit
                                </div>
                            </th>
                            <th id='download'>
                                <div class='sub-unit'>
                                    Download
                                </div>
                            </th>
                            <th id='delete'>
                                <div class='sub-unit'>
                                    Delete
                                </div>
                            </th>
                            </div>
                        </tr>
                        </thead>
                        <?php
                        // for($i=0;$i<50;$i++)
                        // {
                        foreach($resarr as $res)
                        {
                            $noteid = $res['noteID'];
                            // $slicedID = sliceID($noteid);
                            $lastVisit = $res['lastVisited'];
                            $lastVisit = shortDate($lastVisit);     
                            $lastEdit = $res['lastEdited'];
                            $lastEdit = shortDate($lastEdit);        
                            $expiration = $res['expiration'];
                            $expiration = shortDate($expiration); 
                            $xpire =  $res['xpire'];
                            if($xpire == 3650)
                            {
                                $expiration = "NONE";
                            }      
                            $text = $res['text'];
                            $text = sliceText($text);
                            $privacy = $res['notePrivacy'];
                            $privacy = $privacy == 0 ? "Public" : "Private";   
                        echo
                        "<tr>
                            <div class='trdiv'>
                            <td id='noteid'>
                                <div class='sub-unit'>
                                     $noteid
                                </div>
                            </td>
                            <td id='lastEdit'>
                                <div class='sub-unit'>
                                    $lastEdit
                                </div>
                            </td>
                            <td id='lastVisit'>
                                <div class='sub-unit'>
                                    $lastVisit
                                </div>
                            </td>
                            <td id='expire'>
                                <div class='sub-unit'>
                                    $expiration
                                </div>
                            </td>
                            <td id='privacy'>
                                <div class='sub-unit'>
                                    $privacy
                                </div>
                            </td>
                            <td id='textcontent'>
                                <div class='sub-unit'>
                                    $text
                                </div>
                            </td>
                            <td id='share'>
                                <div class='sub-unit'>
                                    <a href='./$noteid'><i class='fas fa-pen-square'></i></a>
                                </div>
                            </td>
                            <td id='download'>
                                <div class='sub-unit'>
                                    <a href='downloadastext.php?id=$noteid'><i
                                    class='fa fa-download'
                                    style='font-size:20px'
                                ></i></a>
                                </div>
                            </td>
                            <td id='delete'>
                                <div class='sub-unit'>
                                    <a href='zzz' id='$noteid'><i class='fa fa-trash' aria-hidden='true'></i></a>
                                </div>
                            </td>
                            </div>
                        </tr>";
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
        
        <script>
            function hideChild() {
                document.getElementById('drp1').display = 'none';
            }

            function goToReg() {
                window.location.href = 'reg.php';
            }
            function showChild(ele) {
                var id = ele.id;
                if (id == 'p1') {
                    document.getElementById('drp1').style.display = 'block';
                    document.getElementById('drp1').focus();
                    document.getElementById('drp2').style.display = 'none';
                    document.getElementById('drp3').style.display = 'none';
                }
                if (id == 'p2') {
                    document.getElementById('drp2').style.display = 'block';
                    document.getElementById('drp2').focus();
                    document.getElementById('drp1').style.display = 'none';
                    document.getElementById('drp3').style.display = 'none';
                }
                if (id == 'p3') {
                    document.getElementById('drp3').style.display = 'block';
                    document.getElementById('drp3').focus();
                    document.getElementById('drp1').style.display = 'none';
                    document.getElementById('drp2').style.display = 'none';
                }
            }

            $('#delete a').click(function(e) {
                e.preventDefault();
                //alert('delete');
                let that = this;
                
                //return;
                console.log($(this).attr('id'));
                $.ajax({

                    url:'deletenote.php',
                    method:'POST',
                    data:{
                        delete:"delete",
                        noteID: $(this).attr('id')
                    },
                    success:function(response){
                        //$(this).css("display", "none");
                        //$(this).remove();
                        // $(that).parents('tr').hide();
                        $(that).parents('tr').fadeOut(500);
                        let ttn =  $('#totalNotes').text();
                        let tn = parseInt(ttn);
                        tn = tn-1;
                        $('#totalNotes').text(tn);
                        console.log('done');
                    }
                });

            });
        </script>
    </body>
</html>
