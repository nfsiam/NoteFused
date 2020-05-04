<?php
require "db/dbcon.php";
$ptime = time();
// $ptime = strtotime('+1 day');

$query2 = "INSERT INTO abcd (ptime,mtime) VALUES ('$ptime',UNIX_TIMESTAMP())";
execute($query2);

// date_default_timezone_set("Asia/Dhaka");
// date_default_timezone_set("UTC");
// echo date_default_timezone_get();
// echo date('d/m/Y h:i:s a',$ptime);
