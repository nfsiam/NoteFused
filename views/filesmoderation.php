<?php
    session_start();
    require_once dirname(__FILE__).'/../models/db/dbcon.php';

    //preventing access from view route
    if (strpos($_SERVER['REQUEST_URI'], '/views/') !== false) {
        exit();
    }
    if(!isset($_SESSION['admin']))
    {
        header("Location:login");
    }
    
    date_default_timezone_set("Asia/Dhaka");
    function shortDate($longDate)
    {
        return date('d/m/Y',$longDate);
    }


    $results_per_page = 50;

    $query= "SELECT * FROM files;";
    $result = get($query);
    $number_of_results = mysqli_num_rows($result);

    $number_of_pages = ceil($number_of_results/$results_per_page);


    if (!isset($_GET['p']))
    {
        $page = 1;
    }
    else
    {
        $pGet = 1;
        try
        {
            $pGet = (int)$_GET['p'];
        }
        catch(Error $e)
        {

        }
        if($pGet < 1)
        {
            $page = 1;
        }
        elseif($pGet > $number_of_pages)
        {
            $page = $number_of_pages;
        }
        else
        {
            $page = $pGet;
        }
    }

    $this_page_first_result = ($page-1)*$results_per_page;


    $resarr = array();

    $query = "SELECT * FROM files order by uploadDate DESC LIMIT $this_page_first_result , $results_per_page";
    $result=get($query); 
    
    if($result !== false)
    {
        while($row = mysqli_fetch_assoc($result))
        {
            $resarr[] = $row;
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Document</title>
        <link rel="stylesheet" href="views/styles/all.css" />
        <link rel="stylesheet" href="views/styles/adbase.css" />
        <link rel="stylesheet" href="views/styles/pagination.css" />
        <link rel="stylesheet" href="views/styles/notesmoderation.css" />
        <link rel="stylesheet" href="views/styles/throwlert.css" />

        <script src="views/js/jquery341.js"></script>
        <script src="views/js/throwlert.js" defer></script>
        <script
            type="text/javascript"
            src="https://www.gstatic.com/charts/loader.js"
        ></script>
        <script></script>
    </head>
    <body>
        <section class="ad-holder">
            <section class="ad-sidebar">
                <div class="sidebar-toggler">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                <div class="ad-side">
                    <ul>
                        <li><a href="dashboard">Dashboard</a></li>
                        <li>
                            <a href="planmoderation">Plan Moderation</a>
                        </li>
                        <li><a href="notesmoderation">Note Moderation</a></li>
                        <li><a href="filesmoderation">File Moderation</a></li>
                        <li><a href="urlsmoderation">URL Moderation</a></li>
                        <li><a href="controllers/destroysessionmodule.php">Logout</a></li>
                    </ul>
                </div>
            </section>
            <section class="ad-container">
                <div class="mini-ad-container">
                    <div class="search-row">
                        <input type="text" placeholder="search for user" />
                    </div>
                    <div class="note-plate-row">

                    <?php

                        foreach($resarr as $res)
                        {
                            $fileid = $res['fileID'];
                            $filename = $res['fName'];

                            $username = $res['fileOwner'];

                            $uploadDate = $res['uploadDate'];
                            $uploadDate = shortDate($uploadDate);

                            $size = $res['filesize'];
                            $size = (double)$size;
                            $size = $size/1024;

                            $size = number_format((float)$size, 2, '.', '');
                            $size = $size.' MB';
                                   echo "<div class='note-plate'>
                                            <div class='row1'>
                                                <div class='noteID'><a href='./$fileid'>$filename</a></div>
                                                <div class='username'>$username</div>
                                            </div>
                                            <div class='row2'>
                                                <div class='dates-holder'>
                                                    <div>Upload Date : $uploadDate</div> <div>File Size : $size</div>
                                                </div>
                                                <div class='action-button-holder'>
                                                    <a href='' class='delete-button' data-fileid='$fileid'>Delete</a>
                                                </div>
                                            </div>
                                        </div>";
                        }

                    ?>
                                <?php
                                    echo "<div class='pagination'>"; //start of pagination
                                    if($page > 1)
                                    {
                                        $prev_page = $page - 1;
                
                                        echo "<div class='paging-button-holder'>
                                                <a href='notesmoderation?p=$prev_page'>Newer</a>
                                            </div>";
                                    }
                                        
                                        echo "<div class='current-button-holder'>
                                                Page $page out of $number_of_pages Pages
                                            </div>";
                                    if($page < $number_of_pages)
                                    {
                                        $next_page = $page + 1;
                                        echo "<div class='paging-button-holder'>
                                                <a href='notesmoderation?p=$next_page'>Older</a>
                                            </div>";
                                    }
                
                                    echo "</div>"; //end of pagination
                                ?>

                    </div>
                    <!-- end of note-plate-row -->
                </div>
                <!-- end of mini-ad-container -->
            </section>
            <!-- end of ad-container -->
        </section>
        <div class="throwlert">
            <div class="alert-box">
                <div class="alert-close-button">
                    <button><i class="fas fa-times"></i></button>
                </div>
                <div class="alert-type type-success">
                    <i class="far fa-check-circle"></i>
                </div>
                <div class="alert-type type-error">
                    <i class="far fa-times-circle"></i>
                </div>
                <div class="alert-dialog"></div>
            </div>
        </div>
        <script>
            $('.sidebar-toggler').click(function () {
                $('.ad-sidebar').toggleClass('ad-sidebar-active');
            });
            $('.ad-side a').eq(3).css('background-color', '#555');

            // $('.search-row input').keyup(function () {
            //     $.ajax({
            //         url: 'controllers/planmoderationhandler.php',
            //         method: 'POST',
            //         data: {
            //             searchByUser: $('.search-row input').val(),
            //         },
            //         success: function (data) {
            //             $('.user-plate-row').html(data);
            //         },
            //     });
            // });

            $('.note-plate-row').on('click', '.delete-button', function (e) {
                e.preventDefault();
                let that = $(this);
                $.ajax({
                    url: 'controllers/filesmoderationhandler.php',
                    method: 'POST',
                    dataType: 'JSON',
                    data: {
                        delete: $(this).data('fileid'),
                    },
                    success: function (data) {
                        if ('success' in data) {
                            throwlert(1, data.success);
                            that.closest('.note-plate').fadeOut();
                        } else {
                            throwlert(0, 'Something went wrong!');
                        }
                    },
                });
            });
            
        </script>
    </body>
</html>
