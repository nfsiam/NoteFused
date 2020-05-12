<?php
    // if(isset($_POST['getRec']))
    // {

    //     $data = array();
    //     $data[] = array('Date', 'Sales', 'Expenses', 'lol');
    //     $data[] = array('01/Mar/2020', 37.8, 10.8, 41.8);
    //     $data[] = array('03/Mar/2020', 77.8, 80.8, 41.8);
    //     $data[] = array('19/Mar/2020', 87.8, 50.8, 21.8);

    //     echo json_encode($data);
    // }

    $day = strtotime('-6 days',time());

    require_once "db/dbcon.php";
    $query = "INSERT INTO `stat`(`datestamp`,filedelete,username) VALUES ('$day','1','guest');";
    execute($query);

    echo date('d/M/Y',$day);
?>
<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/loader.css">

</head>
<body>
    <div class="loader">
        <div class="one"></div>
        <div class="two"></div>
        <div class="three"></div>
        <div class="four"></div>
    </div>
    
</body>
</html> -->


<!-- SELECT DISTINCT FROM_UNIXTIME(lastVisited,"%hh:%mm,%d, %Y") AS month, count(*) as numberOfVisits
FROM notes
GROUP BY month
ORDER BY lastVisited


SELECT FROM_UNIXTIME(lastVisited) AS TIME FROM 	notes WHERE noteID='5a5e2d' -->


<!-- SELECT DISTINCT FROM_UNIXTIME(lastVisited,"%d/%M/%Y") AS day, count(*) as numberOfVisits
FROM notes
GROUP BY day
ORDER BY lastVisited -->


<!-- SELECT DISTINCT FROM_UNIXTIME(lastVisited,"%d/%M/%Y") AS day, count(*) as numberOfVisits
FROM notes
WHERE FROM_UNIXTIME(lastVisited) >= CURDATE() - INTERVAL 2 Day
GROUP BY day
ORDER BY lastVisited -->

<!-- 
SELECT date_sent_push, 
       MAX(count_click) as count_click,
       MAX(count_sent) as count_sent 
FROM
(SELECT date_format(date_click, '%Y-%m-%d') as date_sent_push
     , COUNT(id) as count_click
     , NULL as count_sent
  FROM t1 
  GROUP BY date_sent_push 
  UNION ALL
  SELECT date_format(date_sent, '%Y-%m-%d') as date_sent_push
     , NULL as count_click
     , SUM(count) as count_sent 
  FROM t2 
  GROUP 
    BY date_sent_push 
) as t3
GROUP BY date_sent_push


select t1.DATE, t1.newpost, t2.subs 
    from (
      SELECT DATE(created) DATE, COUNT(DISTINCT created) newpost 
      FROM surveys 
      WHERE created >= Last_day(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL 1 MONTH 
      AND created < last_day(CURRENT_DATE) + INTERVAL 1 DAY 
      GROUP BY DATE(created)
    ) t1
    left join  (
      SELECT DATE(TIMESTAMP) DATE, subs 
      FROM trafficstats 
      WHERE TIMESTAMP >= LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL 1 MONTH 
      AND TIMESTAMP < LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY
    ) t2 on t1.DATE = t2.DA


select t1.DATE, t1.numberOfVisits 
    from (
        SELECT DISTINCT FROM_UNIXTIME(lastVisited,"%d/%M/%Y") AS day, count(*) as numberOfVisits
        FROM notes
        WHERE FROM_UNIXTIME(lastVisited) >= CURDATE() - INTERVAL 2 Day
        GROUP BY day
    ) t1
    left join  (
      SELECT DISTINCT FROM_UNIXTIME(uploadDate,"%d/%M/%Y") AS day, count(*) as numberOfVisits
        FROM files
        WHERE FROM_UNIXTIME(uploadDate) >= CURDATE() - INTERVAL 2 Day
        GROUP BY day
    ) t2 on t1.day = t2.day and t1.numberOfVisits = t2.numberOfVisits




    SELECT *  from (SELECT DISTINCT FROM_UNIXTIME(lastVisited,"%d/%M/%Y") AS day, count(*) as numberOfVisits  FROM notes WHERE FROM_UNIXTIME(lastVisited) >= CURDATE() - INTERVAL 2 Day  GROUP by day
UNION
SELECT DISTINCT FROM_UNIXTIME(uploadDate,"%d/%M/%Y") AS day, count(*) as numberOfVisits FROM files WHERE FROM_UNIXTIME(uploadDate) >= CURDATE() - INTERVAL 2 Day GROUP by day) as a group by day -->


<!-- SELECT DISTINCT FROM_UNIXTIME(lastVisited,"%d/%M/%Y") AS day, count(*) as notevisit  FROM notes WHERE FROM_UNIXTIME(lastVisited) >= CURDATE() - INTERVAL 2 Day  GROUP by day -->


<!-- SELECT FROM_UNIXTIME(day,"%d/%M/%Y") AS din, SUM(note) as nc, SUM(file) as fc, SUM(url) as uc from abcd WHERE FROM_UNIXTIME(day) >= CURDATE() - INTERVAL 3 Day group by din -->